<?php

define('PAGE_SIZE', 6);

// Возвращает номер текущей страницы
function getCurrentPage(){
// ваша реализация
}


// Возвращает массив со всем данными
function _getStorage(){
    $arr = file('db.txt', FILE_IGNORE_NEW_LINES);
    $ret = array();
    foreach($arr as $row) {
        $tmp = explode('|', $row);
        $ret[] = array('title'=>$tmp[0],'descr'=>$tmp[1],'cost'=>$tmp[2]);
    }
    return $ret;
}

// Возвращает число записей в хранилище
function getStorageSize(){
// ваша реализация
}

function getItemsForPage($pageNum, $pageSize = PAGE_SIZE){
// ваша реализация
}


// ваша реализация