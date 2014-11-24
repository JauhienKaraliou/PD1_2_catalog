<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 22.11.14
 * Time: 16.48
 */
define('PAGE_SIZE',6);
if(isset($_GET['page'])){
    $pageToDisplay=(int)$_GET['page'];
} else{
    $pageToDisplay=1;
}
if(isset($_GET['items'])){
    $itemsPerPage=(int)$_GET['items'];
} else {
    $itemsPerPage=PAGE_SIZE;
}
if (isset($_GET['pagebot'])){
    $pageToDisplayBot=(int)$_GET['pagebot'];
} else {
    $pageToDisplayBot=1;
}
if(isset($_GET['itemsbot'])){
    $itemsPerPageBot=(int)$_GET['itemsbot'];
} else {
    $itemsPerPageBot=PAGE_SIZE;
}
function itemQuantity($itemsPerPage=PAGE_SIZE,$side=1,$itemsPerPageAnother=PAGE_SIZE,$currentPageAnother=1){
    $htmlQuantity='<ul class="list-inline">';
    for ($i=3;$i<=9;){
        if ($i==$itemsPerPage){
            $htmlQuantity.='<li class="selected">Items on page'.$i.'</li>';
        } else {
            if($side==1){
                $htmlQuantity .= '<li class="btn btn-info"><a href="?items='. $i . '&pagebot='.$currentPageAnother.'&itemsbot='.$itemsPerPageAnother.'">Items on page' . $i . '</a></li>';
            } elseif($side==2){
                $htmlQuantity .= '<li class="btn btn-info"><a href="?items='. $itemsPerPageAnother . '&page='.$currentPageAnother.'&itemsbot='.$i.'">Items on page' . $i . '</a></li>';
            }
        }
        $i += 3;
    }
    $htmlQuantity.='</ul>';
    return $htmlQuantity;
}
function paginator($numberOfPages,$currentPage=1,$itemsPerPage=PAGE_SIZE,$side=1,$currentPageAnother=1,$itemsPerPageAnother=PAGE_SIZE){
    $htmlPaginator='<ul class="list-inline">';                          //here can add class= for bootstrap
    for ($i=1; $i<=$numberOfPages; $i++){
        if($i==$currentPage){
            $htmlPaginator.="<li class=\"selected\">$i</li>";
        } else{
            if($side==1){
                $htmlPaginator.='<li class="btn btn-default"><a href="?page='.$i.'&items='.$itemsPerPage.'&pagebot='.$currentPageAnother.'&itemsbot='.$itemsPerPageAnother.'">'.$i.'</a></li>';
            } elseif ($side==2){
                $htmlPaginator.='<li class="btn btn-default"><a href="?page='.$currentPageAnother.'&items='.$itemsPerPageAnother.'&pagebot='.$i.'&itemsbot='.$itemsPerPage.'">'.$i.'</a></li>';
            }
        }
    }
    $htmlPaginator.='</ul>';
    return $htmlPaginator;
}       //returns html-code for paginator
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
function getItemsForDefinitePage($itemsToDisplayAll, $pageToDisplay=1, $itemsPerPage=PAGE_SIZE){
    $firstItemOnPage=$itemsPerPage*($pageToDisplay-1);
    $itemsToDisplay=array_slice($itemsToDisplayAll,$firstItemOnPage,$itemsPerPage);
    return $itemsToDisplay;
}       //returns an array to display on selected page
function generatePageToDisplay($itemsToDisplay){
    $htmlList="<ul>";
    foreach($itemsToDisplay as $item){
        $htmlList.="<li><h3>$item[title]</h3><p>$item[descr]</p><p>$item[price]</p></li>";
    }
    $htmlList.="</ul>";
    return $htmlList;
}       //returns html-code for list of items
function getNumberOfPages($storageSize,$itemsPerPage=PAGE_SIZE){
    $numberOfPages=ceil($storageSize/$itemsPerPage);
    return $numberOfPages;
}

$allItems=getItemsAll();
$numberOfItems=getStorageSize();
//top side
$side=1;
$itemsForDefinitePage=getItemsForDefinitePage($allItems,$pageToDisplay,$itemsPerPage);
$htmlPage=generatePageToDisplay($itemsForDefinitePage);
$numberOfPages=getNumberOfPages($numberOfItems,$itemsPerPage);
$htmlPaginator=paginator($numberOfPages,$pageToDisplay,$itemsPerPage,$side,$pageToDisplayBot,$itemsPerPageBot);
$htmlItemQuantity= itemQuantity($itemsPerPage,$side,$itemsPerPageBot,$pageToDisplayBot);
//bottom side
$side=2;
$itemsForDefinitePageBot=getItemsForDefinitePage($allItems,$pageToDisplayBot,$itemsPerPageBot);
$htmlPageBot=generatePageToDisplay($itemsForDefinitePageBot);
$numberOfPagesBot=getNumberOfPages($numberOfItems,$itemsPerPageBot);
$htmlPaginatorBot=paginator($numberOfPagesBot,$pageToDisplayBot,$itemsPerPageBot,$side,$pageToDisplay,$itemsPerPage);
$htmlItemQuantityBot=itemQuantity($itemsPerPageBot,$side,$itemsPerPage,$pageToDisplay);
echo '<HEAD><META charset="utf-8"><TITLE>Catalog</TITLE><link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"></HEAD><body>';
//top side of catalog
echo $htmlPage;
echo $htmlPaginator;
echo $htmlItemQuantity;
echo '<hr>';
//bottom side of catalog
echo $htmlPageBot;
echo $htmlPaginatorBot;
echo $htmlItemQuantityBot;
echo '</body>';
//echo $numberOfItems;
//print_r($itemsForDefinitePage);