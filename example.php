<?php

require __DIR__ . '/vendor/autoload.php';


$cavaConverter = new \App\CavaConverter();

$jsonContent = '{"x":1,"c":"Hello","y":3,"z":3}';
$cavaConverter->loadJson($jsonContent);

$csv = $cavaConverter->convertJsonToCsv(true);

echo $csv;


///
$htmlContent = '
<p>
Hello,
</p>
';
$cavaConverter->loadHtml($htmlContent);

$cavaConverter->convertHtmlToPdf();