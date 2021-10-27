<?php

namespace Calendrier;

use Validator;

class ValidatorEvent extends Validator {

    private $data;
    private $errors;


    /**
     * @param array $data
     * @return array!bool
     */
    public function validates(array $data) {
        parent::validates($data);
        $this->validate('name', 'minLenght', 30);
        return $this->errors;
    }




}