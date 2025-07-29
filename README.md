# Projeto Filmes

A aplicação consiste em um catálogo de filmes que consome dados da API TMDB, com funcionalidades de busca e favoritos. O backend foi desenvolvido com Laravel e o frontend com Vue 3.

---

## 🔧 Tecnologias Utilizadas

### Backend
- PHP 8.2
- Laravel 12
- MySQL
- Nginx
- Docker

### Frontend
- Vue 3
- Vite
- TailwindCSS
- Axios

---

## 🚀 Instruções para rodar o projeto

> Pré-requisitos: Docker e Docker Compose instalados

## 🔐 Como obter a API Key do TMDB
- Acesse: https://www.themoviedb.org/
- Crie uma conta gratuita.
- Vá em “Settings” > “API” e gere sua chave.
- Adicione ao arquivo .env do frontend:

```bash
# Clone o repositório
git clone https://github.com/dinstmannCode/projeto-filmes.git
cd projeto-filmes

# Copie o .env do frontend e backend
Crie o arquivo .env a partir do exemplo:
cp backend/.env.example backend/.env

# Suba os containers
docker-compose up -d --build
# Execute o comando para entrar no container do backend:
docker exec -it projeto-filmes-app bash
# Execute os comandos
composer install
php artisan key:generate

# O banco é iniciado com o container mysql via Docker.
# Para popular manualmente:
php artisan migrate

# Saia do container do backend
exit

# Execute o comando para entrar no container do frontend:
docker exec -it projeto-filmes-frontend sh
# Execute o comando
npm install

# Caso queira manter a aplicação assistindo as alterações de estilo, rode o comando
npx @tailwindcss/cli -i ./src/style.css -o ./src/output.css --watch


# Acesse o frontend
http://localhost:5173

# Acesse o backend (API)
http://localhost:8000
```

---

## 🌐 Funcionalidades

### Página Inicial
- Lista de filmes populares da API TMDB
- Barra de pesquisa fixa e animada
- Scroll infinito (carrega mais ao rolar)
- Botão para adicionar favoritos com animação

### Página de Favoritos
- Exibe todos os filmes favoritados
- Botão para remover dos favoritos
- Modal de confirmação para remoção

---

## 📂 Estrutura do Projeto

### Backend
```
backend/
├── app/
│   └── Domains/
│       └── Movies/
│           ├── Models/
│           ├── Http/Controllers/
│           └── Services/TmdbService.php
├── routes/api.php
├── Dockerfile
└── nginx/
```

### Frontend
```
frontend/
├── src/
│   ├── components/
│   ├── views/
│   └── services/api.js
├── tailwind.config.js
├── Dockerfile
```

---

## 📫 API Endpoints

### TMDB
- `/movie/popular` (externo via service backend)

### Backend Laravel
- `GET /api/movies/add-favorites`
- `POST /api/movies/add-favorites`
- `DELETE /api/movies/favorites/{tmdb_id}`

---

## ✅ Testes

- Buscar filmes: Use a barra de pesquisa na Home.
- Adicionar aos favoritos: Clique no icone de coração.
- Visualizar favoritos: Acesse a aba “Meus Favoritos”.
- Remover favoritos: Clique no icone de corção e confirme na modal. Disponível apenas na pagina “Meus Favoritos”.
- Filtrar por gênero: Clique no gênero desejado para filtrar.

---

## 🗃️ CRUD dos Favoritos
- Model: App\Domains\Movies\Models\MovieFavorite
- Controller: App\Domains\Movies\Http\Controllers\MovieFavoriteController
- Service TMDB: App\Domains\Movies\Services\TmdbService
- Rotas: routes/api.php


## 🧠 Organização

- **Branches**: master + feat/*
- **Commits**: sempre em inglês seguindo convenções claras
- **Domain Driven Design** aplicado no backend

---

## ✅ Testes

O projeto foi testado utilizando:
- Insomnia (testes de API)
- Navegador com testes manuais
- Scroll e responsividade em diferentes tamanhos de tela

## 👨‍💻 Desenvolvedora

Marilia Dinstmann  
LinkedIn: [https://www.linkedin.com/in/marilia-dinstmann/]
---
