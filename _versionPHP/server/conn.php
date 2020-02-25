<?php 
session_start();
Class _MySQL {

	private $servername = "localhost";
	private $username = "nxtu";
	private $password = "conexion1";
	public $conn = "";
	function __construct()
	{
		try {
		    $this->conn = new PDO("mysql:host=".$this->servername.";dbname=p_agenda", $this->username, $this->password);
		    // set the PDO error mode to exception
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    }
		catch(PDOException $e)
	    {
	    	echo "Connection failed: " . $e->getMessage();
	    }
	}
    public function getFields($table,$campos="*",$where=null,$join='')
    {
    	if($where){
    		$sql = $this->conn->prepare("select ".$campos." from ".$table.$join." where ".$where);
    	}else{
    		$sql = $this->conn->prepare("select ".$campos." from ".$table.$join);
    	}
    	$sql->execute();

	    // set the resulting array to associative
	    $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
	    $rows = $sql->fetchAll();
	    return $rows;
    }
    public function createResponse($success,$msg="",$data="")
    {
    	echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
    }
    public function request($variable)
	{
		if(isset($_REQUEST[$variable]))
		{
			return $_REQUEST[$variable];
		} else
		{
			return false;
		}
	}
    public function crypt_blowfish($password, $digito = 7) 
    {
        $set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $salt = sprintf('$2a$%02d$', $digito);
        for($i = 0; $i < 22; $i++)
        {
         $salt .= $set_salt[mt_rand(0, 22)];
        }
        return crypt($password, $salt);
    }
    public function validatePassword($password, $passBD)
    {
    	if(crypt($password, $passBD)==$passBD)
    	{
    		return true;
    	}
    	return false;
    }
}

Class Events extends _MySQL
{
	function all()
	{
		$user = isset($_SESSION['id']);
		$data = null;
		$msj = "Credenciales incorrectas";
		$exists = $this->getFields("events", "id,titulo as `title`, date_init as `start`, date_finish as `end`, allday as allDay", "user = '".$_SESSION['id']."'");
		if(count($exists)>0)
		{
			foreach ($exists as $key => $value) {
				if($value['allDay']==1)
				{
					$exists[$key]['allDay']=true;
				}else{
					$exists[$key]['allDay']=false;
				}
			}
			$data=$exists;
			$msj = "Eventos encontrados";
		}
		$this->createResponse($user, $msj, $data);
	}
	function save()
	{
		try {
		    // prepare sql and bind parameters
		    $stmt = $this->conn->prepare("INSERT INTO events (titulo,date_init,time_init,date_finish,time_finish,allday,user)
		    VALUES (:titulo,:date_init,:time_init,:date_finish,:time_finish,:allday,:user)");
		    $stmt->bindParam(':titulo', $titulo);
		    $stmt->bindParam(':date_init', $start_date);
		    $stmt->bindParam(':time_init', $start_hour);
		    $stmt->bindParam(':date_finish', $end_date);
		    $stmt->bindParam(':time_finish', $end_hour);
		    $stmt->bindParam(':allday', $allDay);
		    $stmt->bindParam(':user', $_SESSION['id']);

		    // insert a row
			$titulo = $this->request('titulo');
			$start_date = $this->request('start_date');
			$start_hour = $this->request('start_hour');
			$end_date = $this->request('end_date');
			$end_hour = $this->request('end_hour');
			$fullDay = $this->request('allDay')==true?1:0;
			$allDay = $fullDay;
		    $stmt->execute();

		    return $this->all();
		}catch(PDOException $e){
	    	echo "Error: " . $e->getMessage();
	    }
	}
	function update()
	{
		try {
			$id = $this->request('id');
			$start_date = $this->request('start_date');
			$start_hour = $this->request('start_hour');
			$end_date = $this->request('end_date');
			$end_hour = $this->request('end_hour');
		    $sql="UPDATE events SET date_init='$start_date',time_init='$start_hour',date_finish='$end_date',time_finish='$end_hour' WHERE id = '$id'";
		    // prepare sql and bind parameters
		    $stmt = $this->conn->prepare($sql);
			
		    $stmt->execute();

		    $this->createResponse(true, $stmt->rowCount() . " records UPDATED successfully", null);
		}catch(PDOException $e){
	    	echo "Error: " . $e->getMessage();
	    }
	}
	function delete()
	{
		try {
			$id = $this->request('id');
		    $sql="DELETE FROM events WHERE id = '$id'";
		    // prepare sql and bind parameters
		    $stmt = $this->conn->prepare($sql);
			
		    $stmt->execute();

		    $this->createResponse(true, $stmt->rowCount() . " records DELETED successfully", null);
		}catch(PDOException $e){
	    	echo "Error: " . $e->getMessage();
	    }
	}
}	

$e = new Events();

Class Auth extends _MySQL
{
	function validate($email,$password)
	{
		$user = false;
		$msj = "Credenciales incorrectas";
		$exists = $this->getFields("users","*","email = '".$email."'");
		if(count($exists)>0)
		{
			$passBD = $exists[0]['password'];
			$user = $this->validatePassword($password,$passBD);
			if($user)
			{
				$_SESSION['id']=$exists[0]['id'];
				$msj = "Ok";
			}
		}
		$this->createResponse($user, $msj);
	}
}

$u = new Auth();

?>