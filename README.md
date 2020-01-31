# TDD Microservice in PHP
## Introduction
This project is a proof-of-concept of Microservice Architecture build using CodeIgniter 3 with Test Driven Development in mind.  

There are three main decoupled service in this projects: Financial service, Order service, and Warehouse service. Each services has its own MySQL database, in case a service need data from another service, the service will do the checking using Helper that pass message through RabbitMQ AMQP Queue. All these dependency are already packed in one docker-compose.

## Prerequiste
- Docker
- Docker Compose
- Apache HTTP Server (Optional, already bundled in docker-compose)
- PHP 7.3 (Optional, already bundled in docker-compose)
- MySQL 8.0 (Optional, already bundled in docker-compose)
- RabbitMQ (Optional, alraedy bundled in docker-compose)

## Running
Normally, to run PHP application we just need to access it from browser by entering the address and the browser will render the page according to the instructions coded. To enable the worker subscribtion to the queue, it need to run continously, thus the worker run by using CLI. Worker initialization is done automatically if using docker-compose, if not then start the worker by running the start_worker.sh script on each service directory. 

**Start with docker (recommended)**
```
docker-compose up
```

php container will fail several time, it is normal, because it is waiting for the RabbitMQ container to be up.

If containers are run succesfully, you will see two lines of messages like shown bellow, that means the worker already started subscribing to the queue.
```
[x] Awaiting message
``` 

## Database Migration
To start database migration,access each service with migrate route (by default the services run in port 8081, 8082, and 8083)
```http
localhost:8081/tdd-microservice-poc/index.php/migrate
localhost:8082/tdd-microservice-poc/index.php/migrate
localhost:8083/tdd-microservice-poc/index.php/migrate
```

## API
### Financial Service
#### Get list of invoices
```http
GET localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices
```

#### Create a new invoice
(Usually called by helper after order check out)
```http
POST localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices
```

Request Body
```json
{
    "id": "1",
    "order_id": "1",
    "total": "10000",
    "status": "incomplete"
}
```
`id` is optional, it is auto-increased from previous data in the table
#### Get an invoice

```http
GET localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/{invoice_id}
```

#### Update an invoice 
```http
PUT localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/{invoice_id}
```

Request Body
```json
{
    "status": "waiting"
}
```

#### Delete an invoice
```http
DELETE localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/{invoice_id}
```

#### Update an invoice by order id
(Usually called by helper after confirming stock exist)
```http
PUT localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/orders/{order_id}
```

Request Body
```json
{
    "status": "waiting"
}
```

#### Delete an invoice by order id
(Usually called by helper after failing to confirm stock exist)
```http
DELETE localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/{invoice_id}
```

### Order Service
#### Get list of orders
```http
GET localhost:8082/tdd-microservice-poc/index.php/api/v1/orders
```

#### Create a new order
```http
POST localhost:8082/tdd-microservice-poc/index.php/api/v1/orders
```
Request Body
```json
{
    "id": "1",
    "product_id": "1",
    "quantity": "5",
    "price": "5000"
}
```
`id` is optional, it is auto-increased from previous data in the table

#### Get an order
```http
GET localhost:8082/tdd-microservice-poc/index.php/api/v1/orders/{order_id}
```

#### Update an order
```http
PUT localhost:8082/tdd-microservice-poc/index.php/api/v1/orders/{order_id}
```

Request Body
```json
{
    "quantity": "10",
    "price": "500"
}
```

#### Delete an order
```http
DELETE localhost:8082/tdd-microservice-poc/index.php/api/v1/orders/{order_id}
```

Request Body
```json
(Not required)
```

#### Checkout an order to create it invoice and update the stock
(Will create invoice and check if products is in stock)
```http
POST localhost:8082/tdd-microservice-poc/index.php/api/v1/orders/checkout/{order_id}
```

### Warehouse Service
#### Get list of products
```http
GET localhost:8083/tdd-microservice-poc/index.php/api/v1/products
```

#### Create a new product
```http
POST localhost:8083/tdd-microservice-poc/index.php/api/v1/products
```

Request Body
```json
{
    "id": "1",
    "stock": "10",
    "price": "500"
}
```
`id` is optional, it is auto-increased from previous data in the table

#### Get a product
```http
GET localhost:8083/tdd-microservice-poc/index.php/api/v1/products/{product_id}
```

#### Update a product
```http
PUT localhost:8083/tdd-microservice-poc/index.php/api/v1/products/{product_id}
```

Request Body
```json
{
    "stock": "10",
    "price": "500"
}
```

#### Delete a product
```http
DELETE localhost:8083/tdd-microservice-poc/index.php/api/v1/products/{product_id}
```

#### Update stock of a product
```http
PUT localhost:8083/tdd-microservice-poc/index.php/api/v1/products/stocks/{product_id}
```

Request Body (Decrese stock by 10)
```json
{
    "quantity" : "-10"
}
```

Request Body (Increase stock by 10)
```json
{
    "quantity" : "+10"
}
```

## Architecture
Here is the architecture for the microservice (if it fails to show, you can open the `TDD Microservice.xml` in draw.io)

![Diagram](https://gitlab.playcourt.id/indrawp/tdd-microservice-poc/raw/develop/TDD%20Microservice.xml)
