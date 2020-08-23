FROM nginx:1.19.2-alpine

WORKDIR /app

COPY ./docker/nginx.conf /etc/nginx/nginx.conf
