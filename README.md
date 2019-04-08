# api-pet

## Passo a passo - Configuração

```php
    composer install
    
    sudo chmod -R 777 storage
    sudo chmod -R 777 bootstrap/cache
    
    php artisan key:generate
```

Após instalar. criar e configurar o arquivo .env

```php
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_DATABASE={NOME-DO-BANCO}
    DB_USERNAME={NOME-DO-USUARIO}
    DB_PASSWORD={SENHA-DO-BANCO}
```

Em seguida, configurar a aplicação:

```php
    php artisan vendor:publish
    php artisan jwt:generate
    php artisan migrate
    php artisan db:seed
```

## EndPoits

### Autenticação

```
    POST    api/autenticacao/
    GET     api/autenticacao/detalhes
```

### Raças

```
    GET     api/racas
    GET     api/racas/{id}
    POST    api/racas/store
    PUT     api/racas/{id}
    DELETE  api/racas/{id}
```

### Proprietários

```
    GET     api/proprietarios
    GET     api/proprietarios/{id}
    POST    api/proprietarios/store
    PUT     api/proprietarios/{id}
    DELETE  api/proprietarios/{id}
```

### Animais (Pets)

```
    GET     api/pets
    GET     api/pets/{id}
    POST    api/pets/store
    PUT     api/pets/{id}
    DELETE  api/pets/{id}
```

## Testes Unitários

```php
    vendor/bin/phpunit
```

## Postman 

Segue no projeto o arquivo de exportação do postman, contendo os endpoints listados acima, conforme solicitado no projeto.

```
    postman-api-pets.postman_collection.json
```
