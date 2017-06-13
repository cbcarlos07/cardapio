/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



var qtdeCampos = 0;

function addCampos() {
 
    var objPai = document.getElementById("campoPai");
    var objPai_ = document.getElementById("campoPai_");
    //Criando o elemento DIV;
    var objFilho = document.createElement("div");
    var objFilho_ = document.createElement("div");
    //Definindo atributos ao objFilho:
    objFilho.setAttribute("id","filho"+qtdeCampos);
    objFilho_.setAttribute("id","filho_"+qtdeCampos);

    //Inserindo o elemento no pai:
    objPai.appendChild(objFilho);
    objPai_.appendChild(objFilho_);
    //Escrevendo algo no filho recém-criado:
    //document.getElementById("filho_"+qtdeCampos).innerHTML = "<input type='text' id='campo"+qtdeCampos+"' name='campo[]' value='Campo com id: "+qtdeCampos+"'> <input type='button' onClick='removerCampo("+qtdeCampos+")' value='Apagar campo'>";
    document.getElementById("filho"+qtdeCampos).innerHTML = "<input type='text' id='campo"+qtdeCampos+"' name='campo[]' value='Campo com id: "+qtdeCampos+"'>";
    document.getElementById("filho_"+qtdeCampos).innerHTML = "<input type='button' onClick='removerCampo("+qtdeCampos+")' value='Apagar campo'>";
    qtdeCampos++;
    }

    function removerCampo(id) {
    var objPai = document.getElementById("campoPai");
    var objPai_ = document.getElementById("campoPai_");
    var objFilho = document.getElementById("filho"+id);
    var objFilho_ = document.getElementById("filho_"+id);

    //Removendo o DIV com id específico do nó-pai:
    var removido = objPai.removeChild(objFilho);
    var removido2 = objPai_.removeChild(objFilho_);
    
}
