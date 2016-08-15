#!/bin/bash

for f in *.shp
do
    shp2pgsql -I -s 32718 -W "latin1" $f `basename $f .shp` > `basename $f .shp`.sql
done

for f in *.sql
do
    psql -U dubgcc -d cartografia_peru -f $f
done
