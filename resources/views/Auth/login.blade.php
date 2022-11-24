<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, maximum-scale=1.0, user-scalable=no" />
    <title>ERPCASTRO :: </title>
    <link type="text/css" media="screen" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link type="text/css" media="screen" rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link type="text/css" media="screen" rel="stylesheet" href="{{ asset('css/icons.css') }}" />
    <link type="text/css" media="screen" rel="stylesheet" href="{{ asset('css/iziToast.css') }}" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/iziToast.js') }}"></script>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <img style="width: 300px;" class="img-responsive" src="/assets/images/logo.png"/>
    </div> <!-- /login-header -->
    <!-- Notification -->
    <div class="login-wrap">
        <div class="login-info"></div>
        <form class="form-vertical" id="form_login">
            <div class="form-group login-input">
                <i class="icon16 icon-app-acl-client overlay">&nbsp;</i>
                <input class="form-control text-input" type="text" name="usuario" required id="usuario" placeholder="Usuário">
            </div>
            <div class="form-group login-input">
                <i class="icon16 icon-app-lock overlay">&nbsp;</i>
                <input class="form-control text-input" type="password" name="senha" required id="senha" placeholder="Senha">
            </div>
            <button type="submit" style="width: 100%;" class="btn btn-block btn-outline-success">Login</button>
        </form>
    </div>
</div>
<div class="text-center login-extra">
    <span><a href="https://erpcastro.com.br" target="_blank" class="text-dark">ERPCASTRO</a></span>
    <span>4.0 - Build 1 |</span>
    <span> - </span>
    <span>&copy; 2022 - 2022</span>
</div>
<script>
    $("#form_login").submit(function(event){
        event.preventDefault();
        let usuario = $("#usuario").val();
        let senha = $("#senha").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('login.form') }}",
            data: {
                _token: "{{ csrf_token() }}",
                user: usuario,
                password: senha
            },
            dataType: 'json',
            success: function(response){
                if(response.status === true){
                    window.location.href = "{{ route('dashboard') }}";
                }else{
                    iziToast.warning({
                        title: 'Usuário ou senha incorreto',
                        message: 'Verifique os dados e tente novamente'
                    });
                    $("#usuario").val("");
                    $("#senha").val("");
                    $("#usuario").focus();
                }
            }
        }).catch(function(error){
            console.log(error);
            iziToast.error({
                title: 'Erro',
                message: 'Contate o administrador do sistema'
            });
            $("#usuario").val("");
            $("#senha").val("");
            $("#usuario").focus();
        });
    });
</script>
</body>
</html>
