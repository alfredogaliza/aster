<?php

require_once "lib/mpdf/mpdf.php";

class PDF extends mPDF {
	
	public function __construct($mode = "A4"){
		parent::__construct('utf-8', $mode);
		$this->SetDisplayMode('fullpage');
		$this->showWatermarkImage = true;
		$this->showWatermarkText = true;	
	}

	public function start(){
		ob_start();
	}

	public function end(){
		$html = ob_get_clean();
		
		ob_start();
		$this->WriteHTML($html);
		ob_get_flush();

		
		if ($msg = ob_get_clean()) echo $msg;
		else $this->Output();
	}
}
