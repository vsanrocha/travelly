# Frontend – Travelly

## 📝 Descrição
SPA desenvolvida em Vue 3, com TypeScript, Pinia para gerenciamento de estado, Vue Router para navegação e VeeValidate para validação de formulários.

## ⚙️ Setup local
1. Instale as dependências:
   ```bash
   pnpm install
   ```

## 🏃 Scripts
- `pnpm dev` — Inicia o servidor de desenvolvimento
- `pnpm build` — Gera build de produção
- `pnpm lint` — Lint do código com ESLint
- `pnpm format` — Formata o código com Prettier

## 🐳 Docker
- Para subir o frontend em container:
  ```bash
  docker-compose up
  ```

## 🖥️ Estrutura de Pastas
- `components/` – Componentes reutilizáveis da interface
- `pages/` – Páginas principais da aplicação
- `layouts/` – Layouts globais e wrappers
- `store/` – Stores Pinia para estado global

## 🎨 Estilização
- UI baseada em Shadcn Vue
- Tailwind CSS para utilitários de estilo
- ESLint + Prettier para padronização e qualidade de código

## 🔐 Autenticação
- Login realizado via formulário, autenticação com token JWT/Sanctum
- O token é armazenado no `localStorage` e enviado via header `Authorization` em cada requisição autenticada

## 🔗 Integração com API
- Axios configurado em `src/utils/axios.ts`
- Interceptors para adicionar token de autenticação e tratar respostas de erro
