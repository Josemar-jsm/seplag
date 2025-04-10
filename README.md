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

## 🔐 Autenticação com JWT

A autenticação da API utiliza tokens JWT (JSON Web Token). O token tem validade de **5 minutos** e pode ser renovado antes de expirar.

### Fluxo de autenticação
1. Faça login com `POST /api/v1/auth/login` e receba um token JWT.
2. Use esse token para autenticar requisições protegidas via header:
   ```
   Authorization: Bearer {seu_token}
   ```
3. Antes que o token expire, chame `POST /api/v1/auth/refresh` para gerar um novo token.
4. Para obter os dados do usuário autenticado, utilize `GET /api/v1/auth/me`.

### Endpoints de autenticação
- `POST /api/v1/auth/login` — Login do usuário
- `POST /api/v1/auth/logout` — Logout do usuário
- `POST /api/v1/auth/refresh` — Renovar o token JWT
- `GET /api/v1/auth/me` — Retornar dados do usuário autenticado

### ℹ️ Dica: como usar o token no Postman

Após realizar o login (`POST /api/v1/auth/login`), copie o valor de `access_token` da resposta.

Abra o Postman, vá até o ambiente `Seplag_Env` e atualize a variável `auth_key` com o token:

1. Clique em "Environments" no canto superior direito.
2. Selecione `Seplag_Env`.
3. Na linha da variável `auth_key`, cole o token JWT recebido.
4. Salve.

A partir disso, os endpoints protegidos que usam `{{auth_key}}` no header `Authorization` funcionarão normalmente.

---

## 📚 Endpoints Disponíveis

### 🔐 Autenticação
- `POST /api/v1/auth/login` — Login do usuário
- `POST /api/v1/auth/logout` — Logout do usuário
- `POST /api/v1/auth/forgot-password` — Recuperação de senha
### 🏛️ Unidades
- `GET /api/v1/unidades` — Listar unidades
- `GET /api/v1/unidades/{id}` — Visualizar unidade
- `POST /api/v1/unidades` — Cadastrar unidade
- `PUT /api/v1/unidades/{id}` — Atualizar unidade
- `DELETE /api/v1/unidades/{id}` — Excluir unidade
### 👨‍💼 Servidores Efetivos
- `GET /api/v1/servidores-efetivos` — Listar servidores efetivos
- `GET /api/v1/servidores-efetivos/{id}` — Visualizar servidor efetivo
- `POST /api/v1/servidores-efetivos` — Cadastrar servidor efetivo
- `PUT /api/v1/servidores-efetivos/{id}` — Atualizar servidor efetivo
- `DELETE /api/v1/servidores-efetivos/{id}` — Excluir servidor efetivo
- `GET /api/v1/servidores-efetivos/unidade/{unid_id}` — Listar servidores de uma unidade
- `GET /api/v1/servidores-efetivos/endereco-funcional?nome=Jo` — Buscar endereço funcional por nome
### 🗂️ Lotações
- `GET /api/v1/lotacoes` — Listar lotações
- `GET /api/v1/lotacoes/{id}` — Visualizar lotação
- `POST /api/v1/lotacoes` — Cadastrar lotação
- `PUT /api/v1/lotacoes/{id}` — Atualizar lotação
- `DELETE /api/v1/lotacoes/{id}` — Excluir lotação
### 🖼️ Fotos Temporárias
- `GET /servidores-efetivos/{id}/foto-temporaria` — Obter URL temporária de uma foto
- `POST /servidores-efetivos/{id}/fotos` — Upload de múltiplas fotos em base64

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




