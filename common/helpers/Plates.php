<?php

namespace common\helpers;

class Plates
{
    public static function toBase($arg){
        $arg=strtoupper($arg);
        $arg=str_replace (' ','',$arg);
        $arg=str_replace ('А','A',$arg);
        $arg=str_replace ('В','B',$arg);
        $arg=str_replace ('Е','E',$arg);
        $arg=str_replace ('К','K',$arg);
        $arg=str_replace ('М','M',$arg);
        $arg=str_replace ('Н','H',$arg);
        $arg=str_replace ('О','O',$arg);
        $arg=str_replace ('Р','P',$arg);
        $arg=str_replace ('С','C',$arg);
        $arg=str_replace ('Т','T',$arg);
        $arg=str_replace ('У','Y',$arg);
        $arg=str_replace ('Х','X',$arg);

        $arg=str_replace ('а','A',$arg);
        $arg=str_replace ('в','B',$arg);
        $arg=str_replace ('е','E',$arg);
        $arg=str_replace ('к','K',$arg);
        $arg=str_replace ('м','M',$arg);
        $arg=str_replace ('н','H',$arg);
        $arg=str_replace ('о','O',$arg);
        $arg=str_replace ('р','P',$arg);
        $arg=str_replace ('с','C',$arg);
        $arg=str_replace ('т','T',$arg);
        $arg=str_replace ('у','Y',$arg);
        $arg=str_replace ('х','X',$arg);

        return $arg;
    }

    public static function fromBase($arg){
        $arg=str_replace ('A','а',$arg);
        $arg=str_replace ('B','в',$arg);
        $arg=str_replace ('E','е',$arg);
        $arg=str_replace ('K','к',$arg);
        $arg=str_replace ('M','м',$arg);
        $arg=str_replace ('H','н',$arg);
        $arg=str_replace ('O','о',$arg);
        $arg=str_replace ('P','р',$arg);
        $arg=str_replace ('C','с',$arg);
        $arg=str_replace ('T','т',$arg);
        $arg=str_replace ('Y','у',$arg);
        $arg=str_replace ('X','х',$arg);

        return $arg;
    }
}