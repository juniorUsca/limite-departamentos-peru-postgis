<?php

ini_set('memory_limit', '512M');
ini_set('max_execution_time', '180');

  $db = pg_connect("host=postgis port=5432 user=debugcc password=root dbname=cartografia_peru");
  
  $query = "
    SELECT 
    nombdep, ST_ASGEOJSON(ST_TRANSFORM(geom,4674)) AS LongLat --using st_transform to get wkt with longitude and latitude (4674 is the SIRGAS 2000 SRC by south america)
    FROM
    bas_lim_departamento";
  $result = pg_query($db, $query);
  
  $coor = array();
  $names = array();

  $i = 0;
  while ($row = pg_fetch_assoc($result)) {
    $names[] = $row['nombdep'];
    $row_array = json_decode($row['longlat'], true);
    
    $coordinates_by_department = $row_array['coordinates'][0][0];
    $coor[] = $coordinates_by_department;
    
    if ($i == 14) {
      $coordinates_by_department = $row_array['coordinates'][1][0];
      $coor[] = $coordinates_by_department;
    }
    if ($i == 20) {
      $coordinates_by_department = $row_array['coordinates'][4][0];
      $coor[] = $coordinates_by_department;
    }
    $i = $i + 1;
  }
  $res = array();
  $res[] = $coor;
  $res[] = $names;

  header('Content-Type: application/json');
  echo json_encode($res);
?>
