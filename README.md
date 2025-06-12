# Custom API Endpoints for WordPress

A lightweight WordPress plugin that exposes custom REST API endpoints for use with MPDB site's data, such as gigs, songs, and venues.

---

## Plugin Details

- **Plugin Name:** Custom API Endpoints
- **Version:** 1.1
- **Author:** Dennis Perremans

---

## Features

- Custom REST API endpoints using the WordPress REST API.
- Returns stats about gigs and songs (e.g. total songs played).
- Lists all unique venues where gigs were performed.


---

## Available Endpoints

All endpoints are available under:  
`/wp-json/custom/v1/`

### `GET /songs-played-count`
Returns statistics about the total number of songs played, total gigs, and unique songs.

**Example response:**
```json
{
  "total_songs_played": 186,
  "total_gigs": 75,
  "total_unique_songs": 52
}
```

### `GET /venues`
Return all the uses venues from the ACF field venue_name

**Example response:**
```json
[
  "Ancienne Belgique",
  "Paradiso",
  "De Kreun"
]
```