
# Project Title

e-commerce project that have Visitors, merchants end-consumers roles that interacte together in
the e-commerce to buy and sell products from diffrent stores.


## Perquisites
- PHP version +8.1

- Laravel version +8

- Mysql server

- Git 
## getting started steps

To deploy this project run

1- Clone the project for github 
```bash
git clone https://github.com/ahmedabdelaziz11/e-commerce
```
2. Move to the project folder 
        
```bash
cd e-commerce
```

3. Run Composer install in the project folder

```bash
composer install
```

4. Copy .env.example file in the project folder

```bash
cp .env.example .env
```
5. open mysql server
> create database with any name then edit the following in your .env file

```env
DB_DATABASE=database_name
DB_USERNAME=user_name
DB_PASSWORD=password
```

6. Run the following commands in same sequence

```bash
php artisan key:generate
php artisan jwt:secret
php artisan serve
```

7. open open the following link

<http://localhost:8000>

## API Reference

you can find all api links and data in this Postman [link](https://documenter.getpostman.com/view/25927491/2s93JtPPBT)