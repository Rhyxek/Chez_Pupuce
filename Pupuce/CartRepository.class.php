<?php

/**
 * Permet de relier le panier au bazar de la base de données.
 * 
 */

class CartRepository extends Repository {

	/**
	 * Insère un produit associé à un utilisateur 
	 * @param User $ 		L'instance utilisateur 
	 * @param Product $ 	L'instance produit 
	 * @param int $ 		La quantité (facultatif)
	 */
	public static function insert() {
		// On a les arguments. Minimum 2, maximum 3.
		$args 	= func_get_args();
		$nargs 	= func_num_args();

		if ($nargs < 2 or $nargs > 3)
			throw new InvalidArgumentException('Cette fonction accepte un minimum de deux arguments, et un maximum de trois arguments.');

		if (gettype($args[0]) !== 'object' or get_class($args[0]) !== 'User')
			throw new InvalidArgumentException('Cette fonction attend un argument 1 associé à la classe `User`.');

		if (gettype($args[1]) !== 'object' or get_class($args[1]) !== 'Product')
			throw new InvalidArgumentException('Cette fonction attend un argument 2 associé à la classe `Product`.');

		if (isset($args[3]) and gettype($args[3]) !== 'integer')
			throw new InvalidArgumentException('Cette fonction attend un argument 3 de type integer.');
		
	}

	/**
	 * Récupère l'ensemble du panier utilisateur 
	 * @param User $ 		L'instance utilisateur 
	 * @return Cart[] 		Un tableau de "paniers", qui forme le panier global
	 */
	public static function find() {

	}

	/**
	 * Met à jour la quantité produit en ajoutant ou réduisant.
	 * @param User $ 		L'instance utilisateur 
	 * @param Product 		L'instance produit 
	 * @param int 			La quantité à ajouter (positive) ou retirer (négative)
	 */
	public static function update() {

	}

	/**
	 * Supprime le "panier"
	 * @param User $ 		L'instance utilisateur 
	 * @param Product $ 	L'instance produit 
	 */
	public static function delete() {

	}
}