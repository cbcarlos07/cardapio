/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var mensagem = $('.mensagem');

function logar(acao){
        jQuery('#login-form').submit(function(){
        //alert('Submit');
        //var dados = jQuery( this ).serialize();
        var usuario = document.getElementById("usuario").value;
        var senha = document.getElementById("senha").value;
        
        //var cracha = $('#cracha').value;
        //alert("Usuario: "+usuario+" Senha: "+senha);    
        //console.log("Usuario: "+usuario+" Senha: "+senha);    
        jQuery.ajax({
                type: "POST",
                url: "usuario.php",
                beforeSend: carregando,
                
                data: {
                    'usuario' : usuario,
                    'senha'   : senha,
                    'acao'     : acao
                },
                success: function( data )
                {
                    //var retorno = data.retorno;
                    //alert(retorno);

                    console.log("Data: "+data);
                    if(data == 1){
                        sucesso();
                      }
                    else{
                        errosend();
                        $('input[name="senha"]').css("border-color","red").focus();
                        $('input[name="loginname"]').css("border-color","red").focus();
                   }
                }
        });

        return false;
        });
    }
    
    

function carregando(){
        var mensagem = $('.mensagem');
        //alert('Carregando: '+mensagem);
        mensagem.empty().html('<p class="alert alert-warning"><img src="img/loading.gif" alt="Carregando..."> Verificando dados!</p>').fadeIn("fast");
        setTimeout(function (){
            
        },300);
        
  }

  function errosend(){
        var mensagem = $('.mensagem');
        mensagem.empty().html('<p class="alert alert-danger"><strong>Opa!</strong> Por favor, verifique seu login e/ou sua senha</p>').fadeIn("fast");
}
function sucesso(msg){
        var mensagem = $('.mensagem');
        mensagem.empty().html('<p class="alert alert-success"><strong>OK.</strong> Estamos redirecionando</p>').fadeIn("fast");                
        setTimeout(function (){
            location.href = "snd.php"
        },1500);
        //window.setTimeout()
        //delay(2000);
}