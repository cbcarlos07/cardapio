<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prato_DAO {
    
    
    public function insert (Prato $tp){
        require_once 'ConnectionFactory.class.php';
        $teste = false;
        $conn = new ConnectionFactory();   
        $conexao = $conn->getConnection();
        $sql_text = "INSERT INTO DBAADV.INTRA_PRATOS (CD_PRATO, NM_PRATO, CD_TIPO_PRATO, DS_INGREDIENTE)
		     VALUES (:CD, :DSTP, :CDTP, :INGREDIENTE )";
        try {
           // echo "Nome: ".
            $codigo      = $this->getCodigo();
            $descricao   = $tp->getNome();
            $prato        = $tp->getTipo_prato();
            $ingrediente = $tp->getDs_ingrediente();
            $statement   = oci_parse($conexao, $sql_text);
            oci_bind_by_name($statement, ":CD", $codigo);
	    oci_bind_by_name($statement, ":DSTP", $descricao);
            oci_bind_by_name($statement, ":CDTP", $prato);
            oci_bind_by_name($statement, ":INGREDIENTE", $ingrediente);
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
	    $teste = true;
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $teste;
    }
    
    
    public function update (Prato $tp){
        require_once 'ConnectionFactory.class.php';
        $conn = new ConnectionFactory();   
        $teste = false;
        $conexao = $conn->getConnection();
        $sql_text = "UPDATE DBAADV.INTRA_PRATOS SET 
                     NM_PRATO       = :DSTP 
                    ,CD_TIPO_PRATO  = :CDTP
                    ,DS_INGREDIENTE = :INGREDIENTE
                     WHERE CD_PRATO = :CD ";
        try {
            $codigo      = $tp->getCodigo();
            $descricao   = $tp->getNome();
            $prato        = $tp->getTipo_prato();
            $ingrediente = $tp->getDs_ingrediente();
            $statement   = oci_parse($conexao, $sql_text);
            oci_bind_by_name($statement, ":CD", $codigo);
	    oci_bind_by_name($statement, ":DSTP", $descricao);
            oci_bind_by_name($statement, ":CDTP", $prato);
            oci_bind_by_name($statement, ":INGREDIENTE", $ingrediente);
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
		 $sql_text = "SELECT DBAADV.SEQ_INTRA_PRATOS.NEXTVAL CODIGO FROM DUAL";
				
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
          $sql_text = "DELETE FROM DBAADV.INTRA_PRATOS WHERE ROWID = :CDTP";
          $select = "SELECT ROWID FROM DBAADV.INTRA_PRATOS R WHERE CD_PRATO = :CDTP";
          try{
              echo "<br> Codigo pra excluir: $codigo";
              $statement = oci_parse($connection, $select);
              oci_bind_by_name($statement, ":CDTP", $codigo);
              $rowid = oci_new_descriptor($connection, OCI_D_ROWID);
              oci_define_by_name($statement, "ROWID", $rowid);
              oci_execute($statement);
              while(oci_fetch($statement)){
                $nrows = oci_num_rows($statement);
                $delete = oci_parse($connection, $sql_text);
                oci_bind_by_name($delete, ":CDTP", $rowid, -1, OCI_B_ROWID);
                oci_execute($delete, OCI_COMMIT_ON_SUCCESS);       
              }
            $teste = true;
          } catch (PDOException $ex) {
              echo "Erro: ".$ex->getMessage();
          }
          return $teste;
      }
      
      public function  verificarDulicidade($descricao){
          require_once  'ConnectionFactory.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();
         $i = 0;
         $sql_text = "SELECT * FROM DBAADV.INTRA_PRATOS I WHERE I.NM_PRATO = :DSTP ";
         try {
           $stmt = oci_parse($conexao, $sql_text);                                            
           oci_bind_by_name($stmt, ":DSTP", $descricao);
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
    
    public function  lista_prato($desc){
        require_once 'ConnectionFactory.class.php';
        require '/servicos/PratoList.class.php';
        require_once 'beans/Prato.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();                 
        // $prato = null;
         $pratoList = new PratoList();
         try {
             if($desc != ""){
                 $sql_text = "SELECT * FROM DBAADV.INTRA_PRATOS I, DBAADV.INTRA_TIPO_PRATO T WHERE I.NM_PRATO LIKE :DSTP AND I.CD_TIPO_PRATO = T.CD_TIPO_PRATO";
                 $statement = oci_parse($conexao, $sql_text);
                 $parametro = "%".$desc."%";
                 oci_bind_by_name($statement, ":DSTP", $parametro,-1);
             }else{
                 $sql_text = "SELECT * FROM DBAADV.INTRA_PRATOS I, DBAADV.INTRA_TIPO_PRATO T WHERE I.CD_TIPO_PRATO = T.CD_TIPO_PRATO ORDER BY 1";
                 $statement = oci_parse($conexao, $sql_text);	
             }
              oci_execute($statement);
              while($row = oci_fetch_array($statement, OCI_ASSOC)){
                  $prato = new Prato(); 
                  include_once 'beans/Tipo_Prato.class.php';
                  $prato->setCodigo($row["CD_PRATO"]);
                  $prato->setNome($row["NM_PRATO"]);
                  $tipo_prato = new Tipo_Prato();
                  $tipo_prato->setCodigo($row["CD_TIPO_PRATO"]);
                  $tipo_prato->setDescricao($row["D_TIPO_PRATO"]);
                  $prato->setTipo_prato($tipo_prato);
                  $prato->setDs_ingrediente($row["DS_INGREDIENTE"]);
                  $pratoList->addPrato($prato);
              }
               $conn->closeConnection($conexao);
         } catch (PDOException $ex) {
               echo "Erro: ".$ex->getMessage();
         }
         return $pratoList;
    }
     
    
    public function  recuperar_prato($id){
        require_once 'ConnectionFactory.class.php';
        $conn = new ConnectionFactory();   
        $conexao = $conn->getConnection();   
        $prato = null;
       // echo "Codigo: $id";
        $sql_text = "SELECT * FROM DBAADV.INTRA_PRATOS I , DBAADV.INTRA_TIPO_PRATO T WHERE I.CD_PRATO = :CDTP  AND I.CD_TIPO_PRATO = T.CD_TIPO_PRATO";
        try {
            $statement = oci_parse($conexao, $sql_text);         
            oci_bind_by_name($statement, ":CDTP", $id);
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $prato = new Prato();
                include_once 'beans/Tipo_Prato.class.php';
                $prato->setCodigo($row["CD_PRATO"]);
                $prato->setNome($row["NM_PRATO"]);
                $tipo_prato = new Tipo_Prato();
                $tipo_prato->setCodigo($row["CD_TIPO_PRATO"]);
                $tipo_prato->setDescricao($row["D_TIPO_PRATO"]);
                $prato->setTipo_prato($tipo_prato);
                $prato->setDs_ingrediente($row["DS_INGREDIENTE"]);
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $prato;
    }
    
     public function  contarRegistros(){
        $conn = new ConnectionFactory();   
        $conexao = $conn->getConnection();   
        $prato = 0;
        $sql_text = "SELECT COUNT(*) TOTAL FROM DBAADV.INTRA_PRATOS ";
        try {
            $statement = oci_parse($conexao, $sql_text);                     
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $prato = $row["CD_PRATO"];
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo "Erro: ".$ex->getMessage();
        }
        return $prato;
    }
    
     public function  verificarCadastro($cd){
          require_once  'ConnectionFactory.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();
         $i = 0;
         $sql_text = "SELECT * FROM DBAADV.INTRA_CARDAPIO_POR_PRATOS D
                        WHERE D.CD_PRATO = :CD";
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
} // fim da classe