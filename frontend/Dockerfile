# frontend/Dockerfile

FROM node:22.12

WORKDIR /app

COPY package.json package-lock.json ./

# Instala dependências
RUN npm install

COPY . .

RUN npx @tailwindcss/cli -i ./src/style.css -o ./src/output.css --watch

EXPOSE 5173

CMD ["npm", "run", "dev", "--", "--host", "npx", "tailwindcss", "preview", "--port", "5173"]
