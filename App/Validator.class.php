<?php


class Validator {

    private $data;
    protected $errors= [];


    /**
     * @param array $data
     * @return array!bool
     */
    public function validates(array $data) {
        $this->errors = [];
        $this->data=$data;

    }

    public function validate(string $field, string $method, ...$parameters) {
        if(!isset($this->data[$field])) {
            $this->errors[$field]="Le champ $field n'est pas rempli.";
        } else {
            call_user_func([$this, $method], $field, ...$parameters);
        }
    }

    public function minLength(string $field, int $length) {
        if(mb_strlen($field) < $length) {
            $this->errors[$field] = "Le champ doit avoir plus de $length caractères.";
        }
    }

}