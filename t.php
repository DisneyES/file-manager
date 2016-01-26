<!doctype html>
<html lang="Pt-Br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        .overlay {
            background-color: transparent;
            bottom: 0;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
        }
    </style>
    <script src="js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.overlay').css({"width": "0px","height": "0px"});

            $('.btn-danger').click(function () {
               $('.overlay').css({"width": $(window).width(),"height": $(window).height()});
           });
               $('.btn-success').click(function () {
                   alert("Alert");
               });
               $('.btn-warning').click(function () {
                   $('body').off('click');
               });
        });
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="col-md-12">
        <input type="button" class="btn btn-danger" value="Desabilitar clique">
        <div class="btn-group">
            <button class="btn btn-success">Alert</button>
            <button class="btn btn-success">Alert</button>
            <button class="btn btn-success">Alert</button>
            <button class="btn btn-success">Alert</button>
        </div>
        <input type="button" class="btn btn-warning" value="Habilitar clique">
    </div>
</div>
<div class="overlay"></div>
</body>
</html>