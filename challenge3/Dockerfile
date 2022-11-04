FROM nginx:latest

ENV UNAME=web

RUN apt-get update \
&& apt-get install -y curl vim mc tree jq php-fpm\
&& apt-get clean \
&& apt-get autoremove -y --purge

RUN sleep 3
RUN service php7.4-fpm start

COPY ./app /app
COPY site.conf /etc/nginx/conf.d/default.conf

WORKDIR /app