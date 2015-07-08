<?php
//ONLY SYMBOL, UPPERCASE, LOWERCASE AND NUMERIC CHARACTERS

function cript($input,$key){
    $vect = array();
    $k = 0;
    for($j=0;$j<strlen($input);$j++,$k++){
        if($k >= strlen($key)) $k = 0;
        $i = ord($input[$j]);
        $c = ord($key[$k]);
        $x = 2*((int)($i/($c+1)))+3;
        $y = 3*($i%($c+1))+2;
        //var_dump($x);
        //var_dump($y);
        //var_dump($k);
        //var_dump($c);
        $dx=$dy='';
        switch (strlen($x)){
            case 1: $dx=65+($c%10);break;
            case 2: $dx=33+($c%10);break;
            case 3: $dx=97+($c%10);break;
        }
        switch (strlen($y)){
            case 1: $dy=97+($c%10);break;
            case 2: $dy=65+($c%10);break;
            case 3: $dy=33+($c%10);break;
        }
        $vect[]=chr($dx);
        $vect[]=$x;
        $vect[]=chr($dy);
        $vect[]=$y;
    }
    return implode($vect);
}

function decript($input,$key){
    $vect = array();
    $k = 0;
    $j = 0;
    while( $j < strlen($input) ){
        if($k >= strlen($key)) $k = 0;
        $dx = ord($input[$j++]);
        if($dx>=33 && $dx<65) $dx = 2;
        elseif ($dx>=65 && $dx<97) $dx = 1;
        else $dx = 3;
        $x = 0;
        for( $l = 0;$l < $dx; $l++,$j++){
            $x = $x*10 + $input[$j];
        }
        $x = ($x-3)/2;
        $dy = ord($input[$j++]);
        if($dy>=33 && $dy<65) $dy = 3;
        elseif ($dy>=65 && $dy<97) $dy = 2;
        else $dy = 1;
        $y = 0;
        for( $l = 0;$l < $dy; $l++,$j++){
            $y = $y*10 + $input[$j];
        }
        $y = ($y-2)/3;
        $c = ord($key[$k++]);
        $i = chr($x*($c+1)+$y);
        $vect[] = $i;
    }
    return implode($vect);
}
