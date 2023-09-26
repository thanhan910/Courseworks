<?php
class Monster { // start the Monster class
    private $num_of_eyes; // properties
    private $colour;

    function __construct($num, $col) { // constructor
        $this->num_of_eyes = $num; // initialise number of eyes
        $this->colour = $col; // initialise colour
    }

    function describe() {
        $ans = "The " . $this->colour . " monster has " . $this->num_of_eyes . " eyes."; 
        return $ans;
    }

    // Getter and Setter methods
    
    public function getNumOfEyes() {
        return $this->num_of_eyes;
    }

    public function setNumOfEyes($num) {
        $this->num_of_eyes = $num;
    }

    public function getColour() {
        return $this->colour;
    }

    public function setColour($col) {
        $this->colour = $col;
    }
}
?>
