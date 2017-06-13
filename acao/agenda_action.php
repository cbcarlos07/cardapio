<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 07/06/2017
 * Time: 17:03
 */

$codigo_cardapio = 0;


if(isset($_POST['cardapio'])){
    $codigo_cardapio = $_POST['cardapio'];
}

verficarAgendados($codigo_cardapio);


function verficarAgendados($cardapio){

    require_once '../controller/Agenda_Controller.class.php';
    require_once '../servicos/AgendaListIterator.class.php';
    require_once '../beans/Agenda.class.php';

      $agendaController = new Agenda_Controller();
      $agenda = new Agenda();
      $totalAgendados = $agendaController->getTotalAgendados($cardapio);
      $testeEnvioEmail =  0;
      $testeEmail = false;

   /* echo "Total agendados: ".$totalAgendados;*/

    // Abre ou cria o arquivo bloco1.txt
// "a" representa que o arquivo é aberto para ser escrito
    //$fp = fopen("bloco1.txt", "a");

    $nomes = "\r\n";
    if( $totalAgendados > 0 ){


        $lista = $agendaController->getEmail($cardapio);
        $agendaLista = new AgendaListIterator($lista);
        $meils = "";
        $i = 0;
        while ($agendaLista->hasNextAgenda()){
            $i++;

            $agenda = $agendaLista->getNextAgenda();
           // $nomes .= $i." - ".$agenda->getNm_Funcionario()."\r\n";


            $corpo = corpoEmailAgendou($agenda->getCardapio(), $agenda->getNm_Funcionario(), $agenda->getRefeicao(), $cardapio);
            $titulo = utf8_decode("Alteração de Cardápio");

            $email = $agenda->getDsEmail();
            if($email == ""){
                $email = $agendaController->getEmailFuncionario($agenda->getCod_Funcionario());
            }

            $testeEmail =  enviar_email($titulo, $email, $corpo);


        }

        $testeEnvioEmail = 1;
      /*  if($testeEmail){
            $testeEnvioEmail = 1;
           // echo json_encode(array("enviou" => 1));
        }else{
            $testeEnvioEmail = 2;
            //echo json_encode(array("enviou" => 0));
        }*/
    }else{
        $testeEnvioEmail = -1;
        //echo json_encode(array("enviou" => -1));
    }


// Escreve "exemplo de escrita" no bloco1.txt
   // $escreve = fwrite($fp, $nomes);

// Fecha o arquivo
  //  fclose($fp); //-> OK;

    echo json_encode(array("enviou" => $testeEnvioEmail));
}



function enviar_email($titulo, $email, $corpo){


    require_once("../servicos/phpmailer/class.phpmailer.php");

    define('GUSER', 'notificacoes@ham.org.br');	// <-- Insira aqui o seu GMail
    define('GPWD', '@dminti35');		// <-- Insira aqui a senha do seu GMail

    $error = "";
    $mail = new PHPMailer();
    $mail->IsSMTP();		// Ativar SMTP
    $mail->SMTPDebug = 1;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
    $mail->SMTPAuth = true;		// Autenticação ativada
    $mail->SMTPSecure = 'tls';	// SSL REQUERIDO pelo GMail
    $mail->Host = 'smtp.gmail.com';	// SMTP utilizado
    $mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom('notificacoes@ham.org.br', 'SND');
    $mail->Subject = $titulo;
    $mail->IsHTML(true);
    $mail->Body = $corpo;
    $mail->AddAddress($email);
    if(!$mail->Send()) {
        $error = 'Mail error: '.$mail->ErrorInfo;
        return false;
    } else {
        $error = 'Mensagem enviada!';
        return true;
    }

}

function corpoEmailAgendou($data,  $nome, $tipo_ref, $cardapio){
    $corpo = "Envio";

    include_once '../controller/CPP_Controller.class.php';
    include_once '../beans/Cardapio_Por_Prato.class.php ';
    include_once  '../beans/Tipo_Prato.class.php ';
    include_once '../servicos/CPPListIterator.class.php';
    include_once  '../servicos/TPListIterator.class.php';

    $cpc = new CPP_Controller();
    //$number = $cpc->getCodigo($_SESSION['codigo']);

    //if($number > 0){

    //echo "Numero: $number";

    $tipo = new Tipo_Prato();
    $rs1    = $cpc->lista_tipo_pratos_1($cardapio);
    $rs2    = $cpc->lista_tipo_pratos_backup_1($cardapio);
    $tpList = new TPListIterator($rs1);
    $tpList1 = new TPListIterator($rs2);

    $cpp   = new Cardapio_Por_Prato();


    $nomeArray = explode(" ", $nome);

    $nome_ = ucfirst($nomeArray[0]);


    $to = "<ul>";
    while($tpList->hasNextTipo()) {

        $tipo = $tpList->getNextTipo();
        $tipo_cd = $tipo->getCodigo();
        $to .= "<b>" . $tipo->getDescricao() . "</b>";


        $tp = $tipo->getDescricao();
        $rs    = $cpc->lista_pratos_1($cardapio, $tipo_cd);
        $cList = new CPPListIterator($rs);

        while($cList->hasNextCardapio()){
            $cpp = $cList->getNextCardapio();
            $v =  $cpp->getTipo_prato()->getDescricao();
            if($v == $tp){  // se a descricao do tipo de prato for igual a tipo de prato

                $to .= "<li>".  $cpp->getPrato()->getNome()." </li>";
            }
        }
    }


    $to .= "</ul>";


    $from = "<ul>";

    while($tpList1->hasNextTipo()) {

        $tipo = $tpList1->getNextTipo();
        $tipo_cd = $tipo->getCodigo();
        $from .= "<b>" . $tipo->getDescricao() . "</b>";


        $tp = $tipo->getDescricao();
        $rs    = $cpc->lista_pratos_backup_1($cardapio, $tipo_cd);
        $cList = new CPPListIterator($rs);

        while($cList->hasNextCardapio()){
            $cpp = $cList->getNextCardapio();
            $v =  $cpp->getTipo_prato()->getDescricao();
            if($v == $tp){  // se a descricao do tipo de prato for igual a tipo de prato

                $from .= "<li>".  $cpp->getPrato()->getNome()." </li>";
            }
        }
    }
    $from .= "</ul>";


    $corpo = "
       <div style='height: 30px; background: #337ab7; color: white; '><h2 style='text-align: center; margin-top: 15px; ' >Altera&ccedil;&atilde;o de Card&aacute;pio</h2></div>
       <hr />
       <p>Ol&aacute;, <strong>$nome_</strong>!</p>
       <p>Informamos que o card&aacute;pio do <strong> $tipo_ref </strong> do dia <strong> $data </strong> foi alterado</p>
       <table border='1' cellspacing='0' cellpadding='2'	>
	   <tr >
	     <td align='center'>De</td>
		 <td align='center'>Para</td>
	   </tr>
	   <tr>
	     <td>
	          $from
	     </td>
		 <td>
		       $to
	     </td>
	   </tr>
	   </table>
	    <p>Atenciosamente,</p>
   
       <p>Servi&ccedil;o de Nutri&ccedil;&atilde;o e Diet&eacute;tica - SND</p>
       <p style='font-size: 10px;'>Este e-mail &eacute; gerado automaticamente, voc&ecirc; n&atilde;o precisa respond&ecirc;-lo</p>
    ";

    return $corpo;
}
