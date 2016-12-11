<?php

namespace App;
/**
 * Class Common
 *
 * @package App
 */
class Common
{

    /**
     * DESC
     *
     * @param $string
     *
     * @throws \Exception
     *
     * @author Ibraheem Abu Kaff <ibra.abukaff@tajawal.com>
     */
    public static function validateJSON($string)
    {
        // decode the JSON data
        json_decode($string);
        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }

        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            throw new \Exception($error);

        }

    }


    public static function isMultiDimensionalArray($array)
    {
        if (count($array) == count($array, COUNT_RECURSIVE)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * chr(0xEF) . chr(0xBB) . chr(0xBF) has been concatenated to make it work with all encoding types
     *
     * @see    : http://blog.programovani.net/en/php/special-characters-export-to-csv/
     *
     * @param        $data
     * @param string $delimiter
     * @param string $enclosure
     *
     * @return string
     *
     * @author Ibraheem Abu Kaff <ibra.abukaff@tajawal.com>
     */
    public static function generateCsv($data, $delimiter = ',', $enclosure = '"')
    {
        $handle = fopen('php://temp', 'r+');
        foreach ($data as $line) {
            fputcsv($handle, $line, $delimiter, $enclosure);
        }
        rewind($handle);
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);

        return chr(0xEF) . chr(0xBB) . chr(0xBF) . $contents;
    }

}