
# Snapp-food challenge

A system to manage order delay reports
## Deployment

To deploy this project, you must have tools such as [docker](https://docs.docker.com/engine/install/) and [docker-compose](https://docs.docker.com/compose/install/) installed.

After the installed:

```bash
cd /project directory

docker-compose -d up
```

After the docker-compose running:

```bash
docker-compose exec app php artisan migrate

docker-compose exec app php artisan dummy:user
```


## API Reference


#### * Login to application
You must be login with username and password

```http
  POST /api/v1/users/login
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `username` | `string` | **Required**. Your username(example:"dummy") |
| `password` | `integer` | **Required**. Your password(example:123456)  |

#### * Create new delay report
Create a delay report for an order using the order ID

```http
  POST Bearer{token} /api/v1/orders/delays/reports
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `orderId` | `integer` | **Required**. The ID of an order |

#### * Assign delay reports to online agent for reviews.

```http
  POST Bearer{token} /api/v1/orders/reviews
```
<font size="1">* This request Assigns the order ID in the delay queue to an online and workless agent.<font>





#### * Get The amount of delay of each store in a period of one week 

```http
  GET Bearer{token} /api/v1/vendors
```




## Postman API Documentation

Click to use: [Postman API](https://documenter.getpostman.com/view/6454018/UzBqoQSU)
## Running Tests

To run tests, run the following command

```bash
  docker-compose exec app php artisan test
```

