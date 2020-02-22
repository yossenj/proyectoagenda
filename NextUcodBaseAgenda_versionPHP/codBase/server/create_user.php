<?php

	include('conn.php');
	Class Users extends _MySQL
	{
		public function init()
		{
			try {
			    $rows=$this->selectUsers();
			    if(count($rows)==0)
			    {
			    	$rows = $this->createUsers();
			    }
			    echo json_encode($rows);
			}
			catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
			$this->conn = null;
		}
		function selectUsers()
		{
			return $this->getFields("users");
		}
		function createUsers()
		{
			try {
			    // prepare sql and bind parameters
			    $stmt = $this->conn->prepare("INSERT INTO users (firstname, lastname, email, password, birthdate)
			    VALUES (:firstname, :lastname, :email, :password, :birthdate)");
			    $stmt->bindParam(':firstname', $firstname);
			    $stmt->bindParam(':lastname', $lastname);
			    $stmt->bindParam(':email', $email);
			    $stmt->bindParam(':password', $password);
			    $stmt->bindParam(':birthdate', $birthdate);

			    // insert a row
			    $firstname = "John";
			    $lastname = "Doe";
			    $email = "john@example.com";
			    $password = $this->crypt_blowfish("12345");
			    $birthdate = date('Y-m-d');
			    $stmt->execute();

			    // insert another row
			    $firstname = "Mary";
			    $lastname = "Moe";
			    $email = "mary@example.com";
			    $password = $this->crypt_blowfish("54321");
			    $birthdate = date('Y-m-d');
			    $stmt->execute();

			    // insert another row
			    $firstname = "Julie";
			    $lastname = "Dooley";
			    $email = "julie@example.com";
			    $password = $this->crypt_blowfish("09876");
			    $birthdate = date('Y-m-d');
			    $stmt->execute();

			    return $this->selectUsers();
			}catch(PDOException $e){
		    	echo "Error: " . $e->getMessage();
		    }
		}
	}

	$u = new Users();
	$u->init();
 ?>
