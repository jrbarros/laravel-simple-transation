## Simple Laravel transaction API

This is a simple Laravel API that allows users to create accounts and make transactions. Ex : credit, debit, PIX.

This project is example of how to use Laravel to create a simple API, using many of the Laravel features and best practices.


## Running the project

To run the project, you need to have docker and docker-compose installed on your machine. After that, you can run the following command:

```bash
docker-compose up -d
```


## Testing the project

To test the project, you need to have docker and docker-compose installed on your machine. After that, you can run the following command:

```bash
docker-compose exec local-php artisan test
```

### Todo

- [ ] Add more unit tests
- [ ] Adds Events
- [ ] Adds Jobs
- [ ] Adds Queue
- [ ] Adds Notifications
- [ ] Add OpenAPI documentation
