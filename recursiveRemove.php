<?php
require_once 'ftpCon.php';
@session_start();
$f = new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]), base64_decode($_SESSION[MD5('password')]));
$f->ftp_rdel('teste/');
$f->logout();