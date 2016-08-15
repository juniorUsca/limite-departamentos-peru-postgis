<!DOCTYPE html>
<html>
  <head>
    <title>CARTOGRAFIA DEL PERU</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
        width: 100%;
      }
      
      #back {
        position: fixed;
        bottom: 50px;
        right: 50px;
        background: #FFAA00;
        color: white;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <section id="slider">
        
    </section>
    <button id="back">Atras</button>

    <script type = "text/javascript" 
         src = "http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
      var map;
      var polygons = [];
      var infowindow;
      var level = "departamentos";

      var lat;
      var lng;



      function clearMap() {
        /// clear polygons
        for (var i = polygons.length - 1; i >= 0; i--) {
          polygons[i].setMap(null);
        }
        polygons = [];
      }



      function obtenerDepartamentos() {
        /// obtenemos departamentos
        $.ajax({
          url: 'ajax/get_departamentos.php',
          type: 'POST',
          dataType: 'json',
        })
        .done(function(res) {
          //console.log(res);
          clearMap();
          /// for por departamento
          var coor = res[0];
          var titles = res[1];

          for (var i = coor.length - 1; i >= 0; i--) {
            
            if (coor[i] != null) {
              var poligono = [];
              /// for por puntos LONG LAT
              for (var j = coor[i].length - 1; j >= 0; j--) {
                poligono.push(
                  {
                    lat: coor[i][j][1],
                    lng: coor[i][j][0]
                  });
              }

              // Construct the polygon.
              var cartografia = new google.maps.Polygon({
                paths: poligono,
                strokeColor: '#FFAA00',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FFAA00',
                fillOpacity: 0.35,
                clickable: false
              });
              cartografia.setMap(map);
              polygons.push(cartografia);

            }

          }
           
        })
        .fail(function(er) {
          console.log(er);
          console.log("error");
        });
      }




      function obtenerPorNivel() {
        if (level=="departamentos") {
          console.log("obtendremosc PROVINCIAS");
        } else if (level=="provincias") {
          console.log("obtendremosc DISTRITOS");
        }
        $.ajax({
            url: 'ajax/get_content.php',
            type: 'POST',
            dataType: 'json',
            data: {
              lat:lat,
              lng:lng,
              level: level
            },
          })
          .done(function(res) {
            console.log(lat,lng);
            console.log(res);

            if(res == "error")
              return false;

            clearMap();
            if (level=="departamentos") {
              level="provincias";
              $('#back').css('background', '#0000FF');
              $('#back').css('color', '#FFF');
            } else if (level=="provincias") {
              level="distritos";
              $('#back').css('background', '#FF00FF');
              $('#back').css('color', '#FFF');
            }

            /// BEGIN creamos poligonos
            for (var i = res.length - 1; i >= 0; i--) {
              
              if (res[i] != null) {
                var poligono = [];
                /// for por puntos LONG LAT
                for (var j = res[i].length - 1; j >= 0; j--) {
                  poligono.push(
                    {
                      lat: res[i][j][1],
                      lng: res[i][j][0]
                    });
                }

                var cartografia;
                // Construct the polygon.
                if (level=="provincias") {
                  cartografia = new google.maps.Polygon({
                    paths: poligono,
                    strokeColor: '#0000FF',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#0000FF',
                    fillOpacity: 0.35,
                    clickable: false
                  });
                } else if (level=="distritos") {
                  cartografia = new google.maps.Polygon({
                    paths: poligono,
                    strokeColor: '#FF00FF',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF00FF',
                    fillOpacity: 0.35,
                    clickable: false
                  });
                }
/*
                google.maps.event.addListener(cartografia, 'click', function (event) {
                  alert("test");
                });

                cartografia.addListener('mouseover', function(event) {
                  console.log("aa");
                  var infowindow = new google.maps.InfoWindow({
                    content: "holaaa"
                  });
                  var marker = new google.maps.Marker({
                    position: event.latLng,
                    title:"Hello World!"
                  });
                  infowindow.open(map,marker);
                });*/

                
                cartografia.setMap(map);
                
                polygons.push(cartografia);

              }

            }
            /// END poligono
            
            
          })
          .fail(function(e) {
            console.log(e);
            console.log("error");
          });
      }







      $('#back').click(function(event) {
        //clearMap();
        if (level=="provincias") {
          level="departamentos";
          $('#back').css('background', '#FFAA00');
          $('#back').css('color', '#FFF');
          console.log("mostraremos DEPARTAMENTOS");
          obtenerDepartamentos();
        } else if (level=="distritos") {
          level="departamentos";
          $('#back').css('background', '#0000FF');
          $('#back').css('color', '#FFF');
          console.log("mostraremos PROVINCIAS");
          obtenerPorNivel();
        }
        return false;
      });

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {
            lat: -10.154098,
            lng: -75.036621
          },
          zoom: 5
        });

        obtenerDepartamentos();


        map.addListener('click', function(event) {
          lat = event.latLng.lat();
          lng = event.latLng.lng();
          //map.setZoom(8);
          //map.setCenter(marker.getPosition());
          
          obtenerPorNivel();  
        });
        
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-0uk5pphNvP9p8BwXo-buC_ocdG8xruE&callback=initMap"
    async defer></script>
  </body>
</html>


