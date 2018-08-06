<?php

require 'utils.inc.php';

// On configure notre environnement 
Repository::configure();

// On prépare notre environnement de test 
Repository::test(function($pdo) {
	# Test session avec ID
	$sql = 'SELECT user_id FROM users LIMIT 1';
	$req = $pdo->query($sql);

	session_start();
	$_SESSION['id'] = (int) $req->fetch()[0]; 

	// Extraction de produit ajouté
	$sql = 'SELECT product_id FROM products LIMIT 1';
	$req = $pdo->query($sql);

	$produit = (int) $req->fetch()[0];

	// on récupère les infos utilisateur a partir de son ID.
	//var_dump($_SESSION['id']);


	//tests
	try {

		// On récupère un objet utilisateur
		$user = UserRepository::find($_SESSION['id']);
		
	} catch (Exception $e) {
		echo '(' . get_class($e) . ') Il y a eu une erreur dans '. $e->getFile() . ' (' . $e->getLine() . ') : ' . $e->getMessage();
		exit();
	}
});

