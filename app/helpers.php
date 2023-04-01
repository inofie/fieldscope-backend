<?php

function getAppName()
{
    return ucwords(str_replace('_', ' ', env('APP_NAME')));
}

function findHashTags($params)
{
    preg_match_all("/(#\w+)/", $params, $matches);
    return isset($matches[1]) ? $matches[1] : NULL;
}

function has_string_keys(array $array) {
    return count(((array) array_filter(array_keys($array), 'is_string'))) > 0;
}

function setAlertOptions($params){

//    {
//        container: '', // alerts parent container place: 'append',
//                place: 'prepend', /*append or prepend in container*/
//                message: 'TEST MSG', /*alert's message*/
//                type: 'success', /*alert's type*/
//                close: true, /*make alert closable*/
//                reset: true, /*close all previouse alerts first*/
//                focus: true, /*auto scroll to the alert after shown*/
//                closeInSeconds: 40, /*auto close after defined seconds*/
//                icon: 'fa fa-check' /*put icon class before the message*/
//            }


    $alertOptions['container'] =  ".alert-container"; // alerts parent container place: 'append';

    $alertOptions['place'] = 'append'; /*append or prepend in container*/
    $alertOptions['message'] = 'TEST MSG'; /*alert's message*/
    $alertOptions['type'] = 'info'; /*alert's type*/
    $alertOptions['close'] = true; /*make alert closable*/
    $alertOptions['reset'] = true; /*close all previous alerts first*/
    $alertOptions['focus'] = true; /*auto scroll to the alert after shown*/
    $alertOptions['closeInSeconds'] = 500; /*auto close after defined seconds*/
    $alertOptions['icon'] = 'fa fa-info-circle'; /*put icon class before the message*/

    $li = "";

    if ((in_array($params['code'], ['404', '400']))) {
        $alertOptions['type'] = 'danger';
        $alertOptions['icon'] = 'fa fa-exclamation-triangle';
    } else {
        $alertOptions['type'] = 'success';
        $alertOptions['icon'] = 'fa fa-check-circle';
    }
    foreach ($params['data'][0] AS $key => $item) {
        $li .= "<li>$item</li>";
    }

    $alertOptions['message'] = " <span>" . $params['message'] . "</span> <ul>$li </ul>";
    return json_encode($alertOptions);
}

function jsond($array,$title = ""){
    echo "<pre>$title<br><br>";
    echo json_encode($array);
    echo "<br><br>";
    die;
}

function pd($array,$title = ""){
    echo "<pre><h3 style='color: white;background-color: #727272'>$title</h3><br><br>";
    if(is_array($array)){
        print_r($array);
    }else if(is_object($array))
        print_r((array) $array);
    else{
        echo $array;
    }
    echo "<br><br>";
    die;
}

function p($array,$title = ""){
    echo "<pre><h3 style='color: white;background-color: #727272'>$title</h3><br><br>";
    if(is_array($array)){
        print_r($array);
    }else if(is_object($array))
        print_r((array) $array);
    else{
        echo $array;
    }
    echo "<br><br>";
}

function vd($array,$title = ""){
    echo "<pre><h3 style='color: white;background-color: #727272'>$title</h3><br><br>";
    var_dump($array);
    echo "<br><br>";
    die;
}

function v($array,$title = ""){
    echo "<pre><h3 style='color: white;background-color: #727272'>$title</h3><br><br>";
    var_dump($array);
    echo "<br><br>";
}

function getRawQuery($sql){
    $query = str_replace(array('?'), array('\'%s\''), $sql->toSql());
    $query = vsprintf($query, $sql->getBindings());
    return $query;
}
