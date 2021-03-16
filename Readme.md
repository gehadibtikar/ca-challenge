#Note
- That challenge is incomplete, I've done the endpoint only without tests and with no frontend (dashboard)

# Setup

- Make sure you have [docker!](https://docs.docker.com/get-docker/) and [docker-compose!](https://docs.docker.com/compose/install/) installed
- From terminal, in project root run `docker-compose build`
- After building the images run `docker-compose up -d`
- Create the db by running `docker-compose exec php bin/console bin/console doctrine:database:create`
- Run db migrations `docker-compose exec php bin/console bin/console doctrine:migrations:migrate --no-interaction`
- To load dummy fixtures run `docker-compose exec php bin/console doctrine:fixtures:load --no-interaction` 

# database
DB client `adminer` can be accessed from http://localhost:8080/
- **Server** : database
- **Username** : root
- **Password** : secret
- **Database** : ca_db


# API

**Overtime Endpoint**
----
Return time series for a hotel based on date group

* **URL**

  /api/hotel/`{id}`/overtime?from=`{from}`&to=`{to}`

* **Method:**

  `GET`


*  **URL Params**

   **Required:**

    -   `id=[integer]`
    -   `from=[date]<yyyy-mm-dd>`
    -   `to=[date]<yyyy-mm-dd>`
    
