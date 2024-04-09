## Inicialização do projeto

### Passo a passo

Crie o Arquivo .env
```sh
cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install
```


Gerar a key do projeto Laravel
```sh
php artisan key:generate
```


Acesse o projeto
[http://localhost](http://localhost)


Gerar a JWT key secret
```sh
php artisan jwt:secret
```

Gerar a JWT certs
```sh
php artisan jwt:generate-certs
```

Gerar as migrations e seeders

```sh
php artisan migrate

php artisan db:seed
```

Após esse passos você pode iniciar as requisições para os endpoints


\
\
\
\
![FastControl](https://i.imgur.com/HlZpwda.png)

