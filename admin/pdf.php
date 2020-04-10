<?php

//pdf.php
//file ini digunakan untuk operasi pencetakan file laporan
//file ini memanggil dan menggunakan kelas dari dompdf

require_once '../assets/plugins/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
	public function __construct()
	{
		parent::__construct();
	}
}


?>