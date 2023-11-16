<?php

namespace Posti\Glue;

class Image
{
    /*
     * @var array
     */
    
    protected $optional = [
        
    ];
    

    /*
     * @var string
     */
    private $url;

    /*
     * @param string $uri
     * @return Attachment
     */

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    
    /*
     * @return string
     */

    public function getUrl() {
        return $this->url;
    }
    
    /*
     * @return mixed
     */

    public function getData() {
        $this->validate();

        return [
            "url" => $this->url
        ];

    }

    /*
     * @return mixed
     */

    private function validate() {
        $errors = [];
        $vars = get_object_vars($this);
        foreach ($vars as $var => $value) {
            if (in_array(trim($var, '$'), $this->optional)) {
                continue;
            }
            if ($value === null) {
                $errors[] = 'Variable ' . $var . ' is missing. Set it with set' . $this->getMethodName($var) . '($val).';
            }
        }
        if (!empty($errors)) {
            throw new \Exception(implode("<br/>", $errors));
        }
        return true;
    }

    /*
     * @param string $var
     * @return string
     */

    private function getMethodName($var) {
        $name = '';
        $parts = explode('_', trim($var, '$'));
        foreach ($parts as $part) {
            $name .= ucfirst($part);
        }
        return $name;
    }

}
