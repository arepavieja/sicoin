<?php 
require '../../../cfg/base.php';
require '../../../lib/dompdf/dompdf_config.inc.php';
$men_row = $mcorreo->selectMensajeIde($_GET['enide']);
$concopia = $mcorreo->conCopia($men_row[0]->meide);
$pie = '
<script type="text/php">
	$logo_inf = $pdf->open_object();
	$w = $pdf->get_width();
	$h = $pdf->get_height();
	$pdf->image("../../../img/logo_inferior.jpg","jpg",0,$h,$w);
	$pdf->close_object();
	$pdf->add_object($logo_inf,"all");
</script>';
$enc = '
<script type="text/php">
	$logo_sup = $pdf->open_object();
	$w = $pdf->get_width();
	$h = $pdf->get_height();
	$pdf->image("../../../img/logo_superior.jpg","jpg",0,0,610,80);
	$pdf->close_object();
	$pdf->add_object($logo_sup,"all");
</script>';
$html  = '<meta charset="utf-8">';
$html .= '<link href="../../../css/print.css" rel="stylesheet" type="text/css">';
$html .= '<p></p>';
$html .= $enc;
$html .= $pie;
$html .= '<table class="table">
	<tbody>
		<tr>
			<th>Número:</th>
			<td>'.$men_row[0]->deabrevi.'-'.sprintf("%05d",$men_row[0]->enide).'</td>
		</tr>
		<tr>
			<th>Fecha y Hora:</th>
			<td>'.$fun->fecha($men_row[0]->mefecha).' -- '.substr($men_row[0]->mehora, 0,5).'</td>
		</tr>
		<tr>
			<th>Para:</th>
			<td>
				'.$men_row[0]->dapellido.', '.$men_row[0]->dnombre.' / '.$men_row[0]->dcadescri.' '.$men_row[0]->ddedescri.'
			</td>
		</tr>
		<tr>
			<th>De:</th>
			<td>
				'.$men_row[0]->rapellido.', '.$men_row[0]->rnombre.' / '.$men_row[0]->rcadescri.' '.$men_row[0]->rdedescri.'
			</td>
		</tr>
		<tr>
			<th>Asunto:</th>
			<td>'.$men_row[0]->metitulo.'</td>
		</tr>
	</tbody>
</table>';

$totalCaracteresPágina = 1500;
//$totalCaracteres = strlen($men_row[0]->memensaj);
$mensaje = substr($men_row[0]->memensaj,0,strrpos(substr($men_row[0]->memensaj,0,$totalCaracteresPágina)," "));

$html .= '<div class="mensaje">'.$mensaje.'</div>

	<div class="firma">'.$men_row[0]->rapellido.', '.$men_row[0]->rnombre.' <br> '.$men_row[0]->rcadescri.' '.$men_row[0]->rdedescri.'</div>';
$html .= '<div class="cc">';
	if(count($concopia)>0) {
$html .= 'C.C: ';
		foreach($concopia as $c) {
$html .= $c->dedescri.', ';
	}
}
$html .= '</div>';
//echo $html;
$dompdf = new DOMPDF();
$dompdf->set_paper("letter","portrait"); 
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("memorandum_".$_GET['enide'].".pdf");
#$html .= $c->peapelli.', '.$c->penombre.' / '.$c->cadescri.' '.$c->dedescri;
?>
