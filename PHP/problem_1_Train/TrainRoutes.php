<?php
require_once 'City.php';
class TrainRoutes
{
    private $trainNumber;
    private $typeOfTrain;
    private $departureCity;
    private $arrivalCity;
    private $departureTime;
    private $arrivalTime;

    public function __construct($trainNumber, $typeOfTrain, $departureCity, $arrivalCity, $departureTime, $arrivalTime)
    {
        $this->trainNumber = $trainNumber;
        $this->typeOfTrain = $typeOfTrain;
        $this->departureCity = $departureCity;
        $this->arrivalCity = $arrivalCity;
        $this->departureTime = $departureTime;
        $this->arrivalTime = $arrivalTime;
    }

    /**
     * @return mixed
     */
    public function getTrainNumber()
    {
        return $this->trainNumber;
    }

    /**
     * @param mixed $trainNumber
     */
    public function setTrainNumber($trainNumber)
    {
        $this->trainNumber = $trainNumber;
    }

    /**
     * @return mixed
     */
    public function getTypeOfTrain()
    {
        return $this->typeOfTrain;
    }

    /**
     * @param mixed $typeOfTrain
     */
    public function setTypeOfTrain($typeOfTrain)
    {
        $this->typeOfTrain = $typeOfTrain;
    }

    /**
     * @return mixed
     */
    public function getDepartureCity()
    {
        return $this->departureCity;
    }

    /**
     * @param mixed $departureCity
     */
    public function setDepartureCity($departureCity)
    {
        $this->departureCity = $departureCity;
    }

    /**
     * @return mixed
     */
    public function getArrivalCity()
    {
        return $this->arrivalCity;
    }

    /**
     * @param mixed $arrivalCity
     */
    public function setArrivalCity($arrivalCity)
    {
        $this->arrivalCity = $arrivalCity;
    }

    /**
     * @return mixed
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    /**
     * @param mixed $departureTime
     */
    public function setDepartureTime($departureTime)
    {
        $this->departureTime = $departureTime;
    }

    /**
     * @return mixed
     */
    public function getArrivalTime()
    {
        return $this->arrivalTime;
    }

    /**
     * @param mixed $arrivalTime
     */
    public function setArrivalTime($arrivalTime)
    {
        $this->arrivalTime = $arrivalTime;
    }


    public function __toString()
    {
        return 'Train number: ' . $this->trainNumber . ' Type of train: ' . $this->typeOfTrain . ' Departure city: ' . $this->departureCity . ' Arrival city: ' . $this->arrivalCity . ' Departure time: ' . $this->departureTime . ' Arrival time: ' . $this->arrivalTime;
    }

}