 <?php


// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
// require_once '../../../../modelos/conexion.php';


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
  		// Logo
  // 		$image_file = $logo["imagen"].".jpg";
		// $this->Image($image_file, 15, 15, 20, '', 'JPG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 18);
        // Title
        $this->Cell(0, 10, "Deposito bancario Pedido ".$_GET["f01i0"], 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

}

$width = 150;  
$height = 150; 

$pageLayout = array($width, $height); //  or array($height, $width) 

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Deposito Bancario');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(10);
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
$pdf->SetFont('times', 'B', 12);

// add a page
$pdf->AddPage();



$pdf->Ln(10);

$html = '<table style="width:100%">
	<tr>

		<td colspan="5" style="text-align:center; font-size:0.9em;">
			Compañias donde puedes hacer tu deposito
		</td>

	</tr>
	<tr style="text-align:left;">

		<td style="text-align:center; width:20%; padding:5;">
		</td>

		<td style="text-align:center; width:20%; padding:5;">
			<img src="images/oxxo.png" border="0" height="40" width="55" align="top" />
		</td>

		<td style="text-align:center; width:20%; padding:5;">
			<img src="images/seven.png" border="0" height="40" width="45" align="middle" />
		</td>

		<td style="text-align:center; width:20%; padding:5;">
			<img src="images/ahorro.png" border="0" height="40" width="45" align="middle" />
		</td>

		<td style="text-align:center; width:20%; padding:5;">
		</td>

	</tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

 ?>