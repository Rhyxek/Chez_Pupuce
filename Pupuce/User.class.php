<?php 
/**
 * Gestion de l'utilisateur 
 * 
 */

class User {
	protected	$userId;			// L'ID de l'utilisateur
	protected 	$userName;			// Son prénom
	protected 	$userSurname;		// Son nom de famille
	protected	$userRegdate;		// Sa date de registration

	/**
	 * Constructeur de classe.
	 * @param array $fetch 		Un ensemble d'informations extraites de la base de données.
	 */
	public function __construct(array $fetch = array()) {
		foreach ($fetch as $name => $val) {

			// On va appeler dynamiquement le setter.
			$func = 'set' . ucfirst(Utils\fromUnderscoreToUpper($name));

			# On vérifie si notre méthode existe.
			if (!method_exists(__CLASS__, $func))
				throw new UnexpectedValueException('La méthode `' . $func . '` n\'existe pas.');

			$this->$func($val);
		}
	}

	public function setUserId($id) {
		$id = (int) $id;
		if ($id <= 0)
			throw new RangeException('L\'ID ne peut être négative ou nulle.');
		$this->userId = $id;
	}

	public function setUserName($name) {
		$name = trim($name);
		if ($name === '')
			throw new UnexpectedValueException('Le client doit avoir un prénom valide');
		$this->userName = $name;
	}

	public function setUserSurname($name) {
		$name = trim($name);
		if ($name === '')
			throw new UnexpectedValueException('Le client doit avoir un nom valide');
		$this->userSurname = $name;
	}

	public function setUserRegdate($date) {
		$sub = explode('-', explode(' ', $date)[0]);

		if (!checkdate($sub[1], $sub[2], $sub[0]))
			throw new UnexpectedValueException('La date est invalide.');

		$this->userRegdate = $date;
	}



	public function userId() {
		return $this->userId;
	}

	public function userName() {
		return $this->userName;
	}

	public function userSurname() {
		return $this->userSurname;
	}

	public function userRegDate() {
		return $this->userRegdate;
	}
}