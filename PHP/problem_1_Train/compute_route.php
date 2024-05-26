<?php
require_once 'City.php';
require_once 'TrainRoutes.php';

class ComputeRoute
{
    private $DBUtils;
    private $type;
    private $visited = array();
    private $found = false;
    private $route = '';

    public function __construct($DBUtils, $type)
    {
        $this->DBUtils = $DBUtils;
        $this->type = $type;
    }

    public function computeRoute($orasPlecare, $orasSosire)
    {
        $trainRoutes = $this->DBUtils->select('trainroutes', '*', '1');
        $this->visited = [];  // Ensure visited array is reset

        if ($this->type === 'directOnly') {
            $this->findDirectRoutes($orasPlecare, $orasSosire, $trainRoutes);
        } elseif ($this->type === 'indirect') {
            $this->findIndirectRoutes($orasPlecare, $orasSosire, $trainRoutes);
        } elseif ($this->type === 'all') {
            $this->findDirectRoutes($orasPlecare, $orasSosire, $trainRoutes);
            $this->findIndirectRoutes($orasPlecare, $orasSosire, $trainRoutes);
        }

        return $this->route;
    }

    private function findDirectRoutes($orasPlecare, $orasSosire, $trainRoutes)
    {
        $this->route .= '<h2>Direct Routes</h2>';
        $this->found = false;
        foreach ($trainRoutes as $trainRoute) {
            if ($trainRoute['departure_location'] == $orasPlecare && $trainRoute['arrival_location'] == $orasSosire) {
                $this->route .= $this->routeToString($trainRoute);
                $this->found = true;
            }
        }

        if (!$this->found) {
            $this->route .= 'No direct route found.<br>';
        }
    }

    private function findIndirectRoutes($orasPlecare, $orasSosire, $trainRoutes)
    {
        $this->route .= '<h2>Indirect Routes</h2>';
        $this->found = false;
        $this->dfs($orasPlecare, $orasSosire, $trainRoutes);

        if (!$this->found) {
            $this->route .= 'No indirect route found.<br>';
        }
    }

    private function dfs($current, $destination, $trainRoutes, $currentPath = [], $currentTime = null)
    {
        $this->visited[$current] = true;
        $currentPath[] = $current;

        if ($current == $destination) {
            $this->found = true;
            $this->route .= implode(' -> ', $currentPath) . '<br>';
            return;
        }

        foreach ($trainRoutes as $trainRoute) {
            if (isset($trainRoute['departure_location'], $trainRoute['arrival_location'], $trainRoute['departure_time']) &&
                $trainRoute['departure_location'] == $current &&
                empty($this->visited[$trainRoute['arrival_location']]) &&
                ($currentTime === null || $trainRoute['departure_time'] >= $currentTime)) {
                $this->dfs($trainRoute['arrival_location'], $destination, $trainRoutes, $currentPath, $trainRoute['arrival_time']);
            }
        }

        $this->visited[$current] = false;
    }

    private function routeToString($route)
    {
        return 'Train number: ' . htmlspecialchars($route['train_number']) .
            ' Type of train: ' . htmlspecialchars($route['type_of_train']) .
            ' Departure city: ' . htmlspecialchars($route['departure_location']) .
            ' Arrival city: ' . htmlspecialchars($route['arrival_location']) .
            ' Departure time: ' . htmlspecialchars($route['departure_time']) .
            ' Arrival time: ' . htmlspecialchars($route['arrival_time']) . '<br>';
    }
}
?>
