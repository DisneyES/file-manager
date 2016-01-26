<?php

/**
 * Created by PhpStorm.
 * User: jorge-jr
 * Date: 17/12/15
 * Time: 21:47
 */
class ftpCon
{
private $ftp;
    public $errorChmod=null;
    private $sizeFolderAtual=0;
    public function conect($host){
        $this->ftp=ftp_connect($host);
        if(!$this->ftp){
            return false;
        }
        else{
            return true;
        }
    }
    public function login($user,$pass){
        if(!ftp_login($this->ftp,$user,$pass)){
            return false;
        }
        else{
            return true;
        }
    }
    public function logout(){
        ftp_close($this->ftp);
    }
    public function nlist($DIR){
            $path = str_replace('\\ ', ' ', $DIR);
            $path = str_replace(' ', '\\ ', $path);

            return ftp_rawlist($this->ftp,$path);
    }
    public function upload($file,$local){

        return ftp_put($this->ftp,$file,$local,FTP_BINARY);
    }
    public function remove($file){
        return ftp_delete($this->ftp,$file);
    }
    public function mkdir($path){
        return ftp_mkdir($this->ftp,$path);
    }
    public $error='';
    public function ftp_rdel ($path)
    {

        if (@ftp_delete($this->ftp, $path) === false) {
            $list=str_replace(' ','\\ ',str_replace('\\ ',' ',$path));
            if ($children = @ftp_nlist($this->ftp, $list.DIRECTORY_SEPARATOR)) {

                foreach ($children as $p) {
                    if($p!='.' && $p!='..') {
                        $tmp=$path.DIRECTORY_SEPARATOR.$p;
                        $this->ftp_rdel($tmp);
                    }
                }
            }

            if(!@ftp_rmdir($this->ftp, $path.DIRECTORY_SEPARATOR)){

                    $this->error .= 'Não foi possível remover ' . $path . '<br>';

            }
        }

        return $this->error;

    }
    public function readDir($path){
        $DIR=str_replace('\\ ',' ',$path);
        $DIR=str_replace(' ','\\ ',$DIR);
        $list=null;
        if ($children = @ftp_nlist($this->ftp, $DIR)) {

            foreach ($children as $p) {
                $list[]=$p;
            }
        }
        return $list;
    }
    public function rename($old,$new){
        return ftp_rename($this->ftp,$old,$new);
    }
    public function recSize ($dir){
        $list=str_replace(' ','\\ ',str_replace('\\ ',' ',$dir));
        if ($children = @ftp_nlist($this->ftp, $list.DIRECTORY_SEPARATOR)) {

            foreach ($children as $p) {
                if($p!='.' && $p!='..') {
                    $tmp=$dir.$p;
                    $size=ftp_size($this->ftp,$tmp);
                    $this->sizeFolderAtual+=($size<0?0:$size);
                    $this->recSize($tmp.DIRECTORY_SEPARATOR);
                }
            }

        }

    }
    public function sizeGet(){
        return $this->sizeFolderAtual;
    }
    public function chmod($dir,$per){
        $mode =octdec( str_pad($per,4,'0',STR_PAD_LEFT) );
        return ftp_chmod($this->ftp,$mode,$dir);

    }
    public function chmodr($dir,$mode){
        $list=str_replace(' ','\\ ',str_replace('\\ ',' ',$dir));
        if ($children = @ftp_nlist($this->ftp, $list.DIRECTORY_SEPARATOR)) {

            foreach ($children as $p) {
                if($p!='.' && $p!='..') {
                    $tmp=$dir.$p;
                    if(!ftp_chmod($this->ftp,$mode,$tmp)){
                        $this->errorChmod[]=$tmp;
                    }
                    $this->chmodr($tmp.DIRECTORY_SEPARATOR,$mode);
                }
            }

        }
        ftp_chmod($this->ftp,$mode,$dir);
    }
    public function chmodreset($dir){
        $list=str_replace(' ','\\ ',str_replace('\\ ',' ',$dir));
        if ($children = @ftp_nlist($this->ftp, $list.DIRECTORY_SEPARATOR)) {

            foreach ($children as $p) {
                if($p!='.' && $p!='..') {
                    $tmp=$dir.$p;
                    if(!ftp_chmod($this->ftp,420,$tmp)){
                        $this->errorChmod[]=$tmp;
                    }
                    $this->chmodreset($tmp.DIRECTORY_SEPARATOR);
                }
            }

        }
        ftp_chmod($this->ftp,493,$dir);
    }
}