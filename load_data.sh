#!/bin/sh

for f in ./departamentos/*.shp
do
    shp2pgsql -I -s 32718 -W "latin1" $f `basename $f .shp` > /docker-entrypoint-initdb.d/`basename $f .shp`.sql
done

for f in ./provincias/*.shp
do
    shp2pgsql -I -s 32718 -W "latin1" $f `basename $f .shp` > /docker-entrypoint-initdb.d/`basename $f .shp`.sql
done

for f in ./distritos/*.shp
do
    shp2pgsql -I -s 32718 -W "latin1" $f `basename $f .shp` > /docker-entrypoint-initdb.d/`basename $f .shp`.sql
done
