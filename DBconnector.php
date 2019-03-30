<?php
class DbConnector {

  //DB connection
  const USER = 'root';
	const PWD = '';
	const DBNAME = 'confuciopadova';
	const HOST = 'localhost';

	public $connected = false;//used to know current status
	private $db;//database

  //return true if successufully connects to database
	public function openDBConnection() {
		$this->db = new mysqli(static::HOST, static::USER, static::PWD, static::DBNAME);
		if($this->db->connect_error)
    {
			$this->connected =false;
			return false;
		}
    else
		  $this->connected= true;
		$this->db->set_charset('utf8mb4');
		return true;
	}

  //close connection to the database
	public function disconnect(){
		$this->connected=false;
		$this->db->close();
	}

	//execute the query and return the result
	public function doQuery($q){
		$query=mysqli_real_escape_string($this->db, $q);
		$result = $this->db->query($q);
		return $result;
	}

}
?>
