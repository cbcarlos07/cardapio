<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cardapio_DAO {
    
    
    public function insert (Cardapio $cardapio){
        require_once 'ConnectionFactory.class.php';
        $teste = false;
        $conn = new ConnectionFactory();   
        $conexao = $conn->getConnection();
        $sql_text = "INSERT INTO DBAADV.INTRA_CARDAPIO (CD_CARDAPIO, DT_CARDAPIO, CD_TP_REFEICAO )
		     VALUES (:CD, to_date(:DT,'DD/MM/YYYY'), :CDP )";
        try {
           // echo "Nome: ".
            //AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
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
    
    public function publicar ($cardapio, $opcao){
        require_once 'ConnectionFactory.class.php';
        $conn = new ConnectionFactory();   
        $teste = false;
        $conexao = $conn->getConnection();
        $sql_text = "UPDATE DBAADV.INTRA_CARDAPIO SET 
                     SN_PUBLICADO      = :CDP 
                     WHERE  CD_CARDAPIO = :CD ";
        try {
            
            $statement   = oci_parse($conexao, $sql_text);
            oci_bind_by_name($statement, ":CDP", $opcao);
            oci_bind_by_name($statement, ":CD", $cardapio);
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
            $teste = true;
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $teste;
    }

    public function  getCodigo(){
                 $conn = new ConnectionFactory();   
                 $conexao = $conn->getConnection();
                 $i = 0;
		 $sql_text = "SELECT DBAADV.SEQ_INTRA_CARDAPIO.NEXTVAL CODIGO FROM DUAL";
				
					try {
						
                                            $stmt = oci_parse($conexao, $sql_text);
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
        
      public function delete($codigo){
          require_once 'ConnectionFactory.class.php';
          $teste = false;
          $conn = new ConnectionFactory();
          $connection = $conn->getConnection();
          $sql_text = "DELETE FROM DBAADV.INTRA_CARDAPIO WHERE ROWID = :CD";
          $select = "SELECT ROWID FROM DBAADV.INTRA_CARDAPIO R WHERE CD_CARDAPIO = :CD";
          try{
              $statement = oci_parse($connection, $select);
              oci_bind_by_name($statement, ":CD", $codigo);
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
     
      public function  verificarDulicidade($data, $cd){
          require_once  'ConnectionFactory.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();
         $i = 0;
         $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO I WHERE
                     to_char(I.DT_CARDAPIO,'DD/MM/YYYY') = NVL(:DT,TO_CHAR(SYSDATE,'DD/MM/YYYY')) AND I.CD_TP_REFEICAO = :CD";
         //AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
         echo "<br>Data no dao: ".  $data."<br>";
         try {
             
           $stmt = oci_parse($conexao, $sql_text);                                            
           oci_bind_by_name($stmt, ":DT", $data);
           oci_bind_by_name($stmt, ":CD", $cd);
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
    
    public function  verificarCadastro($cd){
          require_once  'ConnectionFactory.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();
         $i = 0;
         $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO_POR_PRATOS D
                        WHERE D.CD_CARDAPIO = :CD";
         try {
           $stmt = oci_parse($conexao, $sql_text);                                            
           
           oci_bind_by_name($stmt, ":CD", $cd);
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
    
    public function  lista_cardapio($desc){
        require_once 'ConnectionFactory.class.php';
        require '/servicos/CardapioList.class.php';
        require_once 'beans/Cardapio.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();                 
        // $cardapio = null;
         $cardapioList = new CardapioList();
         try {
             if($desc != "%"){
                 $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO C, DBAADV.INTRA_TP_REFEICAO T WHERE  TO_CHAR(C.DT_CARDAPIO,'DD/MM/YYYY') = :DT
                              AND C.CD_TP_REFEICAO = T.CD_TP_REFEICAO ORDER BY 1 DESC"    ;
                 $statement = oci_parse($conexao, $sql_text);
                 
                 oci_bind_by_name($statement, ":DT", $desc,-1);
             }else{
                 $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO C, DBAADV.INTRA_TP_REFEICAO T WHERE C.CD_TP_REFEICAO = T.CD_TP_REFEICAO ORDER BY 1 DESC";
                 $statement = oci_parse($conexao, $sql_text);	
             }
              oci_execute($statement);
              while($row = oci_fetch_array($statement, OCI_ASSOC)){
                  $cardapio = new Cardapio(); 
                  include_once 'beans/Tipo_Refeicao.class.php';
                  $cardapio->setCodigo($row["CD_CARDAPIO"]);
                  $cardapio->setData($row["DT_CARDAPIO"]);
                  $cardapio->setPublicado($row["SN_PUBLICADO"]);
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
        $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO C, DBAADV.INTRA_TP_REFEICAO T WHERE  C.CD_CARDAPIO = :CD";
        try {
            $statement = oci_parse($conexao, $sql_text);         
            oci_bind_by_name($statement, ":CD", $id);
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $cardapio = new Cardapio(); 
                  
                  $cardapio->setCodigo($row["CD_CARDAPIO"]);
                  $cardapio->setData($row["DT_CARDAPIO"]);
                  $cardapio->setPublicado($row["SN_PUBLICADO"]);
                       
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