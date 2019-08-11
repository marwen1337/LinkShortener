<?php
/**
 * Created by PhpStorm.
 * User: marvi
 * Date: 10.08.2019
 * Time: 14:04
 */

unset($_SESSION['uid']);
session_destroy();
session_start();
header("Location: login");