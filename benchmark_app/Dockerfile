
FROM debian:jessie

RUN apt-get update -y
RUN apt-get install php5 php5-pgsql -y

ADD ./select.php /
ADD ./words /

ENTRYPOINT php /select.php
