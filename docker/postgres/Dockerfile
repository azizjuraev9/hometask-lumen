FROM postgres:alpine

ARG DB_DATABASE
ARG DB_PORT

RUN apk update \
    && apk add mc nano wget

CMD ["postgres"]

EXPOSE $DB_PORT
