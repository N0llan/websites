<?php
/**
 * Daniel Jennebo
 * Programvaruteknik 2014
 * Webbprogrammering
 * 2016-02-07
 * Filen skapar klassen MyList
 */
 
class MyList{
	
	public $firstName, $lastName, $nick,$epost,$admin;
	
	public function __construct($firstName, $lastName, $nick, $epost, $admin)
	{									//Konstruktor
		$this->admin=$admin;
		$this->firstName=$firstName;
		$this->lastName=$lastName;
		$this->nick=$nick;
		$this->epost=$epost;
	}
}
 
?>