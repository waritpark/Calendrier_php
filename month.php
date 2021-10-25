<?php

namespace Calendrier;

class Month {

    public $days = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    private $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'];
    public $month;
    public $year;


    /** Mon constructeur
     * @param int $month : Le mois compris entre 1 et 12
     * @param int $year : L'année
     * @throws \Exception
     */
    function __construct(?int $month = null, ?int $year = null) {
        if($month == null || $month < 1 || $month > 12) {
            $month = intval(date('m'));
        }
        if($year == null) {
            $year = intval(date('Y'));
        }
        if($month<1 || $month > 12) {
            throw new \Exception("le mois $month n'est pas valide");
        }
        if ($year < 2010) {
            throw new \Exception("l'année' est inférieur à 2010");
        }
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Renvoie le premier jour du mois
     * @return \DateTimeImmutable
     */
    public function getStartingDay(): \DateTimeInterface {
        return new \DateTimeImmutable("{$this->year}-{$this->month}-01");
    }

    /**
     * Retourne le mois en toute lettre et l'année en chiffre
     * @return string
     */
    public function toString (): string {
       return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    /**
     * Retourne seulement le mois en toute lettre
     * @return string
     */
    public function toStringMonth (): string {
        return $this->months[$this->month - 1];
     }

    /**
     * Retourne le nombre de semaine dans le mois
     * @return int
     */
    public function getWeeks(): int {
        $start = $this->getStartingDay();
        $end = $start->modify('+1 month -1 day');
        $startWeek = intval($start->format('W'));
        $endWeek = intval($end->format('W'));
        if ($endWeek === 1) {
            $endWeek = intval($end->modify('- 7 days')->format('W'))+1;
        }
        $weeks = $endWeek - $startWeek +1;
        if ($weeks < 0) {
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }

    /**
     * Est-ce que le jour est dans le mois en cours ?
     * @param \DateTimeInterface $date
     * @return bool
     */
    public function withinMonth (\DateTimeInterface $date): bool {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoie le mois suivant
     * @return Month
     */
    public function nextMonth(): Month {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * Renvoie le mois précédent
     * @return Month;
     */
    public function previousMonth(): Month {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }




}