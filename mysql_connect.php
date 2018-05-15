<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 14/05/2018
 * Time: 19:08
 */

$dbHost = '';
$dbUser = '';
$dbPass = '';
$dbName = '';

$link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (mysqli_connect_error()) {
    die(mysqli_connect_error());
}