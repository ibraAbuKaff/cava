# cava
Light package to convert any (HTML to PDF) format, OR  (JSON to CSV), regardless what is the language you are using (English, Spanish, French, Japanese,.....). By using this package, you will not face any encoding issues which is the most popular issues in any converter

Example: 
```
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

```
