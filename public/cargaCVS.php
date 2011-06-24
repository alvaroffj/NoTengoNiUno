<?php

$xls = "respaldo.csv";
$f = fopen($xls, "r");
$datos = fgetcsv($f, 1000, ";");
//echo "<pre>";
//print_r($datos);
//echo "</pre>";
$sql = "INSERT INTO REGISTRO (ID_TIPO_REGISTRO, ID_CATEGORIA, ID_USUARIO, MONTO_REGISTRO, FECHA_REGISTRO, DESC_REGISTRO, ESTADO_REGISTRO) VALUES \n";
while (($datos = fgetcsv($f, 1000, ";")) !== FALSE) {
    if ($datos[0] != "") {
        $fecha = setFecha($datos[0]);
        $idCat = $datos[1];
        $idUs = 1;
        $desc = $datos[2];
        $est = 0;
        $monto = $datos[3];
        if($monto<0) {
            $monto = $monto*-1;
            $tm = 2;
        } else $tm = 1;

        $sql .= "(".$tm.", ".$idCat.", ".$idUs.", ".$monto.", '".$fecha."', '".$desc."', ".$est."),\n";
    }
}

echo $sql;
function setFecha($f) {
    $fe = split("\.", $f);
    return $fe[2]."-".$fe[1]."-".$fe[0];
}
?>
