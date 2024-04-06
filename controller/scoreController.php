<?php

require('../models/common_functions/functions.php');

class scoreController
{
	public $myFunction, $dbConn; 
	private $formdata;
	function __construct()
	{
		$this->myFunction = new commonFunctions();
		$this->dbConn = $this->myFunction->conn;
		$this->formdata = isset($_POST['formdata']) ? $_POST['formdata'] : array();
		
	}

	function sqlQueries()
	{
		$array = array();
		
		$array[0] = "SELECT answer, question_code FROM tbl_questions WHERE status='Active'";
		
		return $array;
	}
	
	function event($action)
	{
		$SQL=$this->sqlQueries();
		switch($action)
		{
			
			case "calculate_score":
			    $correctAnswers = array();
			    $result = mysqli_query($this->dbConn, $SQL[0]);
				while($rows=mysqli_fetch_assoc($result)){
					$correctAnswers[] = $rows;
				}
				$matchedCodes = [];
				foreach ($correctAnswers as $correctAnswer) {
					foreach ($this->formdata as $formData) {
						if ($correctAnswer['answer'] === $formData['answer'] && $correctAnswer['question_code'] === $formData['code']) {
							$matchedCodes[] = $correctAnswer['question_code'];
						}
					}
				}
                
                $scored = 0; 

				for ($i = 0; $i < count($matchedCodes); $i++) { 
					$scored += $this->calculateScore($matchedCodes[$i]); 
				}
				
                $this->myFunction->updateDataORDelete("UPDATE tbl_exam_login SET scored='".$scored."', total_score='".$this->totalScore()."' WHERE email='".$_SESSION['applicant_email']."'");
				unset($_SESSION['applicant_email']);
				echo $scored."/".$this->totalScore();
			break;
	
			
			
			default:
			     "No Action Found !";
		    break;		 
		}
	}
	
	function calculateScore($QCode)
	{
		$query = "SELECT score FROM tbl_questions WHERE question_code='".$QCode."' AND status='Active'";
		$scoreResult = mysqli_query($this->dbConn, $query);
		
		if ($scoreResult && mysqli_num_rows($scoreResult) > 0) {
			$scoreRow = mysqli_fetch_assoc($scoreResult);
			return $scoreRow['score'];
		} else {
			return 0; 
		}
	}
	
	function totalScore()
	{
		$sql="SELECT SUM(`score`) AS total_score FROM tbl_questions WHERE `status`='Active'";
	    $totalResult = mysqli_query($this->dbConn, $sql);
		$totalScore = mysqli_fetch_assoc($totalResult);
		return number_format($totalScore['total_score'], 0);;
	}
	
}

$obj = new scoreController();
$obj->event($_POST['action']);

?>