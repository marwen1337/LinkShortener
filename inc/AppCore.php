<?php
/**
 * Created by PhpStorm.
 * User: marvi
 * Date: 08.08.2019
 * Time: 15:33
 */

class AppCore{

    private $config_file;
    private $pdo;
    private $lang;


    /**
     * AppCore constructor.
     */
    public function __construct($config_file){
        $this->init($config_file);
    }

    /**
     * @param $config_file
     */
    private function init($config_file){
        session_start();
        require_once $config_file;
        $this->config_file = $config_file;

        if(isset($_COOKIE['lang'])){
            $json_lang = file_get_contents(dirname($config_file) . "/lang/" . $_COOKIE['lang'] . ".json");
        }else{
            setcookie("lang", "gb", time() + 3600 * 24 * 365 * 10);
            $json_lang = file_get_contents(dirname($config_file) . "/lang/gb.json");
        }

        $this->lang = json_decode($json_lang);
        $this->pdo = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DATABASE, MYSQL_USERNAME, MYSQL_PASSWORD);
    }

    /**
     *
     */
    public function reinit(){
        $this->init($this->config_file);
    }

    /**
     * @return string
     */
    public function lang($s){
        return $this->lang[$s];
    }

    /**
     * @return array
     */
    public function fullLang(){
        return $this->lang;
    }

    public function languages(){
        return json_decode(file_get_contents(dirname($this->config_file) . "/lang/languages.json"), true);
    }

    /**
     * @return PDO
     */
    public function getPDO(){
        return $this->pdo;
    }

    /**
     * @return string
     */
    public function hash($s){
        return hash('sha512', $s);
    }

    /**
     * @return string
     */
    public function getUrl(){
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    /**
     * @return string
     */
    public function getWebRoot(){
        return WEB_ROOT;
    }

    /**
     * @return string
     */
    public function getWebRewrite(){
        return WEB_REWRITE;
    }

    /**
     * @return string
     */
    public function getWebUrl(){
        return $this->getWebRoot() . $this->getWebRewrite();
    }

    /**
     * @param $reason
     * @return mixed
     */
    public function printError($reason){
        return print_r(json_encode(array("error" => true, "reason" => $reason)));
    }

    /**
     * @return bool
     */
    public function isUserLoggedIn(){
        return (!empty($_SESSION['uid']));
    }

    public function getUserID(){
        return $this->isUserLoggedIn() ? $_SESSION['uid'] : null;
    }
}