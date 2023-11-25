Step 1 :
```
composer install
```

```
npm install
```

Step 2:

set your database in .env after that run below command
```
php artisan migrate:refresh --seed
```
```
php artisan passport:install
```


Step 3:

Import postman collection link:
https://devgjteam1.postman.co/workspace/My-Workspace~5dcc1f5f-afed-4ffb-8dcd-98f39544bd7c/collection/18346261-1689efa2-bab5-4862-a54d-90187a4f7b3f?action=share&creator=18346261&active-environment=18346261-4343a92a-4e78-4354-b4be-d9c5d30c79c2

and add postman collection Variables add project directory path in api_path variable "api_path". ex.: "http://localhost/social-app/public/api/"
