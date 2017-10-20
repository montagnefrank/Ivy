<?php
session_start();
require_once('conexion.php');
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {die('Fallo la conexion con el servidor ' . mysql_error());	}
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {	die("Ubase de datos no encontrada"); }
	
	if($_POST["btn_cliente"]!=null)
	{$_SESSION["ced"]=$_POST["btn_cliente"];	}
	$_SESSION["rr"]=$_SESSION["ced"];

$sql1="SELECT id_venta, cpnum1_venta, cpnum2_venta, cpnumero_venta FROM tblfactura_venta ORDER BY id_venta DESC limit 1;";
$result1=mysql_query($sql1);	
while ($row1 = mysql_fetch_array($result1)) { 
	$id_num=$row1["id_venta"];
	$_SESSION["fac_num"]=$id_num;
	$num1=$row1["cpnum1_venta"];
	$num2=$row1["cpnum2_venta"];
	$numfac=$row1["cpnumero_venta"];
	
	}
	
	$num11=(int)$num1;
	$num22=(int)$num2;
	$num33=(int)$numfac+1;
	if($num1<1);
	$num11=1;
	if($num2<1)
	$num22=1;
	
	if($num11>=0 && $num11<10)
		$num111="00".$num11;
	if($num11>=10 && $num11<100)
		$num111="0".$num11;
	if($num11>=100 && $num11<1000)
		$num111=$num11;
		
	if($num22>=0 && $num22<10)
		$num222="00".$num22;
	if($num22>=10 && $num22<100)
		$num222="0".$num22;
	if($num22>=100 && $num22<1000)
		$num222=$num22;
		
	if($num33>0 && $num33<10)
		$num333="000000".$num33;
	if($num33>=10 && $num33<100)
		$num333="00000".$num33;
	if($num33>=100 && $num33<1000)
		$num333="0000".$num33;
	if($num33>=1000 && $num33<10000)
		$num333="000".$num33;
	if($num33>=10000 && $num33<100000)
		$num333="00".$num33;
	if($num33>=100000 && $num33<1000000)
		$num333="0".$num33;
	if($num33>=1000000 && $num33<10000000)
		$num333="".$num33;
		
		
	function id_fac(){
            $sql_u="select id_venta from tblfactura_venta where id_venta=(select max(id_venta) from tblfactura_venta) ";
            $result_v=mysql_query($sql_u);	
            while ($ven = mysql_fetch_row($result_v))
            {$ult=$ven[0];}
            return $ult;
        }

        function id_asiento(){
                $sql_asiento="select id_asiento from tblasientos where id_asiento=(select max(id_asiento) from tblasientos) ";
                $result_asiento=mysql_query($sql_asiento);	
                while ($asiento = mysql_fetch_row($result_asiento))
                {$idasiento=$asiento[0];}
                return $idasiento;
        }

        function asiento_numero($numero_asiento){
                $sql_consultar_asiento="SELECT cpnumero_asiento FROM tblasientos where id_asiento='".$numero_asiento."';";
                $ejecutar_asiento=mysql_query($sql_consultar_asiento) or die(mysql_error());
                while($row=mysql_fetch_array($ejecutar_asiento)){
                $numero=$row["cpnumero_asiento"];
                }
                 return $numero;
        }
	
	if($_SESSION["fecha_venta"]=="" || $_SESSION["fecha_venta"]==" "){
		$_SESSION["fecha_venta"]=date("d/m/Y");
	}
	
	if($_SESSION["factura_numero"]=="" || $_SESSION["factura_numero"]==" "){
	$_SESSION["factura_numero"]=$num333;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="https://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript">setInterval(function() {
    $("#resultado").load(location.href+" #content>*","");
}, 5000);</script>

<title>Factura Venta</title>
<script>
		function imprimir(){
		  var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
		  var ventana=window.open('','_blank');  //abrimos una ventana vac a nueva
		  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
		  ventana.document.close();  //cerramos el documento
		  ventana.print();  //imprimimos la ventana
		  ventana.close();  //cerramos la ventana
		}
	</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="funciones_ajax.js"></script>
<script src="js/jquery-1.3.1.min.js" type="text/javascript"> </script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script language="javascript">
    function redondeo2decimales(numero) {
           var flotante = parseFloat(numero);
           var resultado = Math.round(flotante*100)/100;
           return resultado;
   } 

        function descuento() {
                var descuento=document.getElementById("txtdescuento").value;
                var subtotal=document.getElementById("txtsubtotal").value;
                var d=descuento/100;
                var desc=subtotal*d;
                var descontado=subtotal-desc;
                var iva=descontado*0.12;
                var total=descontado+iva;
                if(descuento=="" || descuento == 0) {
                document.getElementById('txtsd').value= 0;
                document.getElementById('txtid').value=0;
                document.getElementById('txttd').value=0;
                }
                else{
                document.getElementById('txtsd').value= redondeo2decimales(descontado);
                document.getElementById('txtid').value=redondeo2decimales(iva);
                document.getElementById('txttd').value=redondeo2decimales(total);
                }
        }
</script>
<link href="css/estilo_personalizado.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.botoncontacto 
{background-image: url(imagen/a�adir.png); width:40px; height: 42px; border-width: 0;  font-size:0px; }

.quitar 
{background-image: url(imagen/quitar.png); width:25px; height: 24px; border-width: 0;  font-size:0px; }
</style>


<script src="js/jquery-1.3.1.min.js" ></script>
    <script type="text/javascript">
        $('document').ready(function(){
		$('#btninsertar').click(function(){
			if($('#txtcantidad').val()==""){
			alert("Introduce la cantidad del producto");
			return false;
				 }
			else{
			var cantidad = $('#txtcantidad').val();
				}
				
			if($('#txtdetalle').val()==""){
			alert("Producto no encontrado, busque el producto y seleccione lo desglozado.!!");
			return false;
				}
			else{
			var detalle= $('#txtdetalle').val();
				}
				
			if($('#txtunitario').val()==""){
			alert("Introduce el valor unitario del producto");
						return false;
					}
					else{
				var unitario = $('#txtunitario').val();
					}
					jQuery.post("#", {
						cant:cantidad,
						deta:detalle, 
						uni:unitario
					}, function(data, textStatus){
	if(data == 1){
	var cantidad = $('#txtcantidad').val("");
	var detalle= $('#txtdetalle').val("");
	var unitario = $('#txtunitario').val("");
	$('#res').html("LISTO");
	$('#res').css('color','green');
			}
	else{
	$('#res').html("ERROR");
	$('#res').css('color','red');
						}
					});
				});
			});
		</script> 
        

<style>
.table {
  border: black 1px solid;
}
</style>
<script language="javascript">          
function abrir(direccion, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, sustituir){
    var izquierda = (screen.availWidth - ancho) / 2;
    var arriba = (screen.availHeight - alto) / 2;
    var opciones = "fullscreen=" + pantallacompleta +
                 ",toolbar=" + herramientas +
                 ",location=" + direcciones +
                 ",status=" + estado +
                 ",menubar=" + barramenu +
                 ",scrollbars=" + barrascroll +
                 ",resizable=" + cambiatamano +
                 ",width=" + ancho +
                 ",height=" + alto +
                 ",left=" + izquierda +
                 ",top=" + arriba;

    var ventana = window.open(direccion,"ventana",opciones,sustituir);
}                      
</script> 
<link rel="stylesheet" type="text/css" media="all" href="calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="calendar.js"></script>
  <script type="text/javascript" src="calendar-en.js"></script>
  <script type="text/javascript" src="calendar-setup.js"></script>
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
   		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
   		<link href="css/jqueryui.css" type="text/css" rel="stylesheet"/>
       
        
           <script>
		 
	       	$(document).ready(function(){ 	
                        $( "#txtdetalle2" ).autocomplete({
      				source: "buscarcliente2.php",
      				minLength: 2
    			});
    			
    			$("#tblver").mouseover(function(){
    				$.ajax({
    					url:'cliente2.php',
    					type:'POST',
    					dataType:'json',
    					data:{ matricula1:$('#txtdetalle2').val()}
    				}).done(function(respuesta){
    				$("#txtdetalle").val(respuesta.codigo);
					$("#txtunitario").val(respuesta.precio );
    					
    				});
    			}); 
				   			    		
			});
		 
        </script>
        
     
</head>

<body >
<form id="form1" name="form1" method="post" action="">
<?php 
	$sqlconsulta="SELECT id_cliente, cpcedula_cliente, cprazonsocial_cliente, cpdireccion_cliente , cptelefono_cliente FROM tblcliente WHERE cpcedula_cliente='".$_SESSION["rr"]."' ;";
	$ejec=mysql_query($sqlconsulta);
	while ($row = mysql_fetch_array($ejec)) {
			$id_cliente=$row["id_cliente"];
		   $cedula = $row["cpcedula_cliente"];
		   $nombre = $row["cprazonsocial_cliente"];
		   $direccion = $row["cpdireccion_cliente"];
		   $telefono = $row["cptelefono_cliente"];
		   $_SESSION["cedula_imprimir"]=$cedula ;
		}
		
?>
<?php 
function redondeo($valor) { 
   $float_redondeado=round($valor * 100) / 100; 
   return $float_redondeado; 
}
$fec_pago=date("d/m/Y", mktime(0, 0, 0, date("m"), date("d")+5, date("Y") ));
?>
  <table width="663" border="0" align="center"  >
    <tr>
      <td height="29" colspan="6" align="center"  bgcolor="#99CCFF"><strong>DATOS PERSONALES</strong></td>
    </tr>
    <tr>
      <td width="138"><strong>C.I. / RUC.:</strong></td>
      <td width="133"><?php echo $cedula ?></td>
      <td width="30"><a href="buscar_cliente.php"><img src="imagen/images.jpg" width="23" height="22" title="Buscar proveedor" style="cursor:pointer" /></a></td>
      <td width="30"><a href="#"  onClick="abrir('frmcliente_2.php', '', '', '', '', '', 'auto', '', '650', '480', '')"><img src="imagen/new.png" width="18" height="22" title="Nuevo proveedor" style="cursor:pointer" /></a></td>
      <td width="109"><strong>Num. Factura:</strong></td>
      <td width="197"><?php echo ($num111."-".$num222."-")?><input name="txtnumero" type="text" value="<?php echo $_SESSION["factura_numero"]?>" size="10" /></td>
    </tr>
    <tr>
      <td><strong>Sr. (es)</strong></td>
      <td colspan="5"><?php echo $nombre." ".$apellido ?></td>
    </tr>
    <tr>
      <td height="22"><strong>Direcci�n:</strong></td>
      <td colspan="5"><?php echo $direccion ?></td>
    </tr>
    <tr>
      <td><strong>Tel�fono:</strong></td>
      <td colspan="3"><?php echo $telefono ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      
    </tr>
    <tr>
      <td><strong>Forma pago:</strong></td>
      <td colspan="3"><select name="cbxpago" class="text">
        <option value="EFECTIVO">Efectivo</option>
        <option value="CHEQUE">Cheque</option>
        <option value="TRANSACCION">Transaccion</option>
      </select></td>
      <td><strong>Vendedor:</strong></td>
      <td><?php echo "BURTON TECH - 3050254329001";?></td>
    </tr>
    <tr>
      <td><strong>Fecha emisi�n:</strong></td>
      <td colspan="3"><input name="txtdate" type="text" id="txtdate" value="<?php echo $_SESSION["fecha_venta"];?>" readonly="readonly" />
       <script type="text/javascript">
    function catcalc(cal) {
        var date = cal.date;
        var time = date.getTime()
        // use the _other_ field
        var field = document.getElementById("f_calcdate");
        if (field == cal.params.inputField) {
            field = document.getElementById("txtdate");
            time -= Date.WEEK; // substract one week
        } else {
            time += Date.WEEK; // add one week
        }
        var date2 = new Date(time);
        field.value = date2.print("%d/%m/%Y");
    }
    Calendar.setup({
        inputField     :    "txtdate",   // id of the input field
        ifFormat       :    "%d/%m/%Y ",       // format of the input field
        showsTime      :    false,
        timeFormat     :    "24",
        onUpdate       :    catcalc
    });

</script></td>
      <td><strong>Fecha Pago:</strong></td>
      <td><input name="txtfechapago" type="text" class="text" id="txtfechapago" readonly="readonly" value="<?php echo $fec_pago ?>" /></td>
    </tr>
  </table>
  <br />
  
  <table width="610"  border="0" align="center" id="tblver" onmousemove="detalle()">
  
    <tr >
      <td width="64" align="center"><strong>Cantidad</strong></td>
      <td colspan="3" align=""><label>
        <input name="txtcantidad" type="text" class="table" id="txtcantidad" value="1" size="10"/>
      </label></td>
     
    </tr>
    <tr >
      <td height="26" align="center"><strong>Detalle:</strong></td>
      <td width="440" align=""><label for="textfield">
        <input name="txtdetalle2" type="text" id="txtdetalle2" size="40" class="table" />
    </label></td>
      <td width="2" align="">&nbsp;</td>
      <td align=""><input name="txtdetalle" type="hidden" class="table" id="txtdetalle" value=""  /></td>
    </tr>
    
    <tr >
      <td height="44" align="center" valign="top"><strong>P. Unitario</strong></td>
      <td colspan="2" align="" valign="top"  ><input name="txtunitario" type="text" id="txtunitario" size="10" class="table" /></td>
      <td width="26" align=""  > <span id="res"></span></td>
      <td width="56"  align="" rowspan="4" ><input name="btninsertar" type="submit" class="botoncontacto"  id="btninsertar" value="Insertar" style="cursor:pointer" title="Insertar los datos"  /></td>
    </tr>

  </table>
  <br />
  <div id="resultado">
  <table width="663" border="0" align="center" id="myTable"  >
    <tr bgcolor="#00CCFF"  >
      <td width="91" class="table"><strong>Cantidad</strong></td>
      <td width="330" align="center" class="table" ><strong>Descripcion</strong></td>
      <td width="74"  class="table"><strong>P. Unit</strong></td>
      <td width="84" class="table" ><strong>P. Total</strong></td>
      <td width="84" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
     
    <?php
        if(isset($_POST["btninsertar"])) {
		$cantidad=$_POST["txtcantidad"];
		$detalle=$_POST["txtdetalle2"];
		$unitario=$_POST["txtunitario"];
		$cuenta_de=$_POST["txtdetalle"];
		
		$sql_consultar_descripcion="select cpdescripcion_producto from tblproducto where cpcodigo_producto='$cuenta_de';";
		$ejecutar_consulta=mysql_query($sql_consultar_descripcion) or die(mysql_error());
		while($fila=mysql_fetch_array($ejecutar_consulta)){
                    $descripcion_producto=$fila["cpdescripcion_producto"];
		}
		
		$total=redondeo($cantidad*$unitario);
$sqlinsertfac="INSERT INTO  tbaux_ven(  cpcantidad_ax, cpdet_aux,  cppu_aux, cppt_aux, cpdescripcion_cuenta)VALUE ('$cantidad',  '$descripcion_producto',  '$unitario', '$total' , '$cuenta_de' );";
	$sql_1=mysql_query($sqlinsertfac);
	
	$fecha_venta=$_POST["txtdate"];
	$numero_facturero=$_POST["txtnumero"];
	
	$_SESSION["fecha_venta"]= $fecha_venta;
	$_SESSION["factura_numero"]=$numero_facturero;
	$ss = $seconds * 10000;
				$url="frmfactura_venta.php";
$comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".$ss.");</script>";
				echo ($comando);
	
    }
			if(isset($_POST["id"])){
			$val=$_POST["id"];
			$delet="DELETE FROM tbaux_ven WHERE id_auxc = $val;";
			mysql_query($delet);
			
	$fecha_venta=$_POST["txtdate"];
	$numero_facturero=$_POST["txtnumero"];
	
	$_SESSION["fecha_venta"]= $fecha_venta;
	$_SESSION["factura_numero"]=$numero_facturero;
	$ss = $seconds * 10000;
				$url="frmfactura_venta.php";
$comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".$ss.");</script>";
				echo ($comando);
			
			}
			
			
			
	?>
    <?php include('consul_fac_ventas.php');?>
    <tr >
      <td colspan="2">&nbsp;</td>
      <td  bgcolor="#CCCCCC" >Subtotal:</td>
      <td bgcolor="#CCCCCC"><?php echo $subtotal ?>
        <input type="hidden" name="txtsubtotal" value="<?php echo $subtotal ?>" id="txtsubtotal" /></td>
      <td bgcolor="#FFFFFF"><input name="txtsd" type="text" id="txtsd" value="0" size="5" readonly="readonly" style="border:none" /></td>
    </tr>
    <tr >
      <td colspan="2">&nbsp;</td>
      <td  >IVA 12%:</td>
      <?php $iva=redondeo($subtotal*0.12);?>
      <td><?php echo $iva?></td>
      <td bgcolor="#FFFFFF"><input name="txtid" type="text" id="txtid" value="0" size="5" readonly="readonly" style="border:none" /></td>
    </tr>
    <tr >
      <td colspan="2">&nbsp;</td>
      <td bgcolor="#CCCCCC" >Descuento:</td>
      <td bgcolor="#CCCCCC" ><input name="txtdescuento" type="text" id="txtdescuento"   onkeyup="descuento()" value="0" size="3" class="table"/></td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr >
      <td width="91" colspan="2">&nbsp;</td>
      <td width="74"  ><strong>Total:</strong></td>
      <?php $total=$subtotal+$iva; ?>
      <td width="84" ><hr />
        <?php echo $total?></td>
      <td width="84" bgcolor="#FFFFFF"><input name="txttd" type="text" id="txttd" value="0" size="5" readonly="readonly" style="border:none" /></td>
    </tr>
  </table>
  </div>
  <br />
  <table width="668" border="0" align="center">
    <tr>
      <td width="277" align="center"><label>
        <input type="submit" name="button" id="button" value="Registrar e Imprimir factura" />
      </label></td>
      <td width="209" align="center"><label>
        <input type="submit" name="button2" id="button2" value="Cancelar" />
      </label></td>
      
    </tr><span class="botoncontacto"> <a href=index.php>Regresar</a></span>
  </table>
  <p><br />
<table width="157" height="44" border="0" align="left" class="table" bgcolor="#CCFF00">
    <tr>
      <td width="149" align="center"><strong><a href="index.php">ATRAS</a></strong></td>
    </tr>
  </table>
  </p>
 <?php 
 echo $numero_asiento=asiento_numero(id_asiento());
 if(isset($_POST["button"])) {
#llamada a los campos para hacer el respectivo ingreso de factura
	 $factura=$id_num+1;
	 $iva=redondeo($iva);
	 $total=redondeo($total);
	 $_SESSION["fac_num"]=$factura;
	 $facven_id=(int)id_fac()+1;
	 $fecha_actual=$_POST["txtdate"];
	 $vendedor="BURTON TECH - 3050254329001";
	 $descuento="0";
	 $debe="debe";
	 $haber="haber";
	 $estado="PENDIENTE";
	 $pago=$_POST["cbxpago"];
	 $numfacturero=$_POST["txtnumero"]; 
	 
	 
	 #Ingresar en la tabla factura
	$sql_fac="INSERT INTO tblfactura_venta(id_venta, cpnum1_venta, cpnum2_venta, cpnumero_venta, cpfecha_venta, cpfechapag_venta, cpvendedor_venta, cpformpag_venta, cpsubtotal_ventas, cpiva_ventas, cpdescuento_ventas, cptotal_ventas, idcliente_venta, cpestado_factura) VALUE ('$facven_id', '$num111', '$num222', '$numfacturero', '$fecha_actual', '$fec_pago', '$vendedor', '$pago', '$subtotal', '$iva', '$descuento', '$total', '$id_cliente', '$estado');";
	$eje_correc=mysql_query($sql_fac) or die(mysql_error());
if($eje_correc){ 
	 $tblfac="select * from tbaux_ven";
	$res=mysql_query($tblfac);
while($rr=mysql_fetch_array($res)) {
				  $cant=$rr['cpcantidad_ax'];
				  $deta=$rr['cpdet_aux'];
				  $prec=$rr['cppu_aux'];
				  $descipcuenta=$rr['cpdescripcion_cuenta'];
				  $tota=$rr['cppt_aux'];
$sql_insert="INSERT INTO tbldetalleventas( cpcantidad, cpdetalle, cpprecio_u,cppreciototal,idventa_detalles, cpplancuentas) VALUE ( '$cant', '$deta', '$prec', '$tota', ' $facven_id', '$descipcuenta');";
	 mysql_query($sql_insert) or die(mysql_error());
#consultar producto
$sql_consultar_producto="SELECT cpstock_producto FROM tblproducto where cpcodigo_producto='$descipcuenta';";
$ejecutar_producto=mysql_query($sql_consultar_producto) or die(mysql_error());
while($columna=mysql_fetch_array($ejecutar_producto)){
$disponible=$columna["cpstock_producto"];
}

$residuo=$disponible-$cant;
#actualizar datos de productos
$sql_actualizar="UPDATE tblproducto SET cpstock_producto = '$residuo' WHERE cpcodigo_producto = '$descipcuenta';";
mysql_query($sql_actualizar) or die(mysql_error());
	 
			}
			
			
$deletable="truncate table tbaux_ven; ";
$res1=mysql_query($deletable) or die(mysql_error());
			if($res1){
			echo "<script> alert('Datos registrados') </script>";
			$_SESSION["ced"]=" ";
			$_SESSION["fecha_venta"]= " ";
			$_SESSION["factura_numero"]=" ";
			unset($_SESSION["factura_numero"]);
			$comando11 = "<script language='JavaScript'>window.open('imprimir.php','','width=800, height=800, scrollbars=yes','', '');</script>";
				echo ($comando11);
			
			$url="frmfactura_venta.php";
$comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".($seconds * 10000).");</script>";
			    echo ($comando);
				
				
			}
 }
 }
 
 if(isset($_POST["button2"]))
{
	$deletable=" truncate table tbaux_ven; ";
			$res1=mysql_query($deletable) or die(mysql_error());
			$_SESSION["ced"]=" ";
			$ss = $seconds * 10000;
				$url="frmfactura_venta.php";
$comando = "<script>window.setTimeout('window.location=".chr(34).$url.chr(34).";',".$ss.");</script>";
				echo ($comando);
			
}
 ?>
</form>
</body>
</html>