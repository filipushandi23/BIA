<?php
	session_start();
	
	// destroy the session
	if(session_destroy()){
		header('location: index.php');
	}
	
?>