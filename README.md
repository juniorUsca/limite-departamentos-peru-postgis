# limite-departamentos-peru-postgis
Limite departamental, provincial y distrital del Peru. Usando postgis, php y google maps


1. Instalar postgis y crear una base de datos llamada: cartografia_peru
2. Entrar a las carpetas: departamentos, distritos y provincias
3. Editar los archivos: <b>DEPARTAMENTOS.sh, DISTRITOS.sh y PROVINCIAS.sh</b>
4. Buscar la siguiente linea y cambiar dubgcc por tu propio nombre de usuario en postgres y cartografia_peru por el nombre de tu base de datos
  ```
    psql -U dubgcc -d cartografia_peru -f $f
  ```
5. Ejecutar los archivos: <b>DEPARTAMENTOS.sh, DISTRITOS.sh y PROVINCIAS.sh</b>
  ejm. 
  ```
    ./DEPARTAMETOS.sh
  ```
6. Copiar los datos de la carpeta web a <b>/var/www/html</b>
7. En tu explorador entrar a la url <b>localhost</b>. Como los datos son bastantes demorara un poco en cargar segun la velocidad de tu computador

8. Si pondras en produccion el proyecto cambia el <b>apikey de googlemaps</b> en el archivo <b>index.php</b> en la linea <b>264</b>
