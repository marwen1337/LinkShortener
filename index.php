<?php
/**
 * Created by PhpStorm.
 * User: marvi
 * Date: 08.08.2019
 * Time: 15:31
 */

require_once 'inc/AppCore.php';

$core = new AppCore(dirname(__FILE__) . "/config/default_config.php");

if(!empty($_GET['lang']) && $_GET['lang'] != $_COOKIE['lang']){
    if(!empty($core->languages()[$_GET['lang']])){
        setcookie("lang", $_GET['lang'], time() + 3600 * 24 * 365 * 10);
        header("Refresh: 0");
        exit;
    }
}

$args = explode("/", str_replace($core->getWebUrl(), "", strtok($core->getUrl(), "?")));
$file = dirname(__FILE__) . '/inc/fnd/' . $args[0] . '.php';

if(empty($args[0])){
    require dirname(__FILE__) . '/inc/fnd/home.php';
}else if(file_exists($file)){
    require $file;
}else{
    $core->printError("Site not found.");
}