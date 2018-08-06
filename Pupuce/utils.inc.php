<?php
/**
 * Ensemble d'utilitaires
 * 
 */

# On rajoute un namespace pour ne pas confondre avec les fonctions "built-in" de PHP.
namespace Utils;

/**
 * Permet de changer une syntaxe, par exemple user_id => userId
 * @param string $val La valeur à modifier
 * @return La valeur modifiée 
 */
function fromUnderscoreToUpper($val) {
	$tab = explode('_', $val);
	return $tab[0] . ucfirst($tab[1]);
}

# Autoloader
spl_autoload_register(function ($class) {
	include $class . '.class.php';
});