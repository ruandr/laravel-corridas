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

## Api Requests
O Seeder irá gerar um usuário de teste com um token de requisição fixo para testes: `FF3B6EAAAC507A073DA3CE09`

Exemplo de chamada da requisição

    Authorization: Bearer FF3B6EAAAC507A073DA3CE09

Além do header `Authorization` as rotas de cadastro necessitam do header `Content-Type`

    Content-Type: application/x-www-form-urlencoded

Os parâmtros devem ser enviados como parâmetros de formulário

## Rotas

#### Cadastros
- Adiciona corredor: POST - `api/v1/corredor`
    - Parâmetros: `nome`, `cpf`, `data_nascimento`

- Adiciona prova: POST - `api/v1/prova`
    - Parâmetros: `tipo`¹, `data`

- Adiciona prova corredor: POST - `api/v1/provaCorredor`
    - Parâmetros: `id_corredor`, `id_prova`

- Adiciona prova resultado: POST - `api/v1/provaResultado`
    - Parâmetros: `id_corredor`, `id_prova`, `hora_inicio`², `hora_fim`²

#### Buscas
- Busca corredores cadastrados: GET - `api/v1/corredores`

- Busca corredor por cpf: GET - `api/v1/corredor/{cpf}`

- Busca provas cadastradas: GET - `api/v1/provas`

- Busca provas por data: GET - `api/v1/provas/data/{data}`

- Busca provas por tipo: GET - `api/v1/provas/tipo/{tipo}¹`

- Busca Provas Corredores cadastrados: GET - `api/v1/provasCorredores`

- Busca Provas Corredores por Ids de prova e corredor: GET - `api/v1/provaCorredor/{idProva}/{idCorredor}`

#### Listagens
- Listagem de resultados gerais: GET - `api/v1/resultado`

- Listagem de resultados por idade: GET - `api/v1/resultado/classificacaoPorIdade/{faixaDeIdade?}³`

¹ Tipos de Prova
- 3
- 5
- 10
- 21
- 42

² Formato de horarios esperados: `hh:mm`

³ Faixa de idade: opcional
- 18-25
- 26-35
- 36-45
- 46-55
- 56-999

## Arquitetura
O projeto utiliza além do MVC padrão do Laravel alguns patterns para melhor organização e escalabilidade do código, visando separar as dependencias de maneira organizada.

- Service Layer
O patter Service Layer, é utilizado para separar a lógica das regras de negócio em uma camada diferente do Controller, assim, o controller irá se responsabilizar apenas de chamar os métodos dos services necessários para executar as ações que deseja.

- Repository Pattern
O repository pattern é um modo de centralizar toda a interação com o banco de dados em uma outra camada, neste caso foi aplicato o CQRS pattern em conjunto.

- CQRS Pattern
O CQRS(Command Query Responsibility Segregation) é utilizado para separar as interações com o banco em dois tópicos:

    - Queries: Responsáveis pela leitura em banco
    - Commands: Responsáveis pela escrita(INSERT e UPDATE) e remoção(DELETE)