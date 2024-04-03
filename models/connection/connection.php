<?php

class dbConnection
{
	function myDB()
	{
		$connection = mysqli_connect("localhost", "root", "", "db_question_generator");
		if(!$connection)
		{
			Die("Failed to connect".mysqli_connect_error());
		}
		return $connection;
		//echo "connection success";
	}
}


?>