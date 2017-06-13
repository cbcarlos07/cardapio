<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//ela herdará os métodos e atributos do PDO através da palavra-chave extends
class ConnectionFactorySQL extends PDO {
    //private $dsn = 'dblib:host=10.51.26.2;dbname=APS';
    private $dsn = 'DRIVER={SQL Server};SERVER=10.51.27.171;DATABASE=MIX';
   // private $dsn;
    //$db = new PDO('odbc:Driver=FreeTDS; Server=hostname_or_ip; Port=port; Database=database_name; UID=username; PWD=password;');
//DRIVER={SQL Server};SERVER=sq200.ha.6ps.com;DATABASE=Express
    private $username = 'ham';
    private $pwd = 'mix1844';
    public $handle = null;
    private $db = null;
    private $hostname = 'srvbdcacs';
    private $dbname = 'mix';

    function __construct() {
        try {
            //aqui ela retornará o PDO em si, veja que usamos parent::_construct()
//            if ($this->handle == null) {
//                $connection = mssql_connect($this->dsn,$$this->user, $this->password);
//                //new PDO('mysql:host=localhost;dbname=exemplo;', 'usuário', 'senha'); 
//                //$dbh = parent::__construct($this->dsn, $this->user, $this->password);
//                //$dbh =  new PDO('odbc:Driver=FreeTDS; Server=hostname_or_ip; Port=port; Database=database_name; UID=username; PWD=password;');
//                //$this->handle = $dbh;
//                $this->handle = $connection;
//                return $this->handle;
//            }
            
            //$this->db = new PDO ("dblib:host=$this->hostname;dbname=$this->dbname", "$this->username", "$this->pwd");
            $this->db = new PDO('odbc:Driver={SQL Server};Server=10.51.27.171;Database=MIX; Uid=ham;Pwd=mix1844');
        } catch (PDOException $e) {
            echo 'Conexão falhou. Erro: ' . $e->getMessage();
            return false;
        }
    }

    //aqui criamos um objeto de fechamento da conexão
    function __destruct() {
        $this->handle = NULL;
    }

}