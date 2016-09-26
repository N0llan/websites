<?php 

class dbConn{
	
	function __construct(){
		$this->dbName = 'postgres';
		$this->dbPort = '5432';
		$this->dbHost = '127.0.0.1';
		$this->dbUser = 'postgres';
		require ('dbPassword.php');
		$this->dbPass = $password;
		$this->dbConnected;
	}
	
	public function connectDB(){
		$this->dbConnected = pg_connect("host=$this->dbHost port=$this->dbPort dbname=$this->dbName user=$this->dbUser password=$this->dbPass");
		if ($this->dbConnected){
			return true;
		} else {
			return false;
		}
	}

	public function disconnectDB(){
		if ($dbConnected != NULL){
			return pg_close();
		}
		return 0;
	}

	public function queryDB($query){
		return pg_query($this->dbConnected,$query);
	}

}

?>