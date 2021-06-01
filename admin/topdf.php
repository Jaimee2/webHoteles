<?php
	/* 
		Clase encargada únicamente de convertir una tabla en PDF
	*/
	require_once 'dompdf/autoload.inc.php';
	use Dompdf\Dompdf;

	function convertirAPDF($contenido, $nombrePDF) {

		$dompdf = new Dompdf();
		$dompdf->loadHtml($contenido);
		$dompdf->setPaper('A4', 'landscape');
		
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render(); // Generar el PDF desde contenido HTML
		$pdf = $dompdf->output(); // Obtener el PDF generado
		//$dompdf->stream(); // Enviar el PDF generado al navegador*/
		$dompdf->stream($nombrePDF,array('Attachment'=>0));
	}

?>