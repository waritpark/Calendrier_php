<?php

namespace App;

class Validator {

    private $data;
    protected $errors= [];

    public function __construct(array $data) {
        $this->data=$data;
    }

    /**
     * @param array $data
     * @return array!bool
     */
    public function validates(array $data) {
        $this->errors = [];
        $this->data=$data;
        return $this->errors;
    }

    public function validate(string $field, string $method, ...$parameters): bool {
        if(!isset($this->data[$field])) {
            $this->errors[$field]="Le champ $field n'est pas rempli.";
            return false;
        } else {
            return call_user_func([$this, $method], $field, ...$parameters);
        }
    }

    public function minLength(string $field, int $length) {
        if(strlen($this->data[$field]) < $length) {
            $this->errors[$field] = "Le champ doit avoir plus de $length caractères.";
            return false;
        }
        return true;
    }

    public function date(string $field) {
        if(\DateTime::createFromFormat('Y-m-d', $this->data[$field]) === false) {
            $this->errors[$field]= "La date n'est pas valide.";
            return false;
        }
        return true;
    }

    public function time(string $field) {
        if(\DateTime::createFromFormat('H:i', $this->data[$field]) === false) {
            $this->errors[$field]= "Le temps n'est pas valide.";
            return false;
        }
        return true;
    }

    public function beforeTime(string $startField, string $endField) {
        if ($this->time($startField) && $this->time($endField)) {
            $start = \DateTime::createFromFormat('H:i', $this->data[$startField]);
            $end = \DateTime::createFromFormat('H:i', $this->data[$endField]);
            if ($start->getTimestamp() > $end->getTimestamp()) {
                $this->errors[$startField]= "Le début d'un événement doit être avant la fin de ce même événement.";
                return false;
            }
            else {
                return true;
            }
        }
        return false;
    }

}