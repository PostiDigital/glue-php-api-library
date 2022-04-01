<?php

namespace Posti\Glue;

use PostiWarehouse\Classes\Dataset;

class Attachment
{
    /*
     * @var array
     */
    
    protected $optional = [
        
    ];
    
    /*
     * @var string
     */

    private $name;
    
    /*
     * @var string
     */

    private $type;

    /*
     * @var string
     */
    private $content_type;

    /*
     * @var string
     */
    private $uri;

    /*
     * @param string $name
     * @return Attachment
     */

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    /*
     * @return string
     */

    public function getName() {
        return $this->name;
    }

    /*
     * @param string $type
     * @return Attachment
     */

    public function setType($type) {
        $this->type = $type;
        return $this;
    }
    
    /*
     * @return string
     */

    public function getType() {
        return $this->type;
    }

    /*
     * @param string $content_type
     * @return Attachment
     */

    public function setContentType($content_type) {
        $this->content_type = $content_type;
        return $this;
    }
    
    /*
     * @return string
     */

    public function getContentType() {
        return $this->content_type;
    }

    /*
     * @param string $uri
     * @return Attachment
     */

    public function setUri($uri) {
        $this->uri = $uri;
        return $this;
    }
    
    /*
     * @return string
     */

    public function getUri() {
        return $this->uri;
    }
    
    /*
     * @return mixed
     */

    public function getData() {
        $this->validate();

        return [
            "name" => $this->name,
            "type" => $this->name,
            "contentType" => $this->content_type,
            "uri" => $this->uri
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
