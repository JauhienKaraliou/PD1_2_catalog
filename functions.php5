<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 26.11.14
 * Time: 22.53
 */

function array_sum_by_me($arr){
    $sum=(float)$sum;
    foreach($arr as $a){
        $sum+=$a;
    }
    return $sum;
}
function array_unique_by_me($arr){
    $n=count($arr);
    foreach($arr as $k=>$a){
        for ($i=$k+1;$i<=$n;$i++){
            if ($arr[$k]===$arr[$i]){
                unset($arr[$i]);
            }
        }

    }
    return $arr;
}
function implode_by_me($arr){
    $strng=(string)'';
    foreach($arr as $a){
        $strng.=(string)$a;
    }
    return $strng;
}

$arr=array(1 => 1,5,2,3,9,5,7,9);
echo array_sum_by_me($arr);
echo '<br>'.array_sum($arr);
echo '<br>';
print_r(array_unique($arr));
echo '<br>';
print_r(array_unique_by_me($arr));
echo '<br>'.implode_by_me($arr);
