<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Agenda_DAO {
    
    public function  getCodigo($codigo){
                require_once 'ConnectionFactory.class.php';
                
                 $conn = new ConnectionFactory();   
                 $conexao = $conn->getConnection();
                 $i = 0;
		 $sql_text = "SELECT COUNT(*) TOTAL FROM DBAADV.INTRA_AGENDAMENTO I WHERE I.CD_CARDAPIO = :CD";
				
					try {
						
                                            $stmt = oci_parse($conexao, $sql_text);
                                            oci_bind_by_name($stmt, ":CD", $codigo);
                                            oci_execute($stmt);
                                              if ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                                                 $i = $row["TOTAL"]; 
                                              }
                                $conn->closeConnection($conexao);
				} catch (PDOException $ex) {
				//    echo "<script>  alert('Erro: ".$ex->getMessage()."')</script>";
                                    echo " Erro: ".$ex->getMessage();
			  }
            
        		return $i;
	}
        
        
        public function  getLista($codigo, $nome){
                require_once 'ConnectionFactory.class.php';
                require_once './servicos/AgendaList.class.php';
                 $conn = new ConnectionFactory();   
                 $conexao = $conn->getConnection();
                 
		 $sql_text = "SELECT * FROM DBAADV.INTRA_AGENDAMENTO I WHERE I.CD_CARDAPIO = :CD AND I.NM_FUNCIONARIO LIKE :NM";
				
                try {

                        $stmt = oci_parse($conexao, $sql_text);
                        oci_bind_by_name($stmt, ":CD", $codigo);
                        oci_bind_by_name($stmt, ":NM", $nome);
                        oci_execute($stmt);
                        $agendaList = new AgendaList();
                        while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                             $agenda = new Agenda();
                             $agenda->setCardapio($row['CD_CARDAPIO']);
                             $agenda->setCod_Funcionario($row['CD_FUNCIONARIO']);
                             $agenda->setNm_Funcionario($row['NM_FUNCIONARIO']);
                             
                             $agendaList->addAgenda($agenda);
                          }
                        $conn->closeConnection($conexao);
                        } catch (PDOException $ex) {
                        //    echo "<script>  alert('Erro: ".$ex->getMessage()."')</script>";
                            echo " Erro: ".$ex->getMessage();
                  }
            
        		return $agendaList;
	}
}