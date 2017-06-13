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
		         //$sql_text = "SELECT COUNT(*) TOTAL FROM DBAADV.INTRA_AGENDAMENTO I WHERE I.CD_CARDAPIO = :CD";
				 $sql_text = "   SELECT count(*) TOTAL
                 FROM (
                      SELECT CD_FUNCIONARIO
                            ,NM_FUNCIONARIO
                            ,MAX(DT_OPERACAO)                                                DT_OPERACAO
                            ,MAX(TP_STATUS) KEEP (DENSE_RANK LAST ORDER BY DT_OPERACAO)      STATUS
                        FROM INTRA_AGENDAMENTO 
                       WHERE CD_CARDAPIO = :CD                      
                   GROUP BY CD_FUNCIONARIO
                           ,NM_FUNCIONARIO
                       ) 
                 WHERE STATUS = 'A'";
				
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
                //echo "Cod card dao: $codigo<br>";
                //echo "Nome do dao: $nome";
                require_once 'ConnectionFactory.class.php';
                require_once './servicos/AgendaList.class.php';
                 $conn = new ConnectionFactory();   
                 $conexao = $conn->getConnection();
                 
		 //$sql_text = "SELECT * FROM DBAADV.INTRA_AGENDAMENTO I WHERE I.CD_CARDAPIO = :CD AND I.NM_FUNCIONARIO LIKE :NM";
		   $sql_text = "            
               SELECT *
                 FROM (
                      SELECT CD_FUNCIONARIO
					         ,CD_CARDAPIO
                            ,NM_FUNCIONARIO
                            ,MAX(DT_OPERACAO)                                                DT_OPERACAO
                            ,MAX(TP_STATUS) KEEP (DENSE_RANK LAST ORDER BY DT_OPERACAO)      STATUS
                        FROM INTRA_AGENDAMENTO 
                       WHERE CD_CARDAPIO = :CD
                       AND   NM_FUNCIONARIO LIKE :NM
                   GROUP BY CD_FUNCIONARIO
                           ,NM_FUNCIONARIO
			 ,CD_CARDAPIO
                          ORDER BY 3
                       ) 
                 WHERE STATUS = 'A'";	
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
        
        public function  getAlmocou($data, $chapa, $refeicao){
                 
                $p= new PDO('odbc:Driver={SQL Server};Server=10.51.27.171;Database=mix; Uid=ham;Pwd=mix1844');  
                 $status = "N";
                
                 //$datas = explode("/", $data);
                 //$dia = $datas[0];
                 //$mes = $datas[1];
                 //$ano = $datas[2];
                 //$novaDB = $ano."-".$mes."-".$dia;
                
                 //echo "Data no getAlmocou: ".$novaDB."<br>";
                 //echo "Chapa get Almocou: $chapa";
                 
                 if($refeicao == 5){
                     $refeicao = 2;
                 }else if($refeicao == 6){
                     $refeicao = 3;
                 }
                 
                 $query = "
                                select CRH_CODIGO CODIGO
                                      ,PTR_CODIGO
                                      ,PMA_TIPOMARCREF
                                      ,PMA_DATAHORA_GRAV

                                from mix.dbo.pt_marcacao
                                where crh_codigo = $chapa
                                  AND CONVERT( CHAR(10), PMA_DATAHORA_GRAV, 103 ) = '$data'
                                  AND CLO_NUMERO = 1  
                                  AND TPC_CODIGO = 99 
                                  AND PTR_CODIGO = $refeicao 
                                ORDER BY PMA_DATAHORA_GRAV DESC";
                 try {
                    $stmt = $p->prepare($query);
			  //$stmt->bindParam(1, $chapa);
                          
                          //$stmt->bindParam(':CHAPA', $chapa, PDO::PARAM_STR,-1 );
                          //$stmt->bindParam(':DATA_', $data, PDO::PARAM_STR,-1 );
//                          $stmt->bindValue(2,  $data);	
                          $retorno = $stmt->execute();
                          if($retorno > 0){
                             $result = $stmt->fetch();
                              $nome = $result['CODIGO'];
                              if($nome != "")
                               $status = "S";
                          }
//                        
                        } catch (PDOException $ex) {
                        //    echo "<script>  alert('Erro: ".$ex->getMessage()."')</script>";
                            echo " Erro: ".$ex->getMessage();
                  }
            //      echo "<br>Query: $query";
            //echo "<br>Retorno: $retorno";
            //echo "<br>Nome: $nome";
        		return $status;
	}



    public function  getEmail($cd){
        require_once  'ConnectionFactory.class.php';
        require_once  '../beans/Agenda.class.php';
        require_once  '../servicos/AgendaList.class.php';
        $conn = new ConnectionFactory();
        $conexao = $conn->getConnection();
        $agenda = null;
        $agendaList = new AgendaList();
        $i = 0;
        $sql_text = "
                    
                          SELECT *
                             FROM (
                                  SELECT A.CD_FUNCIONARIO
                                        ,A.CD_CARDAPIO
                                        ,A.NM_FUNCIONARIO
                                        ,MAX(A.DT_OPERACAO)                                                DT_OPERACAO
                                        ,MAX(A.TP_STATUS) KEEP (DENSE_RANK LAST ORDER BY DT_OPERACAO)      STATUS
                                        ,A.DS_EMAIL
                                        ,C.DT_CARDAPIO
                                        ,T.DS_TP_REFEICAO
                                    FROM INTRA_AGENDAMENTO A
                                        ,INTRA_CARDAPIO    C 
                                        ,INTRA_TP_REFEICAO T
                                   WHERE A.CD_CARDAPIO = :CODIGO
                                   AND   C.CD_CARDAPIO = A.CD_CARDAPIO
                                   AND   T.CD_TP_REFEICAO = C.CD_TP_REFEICAO
                        
                               GROUP BY A.CD_FUNCIONARIO
                                       ,A.NM_FUNCIONARIO
                                       ,A.CD_CARDAPIO
                                       ,A.DS_EMAIL
                                       ,C.DT_CARDAPIO
                                       ,T.DS_TP_REFEICAO
                                      ORDER BY 3
                                      
                                   ) 
                             WHERE STATUS = 'A'
                          
                    ";
        //AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))

        try {

            $stmt = oci_parse($conexao, $sql_text);
            oci_bind_by_name($stmt, ":CODIGO", $cd);
            oci_execute($stmt);
          //  $fp = fopen("bloco_dao.txt", "a");

            $nomes = "\r\n";
            while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                $agenda = new Agenda();
                $email = "";

                if(isset($row['DS_EMAIL']))
                    $email = $row['DS_EMAIL'];
                $agenda->setCod_Funcionario($row['CD_FUNCIONARIO']);
                $agenda->setNm_Funcionario($row['NM_FUNCIONARIO']);
                $nomes .= $row['NM_FUNCIONARIO']."\r\n";
                $agenda->setDsEmail($email);
                $agenda->setCardapio($row['DT_CARDAPIO']);
                $agenda->setRefeicao($row['DS_TP_REFEICAO']);
                $agendaList->addAgenda($agenda);

            }
            // Escreve "exemplo de escrita" no bloco1.txt
          //  $escreve = fwrite($fp, $nomes);

            // Fecha o arquivo
              //          fclose($fp);
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $agendaList;
    }

    public function getEmailFuncionario($cracha){

        $p= new PDO('odbc:Driver={SQL Server};Server=10.51.26.2;Database=APS; Uid=sa;Pwd=1844');


        $stmt = $p->prepare("select pe.char_0 EMAIL
                               from Person p
                                join Enrollment e on (p.id_person = e.id_person)
                                join Enrollment_Employee ee on (e.id_enrollment = ee.id_enrollment)
                                join Person_Email pe on (pe.id_person = p.id_person) 
                               where
                                 p.id_object_class = 97404
                                 and ee.int_2 = $cracha
								 and pe.bit_0 = 1");

        //$stmt->bindParam(':codigo', $usuario,PDO::PARAM_STR);
        $retorno = $stmt->execute();

        if($retorno > 0){
            $result = $stmt->fetch();
            //echo $result['Nome'];
            $email = $result['EMAIL'];
        }else{
            $email = "N";
        }
        // echo "Nome : ". utf8_encode($nome);
        return  utf8_encode($email);
    }

    public function  getTotalAgendados($cd){
        require_once  'ConnectionFactory.class.php';
        $conn = new ConnectionFactory();
        $conexao = $conn->getConnection();

        $i = 0;
        $sql_text = "
                    
                          SELECT COUNT(*) TOTAL
                             FROM (
                                  SELECT CD_FUNCIONARIO
                                        ,CD_CARDAPIO
                                        ,NM_FUNCIONARIO
                                        ,MAX(DT_OPERACAO)                                                DT_OPERACAO
                                        ,MAX(TP_STATUS) KEEP (DENSE_RANK LAST ORDER BY DT_OPERACAO)      STATUS
                                        ,DS_EMAIL
                                    FROM INTRA_AGENDAMENTO 
                                   WHERE CD_CARDAPIO = :CODIGO
                                   
                               GROUP BY CD_FUNCIONARIO
                                       ,NM_FUNCIONARIO
                                       ,CD_CARDAPIO
                                       ,DS_EMAIL
                                      ORDER BY 3
                                      
                                   ) 
                             WHERE STATUS = 'A'
                          
                    ";
        //AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))

        try {

            $stmt = oci_parse($conexao, $sql_text);
            oci_bind_by_name($stmt, ":CODIGO", $cd);
            oci_execute($stmt);
            if ($row = oci_fetch_array($stmt, OCI_ASSOC)){
               $i = $row['TOTAL'];
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $i;
    }


}