<?php

namespace Calendrier;

class Events {
    
    private $pdo;


    /**
     * constructeur de la classe
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère les evenements commencant entre 2 dates
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     */
    public function getEventsBetween (\DateTimeInterface $start,\DateTimeInterface $end): array {
        $req = "SELECT * FROM t_calendrier_events WHERE start_event BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
        $result = $this->pdo->query($req);
        $resulthrow = $result->fetchAll();
        return $resulthrow;
    }


    /**
     * Récupère les evenements commencant entre 2 dates indexé par jour
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     */
    public function getEventsBetweenByDay (\DateTimeInterface $start,\DateTimeInterface $end): array {
        $events = $this->getEventsBetween($start, $end);
        $days = [];
        foreach ($events as $event){
            $date = explode(' ',$event['start_event'])[0];
            if (!isset($days[$date])) {
                $days[$date] = [$event];
            } else {
                $days[$date][] = $event;
            }
        }
        return $days;
    }

    /**
     * Récupère un événement
     * @return Event
     * @throws \Exception
     */
    public function findInUrlId(): Event {
        $statement = $this->pdo->query('SELECT * FROM t_calendrier_events WHERE id_event ='.$_GET['id_event'].' ');
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
        $result = $statement->fetch();
        if ($result === false) {
            throw new \Exception('Aucun résultat n\'a était trouvé.');
        }
        return $result;
    }

    /**
     * Créer un evement
     */
    public function create(Event $event) {
        $statement = $this->pdo->prepare('INSERT INTO t_calendrier_events (nom_event, desc_event, start_event, end_event) VALUES (?, ?, ?, ?) ');
        return $statement->execute([
            $event->getName(),
            $event->getDesc(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
        ]);
    }
}