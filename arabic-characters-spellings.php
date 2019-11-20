<?php

function checkName($name) {
    $aArray = ["أ", "ا", "إ"];
    $yArray = ["ي", "ى"];
    $tArray = ["ه", "ة"];

    $xArray = ["الا", "الأ", "الإ"];
    $xCase = "ال";

    //Store different spellings 
    $newNames = [];

    //Length for name (UTF8)
    $nameLength = mb_strlen($name);
    
    $firstCharacter = mb_substr($name, 0, 1, 'utf-8');
    $first2Characters = mb_substr($name, 0, 2, 'utf-8');
    $first3Characters = mb_substr($name, 0, 3, 'utf-8');
    $lastCharacter = mb_substr($name, -1, 1, 'utf-8');

    //true if the name has different spellings
    $changed = false;

    //Case 1: First 3 Characters
    if(in_array($first3Characters, $xArray)) {
        $changed = true;

        foreach($xArray as $a) {
            $currentName = $a;
            for($i = 3; $i < $nameLength; $i++) {
                $currentCharacter = mb_substr($name, $i, 1, 'utf-8');
                $currentName .= $currentCharacter;
            }
            $newNames[] = $currentName;
        }
    } else {

        //Case 2: First 2 or 1st Charachter
        if($first2Characters != $xCase && in_array($firstCharacter, $aArray)) {
            $changed = true;

            foreach($aArray as $a) {
                $currentName = $a;
                for($i = 1; $i < $nameLength; $i++) {
                    $currentCharacter = mb_substr($name, $i, 1, 'utf-8');
                    $currentName .= $currentCharacter;
                }
                $newNames[] = $currentName;
            }
        }
    }

    //Check last Charachter 
    //Case 1: 
    if(in_array($lastCharacter, $yArray)) {
        $changed = true;

        foreach($yArray as $a) {
            $currentName = '';

            for($i = 0; $i < $nameLength-1; $i++) {
                $currentCharacter = mb_substr($name, $i, 1, 'utf-8');
                $currentName .= $currentCharacter;
            }

            $currentName .= $a;
            $newNames[] = $currentName;
        }
    }

    //Case 2:
    if(in_array($lastCharacter, $tArray)) {
        $changed = true;

        foreach($tArray as $a) {
            $currentName = '';

            for($i = 0; $i < $nameLength-1; $i++) {
                $currentCharacter = mb_substr($name, $i, 1, 'utf-8');
                $currentName .= $currentCharacter;
            }
            $currentName .= $a;
            $newNames[] = $currentName;
        }
    }

    if(!$changed) {
        $newNames[] = $name;
    }

    //Return all spellings
    return $newNames;
}

?>
