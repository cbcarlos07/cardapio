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
        function pesquisar(origem, div, p, url){
           nameDiv = div;
           a = document.getElementById(origem).value;
           console.log("Pesquisa: "+a);
           console.log("URL: "+url);
           ajax = xmlhttp();
           if (ajax){
        	   ajax.open('get','busca.php?busca='+a+'&pesq='+p+'&url='+url, true);
        	   ajax.onreadystatechange = trazconteudo;
        	   ajax.send(null);
           }
        }
        //função para incluir o conteúdo na pagina
        function trazconteudo(){
        	if (ajax.readyState==4){
        		if (ajax.status==200){
                                
        			document.getElementById(nameDiv).innerHTML = ajax.responseText;
        		}
        	}
        }