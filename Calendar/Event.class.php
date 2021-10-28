<?php

namespace Calendrier;

use DateTime;

class Event {
    private $id_event;
    private $nom_event;
    private $desc_event;
    private $start_event;
    private $end_event;

    public function getId(): int {
        return $this->id_event;
    }
    public function getName() {
        return $this->nom_event;
    }
    public function getDesc(): string {
        return $this->desc_event ?? '';
    }
    public function getStart(): DateTime {
        return new DateTime($this->start_event);
    }
    public function getEnd(): DateTime {
        return new DateTime($this->end_event);
    }

    public function setName(string $nom_event) {
        $this->nom_event=$nom_event;
    }
    public function setDesc(string $desc_event) {
        $this->desc_event=$desc_event;
    }
    public function setStart(string $start_event) {
        $this->start_event=$start_event;
    }
    public function setEnd(string $end_event) {
        $this->end_event=$end_event;
    }

}