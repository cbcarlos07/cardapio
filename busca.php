<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
          jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox({
              loadingImage : 'src/loading.gif',
              closeImage   : 'src/closelabel.png'
            })
          })
</script> 
<?php
 $_pesq =  $_GET['pesq'];
 $_busca = $_GET['busca'];
 $_url =   $_GET['url'];
 
 
 
 switch ($_pesq){
     case 'P':
            recupera_pratos();
            break;
     case 'C':
            recupera_cardapio();
            break;
         
 }
 function recupera_pratos(){
        global $_busca;
        global $_url;
        require_once './controller/Prato_Controller.class.php';
        require_once './servicos/PratoListIterator.class.php';
        $tc = new Prato_Controller();
        $rs = $tc->lista_prato(strtoupper($_busca));
        $i = 0;
        $tipoList = new PratoListIterator($rs);
        $prato = new Prato();
        while($tipoList->hasNextPrato()){
            $prato = $tipoList->getNextPrato();
            $var = $prato->getCodigo()."|".$_url;
            $codigo_prato = $prato->getCodigo();
            echo "<tr>";
            echo "   <td>".$prato->getCodigo()."</td>";
            echo "   <td><a href='pratos_alt.php?codigo=$var' rel='facebox[.bolder]' >".$prato->getNome()."</a></td>";                                            
            echo "   <td>".$prato->getTipo_prato()->getDescricao()."</td>";                                            
            echo "   <td class='actions'>
                       <button data-nome='".$prato->getTipo_prato()->getDescricao()."' data-id='$codigo_prato' class='delete btn btn-danger'>Excluir</button>
                       <a href='pratos_alt.php?codigo=$var' rel='facebox[.bolder]' class='btn  btn-success'>Editar</button>";
            echo "</tr>";
        }
 }
 
 function recupera_cardapio(){
    require_once './controller/Cardapio_Controller.class.php';
    require_once './servicos/CardapioListIterator.class.php';
    require_once './servicos/AgendaListIterator.class.php';
    require_once './controller/Agenda_Controller.class.php';
    $tc = new Cardapio_Controller();
    $rs = $tc->lista_cardapio($valor);
    $i = 0;
    $tipoList = new CardapioListIterator($rs);
    $cardapio = new Cardapio();
    while($tipoList->hasNextCardapio()){
        $cardapio = $tipoList->getNextCardapio();
        $cod_cardapio = $cardapio->getCodigo();
        $ac = new Agenda_Controller();
        $total = $ac->getCodigo($cod_cardapio);
        $var = $cardapio->getCodigo()."|".$url;
        $codigo_cardapio = $cardapio->getCodigo();
        //$data = date('d/m/Y',strtotime($cardapio->getData()));
        $data = $cardapio->getData();
        echo "<tr>";
        echo "   <td>".$cod_cardapio."</td>";
        echo "   <td>".$data."</td>";  
        echo "   <td>".$cardapio->getDescricao()."</td>";  
        echo "   <td>".$cardapio->getTipo_Refeicao()->getDescricao()."</td>";                                            
        $publish = $cardapio->getPublicado();
        if($publish == 'N'){
            echo "   <td><img src='img/notpublished.png' class=img-responsive title='Não publicado'></td>";    
        }else{
            echo "   <td><img src='img/published.png' class=img-responsive title='Publicado'></td>";    
        }
        echo "   <td align='center'><a href=agenda.php?codigo=$codigo_cardapio&data=$data&ref=".$cardapio->getTipo_Refeicao()->getCodigo().">".$total."</a></td>";                                                
        echo "   <td>
                    <form action=cardapio_alt.php method=post> <input type='hidden' value=".$cardapio->getCodigo()." name=codigo > <input  type='hidden' value=".$url." name=url > <input type='hidden' value=E name=acao >                                                            
                        <input type='hidden' value=".$_SERVER['REQUEST_URI']." name=url>
                        <input type='hidden' value=".$cardapio->getCodigo()." name=cardapio>
                        <button  type='submit' value='submit' class='btn btn-default' title='Mostrar os itens adicionados a este card&aacute;pio'>Alterar</button>
                    </form>
                 </td>";                                        
        echo "   <td class='actions'>
                   <button data-nome='".$codigo_cardapio."' data-id='$codigo_cardapio' class='delete btn  btn-danger' title='Excluir card&aacute;pio'>Excluir</button>";
        echo "   <td><form action=car_p.php method=post> <input type='hidden' value=".$cardapio->getCodigo()." name=codigo > <input  type='hidden' value=".$url." name=url > <input type='hidden' value=E name=acao >
                    <input type='hidden' value=".$cardapio->getData()." name=data> <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>
                    <input type='hidden' value=".$cardapio->getCodigo()." name=codigo>
                    <button  type='submit' value='submit' class='btn btn-warning' title='Mostrar os itens adicionados a este card&aacute;pio'>Detalhes</button></form>
                    </td>";
        echo "   <td><form action=cardapio_copy.php method=post> <input type='hidden' value=".$cardapio->getCodigo()." name=codigo > <input  type='hidden' value=".$url." name=url > <input type='hidden' value=E name=acao >
                    <input type='hidden' value=".$cardapio->getData()." name=data> <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>
                    <input type='hidden' value=".$cardapio->getCodigo()." name=codigo>
                    <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>    
                    <input type='hidden' value=".$url." name=url>        
                    <button  type='submit' value='submit'  class='btn btn-success' title='Criar novo card&aacute;pio com os mesmos itens associado a esta op&ccedil;&atilde;o'>Copiar</button></form></td>";
        echo "</tr>";
    }
                                    
 }
    
?>