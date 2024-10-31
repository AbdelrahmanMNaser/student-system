<?php
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $image_path = $_SERVER['DOCUMENT_ROOT'] . '/images/alex_university_logo.png';
  $type = pathinfo($image_path, PATHINFO_EXTENSION);
  $data = file_get_contents($image_path);
  $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

  $img_logo = "<img src='$base64' alt='alx_uni_logo' style='width:100px;height:100px;'>";

$header = "<header style='width:100%;height:auto;'>" . $img_logo . "</header>";

  $table_data = $_POST["html"];
  $title = $_POST["title"];
  $data = $_POST["data"];
  
  // Add title and data
  $title_html = "<h1 style='text-align: center;' >" . $title . "</h1>";
  $data_html = "<p>" . $data . "</p>";
  
  $html = $header . $title_html . $data_html . $table_data;

  $dompdf = new Dompdf();
  $dompdf->loadHtml($html);

  $dompdf->setPaper("A4", "landscape");

  $dompdf->render();

  $dompdf->stream();
}
