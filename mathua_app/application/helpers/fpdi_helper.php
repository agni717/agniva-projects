<?php

function fpdi()
{
    //require_once('tcpdf/config/lang/eng.php');
    require_once('tcpdf/tcpdf.php');
	require_once('fpdi/src/autoload.php');
	
	/*class Pdf extends Fpdi\Tcpdf\Fpdi
	{
		protected $tplId;
		function Header()
		{
			if ($this->tplId === null) {
				$this->setSourceFile(base_url().'logo.pdf');
				$this->tplId = $this->importPage(1);
			}
			$size = $this->useImportedPage($this->tplId, 130, 5, 60);

			$this->SetFont('freesans', 'B', 20);
			$this->SetTextColor(0);
			$this->SetXY(PDF_MARGIN_LEFT, 5);
			$this->Cell(0, $size['height'], 'TCPDF and FPDI');
		}

		function Footer()
		{
			// emtpy method body
		}
	}*/
    
}

?>