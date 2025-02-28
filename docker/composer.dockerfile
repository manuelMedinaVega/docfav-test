FROM composer:latest

ENV COMPOSERUSER=manu
ENV COMPOSERGROUP=manu

RUN adduser -g ${COMPOSERGROUP} -s /bin/sh -D ${COMPOSERUSER}