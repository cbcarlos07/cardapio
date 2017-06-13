<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo "<link rel='shortcut icon' href='img/ham.png'>";
// PRIMEIRAMENTE: INSTALEI A CLASSE NA PASTA FPDF DENTRO DE MEU SITE.

$cd_cardapio = $_GET['cardapio'];
$refeicao = $_GET['ref'];
define('FPDF_FONTPATH','fpdf/font/'); 

// INSTALA AS FONTES DO FPDF
require('fpdf/fpdf.php'); 

// INSTALA A CLASSE FPDF
class PDF extends FPDF {

// CRIA UMA EXTENSÃO QUE SUBSTITUI AS FUNÇÕES DA CLASSE. 
// SOMENTE AS FUNÇÕES QUE ESTÃO DENTRO DESTE EXTENDS É QUE SERÃO SUBSTITUIDAS.

    
    function Header(){ //CABECALHO
        
        $codigo = "Variavel Codigo";
        global $codigo; // EXEMPLO DE UMA VARIAVEL QUE TERÁ O MESMO VALOR EM QUALQUER ÁREA DO PDF.
        $l=3; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA
        $this->SetXY(10,10); // SetXY - DEFINE O X E O Y NA PAGINA
        //$this->Rect(10,10,190,280); // CRIA UM RETÂNGULO QUE COMEÇA NO X = 10, Y = 10 E 
                                    //TEM 190 DE LARGURA E 280 DE ALTURA. 
                                    //NESTE CASO, É UMA BORDA DE PÁGINA.

       // $this->Image('logo.jpg',11,11,40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
        $this->SetFont('Arial','B',12); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8


        $this->Ln(); // QUEBRA DE LINHA

        //$this->Cell(190,10,'',0,0,'L');
        //$this->Ln();
        $l = 4;
        $this->SetFont('Arial','B',12);
        $this->SetXY(10,15);
        
        $titulo = utf8_decode('LISTA DE PESSOAS QUE AGENDARAM E ALMOÇARAM');
        $this->Cell(0,$l,$titulo,'B',1,'C');
        $l=5;
        $this->SetFont('Arial','B',10);
       
        $this->Ln();

        //TITULO DA TABELA DE SERVIÇOS
        $this->SetX(35);
        $this->SetFillColor(232,232,232);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','B',9);
        $this->Cell(20,$l,'ITEM',1,0,'C',1);
        $this->Cell(20,$l,'CRACHA',1,0,'C',1);
        $this->Cell(110,$l,'NOME',1,0,'L',1);
             
       // $this->Ln();

    }


    function Footer(){ // CRIANDO UM RODAPE

        //$this->SetX(15);
        $this->setY(-15);
        //$this->Rect(10,270,190,20);
        $this->SetFont('Arial','',10);        
        
        $this->SetFont('Arial','',7);
        $this->Cell(20,7,utf8_decode('Página '.$this->PageNo().' de {nb}'),0,0,'L');
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Manaus');
        $dia_hoje = date('d');
        $ano_hoje = date('Y');
        $hora_hoje = date('H:i:s');
        $data =  'Manaus, '.ucfirst(gmstrftime('%A')).', '.$dia_hoje.' de '.ucfirst(gmstrftime('%B')).' '.$ano_hoje.' '.$hora_hoje;
        //echo $data;
        $this->SetX(-70);
        $this->Cell(60,7,$data,0,0,'R');
  
    }


}

//CONECTE SE AO BANCO DE DADOS SE PRECISAR 
//include("config.php"); // A MINHA CONEXÃO FICOU EM CONFIG.PHP

            require_once './beans/Agenda.class.php';
            require_once './servicos/AgendaListIterator.class.php';
            require_once './controller/Agenda_Controller.class.php';
            require_once './controller/Cardapio_Controller.class.php';
            require_once './beans/Cardapio.class.php';
            
            $ac = new Agenda_Controller();
            $rs = $ac->getLista($cd_cardapio, "%");

            $agendaList = new AgendaListIterator($rs);
            $agenda = new Agenda();
           
            $pdf=new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4 RETRATO
            //$pdf=new PDF('L','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4   PAISAGEM         
            $pdf->AddPage(); // ADICIONA UMA PAGINA
            
            
            $pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
            $pdf->SetFont('Arial','',10);
            $y = 30; // AQUI EU COLOCO O Y INICIAL DOS DADOS 


            $l=5; // ALTURA DA LINHA
            $y = 28; //posicao no eixo Y
            
            
            $card_controller = new Cardapio_Controller();
            
            $cardapio = $card_controller->recuperar_cardapio($cd_cardapio);
            $i = 0;
            $j = 0;
            
            
       // $this->Ln();
            while ($agendaList->hasNextAgenda()){
              
                $agenda = $agendaList->getNextAgenda();
            // ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA
                $chapa = $agenda->getCod_Funcionario();
                $agenda_str = $ac->getAlmocou($cardapio->getData(), $chapa, $refeicao);
                
                if($agenda_str == 'S'){
                    $i++;
                   
                    if($i > 48)
                    {
                        $pdf->AddPage();
             //           $pdf->SetAutoPageBreak(true, 30);
                        $i = 0;
                        
                    }else{
                      $j++;
                    $cracha = utf8_decode($agenda->getCod_Funcionario()); // NESTE CASO, EU DECODIFIQUEI OS DADOS, POIS É UM CAMPO DE TEXTO.
                    $nome = utf8_decode($agenda->getNm_Funcionario()); // NESTE CASO, EU DECODIFIQUEI OS DADOS, POIS É UM CAMPO DE TEXTO.
                    
                    $pdf->SetFont('Arial','',10);
                    //DADOS
                    $pdf->Ln();
                    //LINHAS NA PAGINA
                    $pdf->SetX(35);
                    $pdf->Cell(20,5,$j,1,0,'C' ); 
                    
                    //$pdf->SetY($y);
                    
                    $pdf->SetX(55);
                    $pdf->Cell(20,5,$cracha,1,0,'C' ); // ESTA É A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA


                    //$pdf->SetY($y);
                    $pdf->SetX(75);
                    //$pdf->Rect(30,$y,100,$l);
                    $pdf->Cell(110,5,$nome,1,0,'L');
                    
                    // $y += $l;
                    }
                    
                }
                


            }
//echo "<link rel='shortcut icon' href='img/ham.png'>";
//$pdf->Footer();
$pdf->Output(); // IMPRIME O PDF NA TELA

Header('Pragma: public'); // ESTA FUNÇÃO É USADA PELO FPDF PARA PUBLICAR NO IE

