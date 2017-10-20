<div id="page-wrapper">
<?php 
    if(isset($dcliente))
    {
        foreach($dcliente as $cliente):
            $nombre=$cliente->cprazonsocial_cliente;
            $cedula=$cliente->cpcedula_cliente;
            $direccion=$cliente->cpdireccion_cliente;
            $telefono=$cliente->cptelefono_cliente;
            $celular=$cliente->cpcelular_cliente;
            
        endforeach;
    }

    if(isset($dfactura))
    {
        
        foreach($dfactura as $datos)
	{
          
          $fechapago=$datos->cpfechapag_venta;
          $subtotal=$datos->cpsubtotal_ventas;
          $iva=$datos->cpiva_ventas;
          $total=$datos->cptotal_ventas;
          $comentario=$datos->comentario;
        }
    }
   ?>


    <div id="form1" name="form1" style="margin-left: 7px;">
    <table width="743" border="0" style="margin-top: 40px;">
    <tr>
      <td colspan="4" align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><br />
          <br />
        </p>
      </td>
    </tr>
    <tr>
      <td width="43" height="19">&nbsp;</td>
      <td width="425">&nbsp;</td>
      <td width="137">&nbsp;</td>
      <td width="120"><?php echo date("Y-m-d"); ?></td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td><?php echo $nombre ?></td>
      <td>&nbsp;</td>
      <td><?php echo $fechapago?></td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td><?php echo $direccion ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="20" >&nbsp;</td>
      <td><?php echo $cedula ?></td>
      <td>&nbsp;</td>
      <td>BURTON TECH - 3050254329001</td>
    </tr>
    <tr>
      <td height="20" >&nbsp;</td>
      <td colspan="3"><?php  echo $telefono; ?></td>
    </tr>
  
  </table>
  <br />
  <table width="723" height="514" border="0" style="margin-top: 14px">
    <tr>
      <td width="717" height="596" valign="top"><table width="719" border="0" >
        <tr>
          <td width="54">&nbsp;</td>
          <td width="336">&nbsp;</td>
          <td width="86">&nbsp;</td>
          <td width="73">&nbsp;</td>
          <td width="65">&nbsp;</td>
          <td width="79">&nbsp;</td>
        </tr>
        <?php
	
	
	echo "<tr>";
	
        foreach ($dfactura as $datos)
	{
            
            echo "<td></td>";
            echo "<td>$datos->cpdetalle</td>";
            echo "<td></td>";
            echo "<td>$datos->cpcantidad</td>";
            echo "<td>$datos->cpprecio_u</td>";
            echo "<td>$datos->cppreciototal</td>";
            echo "</tr>";
           
	}

	
	?>
      </table></td>
    </tr>
  </table>
  <br/>
  <table width="716" border="0">
    <tr>
      <td width="497" height="0"  align="right">&nbsp;</td>
      <td width="109" rowspan="4"  align="right">&nbsp;</td>
      <td  align="right"><?php echo $subtotal; ?></td>
    </tr>
    <tr>
      <td width="497" height="1"  align="left" rowspan="3"><textarea name="textarea" id="textarea" cols="60" rows="5" style="border:none"   ><?php echo $comentario ?></textarea ></td>
      <td height="23"  align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="103" height="27"  align="right"><?php echo $iva ?></td>
    </tr>
    <tr>
      <td width="103" height="11"  align="right"><?php echo $total ?></td>
    </tr>
  </table>
</div>
</div>


<script language="javascript"> 
    function imprimir() { 
//        if ((navigator.appName == "Netscape")) { 
//            window.print() ; 
//        } 
//        else { 
//            var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
//            document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = ""; 
//        } 
    }
    
//        function imprSelec(muestra)
//        {
//            var ficha=document.getElementById(muestra);
//            var ventimp=window.open(' ','popimpr');
//            ventimp.document.write(ficha.innerHTML);
//            ventimp.document.close();
//            ventimp.print();
//            ventimp.close();
//        }

    
    $(document).ready(function() {
       imprimir(); 
    });
</script> 