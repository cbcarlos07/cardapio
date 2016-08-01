<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cardapio_Por_Prato_DAO {
    
    
    public function insert (Cardapio_Por_Prato $cp){
        require_once 'ConnectionFactory.class.php';
        $teste = false;
        $conn = new ConnectionFactory();   
        $conexao = $conn->getConnection();
        $sql_text = "INSERT INTO DBAADV.INTRA_CARDAPIO_POR_PRATOS (CD_CARDAPIO, CD_PRATO )
		     VALUES (:CD, :CDP )";
        try {
           // echo "Nome: ".            
            $cardapio        = $cp->getCardapio();
            $prato           = $cp->getPrato();
            $statement   = oci_parse($conexao, $sql_text);
            echo "Cardapio: $cardapio";
            oci_bind_by_name($statement, ":CD", $cardapio);
	    oci_bind_by_name($statement, ":CDP", $prato);         
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
	    $teste = true;
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $teste;
    }
    
    
    public function update (Cardapio $cardapio){
        require_once 'ConnectionFactory.class.php';
        $conn = new ConnectionFactory();   
        $teste = false;
        $conexao = $conn->getConnection();
        $sql_text = "UPDATE DBAADV.INTRA_CARDAPIO SET 
                     CD_TP_REFEICAO       = :CDP 
                    ,DT_CARDAPIO    = :DT                    
                     WHERE  CD_CARDAPIO = :CD ";
        try {
            $codigo      = $cardapio->getCodigo();
            $data        = $cardapio->getData();
            $tipo        = $cardapio->getTipo_Refeicao();
            $statement   = oci_parse($conexao, $sql_text);
            oci_bind_by_name($statement, ":CD", $codigo);
	    oci_bind_by_name($statement, ":DT", $data);
            oci_bind_by_name($statement, ":CDP", $tipo);            
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
            $teste = true;
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $teste;
    }

    public function  getCodigo($codigo){
                 $conn = new ConnectionFactory();   
                 $conexao = $conn->getConnection();
                 $i = 0;
		 $sql_text = "  SELECT    COUNT(*) CODIGO
                                    FROM     DBAADV.INTRA_CARDAPIO_POR_PRATOS C
                                            ,DBAADV.INTRA_PRATOS              P         
                                            ,DBAADV.INTRA_CARDAPIO            I         
                                            ,DBAADV.INTRA_TIPO_PRATO          T
                                 WHERE      C.CD_PRATO     = P.CD_PRATO
                                       AND  C.CD_CARDAPIO  = I.CD_CARDAPIO 
                                       AND  P.CD_TIPO_PRATO = T.CD_TIPO_PRATO
                                       AND  C.CD_CARDAPIO = :CD 
                                 ORDER BY   P.CD_TIPO_PRATO";
				
					try {
						
                                            $stmt = oci_parse($conexao, $sql_text);
                                            oci_bind_by_name($stmt, ":CD", $codigo);
                                            oci_execute($stmt);
                                              if ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                                                 $i = $row["CODIGO"]; 
                                              }
                                $conn->closeConnection($conexao);
				} catch (PDOException $ex) {
				//    echo "<script>  alert('Erro: ".$ex->getMessage()."')</script>";
                                    echo " Erro: ".$ex->getMessage();
			  }
            
        		return $i;
	}
        
      public function delete($cardapio, $prato){
          require_once 'ConnectionFactory.class.php';
          $teste = false;
          $conn = new ConnectionFactory();
          $connection = $conn->getConnection();
          $sql_text = "DELETE FROM DBAADV.INTRA_CARDAPIO_POR_PRATOS WHERE ROWID = :CD";
          $select = "SELECT ROWID FROM DBAADV.INTRA_CARDAPIO_POR_PRATOS R WHERE CD_CARDAPIO = :CD AND CD_PRATO = :CDP";
          try{
              $statement = oci_parse($connection, $select);
              oci_bind_by_name($statement, ":CD", $cardapio);
              oci_bind_by_name($statement, ":CDP", $prato);
              $rowid = oci_new_descriptor($connection, OCI_D_ROWID);
              oci_define_by_name($statement, "ROWID", $rowid);
              oci_execute($statement);
              while(oci_fetch($statement)){
                $nrows = oci_num_rows($statement);
                $delete = oci_parse($connection, $sql_text);
                oci_bind_by_name($delete, ":CD", $rowid, -1, OCI_B_ROWID);
                oci_execute($delete, OCI_COMMIT_ON_SUCCESS);       
              }
            $teste = true;
          } catch (PDOException $ex) {
              echo "Erro: ".$ex->getMessage();
          }
          return $teste;
      }
     
      public function  verificarDulicidade($card, $prato){
          require_once  'ConnectionFactory.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();
         $i = 0;
         $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO_POR_PRATOS I WHERE I.CD_CARDAPIO = :CD AND I.CD_PRATO = :CDP";
         try {
           $stmt = oci_parse($conexao, $sql_text);                                            
           oci_bind_by_name($stmt, ":CD", $card);
           oci_bind_by_name($stmt, ":CDP", $prato);
           oci_execute($stmt);
           if ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                $i = 1; 
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
           echo " Erro: ".$ex->getMessage();
        }
        return $i;
    }
    
    public function  lista_pratos($cardapio, $tipo_prato){
        require_once 'ConnectionFactory.class.php';
        require_once  '/servicos/CPPList.class.php';
        require_once 'beans/Cardapio_Por_Prato.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();                 
        // $cardapio = null;
         $cardapioList = new CPPList();
         try {
             
                 $sql_text = "    SELECT      C.CD_CARDAPIO, P.CD_PRATO, P.NM_PRATO, T.D_TIPO_PRATO, P.DS_INGREDIENTE 
                                    FROM     DBAADV.INTRA_CARDAPIO_POR_PRATOS C
                                            ,DBAADV.INTRA_PRATOS              P         
                                            ,DBAADV.INTRA_CARDAPIO            I  
                                            ,DBAADV.INTRA_TIPO_PRATO          T
                                 WHERE      C.CD_PRATO     = P.CD_PRATO
                                       AND  C.CD_CARDAPIO  = I.CD_CARDAPIO
                                       AND  P.CD_TIPO_PRATO = T.CD_TIPO_PRATO
                                       AND  C.CD_CARDAPIO = :CD
                                       AND  T.CD_TIPO_PRATO = :CDTP
                                 ORDER BY P.CD_TIPO_PRATO"    ;
                 $statement = oci_parse($conexao, $sql_text);
                 
                 oci_bind_by_name($statement, ":CD", $cardapio,-1);
                 oci_bind_by_name($statement, ":CDTP", $tipo_prato,-1);
             
              oci_execute($statement);
              while($row = oci_fetch_array($statement, OCI_ASSOC)){
                  $cpp = new Cardapio_Por_Prato();
                 
                  
                  include_once 'beans/Tipo_Refeicao.class.php';
                  include_once 'beans/Cardapio.class.php';
                  include_once 'beans/Tipo_Prato.class.php';
                  include_once '/beans/Prato.class.php';
                   $tp = new Tipo_Prato();
                   $prato = new Prato();
                  
                  $cpp->setCardapio($row["CD_CARDAPIO"]);
                  $tp->setDescricao($row["D_TIPO_PRATO"]);
                //  echo "Tipo de prato dao: ".$row["D_TIPO_PRATO"]."<br>";
                  $cpp->setTipo_prato($tp);
                  $prato->setCodigo($row["CD_PRATO"]);
                  $prato->setNome($row["NM_PRATO"]);  
               //   echo "Ingredientes: ".$row["DS_INGREDIENTE"];
                  $prato->setDs_ingrediente($row["DS_INGREDIENTE"]);
                  $cpp->setPrato($prato);
                  $cardapioList->addCardapio($cpp);
              }
               $conn->closeConnection($conexao);
         } catch (PDOException $ex) {
               echo "Erro: ".$ex->getMessage();
         }
         return $cardapioList;
    }
    
    
    public function  pratos_por_cardapio($cardapio){
        require_once 'ConnectionFactory.class.php';
        require_once  '../servicos/CPPList.class.php';
        require_once '../beans/Cardapio_Por_Prato.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();                 
        // $cardapio = null;
         $cardapioList = new CPPList();
         try {
             
                 $sql_text = "SELECT * FROM DBAADV.Intra_Cardapio_Por_Pratos c WHERE C.CD_CARDAPIO = :CD"    ;
                 $statement = oci_parse($conexao, $sql_text);
                 
                 oci_bind_by_name($statement, ":CD", $cardapio,-1);
                 
             
              oci_execute($statement);
              while($row = oci_fetch_array($statement, OCI_ASSOC)){
                  $cpp = new Cardapio_Por_Prato();
                 
                  
                  include_once '../beans/Cardapio_Por_Prato.class.php';
                  $cpp->setPrato($row['CD_PRATO']);
                  $cardapioList->addCardapio($cpp);
              }
               $conn->closeConnection($conexao);
         } catch (PDOException $ex) {
               echo "Erro: ".$ex->getMessage();
         }
         return $cardapioList;
    }
    
    public function  lista_tipo_pratos($cardapio){
        require_once 'ConnectionFactory.class.php';
        require '/servicos/TPList.class.php';
        require_once 'beans/Cardapio_Por_Prato.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();                 
        // $cardapio = null;
         $tplist = new TPList();
         try {
             
                 $sql_text = "    SELECT      DISTINCT T.CD_TIPO_PRATO,T.D_TIPO_PRATO
                                FROM     DBAADV.INTRA_CARDAPIO_POR_PRATOS C
                                        ,DBAADV.INTRA_PRATOS              P         
                                        ,DBAADV.INTRA_CARDAPIO            I  
                                        ,DBAADV.INTRA_TIPO_PRATO          T
                             WHERE      C.CD_PRATO     = P.CD_PRATO
                                   AND  C.CD_CARDAPIO  = I.CD_CARDAPIO
                                   AND  P.CD_TIPO_PRATO = T.CD_TIPO_PRATO
                                   AND  C.CD_CARDAPIO = :CD                           
                            ORDER BY T.CD_TIPO_PRATO"    ;
                 $statement = oci_parse($conexao, $sql_text);
                 
                 oci_bind_by_name($statement, ":CD", $cardapio,-1);
             
              oci_execute($statement);
              while($row = oci_fetch_array($statement, OCI_ASSOC)){
                  
                 
                  
                  include_once 'beans/Tipo_Refeicao.class.php';
                  include_once 'beans/Cardapio.class.php';
                  include_once 'beans/Tipo_Prato.class.php';
                  include_once '/beans/Prato.class.php';
                   $tr = new Tipo_Prato();
                  
                  $tr->setCodigo($row["CD_TIPO_PRATO"]);
                  $tr->setDescricao($row["D_TIPO_PRATO"]);
                  
                  $tplist->addTipo_Prato($tr);
              }
               $conn->closeConnection($conexao);
         } catch (PDOException $ex) {
               echo "Erro: ".$ex->getMessage();
         }
         return $tplist;
    }
    
    public function  lista_cardapio($desc){
        require_once 'ConnectionFactory.class.php';
        require '/servicos/CardapioList.class.php';
        require_once 'beans/Cardapio.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();                 
        // $cardapio = null;
         $cardapioList = new CardapioList();
         try {
             if($desc != ""){
                 $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO C, DBAADV.INTRA_TP_REFEICAO T WHERE  TO_CHAR(C.DT_CARDAPIO,'DD/MM/YYYY') = :DT
                              AND C.CD_TP_REFEICAO = T.CD_TP_REFEICAO"    ;
                 $statement = oci_parse($conexao, $sql_text);
                 
                 oci_bind_by_name($statement, ":DSTP", $desc,-1);
             }else{
                 $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO C, DBAADV.INTRA_TP_REFEICAO T WHERE C.CD_TP_REFEICAO = T.CD_TP_REFEICAO ";
                 $statement = oci_parse($conexao, $sql_text);	
             }
              oci_execute($statement);
              while($row = oci_fetch_array($statement, OCI_ASSOC)){
                  $cardapio = new Cardapio(); 
                  include_once 'beans/Tipo_Refeicao.class.php';
                  $cardapio->setCodigo($row["CD_CARDAPIO"]);
                  $cardapio->setData($row["DT_CARDAPIO"]);
                  $tipo_refeicao = new Tipo_Refeicao();
                  $tipo_refeicao->setCodigo($row["CD_TP_REFEICAO"]);
                  $tipo_refeicao->setDescricao($row["DS_TP_REFEICAO"]);
                  $cardapio->setTipo_Refeicao($tipo_refeicao);                  
                  $cardapioList->addCardapio($cardapio);
              }
               $conn->closeConnection($conexao);
         } catch (PDOException $ex) {
               echo "Erro: ".$ex->getMessage();
         }
         return $cardapioList;
    }
     
    
    public function  recuperar_cardapio($id){
        require_once 'ConnectionFactory.class.php';
        $conn = new ConnectionFactory();   
        $conexao = $conn->getConnection();   
        $cardapio = null;
       // echo "Codigo: $id";
        $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO C, DBAADV.INTRA_TP_REFEICAO T WHERE  C.CD_CARDAPIO = CD
                              AND C.CD_TP_REFEICAO = T.CD_TP_REFEICAO";
        try {
            $statement = oci_parse($conexao, $sql_text);         
            oci_bind_by_name($statement, ":CDTP", $id);
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $cardapio = new Cardapio(); 
                  include_once 'beans/Tipo_Cardapio.class.php';
                  $cardapio->setCodigo($row["CD_CARDAPIO"]);
                  $cardapio->setData($row["DT_CARDAPIO"]);
                  $tipo_refeicao = new Tipo_Refeicao();
                  $tipo_refeicao->setCodigo($row["CD_TP_REFEICAO"]);
                  $tipo_refeicao->setDescricao($row["DS_TP_REFEICAO"]);
                  $cardapio->setTipo_Refeicao($tipo_refeicao);       
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $cardapio;
    }
    
     public function  contarRegistros(){
        $conn = new ConnectionFactory();   
        $conexao = $conn->getConnection();   
        $cardapio = 0;
        $sql_text = "SELECT COUNT(*) TOTAL FROM DBAADV.INTRA_CARDAPIO ";
        try {
            $statement = oci_parse($conexao, $sql_text);                     
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $cardapio = $row["CD_TP_REFEICAO"];
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $cardapio;
    }
} // fim da classe