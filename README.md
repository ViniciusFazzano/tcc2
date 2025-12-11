# Instalação do Projeto Laravel

Este documento descreve o processo completo para configurar e executar o projeto Laravel em um ambiente local de desenvolvimento.

---

## 1. Requisitos mínimos

Certifique-se de ter instalado:

* PHP **>= 8.1** (com extensões recomendadas pelo Laravel)
* Composer **>= 2.x**
* MySQL ou PostgreSQL
* Node.js **>= 18** e NPM ou Yarn
* Git
---

## 2. Clonar o repositório

```bash
git clone https://github.com/ViniciusFazzano/tcc2.git
cd tcc2
```

---

## 3. Instalar dependências PHP

```bash
composer install
```

---

## 4. Configurar o arquivo de ambiente

Crie o arquivo `.env`:

```bash
cp .env.example .env
```

Edite os valores no `.env` conforme necessário:

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
# DB_HOST=localhost
# DB_PORT=5432
# DB_DATABASE=laravel
DB_USERNAME=postgres
DB_PASSWORD=batata
```

---

## 6. Executar migrações e seeders (opcional)

```bash
php artisan migrate
# ou
php artisan migrate --seed
```

---

## 8. Iniciar o servidor local

```bash
php artisan serve
```

Acesse:

```
http://127.0.0.1:8000
```

---

## 10. Executar testes

```bash
php artisan test
```

Ou:

```bash
vendor/bin/phpunit
```

---
