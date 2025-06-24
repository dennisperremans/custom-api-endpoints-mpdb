<?php
/**
 * Custom “filtered gigs” REST handler
 *
 *  Endpoint:  /wp-json/custom/v1/gigs
 *  Query params:
 *      - venue_name  (string, optional, LIKE match)
 *      - country     (string, optional, LIKE match)
 *      - city        (string, optional, LIKE match)
 *      - keyword     (string, optional, matches title/content/acf/songs)
 *      - page        (int,   optional, defaults 1)
 *      - per_page    (int,   optional, defaults 10)
 */

function custom_api_handle_filtered_gigs( WP_REST_Request $request ) {

    /* ---------------- Build meta_query from filters ---------------- */
    $meta_query = [ 'relation' => 'AND' ];

    $maybe_add = function ( $key, $value ) use ( &$meta_query ) {
        if ( ! empty( $value ) ) {
            $meta_query[] = [
                'key'     => $key,
                'value'   => $value,
                'compare' => 'LIKE',
            ];
        }
    };

    $maybe_add( 'venue_name', $request->get_param( 'venue_name' ) );
    $maybe_add( 'country',    $request->get_param( 'country'    ) );
    $maybe_add( 'city',       $request->get_param( 'city'       ) );

    // ---------------- Handle keyword filtering ----------------
    $keyword = trim( $request->get_param( 'keyword' ) ?? '' );
    $has_keyword = ! empty( $keyword );

    /* ---------------- WP_Query ---------------- */
    $page     = max( (int) $request->get_param( 'page' ), 1 );
    $per_page = max( (int) $request->get_param( 'per_page' ), 10 );

    // If keyword provided, use 's' param to match title + content
    $query_args = [
        'post_type'      => 'gig',
        'post_status'    => 'publish',
        'paged'          => $page,
        'posts_per_page' => $per_page,
        'meta_query'     => $meta_query,
    ];

    if ( $has_keyword ) {
        $query_args['s'] = $keyword;
    }

    $query = new WP_Query( $query_args );

    /* ---------------- Convert each post to the SAME shape as /wp/v2/gig ---------------- */
    $controller = new WP_REST_Posts_Controller( 'gig' );   // core posts controller for CPT “gig”
    $items      = [];

    foreach ( $query->posts as $single_post ) {

        // If keyword is set, check ACF fields and related songs manually
        if ( $has_keyword ) {
            $found_match = false;

            // Check ACF fields: venue, city, country
            $acf_fields = [
                get_field( 'venue_name', $single_post->ID ),
                get_field( 'city', $single_post->ID ),
                get_field( 'country', $single_post->ID ),
            ];

            foreach ( $acf_fields as $value ) {
                if ( stripos( $value, $keyword ) !== false ) {
                    $found_match = true;
                    break;
                }
            }

            // Check related songs
            if ( ! $found_match ) {
                $songs = get_field( 'songs', $single_post->ID );
                if ( is_array( $songs ) ) {
                    foreach ( $songs as $song ) {
                        if ( isset( $song->post_title ) && stripos( $song->post_title, $keyword ) !== false ) {
                            $found_match = true;
                            break;
                        }
                    }
                }
            }

            // Check title/content as fallback
            $wp_match = stripos( $single_post->post_title, $keyword ) !== false ||
                        stripos( $single_post->post_content, $keyword ) !== false;

            if ( ! $found_match && ! $wp_match ) {
                continue; // Skip if no match at all
            }
        }

        // Prepare the item (same internals WP uses)
        $response_obj = $controller->prepare_item_for_response( $single_post, $request );
        $items[]      = $controller->prepare_response_for_collection( $response_obj );
    }

    /* ---------------- Build WP_REST_Response with pagination headers ---------------- */
    $response = new WP_REST_Response( $items );
    $response->header( 'X-WP-Total',       (int) $query->found_posts );
    $response->header( 'X-WP-TotalPages',  (int) $query->max_num_pages );

    return $response;
}

/* --------------------------------------------------------------------------
 *  Optional: expose those custom headers to browsers on cross-origin calls.
 * ------------------------------------------------------------------------*/
add_filter(
    'rest_pre_serve_request',
    function ( $served, $result, $request ) {
        if ( ! headers_sent() ) {
            header( 'Access-Control-Expose-Headers: X-WP-Total, X-WP-TotalPages' );
        }
        return $served;
    },
    10,
    3
);
