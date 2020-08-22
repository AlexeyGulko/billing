
## Billing application

###how to install 

- clone this repo
- run `docker run --rm -v $(pwd):/app composer install`
- in project directory run `cp .env.example .env` and cofigure it  
- run in git project directory `docker-compose up -d` 
- after run `docker-compose exec app php artisan key:generate
` and `docker-compose exec app php artisan migrate
`
