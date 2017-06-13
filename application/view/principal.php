<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../public/css/css.css">
        <script type="text/javascript" src="../../public/js/js.js"></script>
    </head>
    <body>
        <form name="form1" action="pegardados.php" method="post">
                <div class="conteudo" bgcolo="#029393">
                    <h2>Cardápio: Terça - Feira (16/02/2016)</h2><h3>Almoço/Jantar</h3>

                    <div class="table">
                        <table>
                            <tr id="title">
                                <td align="center" colspan="2">Salada</td>                        
                            </tr>
                            <tr>
                                <td>Alface</td><td><a href="#">remover</a></td>                        
                            </tr>
                            <tr>
                                <td>Cenoura Ralada</td><td><a href="#">remover</a></td>                        
                            </tr>
                            <tr>
                                <td>Couve Flor Temperada com salsinha</td><td><a href="#">remover</a></td>                        
                            </tr>
                            <tr>
                                <td>Torrada</td><td><a href="#">remover</a></td>
                            </tr>
                            <tr>
                                <td><div id="campoPai"></div></td><td><div id="campoPai_"></div></td>
                            </tr>
                            <tr>
                                <td></td><td><input type="button" value="Adicionar outro" onclick="addCampos()"></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </form>
    </body>
    
</html>
