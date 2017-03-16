
FROM alpine:3.5

RUN apk update
RUN apk add php5 php5-pgsql php5-pdo php5-pdo_pgsql

COPY php.ini /usr/local/etc/php/
COPY ./postgresql.php /
COPY ./words /

ENTRYPOINT php /postgresql.php
