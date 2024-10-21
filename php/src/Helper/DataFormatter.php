<?php

namespace Helper;

class DataFormatter
{
    public static function formatXML($attributes)
    {
        $xmlString = file_get_contents('php://input');

        error_log($xmlString);

        $xml = simplexml_load_string($xmlString);

        if ($xml === false) {
            echo "Failed to parse XML";
            exit;
        }

        $result = [];

        foreach ($attributes as $attribute) {
            if (isset($xml->$attribute)) {
                $result[$attribute] = (string)$xml->$attribute;
            } else {
                $result[$attribute] = null;
            }
        }

        return $result;
    }
}
