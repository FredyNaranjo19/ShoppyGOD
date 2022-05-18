<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha = strftime("%d de ". $meses[date('n')-1]." del %Y"); 
$cliente = $_GET["cliente"];
$idcliente = $_GET["idcliente"];
$empresa = $_GET["emp"];
  $link2= new PDO("mysql:host=162.241.62.82;dbname=twyncost_yira",
   					   "twyncost_yiraUser",
   					   "Yira2021*");
 //$link2= new PDO("mysql:host=localhost:3306;dbname=twyncost_diesel_motors",
 //"root",
 //"");
 					   
$link2->exec("set names utf8");


$stmt = $link2->prepare("SELECT p.codigo, p.nombre,cv.id_empresa, cv.id_usuario_plataforma, cv.estado, cv.id_cliente, 
cv.metodo, cv.folio, cvd.id_producto, cvd.precio, cvd.monto, cvd.cantidad,
(SELECT SUM(cantidad) FROM devoluciones 
 WHERE id_empresa = :id_empresa AND folio = cv.folio 
 AND id_producto = cvd.id_producto) AS cantdev
FROM cedis_ventas as cv, cedis_venta_detalles as cvd, productos as p
WHERE cv.id_empresa=:id_empresa AND cv.metodo='pagos' AND cv.estado='Pendiente' 
AND cv.id_cliente=:cliente AND p.id_producto=cvd.id_producto AND cvd.folio=cv.folio");
$stmt -> bindParam(":id_empresa", $_GET["emp"], PDO::PARAM_STR);
$stmt -> bindParam(":cliente", $_GET["idcliente"], PDO::PARAM_STR);
$stmt -> execute();
$compras = $stmt -> fetchAll();
$datacompras = array();


$stmt = $link2->prepare("SELECT cvp.fecha_pago, cvp.folio,cvp.monto
FROM cedis_ventas_pagos as cvp, cedis_ventas as cv 
WHERE cv.id_empresa=:id_empresa AND cv.estado='Pendiente' 
AND cv.metodo='Pagos' AND cv.id_cliente=:cliente 
AND cvp.folio=cv.folio AND cvp.estado != 'Cancelado'");
$stmt -> bindParam(":id_empresa", $_GET["emp"], PDO::PARAM_STR);
$stmt -> bindParam(":cliente", $_GET["idcliente"], PDO::PARAM_STR);
$stmt -> execute();
$pagos = $stmt -> fetchAll();
$datapagos = array();



$stmt = $link2->prepare("SELECT nombre FROM empresas WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		$nombEmpr = $stmt -> fetch();

class MYPDF extends TCPDF {

   
    }
    


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Yira');
$pdf->SetTitle('Estado de cuenta');
$pdf->SetSubject('');
$pdf->SetKeywords('Estado de cuenta, PDF');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.$nombEmpr[0], PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
// Set some content to print
$empresaHtml = '
<h1>Resumen de general de compras:</h1>
<p>Fecha: '.$fecha .'</p>
<p>Cliente: <span style="font-weight: bold">'.$cliente.'</span></p>
<p>Tabla de compras:</p>';

$pdf->writeHTML($empresaHtml, true, false, true, false, '');
$pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));


// NON-BREAKING ROWS (nobr="true")

$tbl = '
<table border=".2" cellpadding="2" cellspacing="0" align="center">
 <thead>
 <tr style=" background-color:#4876FF;color:#EDEDED; font-size: 10rem">
  <td  width="100" align="center" ><b>Folio</b></td>
  <td  align="center" ><b>Producto</b></td>
  <td  width="50" align="center" ><b>Cant</b></td>
  <td  align="center" ><b>Precio</b></td>
  <td  align="center" ><b>Total</b></td>
 </tr>
</thead>
';
$infill=0;
foreach($compras as $value) {
    $cantfinal = $value['cantidad']-$value['cantdev'];
    if($infill==0){
        $color = "#FFFFFF";
    }else{
        $color = "#E5E5E5";
    }    
    $infill=!$infill;
$tbl .= '
 <tr nobr="true">
  <td  width="100" style="background-color:'.$color.'; font-size: 8rem">'.$value['folio'].'</td>
  <td  style="background-color:'.$color.'; font-size: 8rem">'.$value['codigo'].' / '.$value['nombre'].'</td>
  <td  width="50" style="background-color:'.$color.'; font-size: 8rem">'.$cantfinal.'</td>
  <td  style="background-color:'.$color.'; font-size: 8rem"> $'.$value['precio'].'</td>
  <td  style="background-color:'.$color.'; font-size: 8rem"> $'.$cantfinal*$value['precio'].'</td>
 </tr>';
}
$tbl .= '
 </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');



// -----------------------------------------------------------------------------
$empresaHtml2 = '
<p>Tabla de pagos:</p>';

$pdf->writeHTML($empresaHtml2, true, false, true, false, '');

// NON-BREAKING ROWS (nobr="true")

$tbl2 = '
<table border=".2" cellpadding="2" cellspacing="0" align="center">
 <thead>
 <tr style=" background-color:#4876FF;color:#EDEDED; font-size: 10rem">
  <td  width="110" align="center" ><b>Fecha</b></td>
  <td  width="100" align="center" ><b>Folio</b></td>
  <td  width="100" align="center" ><b>Monto</b></td>
 </tr>
</thead>
';
$infill=0;
foreach($pagos as $value) {
    $datapagos[] = array($value['fecha_pago'],$value['folio'],$value['monto']);
    if($infill==0){
        $color = "#FFFFFF";
    }else{
        $color = "#E5E5E5";
    }    
    $infill=!$infill;
$tbl2 .= '
 <tr nobr="true">
  <td  width="110" style="background-color:'.$color.'; font-size: 8rem">'.$value['fecha_pago'].'</td>
  <td  width="100" style="background-color:'.$color.'; font-size: 8rem">'.$value['folio'].'</td>
  <td  width="100" style="background-color:'.$color.'; font-size: 8rem"> $'.$value['monto'].'</td>
 </tr>';
}
$tbl2 .= '
 </table>';

$pdf->writeHTML($tbl2, true, false, false, false, '');

// -----------------------------------------------------------------------------
// ---------------------------------------------------------
$empresaHtml2 = '
<p></p>
<p ><span style="font-weight: bold">Total compra:</span> $'.number_format($_GET["tcom"], 2, '.', '').'  -->  <span style="font-weight: bold">Total pagos:</span>$'.number_format($_GET["tvp"], 2, '.', '').' --> <span style="font-weight: bold">Adeudo:</span>$'.number_format($_GET["tcom"]-$_GET["tvp"], 2, '.', '').'</p>';

$pdf->writeHTML($empresaHtml2, true, false, true, false, '');


// close and output PDF document
$pdf->Output('estado de cuenta.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
<script>
    console.log($data);
</script>