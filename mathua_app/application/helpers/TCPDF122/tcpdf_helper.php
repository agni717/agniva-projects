<?php

function tcpdf()
{
    //require_once('tcpdf/config/lang/eng.php');
    require_once('tcpdf/tcpdf.php');

    class MYPDF extends TCPDF {

		//Page header
		public function Header() {
			// Logo
			$image_file = K_PATH_IMAGES.'logo_example.jpg';
			$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			$this->SetFont('helvetica', 'B', 20);
			// Title
			$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		}

		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-22);
			// Set font
			$this->SetFont('helvetica', '', 18);
			// Page number
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}

	class CANDPDF extends TCPDF {

		//Page header
		public function Header() {
			// Logo
			$image_file = K_PATH_IMAGES.'logo_example.jpg';
			$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			$this->SetFont('helvetica', 'B', 20);
			// Title
			$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		}

		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-22);
			// Set font
			$this->SetFont('helvetica', '', 18);
			// Page number
			$this->Cell(0, 10, 'https://www.wbhrb.in/', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}
	
	class MyCustomPDFWithWatermark extends TCPDF {
		public function Header() {
			// Get the current page break margin
			$bMargin = $this->getBreakMargin();
	
			// Get current auto-page-break mode
			$auto_page_break = $this->AutoPageBreak;
	
			// Disable auto-page-break
			$this->SetAutoPageBreak(false, 0);
	
			// Define the path to the image that you want to use as watermark.
			$img_file = base_url().'images/WBHRB_Logo_marker.png';
	
			// Render the image
			$this->Image($img_file, 60, 120, 300, 310, '', '', '', false, 300, '', false, false, 0);
	
			// Restore the auto-page-break status
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
	
			// Set the starting point for the page content
			$this->setPageMark();
		}
	}

	class MyCustomPDFWithWatermark_v2 extends TCPDF {
		public function Header() {
			// Get the current page break margin
			$bMargin = $this->getBreakMargin();
	
			// Get current auto-page-break mode
			$auto_page_break = $this->AutoPageBreak;
	
			// Disable auto-page-break
			$this->SetAutoPageBreak(false, 0);
	
			// Define the path to the image that you want to use as watermark.
			$img_file = base_url().'images/WBHRB_Logo_marker.png';
	
			// Render the image
			$this->Image($img_file, 150, 80, 300, 310, '', '', '', false, 300, '', false, false, 0);
	
			// Restore the auto-page-break status
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
	
			// Set the starting point for the page content
			$this->setPageMark();
		}
	}

}

?>