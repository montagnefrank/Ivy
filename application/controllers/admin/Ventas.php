<?php
require_once  APPPATH.'libraries/admin_controller.php';

class Ventas extends admin_controller{
    var $package="admin";
    var $id="ventas";
    
    //Siempre se ejecuta cuando se llama a esta clase antes de ejecutarse cualquier funcion
    function __construct(){
        parent::__construct();
        $this->check_login();
        $this->check_setup();
        $this->removeCache();
    }

    function index(){
        $this->data["active_sub_tab"]="nuevo";
        $this->data["title"] = "Ventas";
        $this->data["productos"]=$this->mydata->buscar_productos();
        $this->data["factura"]=$this->mydata->numerofactura();
        $this->data["dexistentes"]=$this->mydata->datosExistentes();
        
        $this->data = array_merge($this->data,$this->mydata->get_ventas());
        $this->show_me('listado');
    }
    
    public function listado_ventas()
    {
        $listado_ventas=$this->mydata->get_ventas();
        $this->output->set_content_type('application/json')->set_output(json_encode($listado_ventas));
    }
    
    public function nuevoventas()
    {
        
       $resp=$this->mydata->nuevoventas(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function cancelar()
    {
       $resp=$this->mydata->cancelarventas(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    //obtengo un ventas por su id
    public function obtener_ventas()
    {
        $id= $this->input->post('id');
        $resp=$this->mydata->obtenerventas($id);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
   
        
    public function eliminarventas()
    {
       $id= $this->input->post('id');
             
       $datos=array(
           'id_cliente'=>$id
        );
       
       $resp=$this->mydata->deleteventas($datos);       
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function insertar_tabla_temporal()
    {        
       $resp=$this->mydata->insertar_tabla_temporal(); 
       $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    
    
    
    //obtener detalle de cierto producto
    public function obtener_detalle_producto()
    {
        $id= $this->input->post('id');
        $resp=$this->mydata->obtener_detalle_producto($id);       
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function imprimir($id="")
    {
        $this->data["active_sub_tab"]="imprimir";
        $this->data["title"] = "Ventas";
        $this->data["dfactura"]=$this->mydata->obtenerDatosFactura($id);
        $this->data["dcliente"]=$this->mydata->obtenerDatosClienteFactura($id);
        $this->show_me('imprimir');
    }
    
    
    ////////////////////////////
    ////REPORTES DE FACTURAS////
    //REPORTE DE FACTURA VENTAS
    public function factura_ventas()
    {
        $this->data["active_sub_tab"]="factura_ventas";
        $this->data["title"] = "Cobros";
        $this->data["factura_ventas"]=$this->mydata->factura_ventas();  
        $this->show_me();
    }
    public function buscarfactura()
    {
        $resp=$this->mydata->buscarfactura(); 
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function anularfactura()
    {
        $resp=$this->mydata->anularfactura(); 
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function pendientes_cobro()
    {
        $this->data["active_sub_tab"]="pendientes_cobro";
        $this->data["title"] = "Pendientes de Cobro";
        $this->data["dfactura"]=$this->mydata->obtenerPendientesCobro();
        $this->show_me();
    }
    
    public function pagarfactura()
    {
        $resp=$this->mydata->pagarfactura(); 
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function porFactura($id="")
    {
        if($id==""){
            $this->data["active_sub_tab"]="ReporteporFactura";
            $this->data["title"] = "Reporte por Factura de Cobro";
            $this->data["plan"]=$this->mydata->plandecuentas();
            $this->show_me();
        }
        else {
            $this->data["active_sub_tab"]="ReporteporFactura";
            $this->data["title"] = "Reporte por Factura de Cobro";
            $this->data["plan"]=$this->mydata->plandecuentas();
            $this->data["reporte"]=$this->mydata->ReporteporFactura();
            $this->show_me();
        }
    }
    
    public function porCliente($id="")
    {
        if($id==""){
            $this->data["active_sub_tab"]="ReporteporCliente";
            $this->data["title"] = "Reporte por Factura de Cobro";
            $this->data["plan"]=$this->mydata->plandecuentas();
            $this->show_me();
        }
        else {
            $this->data["active_sub_tab"]="ReporteporCliente";
            $this->data["title"] = "Reporte por Factura de Cobro";
            $this->data["plan"]=$this->mydata->plandecuentas();
            $this->data["reporte"]=$this->mydata->ReportePorCliente();
            $this->show_me();
        }
    }
    
    public function reporteGeneral($id="")
    {
        if($id==""){
            $this->data["active_sub_tab"]="ReporteGeneral";
            $this->data["title"] = "Reporte General";
            $this->show_me();
        }
        else {
            $this->data["active_sub_tab"]="ReporteGeneral";
            $this->data["title"] = "Reporte General";
            $this->data["reporte"]=$this->mydata->ReporteGeneral();
            $this->data["finicio"]=$this->input->post('finicio');
            $this->data["ffin"]=$this->input->post('ffin');
            $this->show_me();
        }
    }
    
    public function descargarexcell()
    {
        $this->load->library('Excell');
        //Aqui se crea el objeto de tipo excel 2007
        $objPHPExcel = new PHPExcel();

        //Se le crean las propiedades
        $objProps= $objPHPExcel->getProperties();
        $objProps->setCreator("burtonservers.com");

        //Aqui se activa la primera hoja del excel
        $objPHPExcel->setActiveSheetIndex(0); 
        $objActSheet = $objPHPExcel->getActiveSheet();


        $fecha_inicio=$this->input->post('finicio');
        $fecha_fin=$this->input->post('ffin');
        
        // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:M1');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',"Reporte Completo desde el ".$fecha_inicio." hasta ".$fecha_fin );
        
        $estiloTituloReporte = array(
		'font' => array(
			'name'      => 'Arial',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>10
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		)
	);
				
	//Se ejecuta la consulta y se van creando los filtros del reporte 
	$reporte=$this->mydata->ReporteGeneral();
        
        $titulo=array('Num Factura','Fecha','Cliente','Subtotal','Iva 0%','Iva 12%','Valor Total');
        $fila = 2;
	$letra = 'A';        
        $lastColumn = $letra.$fila;
        
        for($i=0;$i<count($titulo);$i++)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$titulo[$i]);
            $objPHPExcel->getActiveSheet()->getStyle($lastColumn)->applyFromArray($estiloTituloReporte);
            $letra++;
            $lastColumn = $letra.$fila;
            
        }
        
        $letra = 'A';
        $fila = 3;
        $lastColumn = $letra.$fila;
        
        
        
        for($i=0;$i<count($reporte[0]);$i++)
        {
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[0][$i][0]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[0][$i][1]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[0][$i][2]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[0][$i][3]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[0][$i][4]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[0][$i][5]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[0][$i][6]);
            $letra = 'A';
            $fila++;
            $lastColumn = $letra.$fila; //va iterando desde la E,F,G...n en la fila 1 ($head)
        }
        
        
        $titulo1=array('Num Factura','Fecha','Cliente','Subtotal','Iva','Total','Impuesto','Porcentaje','Valor','Impuesto','Porcentaje','Valor');
        $letra = 'A';
        $fila++;
        $lastColumn = $letra.$fila;      
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($estiloTituloReporte);
        for($i=0;$i<count($titulo1);$i++)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$titulo1[$i]);
            $objPHPExcel->getActiveSheet()->getStyle($lastColumn)->applyFromArray($estiloTituloReporte);
            $letra++;
            $lastColumn = $letra.$fila;
            
        }
        
        $letra = 'A';
        $fila++;
        $lastColumn = $letra.$fila;
        
        $subtotal=0;
        $total=0;
        $valor=0;
        $valor1=0;
        for($i=0;$i<count($reporte[1]);$i++)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][0]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][1]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][2]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][3]);
            $subtotal+=$reporte[1][$i][3];
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][4]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][5]);
            $total+=$reporte[1][$i][5];
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][6]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][7]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][8]);
            $valor+=$reporte[1][$i][8];
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][9]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][10]);
            $letra++;
            $lastColumn = $letra.$fila;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$reporte[1][$i][11]);
            $valor1+=$reporte[1][$i][11];
            
            if($reporte[1][$i][6]=='ANULADO'){
                $estilo= array(		
                    'fill' => array(
                            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array(
                                    'argb' => 'FF0000')
                    ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.":".'L'.$fila)->applyFromArray($estilo);
            }
                
            
            
            $letra = 'A';
            $fila++;
            $lastColumn = $letra.$fila;
        }
        
        $letra = 'D';
        $lastColumn = $letra.$fila;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$subtotal);
        $objPHPExcel->getActiveSheet()->getStyle($lastColumn)->applyFromArray($estiloTituloReporte);
        $letra = 'F';
        $lastColumn = $letra.$fila;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$total);
        $objPHPExcel->getActiveSheet()->getStyle($lastColumn)->applyFromArray($estiloTituloReporte);
        $letra = 'I';
        $lastColumn = $letra.$fila;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$valor);
        $objPHPExcel->getActiveSheet()->getStyle($lastColumn)->applyFromArray($estiloTituloReporte);
        $letra = 'L';
        $lastColumn = $letra.$fila;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($lastColumn,$valor1);
        $objPHPExcel->getActiveSheet()->getStyle($lastColumn)->applyFromArray($estiloTituloReporte);
        
        
        //Dando algunos estilos
	$estiloTituloReporte = array(
		'font' => array(
			'name'      => 'Verdana',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>16,
			'color'     => array(
				'rgb' => 'FF220835'
			)
		),
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array(
				'argb' => 'FFFFFF')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE
			)
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		)
	);
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($estiloTituloReporte);
        
	//Aqui se crea el docuemnto completo con todas las filas insertadas
	$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
	$objPHPExcel->setActiveSheetIndex(0);	
	
	//Worksheet estilo predeterminado (de forma predeterminada diferentes necesidades y Preferencias Configurar individualmente)
	$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);

   // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="ReporteGeneral.xls"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
     }
     
     function cellColor($cells,$color){
            global $objPHPExcel;

            $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                     'rgb' => $color
                )
            ));
        }
    
     
     
   //para crear nuevas tarjetas definitivas
    public function generar_pdf($id) {
       $this->load->library('Pdf');
        $pdf = new Pdf('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('');
        $pdf->SetTitle('');
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $pdf->SetMargins(13, 0, 0);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
        $pdf->SetFont('Helvetica', '', 8);
 
        $pdf->AddPage('P','A4');
              
        $dfactura=$this->mydata->obtenerDatosFactura($id);
        $dcliente=$this->mydata->obtenerDatosClienteFactura($id);
        
        foreach($dcliente as $cliente):
                $nombre=$cliente->cprazonsocial_cliente;
                $cedula=$cliente->cpcedula_cliente;
                $direccion=$cliente->cpdireccion_cliente;
                $telefono=$cliente->cptelefono_cliente;
                $celular=$cliente->cpcelular_cliente;

            endforeach;
        
       foreach($dfactura as $datos)
            {

              $fechapago=$datos->cpfechapag_venta;
              $fechaemis=$datos->cpfecha_venta;
              $subtotal=$datos->cpsubtotal_ventas;
              $iva=$datos->cpiva_ventas;
              $total=$datos->cptotal_ventas;
              $comentario=$datos->comentario;
            }
         $pdf->Ln(38.5);
         
         //$pdf->SetXY(16,240);
         $html='<table border="0">
                <tr>
                  <td width="43" style="height: 18px"></td>
                  <td width="425" style="height: 18px"></td>
                  <td width="90" style="height: 18px"></td>
                  <td width="105" style="height: 18px">'.$fechaemis.'</td>
                </tr>
                <tr>
                  <td style="height:16px"></td>
                  <td style="height: 16px">'.$nombre .'</td>
                  <td style="height: 16px"></td>
                  <td style="height: 16px">'.$fechapago.'</td>
                </tr>
                <tr>
                  <td style="height: 16px"></td>
                  <td style="height: 16px">'.$direccion.'</td>
                  <td style="height: 16px"></td>
                  <td style="height: 16px"></td>
                </tr>
                <tr>
                  <td style="height: 16px"></td>
                  <td style="height: 17px">'.$cedula.'</td>
                  <td style="height: 16px" ></td>
                  <td style="height: 16px">BURTON TECH - 3050254329001</td>
                </tr>
                <tr>
                  <td style="height: 16px"></td>
                  <td colspan="3" style="height: 17px">'.$telefono.'</td>
                </tr>

              </table>';
            $pdf->writeHTML($html, true, false, true, false, '');   
            
            $pdf->Ln(6);
            $html='<table border="0">
                    <tr>
                      <td width="54"></td>
                      <td width="300"></td>
                      <td width="81"></td>
                      <td width="67"></td>
                      <td width="87"></td>
                      <td width="70"></td>
                    </tr>';
                   

                    foreach ($dfactura as $datos)
                    {

                        $html.= " <tr><td></td>";
                        $html.= "<td>$datos->cpdetalle</td>";
                        $html.= "<td></td>";
                        $html.= "<td>$datos->cpcantidad</td>";
                        $html.= "<td>$datos->cpprecio_u</td>";
                        $html.= "<td>$datos->cppreciototal</td></tr>";
                        

                    }
 
                  $html.='</table>';
              $pdf->writeHTML($html, true, false, true, false, '');        
              
              $pdf->SetXY(16,246);
              $pdf->writeHTMLCell(100, 15, $pdf->getX(), $pdf->getY(), $comentario, 0, 0,0, false, 'L', false);
                 
                $pdf->SetXY(180,239);      
                $html='<table border="0">
                    <tr>
                       <td height="22">'.$subtotal.'</td>
                    </tr>
                    <tr>
                       <td height="23"></td>
                    </tr>
                    <tr>
                      <td height="24">'.$iva.'</td>
                    </tr>
                    <tr>
                      <td height="22">'.$total.'</td>
                    </tr>
                  </table>';
            $pdf->writeHTML($html, true, false, true, false, '');      
          // $pdf->writeHTMLCell(10, 15,$pdf->getX(), $pdf->getY(), $html, 0, 0,0, false, 'L', false);
//        
   
// Cerrar el documento PDF y preparamos la salida
// Este método tiene varias opciones, consulte la documentación para más información.
        $nombre_archivo = utf8_decode("Listado de Solicitudes del dia.pdf");
        //$pdf->Output($nombre_archivo, 'FD');
        
        //$pdf->Output(base_url()."public/pdf", 'F');  //save pdf
        $pdf->Output($nombre_archivo, 'I');
       
    }

    
    public function retenciones()
    {
      $this->data["active_sub_tab"]="retenciones";
      $this->data["title"] = "Retenciones";
      $this->data["retenciones"]=$this->mydata->retenciones();
      $this->show_me();
    }
    
    public function buscarRetencion()
    {
        $resp=$this->mydata->buscarRetencion(); 
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
    
    public function hacerRetencion()
    {
        $resp=$this->mydata->hacerRetencion(); 
        $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
}