<?php

/**
 * Permet de relier l'utilisateur au bazar de la base de données.
 * 
 */

class UserRepository extends Repository {

	/**
	 * Insère un nouvel utilisateur 
	 * @param 	User $user 		L'instance utilisateur 
	 * @return 	int 			L'ID utilisateur dans la base de données
	 */
	public static function insert() {
		// [A FAIRE] Les vérifs habituelles
		$args 	= func_get_args(); // La liste des arguments donnés à la fonction
		$nargs 	= func_num_args(); // Le nombre d'arguments

		if ($args[0]->userId() !== null)
			throw new InvalidArgumentException('Cette méthode attend que l\'utilisateur n\'ait pas d\'ID assignée.');

		$sql = 'INSERT INTO users(user_surname, user_name, user_regdate) VALUES(:surname, :name, :regdate)';
		$req = self::$pdo->prepare($sql);
		$req->bindValue(':surname', $args[0]->userSurname());
		$req->bindValue(':name', $args[0]->userName());
		$req->bindValue(':regdate', $args[0]->userRegdate());
		$req->execute();

		return self::$pdo->lastInsertId();
	}

	/**
	 * Trouve un utilisateur en fonction de son ID 
	 * @param int $ 			L'ID utilisateur 
	 * @return User 			L'instance utilisateur
	 */
	public static function find() {
		// Verifications (necessaire car PHP a un typage faible)
		$args 	= func_get_args(); // La liste des arguments donnés à la fonction
		$nargs 	= func_num_args(); // Le nombre d'arguments.

		if ($nargs !== 1 or gettype($args[0]) !== 'integer')
			throw new InvalidArgumentException('Cette fonction demande un argument de type `int`.');
		
		$id = (int) $args[0];
		$sql = 'SELECT user_id, user_surname, user_name, user_regdate FROM users WHERE user_id = :id';
		$req = self::$pdo->prepare($sql);
		$req->bindValue(':id', $id, PDO::PARAM_INT);
		$req->execute(); 

		return new User($req->fetch(PDO::FETCH_ASSOC)); // Pour comprendre, faire un var_dump($req->fetch()) juste après, en enlevant et en laissant PDO::FETCH_ASSOC.
	}

	/**
	 * Met un utilisateur à jour.
	 * @param int $ 			L'ID utilisateur 
	 * @param User 				La version à jour de l'instance utilisateur.
	 * @return User 			L'instance utilisateur
	 */
	public static function update() {

	}

	/**
	 * Supprime un utilisateur en fonction de son ID 
	 * @param int $ 			L'ID utilisateur 
	 */
	public static function delete() {
		
	}
}