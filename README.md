# Custom API Endpoints for WordPress

A lightweight WordPress plugin that exposes custom REST API endpoints for use with the MPDB site’s data, such as gigs, songs, and venues.

---

## Plugin Details

- **Plugin Name:** Custom API Endpoints  
- **Version:** 1.2.0  
- **Author:** Dennis Perremans  

---

## Features

- Custom REST endpoints built on the WordPress REST API.  
- Returns aggregate stats about gigs and songs (e.g. total songs played).  
- Lists every unique venue, country, and city where gigs were performed.  
- **NEW:** Powerful `keyword` filter on the `/gigs` endpoint (searches venue, city, country, gig title/content, and related songs).  

---

## Available Endpoints  
_All routes are prefixed with_ `/wp-json/custom/v1/`

| Method & Path            | Description                                                     |
|--------------------------|-----------------------------------------------------------------|
| **GET /songs-played-count** | Returns total songs played, total gigs, and unique songs.     |
| **GET /venues**              | Returns all venue names (ACF field `venue_name`).            |
| **GET /countries**           | Returns all countries (ACF field `country`).                 |
| **GET /cities**              | Returns all cities (ACF field `city`).                       |
| **GET /gigs**                | Returns gigs list; supports paging and advanced filters.     |

---

### Example: `GET /songs-played-count`

```json
{
  "total_songs_played": 186,
  "total_gigs": 75,
  "total_unique_songs": 52
}
```

---

### Example: `GET /venues`

```json
[
  "Ancienne Belgique",
  "Paradiso",
  "De Kreun"
]
```

---

### Example: `GET /countries`

```json
[
  "Belgium",
  "Italy",
  "Norway"
]
```

---

### Example: `GET /cities`

```json
[
  "Hasselt",
  "Brussels",
  "Trondheim"
]
```

---

### `GET /gigs` – Filters & Pagination

| Query Param   | Type    | Description                                                                                                  |
|---------------|---------|--------------------------------------------------------------------------------------------------------------|
| `venue_name`  | string  | Filter by venue (partial match, case-insensitive).                                                           |
| `country`     | string  | Filter by country (partial match).                                                                           |
| `city`        | string  | Filter by city (partial match).                                                                              |
| `keyword`     | string  | **NEW** – Search term that matches across venue, city, country, gig title, gig content, and related songs.   |
| `page`        | int     | Results page (default **1**).                                                                                 |
| `per_page`    | int     | Items per page (default **10**).                                                                              |

**Response Headers**

| Header             | Meaning                                  |
|--------------------|------------------------------------------|
| `X-WP-Total`       | Total number of gigs that match filters. |
| `X-WP-TotalPages`  | Total pages based on `per_page`.         |

**Sample request**

```
GET /wp-json/custom/v1/gigs?country=Belgium&keyword=Trondheim
```

**Sample response**

```json
[
  {
    "id": 2381,
    "date": "2024-05-14",
    "title": { "rendered": "Oslo, Rockefeller" },
    "acf": {
      "city": "Oslo",
      "country": "Norway",
      "venue_name": "Rockefeller",
      "songs": [
        { "ID": 701, "post_title": "Vortex Surfer" },
        { "ID": 702, "post_title": "The Cuckoo" }
      ]
    }
  }
]
```

---

## Changelog

### 1.2.0
- Added `keyword` filter to `/gigs` endpoint (searches title, content, ACF venue/city/country, and related song titles).  
- Updated README with new filter documentation.
