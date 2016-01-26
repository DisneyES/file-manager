<?php
@session_start();
$arqs=explode('|||||',$_POST['arqspropriedadesAll']);
array_pop($arqs);
if(count($arqs)>0) {
    require_once 'ftpCon.php';
    $f = new ftpCon();
    $f->conect(base64_decode($_SESSION[MD5('server')]));
    $f->login(base64_decode($_SESSION[MD5('user')]), base64_decode($_SESSION[MD5('password')]));
    $user = 6;
    $group = 0;
    $other = 0;

    if (!empty($_POST['userAll3'])) {
        $user += 1;
    }
    if (!empty($_POST['groupAll1'])) {
        $group += 4;
    }
    if (!empty($_POST['groupAll2'])) {
        $group += 2;
    }
    if (!empty($_POST['groupAll3'])) {
        $group += 1;
    }
    if (!empty($_POST['otherAll1'])) {
        $other += 4;
    }
    if (!empty($_POST['otherAll2'])) {
        $other += 2;
    }
    if (!empty($_POST['otherAll3'])) {
        $other += 1;
    }
    foreach ($arqs as $arq) {
        if (!$f->chmod($arq, $user . $group . $other)) {
            $_SESSION['erroUpload'][] = 'Não foi possível alterar a permissão de ' . $arq . '';
        }
    }
    $f->logout();
}
header("Location: index.php?Diretorio=".$_POST['locationAtualpropriedadesAll']);
?>

