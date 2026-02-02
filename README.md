# BOOKS-API-LARAVEL


```

## Serviços

- **app**: Container PHP-FPM 8.2 com Laravel
- **nginx**: Servidor web Nginx
- **db**: Banco de dados PostgreSQL 15

## Pré-requisitos

- Docker
- Docker Compose
- Projeto Laravel (se ainda não tiver, veja instruções abaixo)


```

## 1. Configurar o ambiente:

### copiar e editar o arquivo .env.example


```bash
cp .env.example .env

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_password
```

## 2. Iniciar os containers:

### construir e iniciar os containers
```bash
docker-compose up -d --build
```
### Instalar dependências do Laravel
```bash
docker-compose exec app composer install
```
# Gerar a chave da aplicação
```bash
docker-compose exec app php artisan key:generate
```

# Rodar as migrations
```bash
docker-compose exec app php artisan migrate
```

### 5. Acessar a aplicação:

Abra no navegador: `http://localhost:8000`

## Documentação da API

Todas as rotas da API possuem o prefixo `/api`.

### Autenticação

| Endpoint | Método | Descrição | Protegido |
| :------- | :----- | :--------- | :-------- |
| `/register` | `POST` | Registro de novo usuário | Não |
| `/login` | `POST` | Login do usuário | Não |
| `/logout` | `POST` | Logout do usuário | Sim (Sanctum) |
| `/refresh` | `POST` | Atualiza o token do usuário | Sim (Sanctum) |
| `/me` | `GET` | Retorna os dados do usuário logado | Sim (Sanctum) |

#### Detalhes dos Endpoints

**1. Registro (`POST /api/register`)**
- **Body:**
  ```json
  {
    "name": "Nome do Usuário",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
  }
  ```
- **Resposta (201 Created):**
  ```json
  {
    "message": "User created successfully",
    "user": { "id": 1, "name": "Nome", "email": "user@example.com", ... },
    "token": "1|abcdef..."
  }
  ```

**2. Login (`POST /api/login`)**
- **Body:**
  ```json
  {
    "email": "user@example.com",
    "password": "password"
  }
  ```
- **Resposta (200 OK):**
  ```json
  {
    "message": "User logged in successfully",
    "user": { "id": 1, "name": "Nome", "email": "user@example.com", ... },
    "token": "2|ghjikl..."
  }
  ```

**3. Logout (`POST /api/logout`)**
- **Header:** `Authorization: Bearer {token}`
- **Resposta (200 OK):**
  ```json
  {
    "message": "User logged out successfully"
  }
  ```

**4. Refresh Token (`POST /api/refresh`)**
- **Header:** `Authorization: Bearer {token}`
- **Resposta (200 OK):**
  ```json
  {
    "message": "Token refreshed successfully",
    "token": "3|mnopqr..."
  }
  ```

**5. Me (`GET /api/me`)**
- **Header:** `Authorization: Bearer {token}`
- **Resposta (200 OK):**
  ```json
  {
    "user": { "id": 1, "name": "Nome", "email": "user@example.com", ... }
  }
  ```

## Comandos Úteis

```bash
# Ver logs
docker-compose logs -f

# Parar os containers
docker-compose down

# Parar e remover volumes (CUIDADO: apaga o banco!)
docker-compose down -v

# Acessar o container da aplicação
docker-compose exec app bash

# Rodar comandos Artisan
docker-compose exec app php artisan [comando]

# Rodar Composer
docker-compose exec app composer [comando]

# Acessar o PostgreSQL
docker-compose exec db psql -U laravel_user -d laravel_db
```

## Portas

- **8000**: Aplicação Laravel (Nginx)
- **5432**: PostgreSQL (caso queira acessar diretamente)

## Credenciais do Banco

- **Host**: db (dentro do Docker) ou localhost (fora do Docker)
- **Porta**: 5432
- **Database**: laravel_db
- **Usuário**: laravel_user
- **Senha**: laravel_password

## Troubleshooting

### Erro de permissão em storage/

```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### Erro de conexão com o banco:

Verifique se o container do banco está rodando:
```bash
docker-compose ps
```

### Limpar tudo e recomeçar:

```bash
docker-compose down -v
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```