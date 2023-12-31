FROM php:latest

RUN apt-get update && apt-get install -y bash

WORKDIR /var/www/html

COPY ./src ./

RUN chmod 755 *;
EXPOSE 8888

CMD ["php", "-S", "0.0.0.0:8888"]