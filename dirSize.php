<?php
@session_start();
require_once 'ftpCon.php';
$f=new ftpCon();
$f->conect(base64_decode($_SESSION[MD5('server')]));
$f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));


$dirAtual=$_POST['D']=='.'?'':$_POST['D'];
    $f->recSize($dirAtual);
    $sizeDir=$f->sizeGet();
    ?>
Este diretório possuí o tamanho aproximado de <?php

if(($sizeDir/1024)>=1){
    if(($sizeDir/(1024*1024))>=1){
        if($sizeDir/(1024*1024*1024)>=1){
            echo number_format($sizeDir/(1024*1024*1024),2,',','').' GB';

        }
        else{
            echo number_format($sizeDir/(1024*1024),2,',','').' MB';

        }
    }
    else{
        echo number_format($sizeDir/(1024),2,',','').' KB';

    }
}
else{
    echo $sizeDir." Bytes";
}

?>