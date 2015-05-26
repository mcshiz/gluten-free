<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/gluten-free/php/get-list.php") ;
session_start();
if (isset($_POST['ajaxData'])) {
	if (!isset($_SESSION['votes'])) {
   		$_SESSION['votes'] = 1;
   	}
   	if ($_SESSION['votes'] < 6) { 
		$data = $_POST['ajaxData'];
		$updateData = new GetList();
		$updateData->sendData($data);
		$_SESSION['votes']++;
	} else {
		echo "voteLimit";
	}
} 
return true;