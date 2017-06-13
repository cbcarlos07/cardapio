/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function salvar(alterado){
        jQuery('#cardapio-salvar').submit(function(){
        //alert('Submit');
        //var dados = jQuery( this ).serialize();
        var cardapio = document.getElementById("cardapio").value;
        var prato = document.getElementById("prato").value;
        
        //var cracha = $('#cracha').value;
        //alert("Usuario: "+usuario+" Senha: "+senha);    
        //console.log("Usuario: "+usuario+" Senha: "+senha);    
        jQuery.ajax({
                type: "POST",
                url: "acao/cpp_action.php",
                beforeSend: carregando,
                
                data: {
                    'cardapio' : cardapio,
                    'prato'   : prato,
                    'acao'     : 'S'
                },
                success: function( data )
                {
                    //var retorno = data.retorno;
                    //alert(retorno);

                    console.log("Cardapio retorno: "+data);
                    if(data > 0){
                        //sucesso();
                        console.log("Salvo com sucesso")
                        sucesso('Item adicionado', alterado);
                        listacard(data);
                        
                    }else if(data == -1){
                        console.log("A opcao escolhida ja existe");
                        errosend();
                    }
                    
                }
        });

        return false;
        });
    }
    
    
    
    function excluir(cardapio, prato, usuario, alterado){
        
           // alert('Usuario: '+usuario);
         //alert('Excluir: '+alterado);
        jQuery.ajax({
                type: "POST",
                url: "acao/cpp_action.php",
                beforeSend: carregando,
                
                data: {
                    'cardapio' : cardapio,
                    'prato'   : prato,
                    'acao'     : 'E',
                    'nome'    : usuario
                },
                success: function( data )
                {
                    //var retorno = data.retorno;
                    //alert(retorno);

                    console.log("Cardapio retorno: "+data);
                    if(data == 1){
                        //sucesso();
                        console.log("Excluido com sucesso")
                        $('#myModal').modal('hide');
                        sucesso('Item excluido com sucesso', alterado);
                        //listacard(cardapio);
                        //$('.list-group-item').remove();
                       //$(a.delete).remove();
                        
                    }else if(data == 0){
                        console.log("Nao conseguiu excluir");
                        errosend();
                    }
                    
                }
        });

        return false;
       
    }
    
    

function carregando(){
        var message = $('.message');
        //alert('Carregando: '+message);
        message.empty().html('<p class="alert alert-warning"><img src="img/loading.gif" alt="Carregando..."> Verificando dados!</p>').fadeIn("fast");     
  }

function errosend(){
        var message = $('.message');
        message.empty().html('<p class="alert alert-danger"><strong>Opa!</strong> Voc&ecirc j&aacute; adicionou essa op&ccedil;&atilde;o</p>').fadeIn("fast");
}    
function sucesso(msg, alterado){
        
        var message = $('.message');
        message.empty().html('<p class="alert alert-success"><strong>OK.</strong> '+msg+' </p>').fadeIn("fast");                
        setTimeout(function (){
             //location.reload();
           // alert('Reenviando: '+alterado);
             var form = $('<form action="car_p.php" method="post">' +
                         ' <input type="hidden" name="alterado" value="'+alterado+'">' +
                        '</form>');
             $('body').append(form);
             form.submit();
            //message.hide();
            //document.getElementById('tipo_prato').value = 0;
            //carregar('combo_pratos');
        },1500);
        
        //window.setTimeout()
        //delay(2000);
}

$('.btn-publicar').on('click', function () {
       var acao     = $(this).data('acao');
       var cardapio = $(this).data('cardapio');
       var url      = $(this).data('url');
       var publicar = $(this).data('publicar');
       var alterado = $(this).data('alterado');
        $.ajax({
            url  : 'acao/cardapio_action.php',
            type : 'post',
            dataType : 'json',
            data : {
                acao      : acao,
                codigo    : cardapio,
                url       : url,
                publicado : publicar,
                alterado  : alterado
            },
            success : function (data) {
                if(data.retorno == 1){
                    if( publicar === 'S' ){
                        if(alterado === 1){
                            var retornEmail = enviarEmail(cardapio);
                            alert('Enviar email: '+retornEmail+' '+typeof retornEmail);
                             if(retornEmail == 1){
                                 alert('Enviou email');
                             } else{
                                 alert('Não enviou email');
                             }
                            sucesso('O cardapio foi publicado', 1);
                        }else{
                            sucesso('O cardapio foi publicado', 0);
                        }

                    }else{
                        if(alterado == 1)
                          sucesso('O cardapio foi despublicado', 1);
                        else
                            sucesso('O cardapio foi despublicado', 0);
                    }
                }

            }
        });
});

function enviarEmail(cardapio) {
    alert('Cardapio: '+cardapio);
    var retorno = 0;
    $.ajax({
        url  : 'acao/agenda_action.php',
        type : 'post',
        dataType : 'json',
        data : {
            cardapio : cardapio
        },
        success : function (data) {
            alert('Retorno email: '+data.enviou);
            //retorno = data.enviou;
            //if(data.enviou == 1){

                retorno = data.enviou;
           // }
        }
    });
return retorno;

}
