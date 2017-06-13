<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$chapa = $_GET['chapa'];
$data  = $_GET['data'];
 $p= new PDO('odbc:Driver={SQL Server};Server=SRVBDCACS;Database=mix; Uid=ham;Pwd=mix1844');  
                 $status = "N";
                
                 echo "Data original: $data <br>";
                 $datas = explode('/', $data);
                 $dia = $datas[0];
                 $mes = $datas[1];
                 $ano = $datas[2];
                 $dataUSA = $mes."/".$dia."/".$ano; 
                 $novaData = date('Y-m-d',  strtotime($dataUSA));
                
                 echo "Data no getAlmocou: ".$novaData."<br>";
                 echo "Chapa get Almocou: $chapa";
                 $query = "
                                select CRH_CODIGO CODIGO
                                      ,PTR_CODIGO
                                      ,PMA_TIPOMARCREF
                                      ,PMA_DATAHORA_GRAV

                                from mix.dbo.pt_marcacao
                                where crh_codigo = $chapa
                                  AND CAST(PMA_DATAHORA_GRAV AS DATE) = '$novaData'
                                  AND CLO_NUMERO = 1  
                                  AND TPC_CODIGO = 99 
                                  AND PTR_CODIGO = 2  
                                ORDER BY PMA_DATAHORA_GRAV DESC";
                 try {
                    $stmt = $p->prepare($query);
			 
                          $return = $stmt->execute();
                          if($return > 0){
                              $result = $stmt->fetch();
                              $nome = $result['CODIGO'];
                              if($nome!= "")
                               $status = "S";
                          }
//                        
                        } catch (PDOException $ex) {
                        //    echo "<script>  alert('Erro: ".$ex->getMessage()."')</script>";
                            echo " Erro: ".$ex->getMessage();
                  }
                  echo "<br>Query: $query";
                  echo "<br>Nome: $nome";
                echo "<br>Retorno: $return";