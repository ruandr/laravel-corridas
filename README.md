## Subindo ambiente Docker
Após clonar o projeto siga os seguintes passos

#### Buildando Buildando e Subindo App
```bash
$ docker-compose build app
```
```bash
$ docker-compose up -d
```

#### Configurando o Laravel
```bash
$ docker-compose exec app cp .env.example .env
```
```bash
$ docker-compose exec app composer install
```
```bash
$ docker-compose exec app php artisan key:generate
```

#### Executando Migrations e Seeders
```bash
$ docker-compose exec app php artisan migrate
```
```bash
$ docker-compose exec app php artisan db:seed
```

## Rotas

#### Cadastros
- Adiciona corredor: POST - `api/v1/corredor`
-- Parâmetros: nome, cpf, data_nascimento

- Adiciona prova: POST - `api/v1/prova`
-- Parâmetros: tipo¹, data

- Adiciona prova corredor: POST - `api/v1/provaCorredor`
-- Parâmetros: id_corredor, id_prova

- Adiciona prova resultado: POST - `api/v1/provaResultado`
-- Parâmetros: id_corredor, id_prova, hora_inicio², hora_fim²

#### Listagens
- Listagem de resultados gerais: GET - `api/v1/resultado`

- Listagem de resultados por idade: GET - `api/v1/resultado/classificacaoPorIdade/{faixaDeIdade?}³`

¹ Tipos de Prova
- 3
- 5
- 10
- 21
- 42

² Formato de horarios esperados: hh:mm

³ Faixa de idade: opcional
- 18-25
- 26-35
- 36-45
- 46-55
- 56-999

## Api Requests
O Seeder irá gerar um usuário de teste com um token de requisição fixo para testes: FF3B6EAAAC507A073DA3CE09
Segue o exemplo de requisição
    Authorization: Bearer FF3B6EAAAC507A073DA3CE09

