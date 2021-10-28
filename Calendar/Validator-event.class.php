<?php

namespace Calendrier;

include '../App/Validator.class.php';

use App\Validator;

class ValidatorEvent extends Validator {


    /**
     * @param array $data
     * @return array!bool
     */
    public function validates(array $data) {
        parent::validates($data);
        $this->validate('nom', 'minLength', 5);
        $this->validate('date', 'date');
        $this->validate('start', 'beforeTime', 'end');
        return $this->errors;
    }




}