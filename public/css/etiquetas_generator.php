<?php

//////////////////////////////////////////////////////////////////////////////////////DEBUG EN PANTALLA
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


ini_set('max_execution_time', 1800);
require (__DIR__ . "/conn.php");
session_start();
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

ob_start();

$sql1 = "SELECT distinct agencia,finca FROM tbletiquetasxfinca where archivada = 'No'  AND estado!= '5' AND estado!= '2' ORDER BY agencia DESC";
$valag = mysqli_query($link, $sql1)or die("Error seleccionando los agencias");
$cant = mysqli_num_rows($valag);

while ($rowag = mysqli_fetch_array($valag)) {
    echo "<tr style='background-color:#f9f9f9'><td colspan='8'><strong>Agencia: " . $rowag['agencia'] . "</strong></td></tr>";
    echo "<tr style='background-color:#f9f9f9'><td colspan='8'><strong>Finca: " . $rowag['finca'] . "</strong></td></tr>";
    //Selecciono cada item con solicitud activa
    $sql = "SELECT distinct fecha,fecha_tentativa FROM tbletiquetasxfinca where finca='" . $rowag['finca'] . "' AND archivada = 'No'  AND estado!= '5' AND estado!= '2' AND agencia='" . $rowag['agencia'] . "' order by fecha";
    $val = mysqli_query($link, $sql)or die("Error seleccionando los pedidos");

    //Recorro por cada nro pedido cada item
    while ($row = mysqli_fetch_array($val)) {

        echo "<tr>";
        echo "<td align='left' colspan='3'><strong>Fecha de entrega: " . $row['fecha'] . "</strong></td>";
        echo "</tr>";
        echo '<tr>
                       <td align="center"><strong>Producto</strong></td>
                       <td align="center"><strong>Prod. Desc.</strong></td>
                       <td align="center"><strong>Solicitadas</strong></td>
                       <td align="center"><strong>Enviadas</strong></td> 
                       <td align="center"><strong>Rechazadas</strong></td>
                       <td align="center"><strong>Cierre de Día</strong></td>
                       <td align="center"><strong>Por enviar</strong></td>
                       <td align="center"><strong>Imprimir etiquetas</strong></td>
                 </tr>	';

        //Selecciono cada nropedido los items
        $sentencia = "SELECT distinct item FROM tbletiquetasxfinca where fecha ='" . $row['fecha'] . "' AND finca='" . $rowag['finca'] . "' AND archivada = 'No'  AND estado!= '5' AND agencia='" . $rowag['agencia'] . "'  order by item";
        $consulta = mysqli_query($link, $sentencia)or die("Error seleccionando los items con solicitudes");

        //Por cada item cuento cuantas solicitudes hay
        while ($fila = mysqli_fetch_array($consulta)) {
            //Se cuenta cuantas solicitudes y entregas hay por cada finca e item
            $sql1 = "SELECT SUM(solicitado) as solicitado,SUM(entregado) as entregado, item, fecha, precio FROM tbletiquetasxfinca where fecha='" . $row['fecha'] . "' AND finca='" . $rowag['finca'] . "' AND estado!='5' AND item = '" . $fila['item'] . "' AND agencia='" . $rowag['agencia'] . "'";
            $val1 = mysqli_query($link, $sql1) or die("Error sumando las cantidades de solicitudes y entregas de las fincas");
            $row1 = mysqli_fetch_array($val1);

            //Se cuenta cuantas solicitudes rechazadas hay por cada finca e item
            $sql2 = "SELECT COUNT(*) as rechazado FROM tbletiquetasxfinca where estado='2' AND fecha = '" . $row['fecha'] . "' AND finca='" . $rowag['finca'] . "' AND item = '" . $fila['item'] . "' AND agencia='" . $rowag['agencia'] . "'";
            $val2 = mysqli_query($link, $sql2) or die("Error sumando las cantidades de solicitudes y entregas de las fincas");
            $row2 = mysqli_fetch_array($val2);

            //Se cuenta cuantas solicitudes con cierre de dia por cada finca e item
            $sql3 = "SELECT COUNT(*) as cierre FROM tbletiquetasxfinca where estado= '3' AND fecha = '" . $row['fecha'] . "' AND finca='" . $rowag['finca'] . "' AND item = '" . $fila['item'] . "' AND agencia='" . $rowag['agencia'] . "'";
            $val3 = mysqli_query($link, $sql3) or die("Error sumando las cantidades de solicitudes y entregas de las fincas");
            $row3 = mysqli_fetch_array($val3);

            echo "<tr>";
            echo "<td align='center'><strong>" . $row1['item'] . "</strong></td>";

            //Seleccionando l adescripcion del item
            $sql4 = "SELECT prod_descripcion FROM tblproductos where id_item='" . $row1['item'] . "'";
            $val4 = mysqli_query($link, $sql4) or die("Error sumando las cantidades de solicitudes y entregas de las fincas");
            $row4 = mysqli_fetch_array($val4);

            echo "<td><strong>" . $row4['prod_descripcion'] . "</strong></td>";
            echo "<td align='center'>" . $row1['solicitado'] . "</td>";
            $totalsol += $row1['solicitado'];
            echo "<td align='center'>" . $row1['entregado'] . "</td>";
            echo "<td align='center'>" . $row2['rechazado'] . "</td>";
            echo "<td align='center'>" . $row3['cierre'] . "</td>";

            //se restan las solicitudes - entregado - rechazado	
            $totalrech += $row2['rechazado'];
            $totalent += $row1['entregado'];
            $dif = $row1['solicitado'] - $row1['entregado'] - $row2['rechazado'] - $row3['cierre'];
            $totalcierre = $row3['cierre'];
            if ($dif < 0) {
                $dif = "0";
            }
            $totaldif += $dif;
            $totalprecio += $row1['precio'];

            echo "<td align='center'>" . $dif . "</td>";
            if ($dif != 0) {
                echo '<td align="center"><a href="#" onclick="print2(\'' . $rowag['finca'] . '\',\'' . $row['fecha'] . '\',\'' . $row1['item'] . '\',\'false\',\'' . $row['fecha_tentativa'] . '\')"><img src="../images/print.png" name="btn_cliente" id="btn_cliente" data-toggle="tooltip" data-placement="left" title = "Imprimir etiquetas de esta fecha" width="20" height="20"/></a></td>';
                echo "</tr>";
            } else {
                echo '<td align="center">
                                <a href="#" style="cursor:not-allowed" ><img src="../images/print.png" name="btn_cliente" id="btn_cliente" data-toggle="tooltip" data-placement="left" title = "Imprimir etiquetas de esta fecha" width="20" height="20"/></a>
                                <a class="btn btn-info" href="#" onclick="print2(\'' . $rowag['finca'] . '\',\'' . $row['fecha'] . '\',\'' . $row1['item'] . '\',\'true\',\'' . $row['fecha_tentativa'] . '\')"><b>!</b></a></td>';
                echo "</tr>";
            }
        }//fin while

        if ($totalsol < 0) {
            $totalsol = "0";
        }
        if ($totalent < 0) {
            $totalent = "0";
        }
        if ($totalrech < 0) {
            $totalrech = "0";
        }
        if ($totalcierre < 0) {
            $totalcierre = "0";
        }
        echo "
          <tr>
          <td align='right'></td>				  
          <td align='center'><strong>Total por Fecha:</strong></td>
          <td align='center'><strong>" . $totalsol . "</strong></td>
          <td align='center'><strong>" . $totalent . "</strong></td>
          <td align='center'><strong>" . $totalrech . "</strong></td>
          <td align='center'><strong>" . $totalcierre . "</strong></td>";

        if ($totaldif == 0) {
            echo "<td align='center'><button type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='left' title = 'No hay etiquetas por imprimir'><strong>" . $totaldif . "</strong></button></td>";
        } else {
            echo "<td align='center'><button type='button' class='btn btn-success' data-toggle='tooltip' data-placement='left' title = 'Hay etiquetas por imprimir'><strong>" . $totaldif . "</strong></button></td>";
        }

        //Contar los subtotales
        $TOTALSOL += $totalsol;
        $TOTALENT += $totalent;
        $TOTALRECH += $totalrech;
        $TOTALCIERRE += $totalcierre;
        $TOTALDIF += $totaldif;

//						 if($TOTALDIF != 0){
//						        echo '<td align="center"><input type="image" style="cursor:pointer" name="btn_cliente" id="btn_cliente" src="../images/print.png" heigth="30" value="" data-toggle="tooltip" data-placement="left" title = "Imprimir etiquetas de esta fecha" width="20" onclick="print1(\''.$_SESSION['dato'].'\',\''.$row['fecha'].'\')"/></td>';
//						        echo "</tr>";
//						}else{				
//							echo '<td align="center"><input disabled="true" type="image" style="cursor:not-allowed" name="btn_cliente" id="btn_cliente" src="../images/print.png" heigth="30" value="" width="20" data-toggle="tooltip" data-placement="left" title = "No hay etiquetas para imprimir de este pedido o el DAE está caducado"/></td>';
//						        echo "</tr>";
//					        }
        //Resetear los subtotales
        $totalsol = 0;
        $totalent = 0;
        $totalrech = 0;
        $totalcierre = 0;
        $totaldif = 0;
    }
}

if ($cant > 0) {
    echo "
          <tr>
          <td align='right'></td>				  
          <td align='center'><strong>Total General:</strong></td>
          <td align='center'><strong>" . $TOTALSOL . "</strong></td>
          <td align='center'><strong>" . $TOTALENT . "</strong></td>
          <td align='center'><strong>" . $TOTALRECH . "</strong></td>
          <td align='center'><strong>" . $TOTALCIERRE . "</strong></td>";

    if ($TOTALDIF == 0) {
        echo "<td align='center'><button type='button' class='btn btn-danger btn-lg' data-toggle='tooltip' data-placement='left' title = 'No hay etiquetas por imprimir'><strong>" . $TOTALDIF . "</strong></button></td>";
    } else {
        echo "<td align='center'><button type='button' class='btn btn-success btn-lg' data-toggle='tooltip' data-placement='left' title = 'Hay etiquetas por imprimir'><strong>" . $TOTALDIF . "</strong></button></td>";
    }
} else {
    echo "<tr><td colspan='12'><strong>No hay resultados que mostrar.</strong></td></tr>";
}
$salida2 = ob_get_contents();
ob_end_clean();

$f = fopen("file.php", "w");
fwrite($f, print_r($salida2, true));
fclose($f);

//////////////////////////////////////////////////////////////ETIQUETAS EXISTENTES
ob_start();
//Agrupar el reporte por destino
$a = "SELECT distinct destino,agencia FROM tbletiquetasxfinca  where archivada = 'No' AND estado!='5' order by destino DESC";
$b = mysqli_query($link, $a) or die('Error seleccionando el origen');

$TOTALSOL = 0;
$TOTALENTSTRACK = 0;
$TOTALENTTRACK = 0;
$TOTALENT = 0;
$TOTALRECH = 0;
$TOTALDIF = 0;
$TOTALCIERRE = 0;
$TOTALREUT = 0;
$TOTALPRECIO = 0;
$cont = 0;

while ($fila = mysqli_fetch_array($b)) {
    echo '<tr><td colspan="14"><strong>' . $fila['agencia'] . '</strong></td></tr>';
    echo '<tr>
          <td align="center"><strong>Salida de Finca</strong></td>
          <td align="center"><strong>Finca</strong></td>
          <td align="center"><strong>Producto</strong></td>
          <td align="center"><strong>Prod. Desc.</strong></td>
          <td align="center"><strong>Destino</strong></td>
          <td align="center"><strong>Precio Compra</strong></td>
          <td align="center"><strong>Cajas Ordenadas</strong></td>
          <td align="center"><strong>Cajas Sin Traquear</strong></td>
          <td align="center"><strong>Cajas Traqueadas</strong></td>
          <td align="center"><strong>Total Cajas Recibidas</strong></td>
          <td align="center"><strong>Rechazadas</strong></td>
          <td align="center"><strong>Cierre de Día</strong></td>
          <td align="center"><strong>Reutilizadas</strong></td>
          <td align="center"><strong>Por entregar</strong></td>';
    $cont++;

    //Leer las fechas de los pedidos
    $sql = "SELECT distinct nropedido,fecha FROM tbletiquetasxfinca where archivada = 'No' AND estado!='5' AND destino = '" . $fila['destino'] . "' AND agencia='" . $fila['agencia'] . "' order by fecha, finca";
    $val = mysqli_query($link, $sql);
    if (!$val) {
        echo "<tr><td>" . mysqli_error() . "</td></tr>";
    } else {
        $totalsol = 0;
        $totalentstrack = 0;
        $totalenttrack = 0;
        $totalent = 0;
        $totalrech = 0;
        $totaldif = 0;
        $totalcierre = 0;
        $totalreut = 0;
        while ($row = mysqli_fetch_array($val)) {
            //recorro por cada fecha de entrega que exista en los pedidos
            $sql1 = "SELECT distinct finca,item, precio, destino FROM tbletiquetasxfinca WHERE nropedido = '" . $row['nropedido'] . "' AND fecha = '" . $row['fecha'] . "'AND estado!='5' AND archivada = 'No' order by finca,item";
            $val1 = mysqli_query($link, $sql1);
            if (!$val1) {
                echo "<tr><td>" . mysqli_error() . "</td></tr>";
            } else {
                while ($row1 = mysqli_fetch_array($val1)) {

                    //Se cuenta cuantas solicitudes y entregas hay por cada finca e item
                    $sql2 = "SELECT SUM(solicitado) as solicitado, SUM(entregado) as entregado FROM tbletiquetasxfinca where finca ='" . $row1['finca'] . "' AND item='" . $row1['item'] . "' AND precio='" . $row1['precio'] . "' AND destino='" . $row1['destino'] . "' AND nropedido = '" . $row['nropedido'] . "' AND archivada = 'No' AND estado!='5'";
                    $val2 = mysqli_query($link, $sql2) or die("Error sumando las cantidades de solicitudes y entregas de las fincas");
                    $row2 = mysqli_fetch_array($val2);

                    //Se cuenta cuantas solicitudes rechazadas hay por cada finca e item
                    $sql3 = "SELECT COUNT(*) as rechazado FROM tbletiquetasxfinca where finca ='" . $row1['finca'] . "' AND item='" . $row1['item'] . "' AND precio='" . $row1['precio'] . "' AND destino='" . $row1['destino'] . "' AND estado='2' AND nropedido = '" . $row['nropedido'] . "' AND archivada = 'No'";
                    $val3 = mysqli_query($link, $sql3) or die("Error sumando las cantidades de solicitudes y entregas de las fincas");
                    $row3 = mysqli_fetch_array($val3);

                    //Se cuenta cuantas solicitudes con cierre de dia por cada finca e item
                    $sql4 = "SELECT COUNT(*) as cierre FROM tbletiquetasxfinca where finca ='" . $row1['finca'] . "' AND item='" . $row1['item'] . "' AND precio='" . $row1['precio'] . "' AND destino='" . $row1['destino'] . "' AND estado= '3' AND nropedido = '" . $row['nropedido'] . "' AND archivada = 'No'";
                    $val4 = mysqli_query($link, $sql4) or die("Error sumando las cantidades de solicitudes y entregas de las fincas");
                    $row4 = mysqli_fetch_array($val4);

                    //Se cuenta cuantas solicitudes con cierre de dia por cada finca e item
                    $sql41 = "SELECT COUNT(*) as reutilizadas FROM tbletiquetasxfinca where finca ='" . $row1['finca'] . "' AND item='" . $row1['item'] . "' AND precio='" . $row1['precio'] . "' AND destino='" . $row1['destino'] . "' AND estado= '4' AND nropedido = '" . $row['nropedido'] . "' AND archivada = 'No'";
                    $val41 = mysqli_query($link, $sql41) or die("Error sumando las cantidades de solicitudes y entregas de las fincas");
                    $row41 = mysqli_fetch_array($val41);

                    echo "<tr>";
                    echo "<td><strong>" . $row['fecha'] . "</strong></td>";
                    echo "<td><strong>" . $row1['finca'] . "</strong></td>";
                    echo "<td align='center'><strong>" . $row1['item'] . "</strong></td>";

                    //Seleccionar la descripcion del item
                    $sql5 = "SELECT prod_descripcion FROM tblproductos where id_item ='" . $row1['item'] . "'";
                    $val5 = mysqli_query($link, $sql5) or die("Error seleccionando la descripcion del item");
                    $row5 = mysqli_fetch_array($val5);

                    //Contar cantidad de cajas entregadas sin traquear
                    $sentencia = "SELECT * FROM tblcoldroom INNER JOIN tbletiquetasxfinca ON tblcoldroom.codigo = tbletiquetasxfinca.codigo where tblcoldroom.item = '" . $row1["item"] . "' AND entrada= 'Si' AND salida ='No' AND tblcoldroom.finca='" . $row1['finca'] . "' AND tbletiquetasxfinca.archivada='No' AND tbletiquetasxfinca.estado='1' AND tbletiquetasxfinca.nropedido = '" . $row['nropedido'] . "'";
                    //echo $sentencia;
                    $consulta = mysqli_query($link, $sentencia);
                    $Cantfila = mysqli_num_rows($consulta);

                    //Contar cantidad de cajas entregadas traqueadas
                    $sentencia1 = "SELECT * FROM tblcoldroom INNER JOIN tbletiquetasxfinca ON tblcoldroom.codigo = tbletiquetasxfinca.codigo where tblcoldroom.item = '" . $row1["item"] . "' AND tblcoldroom.finca='" . $row1['finca'] . "' AND  salida ='Si' AND tblcoldroom.tracking_asig !='' AND tbletiquetasxfinca.archivada='No' AND tbletiquetasxfinca.estado='1' AND tbletiquetasxfinca.nropedido = '" . $row['nropedido'] . "'";
                    $consulta1 = mysqli_query($link, $sentencia1);
                    $Cantfila1 = mysqli_num_rows($consulta1);


                    echo "<td>" . $row5['prod_descripcion'] . "</td>";
                    echo "<td align='center'>" . $row1['destino'] . "</td>";
                    echo "<td align='center'>" . $row1['precio'] . "</td>";
                    echo "<td align='center'>" . $row2['solicitado'] . "</td>";
                    echo "<td align='center'>" . $Cantfila . "</td>";
                    echo "<td align='center'>" . $Cantfila1 . "</td>";
                    $totalsol += $row2['solicitado'];
                    //echo "<td align='center'>".$row2['entregado']."</td>";
                    if ($row2['entregado'] == 0) {
                        echo "<td align='center'><button type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='left' title = 'No hay cajas entregadas'><strong>0</strong></button></td>";
                    } else {
                        echo "<td align='center'><strong><a href='etiqentregada.php?id=" . $row['nropedido'] . "' targe='_blank' class='btn btn-success' >" . $row2['entregado'] . "</a></strong></td>";
                    }
                    echo "<td align='center'>" . $row3['rechazado'] . "</td>";
                    echo "<td align='center'>" . $row4['cierre'] . "</td>";
                    echo "<td align='center'>" . $row41['reutilizadas'] . "</td>";

                    //se restan las solicitudes - entregado - rechazado	
                    $totalrech += $row3['rechazado'];
                    $totalentstrack += $Cantfila;
                    $totalenttrack += $Cantfila1;
                    $totalent += $row2['entregado'];
                    $dif = $row2['solicitado'] - $row2['entregado'] - $row3['rechazado'] - $row4['cierre'] - $row41['reutilizadas'];
                    if ($dif < 0) {
                        $dif = "0";
                    }
                    $totalcierre += $row4['cierre'];
                    $totalreut += $row41['reutilizadas'];
                    $totaldif += $dif;
                    $totalprecio += $row1['precio'];

                    if ($dif == 0) {
                        echo "<td align='center'><button type='button' class='btn btn-success' data-toggle='tooltip' data-placement='left' title = 'No hay  cajas pendientes'><strong>" . $dif . "</strong></button></td>";
                    } else {
                        echo "<td align='center'><a href= 'etiqxentregar.php?id=" . $row['nropedido'] . "' title='Ver cajas pendientes' class='btn btn-danger'><strong>" . $dif . "</strong></a></td>";
                    }

                    echo "</tr>";
                }//FIN 3ER WHILE
            }//FIN ELSE
        }//FIN 2DO WHILE
        echo "<tr>
                <td align='right'></td>
                <td align='right'></td>
                <td align='right'></td>
                <td align='right'></td>					  
                <td align='center'><strong>Total por agencia:</strong></td>
                <td align='center'><strong>" . $totalprecio . "</strong></td>
                <td align='center'><strong>" . $totalsol . "</strong></td>
                <td align='center'><strong>" . $totalentstrack . "</strong></td>
                <td align='center'><strong>" . $totalenttrack . "</strong></td>
                <td align='center'><strong>" . $totalent . "</strong></td>
                <td align='center'><strong>" . $totalrech . "</strong></td>
                <td align='center'><strong>" . $totalcierre . "</strong></td>
                <td align='center'><strong>" . $totalreut . "</strong></td>";

        if ($totaldif == 0) {
            echo "<td align='center'><button type='button' class='btn btn-success' data-toggle='tooltip' data-placement='left' title = 'No hay  cajas pendientes'><strong>" . $totaldif . "</strong></button></td>";
        } else {
            echo "<td align='center'><button type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='rigth' title = 'Ver cajas por entregar'>" . $totaldif . "</button></td>";
        }
        echo "</tr>";

        //Sumar alos totales
        $TOTALPRECIO += $totalprecio;
        $TOTALSOL += $totalsol;
        $TOTALENTSTRACK += $totalentstrack;
        $TOTALENTTRACK += $totalenttrack;
        $TOTALENT += $totalent;
        $TOTALRECH += $totalrech;
        $TOTALCIERRE += $totalcierre;
        $TOTALREUT += $totalreut;
        $TOTALDIF += $totaldif;

        //Resetear los subtotales
        $totalprecio = 0;
        $totalsol = 0;
        $totalentstrack = 0;
        $totalenttrack = 0;
        $totalent = 0;
        $totalrech = 0;
        $totalcierre = 0;
        $totalreut = 0;
        $totaldif = 0;
    }//FIN ELSE		   
}//FIN 1ER WHILE
echo "
    <tr>
    <td align='right'></td>
    <td align='right'></td>
    <td align='right'></td>
    <td align='right'></td>					  
    <td align='center'><strong>Total General por País:</strong></td>
    <td align='center'><strong>" . $TOTALPRECIO . "</strong></td>
    <td align='center'><strong>" . $TOTALSOL . "</strong></td>
    <td align='center'><strong>" . $TOTALENTSTRACK . "</strong></td>
    <td align='center'><strong>" . $TOTALENTTRACK . "</strong></td>
    <td align='center'><strong>" . $TOTALENT . "</strong></td>
    <td align='center'><strong>" . $TOTALRECH . "</strong></td>
    <td align='center'><strong>" . $TOTALCIERRE . "</strong></td>
     <td align='center'><strong>" . $TOTALREUT . "</strong></td>";

if ($TOTALDIF == 0) {
    echo "<td align='center'><button type='button' class='btn btn-success' data-toggle='tooltip' data-placement='left' title = 'No hay  cajas pendientes'><strong>" . $TOTALDIF . "</strong></button></td>";
} else {
    echo "<td align='center'><button type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='rigth' title = 'Ver cajas por entregar'>" . $TOTALDIF . "</button></td>";
}
echo "</tr>";

$salida3 = ob_get_contents();
ob_end_clean();

$ff = fopen("file2.php", "w");
fwrite($ff, print_r($salida3, true));
fclose($ff);
?>