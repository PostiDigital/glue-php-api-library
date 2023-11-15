<?php

namespace Posti\Glue;

class Fields
{
    public static function addOptField($obj, $field, $value) {
        if (isset($value)) {
            $obj[$field] = $value;
        }
    }
}
