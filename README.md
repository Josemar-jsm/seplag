Nome: JOSEMAR CRISTIANO DA SILVA
Inscrição: 10161

# 🏛️ SEPLAG - API REST

Este projeto é uma API RESTful desenvolvida em Laravel com suporte a autenticação via JWT, banco de dados relacional e execução em ambiente Docker.

---

## 🚀 Como executar o projeto

### 📥 1. Clonar o repositório

```bash
git clone https://github.com/Josemar-jsm/seplag.git
```

### 📁 2. Entrar na pasta do projeto

```bash
cd seplag
```

### 🐳 3. Subir os containers com Docker

```bash
docker-compose up -d
```

### 📦 4. Instalar as dependências do Laravel

```bash
docker exec -it seplag_laravel_1 composer install
```

### 🗃️ 5. Executar as migrations

```bash
docker exec -it seplag_laravel_1 php artisan migrate
```

### 🌱 6. Popular o banco de dados com seeders

```bash
docker exec -it seplag_laravel_1 php artisan db:seed
```

Esse comando executa os seeders:
- `UnidadeSeeder`
- `UsuarioSeeder` (incluindo criação de um usuário para autenticação)

### 🔐 7. Gerar o token JWT

```bash
docker exec -it seplag_laravel_1 php artisan jwt:secret
```

---

## 🧪 Testando as APIs com Postman

Você pode importar os arquivos disponíveis na **raiz do projeto**:

- `Seplag - API Rest.postman_collection.json`
- `Seplag_Env.postman_environment.json`

### 💡 Como importar:
1. Abra o Postman.
2. Clique em **Importar**.
3. Selecione os arquivos `.json` acima.
4. Use o ambiente `Seplag_Env`.
5. Teste os endpoints com base na coleção `Seplag - API Rest`.

---

## ⚙️ Tecnologias Utilizadas

- Laravel
- PHP
- PostgreSQL
- Docker / Docker Compose
- JWT (Autenticação)
- Postman (para testes)
- Seeders e Migrations

---

## 👤 Autor

Desenvolvido por [Josemar Silva](https://github.com/Josemar-jsm)





