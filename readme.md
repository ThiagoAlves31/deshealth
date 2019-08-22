### deshealth
----
Dependências:
- [Git](https://git-scm.com/ "Git")
- [Composer](https://getcomposer.org/ "Composer")
- [Docker](https://docs.docker.com/get-started/ "Docker")
- [Docker Compose](https://docs.docker.com/compose/install/ "Docker Compose")

#### Siga os passos abaixo para subir o projeto:
```
git clone https://github.com/ThiagoAlves31/deshealth.git
```
```
cd deshealth
```
```
cp .env-example .env
```
```
sudo apt-get install php7.2-mbstring && sudo apt-get install php7.2-xml
```

```
composer install
```
#### Iniciar o container:

Por default a porta padrão do Mysql é a 3306 e do Nginx 8080.
Essa configuração pode ser alterada no docker-compose.yml na raiz do projeto.
```
docker-compose up -d 
```
#### Acessando o container:
```
docker exec -it health-docker-php-fpm bash
```
#### Dentro do container.
Vamos adicionar permissão nos Logs, por ser ambiente de teste vai ser 777 mesmo.
```
chmod -R 777 storage/*
```
Criar tabelas e adicionar dados fictícios.
```
php artisan key:generate
php artisan migrate
php artisan db:seed
```
### Utilizando API
#### Produtos
- GET  /api/products        - Lista todos os produtos
- GET  /api/products/{id}   - Lista um produto pelo id
- GET  /api/products/description/{descricao}   - Lista produtos por palavra chave, procura pelo nome ou nome da industria
- POST /api/products        - Cria um novo produto passando um Json como no exemplo abaixo, podendo passar o numero de estoque ou n
                              não.Caso não passe nada o produto é cadastrado porém com o estoque = 0.
```
{
    "name": "Dorflex 300gm",
    "industry": "Eurofarma",
    "price": "22,90",
    "amount": "100"
}
```
- PUT /api/products/{id}    - Atualiza um produto passando um id e Json.Podendo atualizar 1 ou mais ítens do produto
```
{
    "name": "Dorflex 300gm",
    "industry": "Eurofarma",
    "price": "30,90",
    "amount": "99"
}
```
- DELETE /api/products/{id} - Deleta um produto pelo id
