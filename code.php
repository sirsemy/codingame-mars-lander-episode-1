<?php

class LandingToMars
 {
    private const SAFETY_FALLING_SPEED = -39;
    private const FULL_THRUST_POWER_ALTITUDE = 1560;

    protected $surfaceCoordinates = [];
    public $landingCoordinate;

    public function __construct($surfacePointsNumber)
    {
        $this->drawSurface($surfacePointsNumber);
        $this->defineLandingCoordinate();
    }

    private function drawSurface($surfacePointsNumber)
    {
        for ($i = 0; $i < $surfacePointsNumber; $i++) {
            fscanf(STDIN, "%d %d", $landX, $landY);

            if (array_key_exists($landX, $this->surfaceCoordinates)) {
                continue;
            }

            $this->surfaceCoordinates[$landX] = $landY;
        }
    }

    private function defineLandingCoordinate()
    {
        $coordinateX = 0;
        $coordinateY = -1;

        foreach ($this->surfaceCoordinates as $x => $y) {
            if ($coordinateY == $y) {
                $this->landingCoordinate["x"] = $coordinateX;
                $this->landingCoordinate["y"] = $coordinateY;
                
                break;
            }

            $coordinateX = $x;
            $coordinateY = $y;
        }
    }

    public function isNearToSafetySpeed($speed)
    {
        if ($speed <= self::SAFETY_FALLING_SPEED) {
            return true;
        }

        return false;
    }

    public function isBrakingAltitude($altitude)
    {
        $properHigh = $this->landingCoordinate["y"] + self::FULL_THRUST_POWER_ALTITUDE;

        if ($altitude <= $properHigh) {
            return true;
        }

        return false;
    }
 }

fscanf(STDIN, "%d", $surfacePointsNumber);

$landing = new LandingToMars($surfacePointsNumber);

while (TRUE)
{
    fscanf(STDIN, "%d %d %d %d %d %d %d", $X, $Y, $hSpeed, $vSpeed, $fuel, $rotate, $power);

    if ($landing->isBrakingAltitude($Y)) {
        echo("0 4\n");
    } elseif ($landing->isNearToSafetySpeed($vSpeed)) {
        echo("0 4\n");
    } else {
        echo("0 3\n");
    }   
}
?>
