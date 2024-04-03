<?php
session_start();
require('../models/connection/connection.php');


abstract class functionsDetails
{
	abstract public function insertData($sql);
	abstract public function updateDataORDelete($sql);
	abstract public function listData($sql);
	abstract public function ReturnCountValue($SQL);
	abstract public function userAuthenticationforcheck($SQL,$password);
}

class commonFunctions extends functionsDetails
{
	public $conn, $result;
	function __construct()
	{
		$connection = new dbConnection();
		$this->conn = $connection->myDB();
	}
	
	function ReturnCountValue($SQL)
	{
			$this->result = mysqli_query($this->conn,$SQL);
			$affected_status = mysqli_num_rows($this->result);
			return $affected_status;
	}
	
	public function userAuthenticationforcheck($SQL,$password)
	{
		$admin_status;
		$admin_password;
		$this->result = mysqli_query($this->conn,$SQL);
		$row_count = mysqli_num_rows($this->result);
		while($rows=mysqli_fetch_assoc($this->result))
		{
			$admin_status =$rows['status'];
			$admin_password = $rows['password'];
		}
		
		if($row_count>=1)
		{

			if($admin_status=='Active')
			{
			   	
				if($password==$admin_password)
				{
				   $_SESSION['loginStatus']="pageload";
				   return "redirect-success";
				}
				else
				{
					return 'Please provide correct password...!';
				}

			}
			else
			{
				return 'Your Login is not active, Please contact your administrator..!';
			}
			
		
		}
		else
		{
			return 'Username does not Exists...!';
		}	
		
	}


	
	function insertData($sql)
	{
		if(mysqli_query($this->conn, $sql))
		{
		   $this->result = mysqli_insert_id($this->conn);
		   return $this->result;
		}
		else
		{
			return mysqli_error($this->conn);
		}

	}
	
	function listData($sql)
	{
		$temp = array();
		$this->result = mysqli_query($this->conn, $sql); 
		if ($this->result) { 
			while ($row = mysqli_fetch_assoc($this->result)) { 
				 $temp['data'][] = $row;
			}
			echo json_encode($temp);
		} else {
			echo "Error: " . mysqli_error($this->conn); 
		}
	}
	
	function updateDataORDelete($sql)
	{
		if(mysqli_query($this->conn, $sql))
		{
		   $this->result = mysqli_affected_rows($this->conn);
		   return $this->result;
		}
		else
		{
			return mysqli_error($this->conn);
		}
	}
	
	function __destruct()
	{
		//mysqli_free_result($this->result);
		mysqli_close($this->conn);
	}
	
}
$obj = new commonFunctions();



?>