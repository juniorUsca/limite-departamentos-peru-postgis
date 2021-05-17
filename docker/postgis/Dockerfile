FROM postgis/postgis:13-3.1-alpine
ADD . /app
WORKDIR /app
RUN ./load_data.sh
RUN chown -R postgres:postgres /docker-entrypoint-initdb.d
