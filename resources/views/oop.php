<?
class Vihicle {
    var $color;
    var $wheels;
    var $door;

    function isGoodForRain(){
        return true;
    }
}

class Motorcycle extends Vihicle{
    var $wheels = 2;
    var $door = 0;

    function isGoogdForRain(){
        return false;
    }
}

class Car extends Vihicle{
    var $wheels = 4;
    var $door = 4;
    var $convertible = false;

    function isGoodForRain()
    {
        return !$this->convertible;
    }
}
