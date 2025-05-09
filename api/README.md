# Backend – Travelly

## 📝 Descrição
API REST em Laravel para CRUD de TravelRequest, incluindo autenticação, políticas de acesso e notificações.

## ⚙️ Setup local
1. Copie o arquivo `.env.example` para `.env` e configure as variáveis principais:
   - `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
2. Instale as dependências:
   ```bash
   composer install
   ```
3. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```
4. Execute as migrações e seeders:
   ```bash
   php artisan migrate --seed
   ```

## 🐳 Docker (Laravel Sail)
- Utilize o Laravel Sail para ambiente de desenvolvimento containerizado.
- Para subir os containers:
  ```bash
  ./vendor/bin/sail up -d
  ```
- Para executar comandos artisan dentro do container:
  ```bash
  ./vendor/bin/sail artisan <comando>
  ```
- Para acessar o bash do container:
  ```bash
  ./vendor/bin/sail shell
  ```
- Se houver overrides, utilize arquivos como `docker-compose.override.yml` conforme necessário.

## 🔐 Autenticação
- Utiliza Laravel Sanctum para autenticação baseada em token.
- Para gerar um token de acesso:
  1. Faça login via rota `/api/login` (POST) com email e senha.
  2. O token será retornado na resposta e deve ser usado no header `Authorization: Bearer <token>`.

## 🛣️ Rotas principais
- `GET    /api/travel-requests` – Listar solicitações
- `POST   /api/travel-requests` – Criar solicitação
- `GET    /api/travel-requests/{id}` – Detalhar solicitação
- `PUT    /api/travel-requests/{id}` – Atualizar solicitação
- `PATCH  /api/travel-requests/{id}/status` – Atualizar status
- `DELETE /api/travel-requests/{id}` – Remover solicitação

## 🧪 Testes
- Para rodar os testes no container:
  ```bash
  ./vendor/bin/sail artisan test
  ```
- Para rodar os testes localmente:
  ```bash
  php artisan test
  ```

## 📄 Awards & Observações
- **Policies:** Controle de acesso por usuário implementado via `TravelRequestPolicy`.
- **Form Requests:** Validação centralizada de dados nas requisições.
- **Notifications:** Notificações automáticas em eventos relevantes (ex: status atualizado).
