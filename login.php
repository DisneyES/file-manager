
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
      <meta charset="UTF-8">
    <title>Login</title>
    <script src="js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">
<script>
    $(document).ready(function(){
        $('.btn-success').click(function(){
        $btn=$(this)
        $btn.html('Logando <i class="fa fa-spinner fa-pulse"></i>');
        $btn.attr('disabled',true);
        $.post('login_t.php',$('form').serialize(),function(data){
            $('#res').html(data);
            $('#res').slideDown(500);
                    $btn.html('Entrar');
                     $btn.attr('disabled',false);
            setTimeout(function(){
                $('#res').slideUp(500);
                setTimeout(function(){
                    $('#res').html(' ');
                },600);
            },4000);
        });
        });
        $('body').keydown(function(e){
            if(e.which===13){
                $('.btn-success').click();
            }
        });
    });
</script>
</head>
<body>
    
  
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" onsubmit='return false;'>
                <div id="res"></div>

            <form >
                <div class="col-md-4"><label for="" class="control-label">Servidor</label>
                    <input type="text" name="servidor" class="form-control"></div>
                <div class="col-md-4"><label for="" class="control-label">Usuário</label>
                    <input type="text" name="usuario" class="form-control"></div>
                <div class="col-md-4"><label for="" class="control-label">Senha</label>
                    <input type="password" name="pass" class="form-control"></div>
                <div class="col-md-12" style="margin-top: 10px;">

                    <button type="button" class="btn btn-success">Entrar</button>

                </div>
            </form>
        </div>


    </div>
</div>


</body>
</html>
