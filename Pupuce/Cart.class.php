<?php 
/**
 * Gestion du panier 
 * 
 */

class Cart {
	protected	$userId;			// Une référence à l'utilisateur
	protected 	$productId;			// Une référence au produit 
	protected 	$cartQuantity;		// La quantité désirée de produit 
	protected	$cartAdded;			// Quand est-ce que cela a été ajouté au panier

	public function __construct() {
		
	}
}