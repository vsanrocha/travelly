# Travelly

Sistema de pedidos de viagem corporativa.

## ☁️ Visão Geral
O Travelly é uma plataforma para gestão de solicitações de viagem em empresas. Permite que colaboradores criem, acompanhem e atualizem pedidos de viagem, enquanto gestores podem aprovar, rejeitar ou monitorar o status dos pedidos.

**Principais features:**
- Cadastro e autenticação de usuários
- CRUD de solicitações de viagem
- Aprovação/rejeição de pedidos
- Notificações automáticas
- Interface intuitiva e responsiva

## 🚀 Tecnologias
- Laravel (backend)
- Vue 3 (frontend SPA)
- Pinia (estado global)
- Tailwind CSS
- Docker
- MySQL
- VeeValidate, Shadcn Vue
- ESLint + Prettier

## 📁 Estrutura de Pastas
- `/api` — Backend Laravel (API REST, autenticação, regras de negócio)
- `/client` — Frontend Vue 3 (SPA, autenticação, interface do usuário)

## 🛠️ Pré-requisitos
- Docker
- pnpm
- PHP >= 8.1
- Node.js >= 18

## 🎯 Como rodar
1. Suba o backend:
   ```bash
   cd api
   ./vendor/bin/sail up -d
   ```
2. Suba o frontend:
   ```bash
   cd ../client
   docker-compose up
   ```

## 📄 Awards & Observações
- **Usuário de Teste:**
  - Um usuário padrão é criado pelo seeder para facilitar testes da aplicação:
    - **E-mail:** test@travelly.com
    - **Senha:** 123456

## 📚 Links úteis
- [README do Backend](./api/README.md)
- [README do Frontend](./client/README.md)
