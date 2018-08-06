<?php

/**
 * Permet de gérer la connection à la base de données pour les éléments de la boutique.
 * 
 */

abstract class Repository {
	protected static $pdo;

	# On ne surchargera pas le constructeur pour éviter les problemes
	private final function __construct() {}

	# Méthodes abstraites
	abstract static public function insert();
	abstract static public function find();
	abstract static public function update();
	abstract static public function delete();

	/** 
	 * Permet d'obtenir de manière unique l'instance de PDO.
	 */
	static private function createInstance() {
		if (self::$pdo !== null)
			return;

		$type 		= 'sqlite';
		$db	  		= dirname(__FILE__) . '/db.sqlite';
		$host 		= '';
		$username 	= '';
		$password 	= '';

		try {
			self::$pdo = new PDO($type . ':' . $db . $host, $username, $password);
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e) {
			echo "Impossible de se connecter à la base de données. Erreur : " . $e->getMessage();
			self::$pdo = null;
			exit();
		}
	}

	/**
	 * Configure l'environnement. Crée l'instance qui servira pour tout.
	 */
	static public function configure() {

		// On crée notre instance grâce à la fonction de service associée.
		// On ne crée l'instance qu'une fois, à l'appel de cette fonction. C'est pour cela que l'on a mis createInstance() en private.
		// Le statisme rend cette fonction commune à toutes les instances de repository.
		self::createInstance();

		// Configuration de l'utilisateur 
		$sql = ['
			CREATE TABLE IF NOT EXISTS users (
				user_id				INTEGER 		PRIMARY KEY AUTOINCREMENT,
				user_name 			VARCHAR(50),
				user_surname 		VARCHAR(75),
				user_regdate		DATETIME
			);-- DEFAULT CHARSET=utf8;
		','
			CREATE TABLE IF NOT EXISTS products (
				product_id 			INTEGER 		PRIMARY KEY AUTOINCREMENT,
				product_quantity 	INTEGER, 		
				product_name 		VARCHAR(255)
			);-- DEFAULT CHARSET=utf8;
		','
			CREATE TABLE IF NOT EXISTS carts (
				user_id 			INTEGER,
				product_id 			INTEGER,
				cart_quantity 		INTEGER,
				cart_added 			DATETIME,
				FOREIGN KEY(user_id) 		REFERENCES users(user_id),
				FOREIGN KEY(product_id) 	REFERENCES products(product_id)
			);-- DEFAULT CHARSET=utf8;
		','
			CREATE TABLE IF NOT EXISTS carts_archive (
				cart_reference 		VARCHAR(40),
				cart_elements 		TEXT -- Sérialisation du contenu du panier, de l\'utilisateur et de la date.
			); --ENGINE=ARCHIVE;
			-- Cette table est utilisée comme archive.
		'];

		# Cette méthode résoud un problème de SQLite : on peut pas faire un seul script pour mettre de multiples tables.
		foreach ($sql as $query)
			self::$pdo->query($query);
	}

	/**
	 * Méthode de test. Elle prend en paramètre une fonction anonyme qui va nous servir de "zone de test"
	 * @param callable $func La fonction de test
	 */
	static public function test(callable $func) {

		$sql = '
			INSERT INTO products(product_quantity, product_name) VALUES(42, \'Pantalon\')';
		self::$pdo->exec($sql);

		$mock = new User();
		$mock->setUserName('Monsieur');
		$mock->setuserSurname('Test');
		$mock->setUserRegdate(date('Y-m-d H:i:s'));
		UserRepository::insert($mock);

		// On appelle notre environnement de test, isolé par le biais du "c'est une fonction".
		$func(self::$pdo);

		// On n'a pas TRUNCATE en SQLite, mais on va essayer d'éviter la surcharge
		
		self::$pdo->exec('DELETE FROM users');
		self::$pdo->exec('DELETE FROM products');
		self::$pdo->exec('DELETE FROM carts');
		self::$pdo->exec('DELETE FROM carts_archive');
		#self::$pdo->exec('VACUUM');
	}

}