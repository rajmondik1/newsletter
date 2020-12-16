
## Symfony mysql ngingx boilerplate on docker with rabbitmq
#### To start run:
```cd app```
#### Create env file and change required fields 
```cp .env.example .env```
```sudo docker-compose build```
#### Then install dependencies
```composer install```
#### Start the containers
```docker-compose up```

## admin@admin.com test

## Client
```
 cd client/
 npm run serve
 ```
Url: http://localhost:8080/
## Admin dashboard
``` 
cd admin/
npm run dev
```
Url: http://localhost:9528/
## API
``` 
cd app/
docker-compose up
 ```
Url: http://localhost/

### or just simply run ./start.sh