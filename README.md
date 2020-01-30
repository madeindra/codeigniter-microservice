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
```http
GET localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices
```
```http
POST localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices
```
```http
GET localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/{invoice_id}
```
```http
PUT localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/{invoice_id}
```
```http
DELETE localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/{invoice_id}
```
```http
PUT localhost:8081/tdd-microservice-poc/index.php/api/v1/invoices/orders/{order_id}
```

```http
GET localhost:8082/tdd-microservice-poc/index.php/api/v1/orders
```
```http
POST localhost:8082/tdd-microservice-poc/index.php/api/v1/orders
```
```http
GET localhost:8082/tdd-microservice-poc/index.php/api/v1/orders/{order_id}
```
```http
PUT localhost:8082/tdd-microservice-poc/index.php/api/v1/orders/{order_id}
```
```http
DELETE localhost:8082/tdd-microservice-poc/index.php/api/v1/orders/{order_id}
```
```http
POST localhost:8082/tdd-microservice-poc/index.php/api/v1/orders/checkout/{order_id}
```

```http
GET localhost:8083/tdd-microservice-poc/index.php/api/v1/products
```
```http
POST localhost:8083/tdd-microservice-poc/index.php/api/v1/products
```
```http
GET localhost:8083/tdd-microservice-poc/index.php/api/v1/products/{product_id}
```
```http
PUT localhost:8083/tdd-microservice-poc/index.php/api/v1/products/{product_id}
```
```http
DELETE localhost:8083/tdd-microservice-poc/index.php/api/v1/products/{product_id}
```
```http
PUT localhost:8083/tdd-microservice-poc/index.php/api/v1/products/stocks/{product_id}
```
## Architecture
Here is the architecture for the microservice (if it fails to show, you can open the `TDD Microservice.xml` in draw.io)

![Diagram](https://gitlab.playcourt.id/indrawp/tdd-microservice-poc/raw/develop/TDD%20Microservice.xml)
