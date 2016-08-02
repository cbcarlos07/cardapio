<?php
  session_start();
  $_SESSION['login'] = $_SERVER['REQUEST_URI'];
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <!--<script src="js/bootstrap.js"></script>-->
        <script src="js/jquery.js"></script>
        <script src="js/jquery.min.js"></script>
        <script language="javascript" src="js/acaologin.js"></script>
        <link href="img/ham.ico" rel="short icon">
    </head>
    <body>
        <br>
      <div class="container" style="margin-top:40px">
          <div class="row">
              <div class="col-sm-6 col-md-4 col-md-offset-4">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                                            <strong> Fa&ccedil;a seu login para continuar</strong>
		      </div>
                      <div class="panel-body">
                          <form  action="#" method="POST" id="login-form">
                              <fieldset>
                                  <div class="row">
                                      <div class="center-block">
                                          <img class="profile-img" src="img/card.png" alt="" width="50%">
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">
						 <i class="glyphicon glyphicon-user"></i>
					      </span>
                                              <input class="form-control usuario" placeholder="Usu&aacute;rio" name="loginname" id="usuario"  type="text"  onfocusout="buscar('E')" style="text-transform: uppercase" required="" >
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">
						 <i class="glyphicon glyphicon-lock"></i>
					      </span>
                                              <input class="form-control senha" placeholder="Senha" name="senha" id="senha"  type="password"   style="text-transform: uppercase" required="">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">
						 <i class="glyphicon glyphicon-wrench"></i>
					      </span>
                                              <input class="form-control" placeholder="EMPRESA" name="empresa" id="empresa"  type="text"    >
                                          </div>
                                      </div>
                                      <input value="L" type="hidden" id="acao">
                                      <div class="form-group">
                                          <button  type="submit" class="btn btn-lg btn-primary btn-block" id="btn-login" onclick="logar('L')" >Entrar</button>
                                      </div>
                                      <div class="mensagem">
                                          <p class="alert"></p>
                                      </div>
                                  </div>
                              </fieldset>    
                          </form>
                      </div>
                  </div>
              </div>
          </div>
	</div>
    
                                                            <!--<script src="js/login.js"></script>-->
                                                            <!--<script src="js/bootstrap.min.js"></script>-->
        
        
        
        <script>
        function buscar(acao){
        var usuario = document.getElementById("usuario").value;
        jQuery.post( 'usuario.php', {'usuario': usuario, 'acao' : acao}, function(data) {
                    //alert( 'response: ' + data.response );
                    $('input[name="loginname"]').css("border-color","none");
                    var x = document.getElementById("empresa");
                    //alert(data.response);
                    console.log(data.response);
                    //console.log(data.nome);
                    x.value = data.response;
                    

            },'json');
    }
        </script>
       
    
    </body>
</html>