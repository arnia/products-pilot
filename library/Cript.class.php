<?php

class Cript{
    private $schar;  // simbolic character
    private $uchar; // uppercase caracter
    private $lchar; // lowercase caracter
    private $key = "CIO";

    public function __construct($key = NULL){
        if($key) $this->key = $key;
        $schar = 33;
        $uchar = 65;
        $lchar = 97;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function cript($input){
        $vect = array();
        $k = 0;
        for($j=0;$j<strlen($input);$j++,$k++){
            if($k >= strlen($this->key)) $k = 0;
            $i = ord($input[$j]);
            $c = ord($this->key[$k]);
            $x = 2*((int)($i/($c+1)))+3;
            $y = 3*($i%($c+1))+2;
            //var_dump($x);
            //var_dump($y);
            //var_dump($k);
            //var_dump($c);
            $dx=$dy='';
            switch (strlen($x)){
                case 1: $dx=$this->uchar + ($c%10);break;
                case 2: $dx=$this->schar + ($c%10);break;
                case 3: $dx=$this->lchar + ($c%10);break;
            }
            switch (strlen($y)){
                case 1: $dy=$this->lchar + ($c%10);break;
                case 2: $dy=$this->uchar + ($c%10);break;
                case 3: $dy=$this->schar + ($c%10);break;
            }
            $vect[]=chr($dx);
            $vect[]=$x;
            $vect[]=chr($dy);
            $vect[]=$y;
        }
        return implode($vect);
    }


    public function decript($input){
        $vect = array();
        $k = 0;
        $j = 0;
        while( $j < strlen($input) ){
            if($k >= strlen($this->key)) $k = 0;
            $dx = ord($input[$j++]);
            if($dx>=$this->schar && $dx<$this->uchar) $dx = 2;
            elseif ($dx>=$this->uchar && $dx<$this->lchar) $dx = 1;
            else $dx = 3;
            $x = 0;
            for( $l = 0;$l < $dx; $l++,$j++){
                $x = $x*10 + $input[$j];
            }
            $x = ($x-3)/2;
            $dy = ord($input[$j++]);
            if($dy>=$this->schar && $dy<$this->uchar) $dy = 3;
            elseif ($dy>=$this->uchar && $dy<$this->lchar) $dy = 2;
            else $dy = 1;
            $y = 0;
            for( $l = 0;$l < $dy; $l++,$j++){
                $y = $y*10 + $input[$j];
            }
            $y = ($y-2)/3;
            $c = ord($this->key[$k++]);
            $i = chr($x*($c+1)+$y);
            $vect[] = $i;
        }
        return implode($vect);
    }

}