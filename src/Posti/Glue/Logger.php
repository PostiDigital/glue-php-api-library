<?php

namespace Posti\Glue;

class Logger
{
    /*
     * @var bool
     */

    private $debug = false;
    
    /*
     * @var string
     */

    private $file = "../debug.log";

    /*
     * @param bool $value
     * @return Logger
     */

    public function setDebug($value, $file = false) {
        $this->debug = $value;
        if ($file) {
            $this->file = $file;
        }
        return $this;
    }

    /*
     * @param string $type
     * @param string $message
     */

    public function log($type, $message) {
        if ($this->debug) {
            error_log(date('Y-m-d H:i:s') . ' ' . $type . ' - ' . print_r($message, true), 3, $this->file);
        }
    }

}
