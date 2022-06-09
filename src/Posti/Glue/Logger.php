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
     * @var closure
     */
    private $closure = null;

    /*
     * @param bool $value
     * @param mixed $type
     * @return Logger
     */
    public function setDebug($value, $type = false) {
        $this->debug = $value;
        if (is_string($type)) {
            $this->file = $type;
        } elseif ($type instanceof \Closure) {
            $this->closure = $type;
        }
        return $this;
    }

    /*
     * @param string $type
     * @param string $message
     */
    public function log($type, $message) {
        if ($this->debug) {
            if ($this->closure !== null) {
                call_user_func($this->closure, $message, $type);
            } else {
                error_log(date('Y-m-d H:i:s') . ' ' . $type . ' - ' . print_r($message, true), 3, $this->file);
            }
        }
    }

}
