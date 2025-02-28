<?php
try
{
	//$bdd = new PDO('mysql:host=localhost;dbname=bdduka;charset=utf8', 'root', '');
	$bdd = new PDO('mysql:host=localhost;dbname=bdduka;charset=utf8', 'uka', 'Admin12345');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

?>
