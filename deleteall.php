<?php
@session_start();
$arqs=explode('|||||',$_POST['arquivosaexcluir']);
array_pop($arqs);
$error=null;
if(count($arqs)>0){
    require_once 'ftpCon.php';
    $f=new ftpCon();
    $f->conect(base64_decode($_SESSION[MD5('server')]));
    $f->login(base64_decode($_SESSION[MD5('user')]),base64_decode($_SESSION[MD5('password')]));
    foreach($arqs as $arq){
        $f->ftp_rdel($arq);
        if(!empty($f->error)){
            $_SESSION['erroUpload'][]='Não foi possível remover '.$arq.'';
            $f->error='';
        }
    }

}
header("Location: index.php?Diretorio=".$_POST['locationpathexcluirall']);