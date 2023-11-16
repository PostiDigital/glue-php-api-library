<?php

namespace Posti\Glue\Order;

class Reference
{
    /*
     * @var string
     */

    private $name;

    /*
     * @var string
     */
    private $value;

    /*
     * @param string $name
     * @return Reference
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
     * @param string $value
     * @return Reference
     */

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    /*
     * @return string
     */

    public function getValue() {
        return $this->value;
    }
    
    public function toArray() {
        return [
            'name' => $this->getName(),
            'value' => $this->getValue()
        ];
    }

}
