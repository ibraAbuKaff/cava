<?php

namespace App;

class CavaConverter
{
    public $htmlContent;
    public $jsonContentAsArr;

    public function __construct()
    {
    }

    /**
     * Load Json and prepare it
     *
     * @param $jsonContent
     *
     * @throws \Exception
     *
     * @author Ibraheem Abu Kaff <ibra.abukaff@tajawal.com>
     */
    public function loadJson($jsonContent)
    {
        //check if it's valid json
        Common::validateJSON($jsonContent);
        $jsonContentArr     = json_decode($jsonContent, true);
        $isMultiDimensional = Common::isMultiDimensionalArray($jsonContentArr);
        //check if the array is multi-dimensional or not
        if ($isMultiDimensional) {
            throw  new \Exception('JSON to CSV can not be processed, JSON must be one dimensional structure- one level');
        }
        //get the keys from the array
        $keys = array_keys($jsonContentArr);
        //get the cognitive values
        $values = array_values($jsonContentArr);

        $jsonContentArr   = [];
        $jsonContentArr[] = $keys;
        $jsonContentArr[] = $values;

        $this->jsonContentAsArr = $jsonContentArr;
    }

    /**
     * Convert json to array
     *
     * @param bool $downloadable
     *
     * @return string
     * @throws \Exception
     *
     * @author Ibraheem Abu Kaff <ibra.abukaff@tajawal.com>
     */
    public function convertJsonToCsv($downloadable = false)
    {
        if (!count($this->jsonContentAsArr) || empty($this->jsonContentAsArr)) {
            throw new \Exception('You can not convert to `CSV` as `JSON` content is empty');
        }

        $csv = Common::generateCsv($this->jsonContentAsArr);

        if ($downloadable) {
            $fileName = uniqid();
            header('Content-type: text/csv;charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
        }

        return $csv;
    }


    /**
     * DESC
     *
     * @param $htmlContent
     *
     * @author Ibraheem Abu Kaff <ibra.abukaff@tajawal.com>
     */
    public function loadHtml($htmlContent)
    {
        $this->htmlContent = $htmlContent;
    }

    /**
     * DESC
     *
     * @throws \Exception
     *
     * @author Ibraheem Abu Kaff <ibra.abukaff@tajawal.com>
     */
    public function convertHtmlToPdf()
    {
        if (empty($this->htmlContent)) {
            throw new \Exception('You can not convert to `PDF` as `HTML` content is empty');
        }

        $url  = 'http://freehtmltopdf.com';
        $data = ['convert'  => '',
                 'html'     => $this->htmlContent,
                 'baseurl'  => '',
                 'enablejs' => 1,
        ];

        // use key 'http' even if you send the request to https://...
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $result  = file_get_contents($url, false, $context);

        // set the pdf data as download content:
        header('Content-type: application/pdf');
        $fileName = uniqid();
        header('Content-Disposition: attachment; filename="' . $fileName . '.pdf"');

        echo $result;

    }

}