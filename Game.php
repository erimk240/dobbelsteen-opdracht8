<?php

// gemaakt door Erim kocak


require_once 'Dice.php';

class Game {
    private $dice;
    private $throwCount;
    private $diceCount;

    public function __construct($diceCount) {
        $this -> dice = array();
        $this -> throwCount = 0;
        $this -> diceCount = $diceCount;

        for ($i = 0; $i < $this -> diceCount; $i++) {
            $this -> dice[] = new Dice();
        }
    }

    public function play() {
        $this -> throwCount++;
        echo "Worp " . $this -> throwCount . ": ";
        $results = array();
        foreach ($this -> dice as $dice) {
            $dice -> throwDice();
            $faceValue = $dice -> getFaceValue();
            echo $this -> getDiceSVG($faceValue);
            $results[] = $faceValue;
        }
        echo "<br>";
        $this -> checkSpecial($results);
    }

    private function checkSpecial($results) {
        // Tel het aantal unieke waarden in de resultaten
        $uniqueValues = array_count_values($results);
        // Controleer of er slechts één unieke waarde is (alle dobbelstenen hebben dezelfde waarde)
        if (count($uniqueValues) == 1) {
            // Controleer of de frequentie van de unieke waarde 3 is (alle dobbelstenen hebben dezelfde waarde en we gooien met 3 dobbelstenen)
            if (reset($uniqueValues) == 3) {
                echo "Yahtzee!";
                // Voeg hier eventuele extra functionaliteit toe voor een Yahtzee
            }
        }
    }

    // Methode om SVG-code te genereren voor een dobbelsteen met een specifiek aantal ogen en kleur
    private function getDiceSVG($numberOfEyes) {
        $svg = "<svg width='100' height='100'>";
        $svg .= "<rect width='100' height='100' fill='white' stroke='black' />";
        
        // Coördinaten van de cirkels voor elk aantal ogen
        $circlesCoordinates = array(
            [], // 0 ogen wordt niet gebruikt
            [[50, 50]], // 1 oog
            [[30, 30], [70, 70]], // 2 ogen
            [[30, 30], [50, 50], [70, 70]], // 3 ogen
            [[30, 30], [30, 70], [70, 30], [70, 70]], // 4 ogen
            [[30, 30], [30, 70], [50, 50], [70, 30], [70, 70]], // 5 ogen
            [[30, 30], [30, 50], [30, 70], [70, 30], [70, 50], [70, 70]] // 6 ogen
        );
    
        // Bepaal een willekeurige grootte tussen 25px en 100px

        // UNIEKE GEDEELTE -----------------
        $size = rand(25, 100);
    
        // Voeg cirkels toe op de gespecificeerde coördinaten met de willekeurige grootte
        foreach ($circlesCoordinates[$numberOfEyes] as $coordinate) {
            $svg .= "<circle cx='{$coordinate[0]}' cy='{$coordinate[1]}' r='" . ($size / 10) . "' fill='' />";
        }
    
        $svg .= "</svg>";
        return $svg;
    }
    

    // Toegevoegde methode om het aantal dobbelstenen op te halen
    public function getDiceCount() {
        return $this -> diceCount;
    }

    // Toegevoegde methode om het resultaat van de worp op te halen
    public function getResult() {
        // Hier kun je de resultaten van de worp teruggeven, indien nodig
    }
}

?>