<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha = strftime("%d de ". $meses[date('n')-1]." del %Y"); 
$cliente = $_GET["client"];
$folio = $_GET["fol"];
$empresa = $_GET["empress"];
$tocomp = $_GET["tcomp"];
$link= new PDO("mysql:host=162.241.62.82;dbname=twyncost_yira",
   					   "twyncost_yiraUser",
   					   "Yira2021*");
//$link= new PDO("mysql:host=localhost:3306;dbname=yira2fact",
//"root",
//"");
 					   
$link->exec("set names utf8");


$stmt = $link->prepare("SELECT v.*, p.codigo, p.nombre,  p.descripcion, p.sku, (SELECT SUM(cantidad) FROM devoluciones WHERE id_empresa = :id_empresa AND folio = :folio AND id_producto = v.id_producto) AS cantdev 
												FROM cedis_venta_detalles as v, productos as p 
												WHERE p.id_producto = v.id_producto 
												AND v.folio = :folio 
												AND v.id_empresa = :id_empresa");

		$stmt -> bindParam(":folio", $folio, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		$compra = $stmt -> fetchAll();




$stmt = $link->prepare("SELECT nombre FROM empresas WHERE id_empresa = :id_empresa");
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
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
// Set some content to print
$empresaHtml = '
<h3>Resumen de Compra:</h3>
<p>Fecha: '.$fecha .'</p>
<p>Cliente: <span style="font-weight: bold">'.$cliente.'</span></p>
<p>Folio: <span style="font-weight: bold">'.$folio.'</span></p>
<p>Tabla de compra:</p>';

$pdf->writeHTML($empresaHtml, true, false, true, false, '');


$pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// NON-BREAKING ROWS (nobr="true")

$tbl = '
<table border=".2" cellpadding="2" cellspacing="0" align="center">
 <thead>
 <tr style=" background-color:#4876FF;color:#EDEDED; font-size: 8rem">
  <td  align="center" ><b>Producto</b></td>
  <td  width="270" align="center" ><b>Descripcion</b></td>
  <td  width="50" align="center" ><b>Cant</b></td>
  <td  width="80" align="center" ><b>Precio</b></td>
  <td  width="80" align="center" ><b>Total</b></td>
 </tr>
</thead>
';
$infill=0;
foreach($compra as $value) {
    $cantfinal = $value['cantidad']-$value['cantdev'];
    if($infill==0){
        $color = "#FFFFFF";
    }else{
        $color = "#E5E5E5";
    }    
    $infill=!$infill;
$tbl .= '
 <tr nobr="true">
  <td  style="background-color:'.$color.'; font-size: 7rem">'.$value['codigo'].' / '.$value['nombre'].'</td>
  <td  width="270" style="background-color:'.$color.'; font-size: 7rem">'.$value['descripcion'].'</td>
  <td  width="50" style="background-color:'.$color.'; font-size: 7rem">'.$cantfinal.'</td>
  <td  width="80" style="background-color:'.$color.'; font-size: 7rem"> $'.$value['precio'].'</td>
  <td  width="80" style="background-color:'.$color.'; font-size: 7rem"> $'.$cantfinal*$value['precio'].'</td>
 </tr>';
}
$tbl .= '
 </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
$empresaHtml2 = '
<p ><span style="font-weight: bold">Total compra:</span> $'.number_format($tocomp, 2, '.', '').'</p>';
$pdf->writeHTML($empresaHtml2, true, false, true, false, '');


// -----------------------------------------------------------------------------


// close and output PDF document
$pdf->Output('estado de cuenta.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
