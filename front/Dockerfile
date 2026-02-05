FROM node:lts-alpine

RUN npm install -g http-server

WORKDIR /app

COPY package*.json ./

COPY quasar.config.ts ./

COPY index.html ./

RUN npm install

COPY . .

RUN npm run build

EXPOSE 8080
CMD [ "http-server", "dist/spa", "-p", "8080", "-a", "0.0.0.0" ]