<?php
  ini_set('memory_limit', '512M');
  ini_set('max_execution_time', '180');

  $level = $_POST['level'];
  $lat = $_POST['lat'];
  $lng = $_POST['lng'];

  $db = pg_connect("host=localhost port=5432 user=dubgcc password=root dbname=cartografia_peru");

  /// consulta para obtener PROVINCIAS
  if ($level == "departamentos") {
    $query = "
      SELECT nombprov, ST_ASGEOJSON(ST_TRANSFORM(p.geom,4674)) as LongLat
      FROM
      ( SELECT first_iddp, nombdep, geom
        FROM
        bas_lim_departamento
        WHERE
        st_contains(geom, ST_TRANSFORM( ST_GeomFromText( 'POINT($lng $lat)', 4674), 32718 )) = 't'
      ) depa,
      bas_lim_provincia p
      WHERE
      p.first_idpr::text like depa.first_iddp::text || '%'";
  } else if ($level == "provincias") {
    $query = "
      SELECT nombdist, ST_ASGEOJSON(ST_TRANSFORM(d.geom,4674)) as LongLat
      FROM
      ( SELECT first_idpr, nombprov, geom
        FROM
        bas_lim_provincia
        WHERE
        st_contains(geom, ST_TRANSFORM( ST_GeomFromText( 'POINT($lng $lat)', 4674), 32718 )) = 't'
      ) prov,
      bas_lim_distritos d
      WHERE
      d.idprov = prov.first_idpr";
  } else if ($level == "distritos") {
    header('Content-Type: application/json');
    echo json_encode("error");
  }
  $result = pg_query($db, $query);
  
  //$res = array($level,$lat,$lng);
  $res = array();

  //$i = 0;
  while ($row = pg_fetch_assoc($result)) {
    $row_array = json_decode($row['longlat'], true);
    
    /// 4 level
    for ($i=0; $i < 3; $i++) { 
      for ($j=0; $j < 3; $j++) { 
        $coordinates_by_content = $row_array['coordinates'][$i][$j];
        if ($coordinates_by_content != null)
          $res[] = $coordinates_by_content;
      }
    }
    
    
    /*if ($i == 14) {
      $coordinates_by_department = $row_array['coordinates'][1][0];
      $res[] = $coordinates_by_department;
    }
    if ($i == 20) {
      $coordinates_by_department = $row_array['coordinates'][4][0];
      $res[] = $coordinates_by_department;
    }
    $i = $i + 1;*/
  }

  header('Content-Type: application/json');
  echo json_encode($res);
?>