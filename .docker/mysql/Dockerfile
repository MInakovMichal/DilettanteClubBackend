FROM mysql:8

ADD .docker/mysql/docker-entrypoint-initdb.d/setup.sh /opt/setup.sh

ARG TZ=UTC
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone && chown -R mysql:root /var/lib/mysql/

CMD ["mysqld"]

EXPOSE 3306
