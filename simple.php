<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 23.11.14
 * Time: 21.02
 */

define('PAGE_SIZE',6);

function getItemsAll($fileDB='db.txt'){
    $storage=file($fileDB,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
    $itemsToDisplayAll=array();
    foreach($storage as $row){
        $tempArr=explode('|',$row);
        $itemsToDisplayAll[]=array('title'=>$tempArr[0],'descr'=>$tempArr[1],'price'=>$tempArr[2]);
    }
    return $itemsToDisplayAll;
}       //returns an array consists of all items in catalog
function getStorageSize($fileDB='db.txt'){
    $storage=file($fileDB, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
    $storageSize=count($storage);
    return $storageSize;
}       //returns number of items in catalog
function getItemsForDefinitePage($itemsToDisplayAll, $pageToDisplay=1, $itemsPerPage= PAGE_SIZE){
    $firstItemOnPage=$itemsPerPage*($pageToDisplay-1);
    $itemsToDisplay=array_slice($itemsToDisplayAll, $firstItemOnPage,$itemsPerPage);
    return $itemsToDisplay;
}       //returns an array to display on selected page
function generatePageToDisplay($itemsToDisplay, $itemsPerPage=PAGE_SIZE){
    $htmlList="<ul>";
    foreach($itemsToDisplay as $item){
        $htmlList.="<li><h3>$item[title]</h3><p>$item[descr]</p><p>$item[price]</p></li>";
    }
    $htmlList.="</ul>";//input-type-hidden-number-of-items-per-page
    return $htmlList;
}       //returns html-code for list of items
$allItems=getItemsAll();
//print_r($allItems);
$itemsForDefinitePage=getItemsForDefinitePage($allItems);
$htmlPage=generatePageToDisplay($itemsForDefinitePage);
//print_r($itemsForDefinitePage);
echo $htmlPage;

