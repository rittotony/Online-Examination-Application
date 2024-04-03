<?php

require('../models/common_functions/functions.php');

class mainController
{
	private $myFunction;
    private $formdata;
    private $username;
    private $password;
	function __construct()
	{
		$this->myFunction = new commonFunctions();
		$this->formdata = isset($_POST['formdata']) ? $_POST['formdata'] : array();
		$this->username = isset($this->formdata['username']) ? $this->formdata['username'] : "";
		$this->password = isset($this->formdata['password']) ? $this->formdata['password'] : "";
		$this->question = isset($this->formdata['question']) ? $this->formdata['question'] : "";
		$this->options = isset($this->formdata['options']) ? $this->formdata['options'] : "";
		$this->answer = isset($this->formdata['answer']) ? $this->formdata['answer'] : "";
		$this->score = isset($this->formdata['score']) ? $this->formdata['score'] : "";
		$this->ids = isset($_POST['ids']) ? $_POST['ids'] : "";
		$this->status = isset($_POST['thisStatus']) ? $_POST['thisStatus'] : "";
		$this->name = isset($this->formdata['name']) ? $this->formdata['name'] : "";
		$this->email = isset($this->formdata['email']) ? $this->formdata['email'] : "";
	    $this->totalPossibleScore = isset($this->formdata['totalPossibleScore']) ? $this->formdata['totalPossibleScore'] : "";
	    $this->totalScore = isset($this->formdata['totalScore']) ? $this->formdata['totalScore'] : "";
	
	}

	function sqlQueries()
	{
		$array = array();
		
		$array[0] = "SELECT *FROM tbl_admins WHERE username='".$this->username."' AND password='".$this->password."'";
		
		$array[1] = "INSERT INTO tbl_questions(question, options, answer, score)VALUES('".$this->question."', '".$this->options."', '".$this->answer."', '".$this->score."')";
		
		$array[2] = "SELECT * FROM tbl_questions";
		
		$array[3] = "UPDATE tbl_questions SET status='Deactive' WHERE ids='".$this->ids."'";
		
		$array[4] = "UPDATE tbl_questions SET status='Active' WHERE ids='".$this->ids."'";

        $array[5] = "INSERT INTO tbl_exam_login(name, email) VALUES ('".$this->name."', '".$this->email."')";
        
		$array[6] = "UPDATE tbl_exam_login SET scored='".$this->totalScore."', total_score='".$this->totalPossibleScore."' WHERE email='".$this->email."'";
		
		$array[7] = "SELECT * FROM tbl_exam_login";
		
		return $array;
	}
	
	function event($action)
	{
		$SQL=$this->sqlQueries();
		switch($action)
		{
			
			case "admin_login":
			    $this->result = $this->myFunction->userAuthenticationforcheck($SQL[0],$this->password);
			    echo $this->result;
			break;
	
			case "add_questions":
			   $result = $this->myFunction->insertData($SQL[1]);
			   echo $result;
			break;
			
			case "listAllQuestions":
			   $this->result = $this->myFunction->listData($SQL[2]);
			   echo $this->result;
			break;
			
			case "change_status_active":
			   $this->result = $this->myFunction->updateDataORDelete($SQL[3]);
			   echo $this->result;
			break;
			
			case "change_status_deactive":
			   $this->result = $this->myFunction->updateDataORDelete($SQL[4]);
			   echo $this->result;
			break;
			
			case "examiner_login":
			   $query = "SELECT email FROM tbl_exam_login WHERE email='".$this->email."'";
			   $rowCount = $this->myFunction->ReturnCountValue($query);
			   if($rowCount==0)
			   {
				   $result = $this->myFunction->insertData($SQL[5]);
			       echo $result;
			   }				   
			   else
			   {
				   echo "You Can't Attend the Examination, Because you are Already attended !";
			   }
			break;
			
			case "update_score":
			   $this->result = $this->myFunction->updateDataORDelete($SQL[6]);
			   echo $this->result;
			break;
			
			case "listAllAttendies":
			   $this->result = $this->myFunction->listData($SQL[7]);
			   echo $this->result;
			break;
			
			
			default:
			     "No Action Found !";
		    break;		 
		}
	}
}

$obj = new mainController();
$obj->event($_POST['action']);


?>