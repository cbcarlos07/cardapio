/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 //função para pegar o objeto ajax do navegador
        function xmlhttp(){
        	// XMLHttpRequest para firefox e outros navegadores
        	if (window.XMLHttpRequest){
        		return new XMLHttpRequest();
        	}
        	// ActiveXObject para navegadores microsoft
        	var versao = ['Microsoft.XMLHttp', 'Msxml2.XMLHttp', 'Msxml2.XMLHttp.6.0', 'Msxml2.XMLHttp.5.0', 'Msxml2.XMLHttp.4.0', 'Msxml2.XMLHttp.3.0','Msxml2.DOMDocument.3.0'];
        	for (var i = 0; i < versao.length; i++){
        		try{
        			return new ActiveXObject(versao[i]);
        		}catch(e){
        			alert("Seu navegador não possui recursos para o uso do AJAX!");
        		}
        	} // fecha for
        	return null;
        } // fecha função xmlhttp

        //função para fazer a requisição da página que efetuará a consulta no DB
        function search(){
           a = document.getElementById('select').value;
           b = document.getElementById('cod-card').value;
           //alert("Tese");
           ajax = xmlhttp();
           console.log('Valor: '+a);
           console.log('Valor: '+b);
           
           if (ajax){
        	   ajax.open('get','ingredientes.php?busca='+a+'&card='+b, true);
        	   ajax.onreadystatechange = getContent;
        	   ajax.send(null);
           }
        }
        //função para incluir o conteúdo na pagina
        function getContent(){
        	if (ajax.readyState==4){
        		if (ajax.status==200){
        			document.getElementById('nm_prato').innerHTML = ajax.responseText;
        		}
        	}
        }
        
        //função para fazer a requisição da página que efetuará a consulta no DB
        function listacard(cardapio){
           
           //alert("Tese");
           ajax = xmlhttp();
           console.log('Codigo do cardapio: '+cardapio);
           
           
           if (ajax){
        	   ajax.open('get','menucardapio.php?cardapio='+cardapio, true);
        	   ajax.onreadystatechange = populateDiv;
        	   ajax.send(null);
           }
        }
        
        function populateDiv(){
        	if (ajax.readyState==4){
        		if (ajax.status==200){
        			document.getElementById('liscardapio').innerHTML = ajax.responseText;
                                
                                
        		}
        	}
        }
