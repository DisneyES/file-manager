<?php
if(!empty($_GET['p'])) {
    @session_start();
    $content=file_get_contents('ftp://' . base64_decode($_SESSION[MD5('user')]) . ':' . base64_decode($_SESSION[MD5('password')]) . '@' . base64_decode($_SESSION[MD5('server')]) . DIRECTORY_SEPARATOR . $_GET['p']);
    if((mb_strlen($content)/1024/1024)<=200){
        if(!empty($content)){
            $file = fopen('tmpdownload', 'w+');
            fwrite($file, $content);
            unset($content);
            if (file_exists('tmpdownload')) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($_GET['p']) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize('tmpdownload'));
                readfile('tmpdownload');
                fclose($file);
                $file = fopen('tmpdownload', 'w+');
                ftruncate($file, 0);
                fclose($file);
                exit;
            }

        }
        else{
            ?>
            <script>
                alert('Arquivo vazio ou inexistente');
                window.location.href = document.referrer;

            </script>
            <?php
        }
    }
    else{
        ?>
        <script>
            alert('Tamanho excede o limite');
            window.location.href = document.referrer;
        </script>
        <?php
    }


}
else{
    header("Location: index.php");
}
?>