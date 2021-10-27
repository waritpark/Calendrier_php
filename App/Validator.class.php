<?php

namespace App;

class Validator {

    private $data;
    protected $errors= [];


    /**
     * @param array $data
     * @return array!bool
     */
    public function validates(array $data) {
        $this->data=$data;
        $this->errors = [];
    }

    public function validate(string $field, string $method, ...$parameters) {
        if(!isset($this->data[$field])) {
            $this->errors[$field]="Le champ $field n'est pas rempli.";
        } else {
            call_user_func([$this, $method], $field, ...$parameters);
        }
    }

    public function minLength(string $field, int $length) {
        if(strlen($field) < $length) {
            $this->errors[$field] = "Le champ doit avoir plus de $length caractères.";
        }
    }

    public function date(string $field) {
        if(\DateTime ::createFromFormat('Y-m-d', $this->data[$field]) === false) {
            $this->errors[$field]= "La date n'est pas valide.";
        }
    }

    public function time(string $field) {
        if(\DateTime ::createFromFormat('H:j', $this->data[$field]) === false) {
            $this->errors[$field]= "Le temps n'est pas valide.";
        }
    }

    public function beforeTime(string $startField, string $endField) {
        if ($this->time($startField) && $this->time($endField)) {
            $start = \DateTime ::createFromFormat('Y-m-d', $this->data[$startField]);
            $end = \DateTime ::createFromFormat('Y-m-d', $this->data[$endField]);
            if ($start->getTimestamp() > $end->getTimestamp()) {
                $this->error[$startField]= "Le début de l'événement doit être avant la fin de cet événement.";
                return false;
            }
            return true;
        }
        return false;
    }

}