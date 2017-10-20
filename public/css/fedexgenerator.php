<?php
//////////////////////////////////////////////////////////////////////////////////////DEBUG EN PANTALLA
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 1800);
require_once ('../php/PHPExcel.php');
include ('../php/PHPExcel/IOFactory.php');
require ("conn.php");
require ("islogged.php");
session_start();
ob_start();
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$sql = $_SESSION["query"];
$sqlrep = $_SESSION["xlsups"];
$user = $_SESSION["login"];
$rol = $_SESSION["rol"];
$pais = $_SESSION["pais"];
$ip = $_SERVER['REMOTE_ADDR'];
$nombre = 'order';
$query = mysqli_query($link, $sqlrep);
$query2 = mysqli_query($link, $sql);
//$col = mysqli_num_fields($query);

//echo "<br /> SQL";
//echo "<br /> ";
//echo $sql;
//echo "<br /> REP";
//echo "<br /> ";
//echo $sqlrep;
//die;
$directorio = opendir("fedexfiles/"); //ruta de archivos XML
$iii = 1;
while ($archivo = readdir($directorio)) {
    if (!is_dir($archivo)) {
        $iii++;
    }
}

$fp = fopen('fedexfiles/' . $iii . '.csv', 'w');

//Identificamos el PAIS
if ($pais == 'US') {

    //CREAMOS LOS ENCABEZADOS
    //SI ES ROL 3 TIENE ENCABEZADO SIN MENSAJE AL FINAL
    if ($rol == 3) {
        fputcsv($fp, array('Tracking', 'Company', 'eBinv', 'Orddate', 'Shipto', 'Shipto2', 'Address', 'Address2', 'City', 'State', 'Zip', 'Phone', 'Soldto', 'Soldto2', 'STPhone', 'Ponumber', 'CUSTnbr', 'SHIPDT', 'Deliver', 'SatDel', 'Quantity', 'Item', 'ProdDesc', 'Length', 'Width', 'Height', 'WeightKg', 'DclValue', 'Message', 'Service', 'PkgType', 'GenDesc', 'ShipCtry', 'Currency', 'Origin', 'UOM', 'TPComp', 'TPAttn', 'TPAdd1', 'TPCity', 'TPState', 'TPCtry', 'TPZip', 'TPPhone', 'TPAcct', 'Farm'));
    } else {
        fputcsv($fp, array('Tracking', 'Company', 'eBinv', 'Orddate', 'Shipto', 'Shipto2', 'Address', 'Address2', 'City', 'State', 'Zip', 'Phone', 'Soldto', 'Soldto2', 'STPhone', 'Ponumber', 'CUSTnbr', 'SHIPDT', 'Deliver', 'SatDel', 'Quantity', 'Item', 'ProdDesc', 'Length', 'Width', 'Height', 'WeightKg', 'DclValue', 'Message', 'Service', 'PkgType', 'GenDesc', 'ShipCtry', 'Currency', 'Origin', 'UOM', 'TPComp', 'TPAttn', 'TPAdd1', 'TPCity', 'TPState', 'TPCtry', 'TPZip', 'TPPhone', 'TPAcct', 'Farm', 'MSG'));
    }
    $i = 0; ////////////////////////////////////////////////////////////////////CONTADOR DE CRN 
    $iiii = 1; ////////////////////////////////////////////////////////////////////CONTADOR DE CRN 
    $ii = 1; ///////////////////////////////////////////////////////////////////CONTADOR DE MASTER
    //GENERAMOS EL CSV
    while ($rowr = mysqli_fetch_assoc($query)) {
        if ($i == 0){
            echo "0,\"20\"1,\"IPD\"4,\"".$rowr["nombre_compania"]."\"5,\"FARMS ECUADOR\"6,\"".$rowr["farm"]."\"7,\"Quito\"9,\"170109\"10,\"788516088\"32,\"ALINA ALZUGARAY\"117,\"EC\"183,\"593-224-0163\"1150,\"ALINA ALZUGARAY\"11,\"FEDEX EXPRESS\"12,\"VIA FEDEX IPD\"13,\"6100 NW 36 STREET\"14,\"BUILDING 831\"15,\"MIAMI\"16,\"FL\"17,\"33115\"18,\"7862656564\"50,\"US\"20,\"379816711\"23,\"3\"24,\"" . date('Y') . date('m') . date('d') . "\"68,\"USD\"70,\"3\"71,\"379816711\"75,\"KGS\"1273,\"01\"1274,\"18\"541,\"YNNNNNNNN\"542,\"EBDM".$ii."\"1355,\"FEDEX\"1485,\"ALEX ALFONSO\"1486,\"EBLOOMS\"1487,\"2231 SW 82 PL\"1488,\"MIAMI FLORIDA 33155\"1489,\"MIAMI\"1490,\"FL\"1491,\"33155\"1492,\"1-855-532-5666\"1585,\"US\"1586,\"Y\"99,\"\"";
            echo "\r\n";
            echo "\r\n";
//            echo print_r($rowr); echo "\r\n";
        }
        
        $rowr['cpmensaje'] = preg_replace("/\r|\n/", "", $rowr['cpmensaje']);
        //DEFINIMOS SI TIENE MENSAJE MUESTRA "Y" EN SU DEFECTO MUESTRA "N"
        if (ltrim(rtrim($rowr['mensaje2'])) == 'To-Blank Info   ::From- Blank Info   ::Blank .Info') {
            $rowr['mensaje2'] = "N";
        } else {
            $rowr['mensaje2'] = "Y";
        }
        
        $pricesplit = explode(".", $rowr["dclvalue"]);
        $pricesplit[1] = $pricesplit[1] . "0000";
        $unitprice = $pricesplit[0] . $pricesplit[1];
        
        $pesosplit = explode(".", $rowr["wheigthKg"]);
        if ($pesosplit[1] >= 5){
            $decimal = 1;
        } else {
            $decimal = 0;
        }
        $pesounit = $pesosplit[0] + $decimal;
        $pesounit = $pesounit*10;
        
        $widsplit = explode(".", $rowr["width"]);
        if ($widsplit[1] >= 5){
            $decimal = 1;
        } else {
            $decimal = 0;
        }
        $widunit = $widsplit[0] + $decimal;
        
        $heisplit = explode(".", $rowr["heigth"]);
        if ($heisplit[1] >= 5){
            $decimal = 1;
        } else {
            $decimal = 0;
        }
        $heiunit = $heisplit[0] + $decimal;
        
        $lensplit = explode(".", $rowr["length"]);
        if ($lensplit[1] >= 5){
            $decimal = 1;
        } else {
            $decimal = 0;
        }
        $lenunit = $lensplit[0] + $decimal;
        
        $orderzip = substr($rowr["cpzip_shipto"], 0, 5);
        
        $dir_count = strlen($rowr["direccion"]);
        if ($dir_count >= 35){
            $dir_1 = substr($rowr["direccion"],0,34);
            $dir_2 = substr($rowr["direccion"],35);
        } else {
            $dir_1 = $rowr["direccion"];
            $dir_2 = "";
        }
        
        $pesototal = $widunit + $heiunit + $lenunit;
        if ($pesototal <= 101 || $rowr["cpitem"] == "1021437" || $rowr["cpitem"] == "1021440" || $rowr["cpitem"] == "1021441"  
                    || $rowr["cpitem"] == "1021442" || $rowr["cpitem"] == "12001" || $rowr["cpitem"] == "986521" 
                    || $rowr["cpitem"] == "986480" || $rowr["cpitem"] == "983205" || $rowr["cpitem"] == "100512" 
                    || $rowr["cpitem"] == "100511" || $rowr["cpitem"] == "100502" || $rowr["cpitem"] == "100298" || $rowr["cpitem"] == "983160" ){
            //SI ES ROL 1 MUESTRA TODA LA INFROMACION
            if ($rol == 1 || $rol == 2) {
                unset($rowr['estado_orden']);
                fputcsv($fp, $rowr);
                echo "0,\"20\"1,\"CRN".$iiii."\"11,\"". $rowr["shipto2"] ."\"12,\"". $rowr["shipto1"] ."\"13,\"". $dir_1 ."\"14,\"". $dir_2 ." ". $rowr["direccion2"] ."\"15,\"". $rowr["cpcuidad_shipto"] ."\"16,\"". $rowr["cpestado_shipto"] ."\"17,\"". $orderzip ."\"18,\"". $rowr["cptelefono_shipto"] ."\"21,\"". $pesounit ."\"25,\"". $rowr["cpitem"] ."\"38,\"". $rowr["Ponumber"] . "_" . $rowr["Custnumber"] . "\"50,\"US\"57,\"". $heiunit ."\"58,\"". $widunit ."\"59,\"". $lenunit ."\"68,\"USD\"75,\"KGS\"79,\"". $rowr["prod_descripcion"] ."\"80,\"EC\"81,\"\"82,\"1\"541,\"NNNYNNNNN\"542,\"EBDM".$ii."\"1030,\"". $unitprice ."\"1274,\"18\"99,\"\"         ";
                echo "\r\n";

                //SI ES ROL DISTINTO A 1 MUESTRA SOLO LOS QUE NO TIENEN TRACKING NI LAS CANCELADAS
            } else {
                if (ltrim(rtrim($rowr['estado_orden'])) == 'Active' && $rowr['tracking'] == '') {

                    //SI ES ROL 3 ELIMINA EL MENSAJE AL FINAL
                    if ($rol == 3) {
                        unset($rowr['mensaje2']);
                    }
                    unset($rowr['estado_orden']);
                    fputcsv($fp, $rowr);
                //echo print_r($rowr); echo "\r\n";
                }
            }
            $iiii++;
        }
        $i++;
        if ($iiii >= 999){
            $ii++;
            $iiii = 0;//////////////////////////////////////////////////////////CONTAMOS 1000 ORDENES Y VAMOS AL SIGUIENTE MASTER DE 1000
            echo "\r\n";
            echo "\r\n";
        }
    }
//SI EL PAIS NO ES USA HACER:
} else {
    //CREAMOS LOS ENCABEZADOS
    //SI ES ROL 3 TIENE ENCABEZADO SIN MENSAJE AL FINAL
    if ($rol == 3) {
        fputcsv($fp, array('Tracking', 'Company', 'eBinv', 'Orddate', 'Shipto', 'Shipto2', 'Address', 'Address2', 'City', 'State', 'Zip', 'Phone', 'Soldto', 'Soldto2', 'STPhone', 'Ponumber', 'CUSTnbr', 'SHIPDT', 'Deliver', 'Quantity', 'Item', 'ProdDesc', 'Length', 'Width', 'Height', 'WeightKg', 'DclValue', 'Message', 'Service', 'PkgType', 'GenDesc', 'ShipCtry', 'Currency', 'Origin', 'UOM', 'TPComp', 'TPAttn', 'TPAdd1', 'TPCity', 'TPState', 'TPCtry', 'TPZip', 'TPPhone', 'TPAcct', 'NRIComp', 'NRIAtt', 'NRIAdd1', 'NRIAdd2', 'NRIAdd3', 'NRICity', 'NRIState', 'NRIZip', 'NRIPhone', 'NRIAccount', 'NRITaxid', 'Farm'));
    } else {
        fputcsv($fp, array('Tracking', 'Company', 'eBinv', 'Orddate', 'Shipto', 'Shipto2', 'Address', 'Address2', 'City', 'State', 'Zip', 'Phone', 'Soldto', 'Soldto2', 'STPhone', 'Ponumber', 'CUSTnbr', 'SHIPDT', 'Deliver', 'Quantity', 'Item', 'ProdDesc', 'Length', 'Width', 'Height', 'WeightKg', 'DclValue', 'Message', 'Service', 'PkgType', 'GenDesc', 'ShipCtry', 'Currency', 'Origin', 'UOM', 'TPComp', 'TPAttn', 'TPAdd1', 'TPCity', 'TPState', 'TPCtry', 'TPZip', 'TPPhone', 'TPAcct', 'NRIComp', 'NRIAtt', 'NRIAdd1', 'NRIAdd2', 'NRIAdd3', 'NRICity', 'NRIState', 'NRIZip', 'NRIPhone', 'NRIAccount', 'NRITaxid', 'Farm', 'MSG'));
    }

    //GENERAMOS EL CSV
    while ($rowr = mysqli_fetch_assoc($query)) {

        $rowr['cpmensaje'] = preg_replace("/\r|\n/", "", $rowr['cpmensaje']);
        //DEFINIMOS SI TIENE MENSAJE MUESTRA "Y" EN SU DEFECTO MUESTRA "N"
        if (ltrim(rtrim($rowr['mensaje2'])) == 'To-Blank Info   ::From- Blank Info   ::Blank .Info') {
            $rowr['mensaje2'] = "N";
        } else {
            $rowr['mensaje2'] = "Y";
        }

        //GUARDAMOS FARM PARA AGREGARLO AL FINAL DE ARRAY
        $farm = $rowr['farm'];

        //SI ES DISTINTO A ROL 3 GUARDAMOS EL MENSAJE PARA AGREGARLO AL FINAL DE ARRAY
        if ($rol !== 3) {
            $mensaje2 = $rowr['mensaje2'];
        }

        //DEFINIMOS LOS ELEMENTOS ADICIONALES QUE QUEREMOS AGREGAR Y QUITAR DE ARRAY
        unset($rowr['mensaje2']);
        unset($rowr['satdel']);
        unset($rowr['farm']);
        unset($rowr[45]);
        $rowr[45] = "E-Blooms Direct Inc.";
        $rowr[48] = "ALINA ALZUGARAY";
        $rowr[49] = "2231 S.W. 82 PLACE";
        $rowr[50] = "";
        $rowr[51] = "MIAMI FL 33155";
        $rowr[52] = "WINDSOR RR2";
        $rowr[53] = "ON";
        $rowr[54] = "N8N2M1";
        $rowr[55] = "305-905-0153";
        $rowr[56] = "A173A5";
        $rowr[57] = "816170971RM0001";
        array_push($rowr, $farm);

        //SI NO ES ROL 3 AGREGAMOS EL MENSAJE "Y" O "N" AL FINAL DEL REPORTE
        if ($rol !== 3) {
            array_push($rowr, $mensaje2);
        }

        //SI ES ROL 1 MUESTRA TODA LA INFROMACION
        if ($rol == 1) {
            unset($rowr['estado_orden']);
            fputcsv($fp, $rowr);
            //echo print_r($rowr); echo "\r\n";

            //SI ES ROL DISTINTO A 1 MUESTRA SOLO LOS QUE NO TIENEN TRACKING NI LAS CANCELADAS
        } else {
            if (ltrim(rtrim($rowr['estado_orden'])) == 'Active' && $rowr['tracking'] == '') {
                unset($rowr['estado_orden']);
                fputcsv($fp, $rowr);
            //echo print_r($rowr); echo "\r\n";
            }
        }
    }
}
fclose($fp);

//VALIDAMOS SI EL USUARIO MODIFICA ESTATUS DE DESCARGA
if ($rol > 1) {
    while ($rowr = mysqli_fetch_array($query2)) {
        $sqlup .= $rowr["id_detalleorden"] . ",";
    }

    //REMOVEMOS LA ULTIMA COMA PARA NO GENERAR ERROR DE SINTAXIS
    $sqlup = substr(trim($sqlup), 0, -1);
    //ACTUALIZAMOS ESTATUS A DESCARGADO
    $sqlupdate = "UPDATE tbldetalle_orden SET descargada='Downloaded', user='" . $user . "', status='Ready to ship' where id_detalleorden in (" . $sqlup . ") AND status = 'New'";
    mysqli_query($link, $sqlupdate)or die("Error updating...");

    // ALIMENTAMOS LA BITACORA
    $fecha = date('Y-m-d H:i:s');
    $SqlHistorico = "INSERT INTO tblhistorico (`usuario`,`operacion`,`fecha`,`ip`) VALUES ('$user','Descargar Orden','$fecha','$ip')";
    $consultaHist = mysqli_query($link, $SqlHistorico) or die("Error actualizando la bitacora de usuarios");
}

/////////////////////////////////////////////////////////////////////////////////GUARDAMOS EL ARCHIVO .IN
$salida2 = ob_get_contents();
//ob_end_clean();

$f = fopen("fedexfiles/" . $iii . ".in", "w");
fwrite($f, $salida2);
fclose($f);

header("Content-Disposition: attachment; filename=\"" . date("Y-m-d H:i:s") . "_small.in\"");
header("Content-Type: application/force-download");
header("Content-Length: " . filesize("fedexfiles/" . $iii . ".in"));
header("Connection: close");



////////////////////////////////////////////////////////////////////////////////////////////////////////ENVIAMOS AL CONVERTIDOR A EXCEL
//$_SESSION['filename'] = "xlsups/" . $iii . ".csv";
//header("Location: csvtoxls.php");

////header("Content-Type: text/csv; charset=utf-8");
////header("Content-disposition: filename=" . $nombre . ".csv");
////print $csv;
////LECTOR DE CSV PARA PREPARARLO A XLS
//$objReader = PHPExcel_IOFactory::createReader('CSV');
////CARGAMOS EL CSV DENTRO DEL XLS
//$objPHPExcel = $objReader->load('file.csv');
//
////CONVERTIMOS EL VALOR DE PONUMBER A EXPLICITO PARA EVITAR QUE EXCEL CONVIERTA EL VALOR
//$porowcount = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//$j = "2";
//for ($j = 2; $j <= $porowcount; $j++) {
//    $pvalor = $objPHPExcel->getActiveSheet()->getCell('P' . $j)->getValue();
//    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P' . $j, $pvalor, PHPExcel_Cell_DataType::TYPE_STRING);
//}
//
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="Order.xlsx"');
//header('Cache-Control: max-age=0');
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('php://output');
//
// **SOPORTE** VERIFICAMOS LAS SALIDAS DE NUESTRO SCRIPT
//print_r($sqlrep);
//print_r($sql);
//print_r($pais);
//print_r($sqlup);
//print_r($sqlupdate);
//print_r($SqlHistorico);
//die;
exit;
?>