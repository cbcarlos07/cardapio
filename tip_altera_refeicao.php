<?php
 include './beans/Tipo_Refeicao.class.php';
 include './controller/Tipo_Refeicao_Controller.class.php';
 $var = $_GET['codigo'];
 $valor = explode("|", $var);
 $codigo     = $valor[0];
 $url     = $valor[1];
 
 $tp = new Tipo_Refeicao();
 $tpc = new Tipo_Refeicao_Controller();
 $tp = $tpc->recuperar_tipo($codigo);
 
         
?>

<html>
    <head>
        <title>Menu de Cadastro de Card&aacute;pio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="img/ham.ico" rel="short icon">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/table.css" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    </head>
    <body>
       
                    <div id="main" class="container" >
                        
                         <div class="col-md-10">
                                    <h1 class="text-center alterar">Alterar Registro</h1>
                                    <form action="acao/tr_action.php" method="POST" name="form1">
                                         <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
                                           <input type="hidden" name="acao" value="A">
                                           <input type="hidden" name="url" value="<?php echo $url; ?>" >
                                       <div class="form-group">                                   
                                           <label class="alterar" for="descricao">Descri&ccedil;&atilde;o</label>
                                           <input name="descricao" id="descricao" class="form-control" value="<?php echo $tp->getDescricao(); ?>">
                                      </div>
                                      <div class="form-group">     
                                           <label class="alterar" for="hora">Horário</label>
                                           <input name="horainicial" id="hora" class="form-control" value="<?php echo $tp->getHorarioInicial(); ?>">
                                      </div>        
                                       <div class="form-group">     
                                           <label class="alterar" for="hora">Horário Final</label>
                                           <input name="horafinal" id="hora1" class="form-control" value="<?php echo $tp->getHorarioFinal(); ?>">
                                      </div>

                                        <button class="btn btn-primary" type="submit" value="submit">Salvar</button>
                                   </form>

                               </div>
                            
                </div>
        
        <script src="js/jquery.min.js"></script>        
        <script src="js/jquery.datetimepicker.full.js"></script>
        <script>
            
            $("#hora").datetimepicker({
                datepicker: false, 
                format: 'H:i',
                allowTimes:[
                            '06:15', '07:00', '07:15', 
                            '11:00', '11:15', '14:00', '14:15', '21:00',
                            '22:00'
                           ],
                mask: true           
                           
                
            });
            $.datetimepicker.setLocale('pt-BR');
            
            
        </script>
        <script>
            
            $("#hora1").datetimepicker({
                datepicker: false,
                format: 'H:i',
                allowTimes:[
                            '06:15', '07:00', '07:15', 
                            '11:00', '11:15', '14:00', '14:15', '21:00',
                            '22:00'
                           ],
                mask: true           
            });
            $.datetimepicker.setLocale('pt-BR');
            
            
        </script>
        
        
    </body> 
    
   
</html>
    
    