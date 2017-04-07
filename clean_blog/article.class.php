<?php
class Article {
	private $_idArt;
	private $_auteurArt;
	private $_dateDerModifArt;
	private $_titre;
	private $_chapo;
	private $_contenuArt;
	private $_aComm;

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	function hydrate(array $donnees) 
	{
   		foreach ($donnees as $key => $value)
   		{
      		$method = 'set'.ucfirst($key);
      		if (method_exists($this, $method))
      		{
        		$this->$method($value);
      		}
   		}
	}

	/* Accesseurs / Getters -----------------------------------*/

	public function idArt() {
		return $this->_idArt;
	}
	public function auteurArt() {
		return $this->_auteurArt;
	}
	public function dateDerModifArt() {
		return $this->_dateDerModifArt;
	}
	public function titre() {
		return $this->_titre;
	}
	public function chapo() {
		return $this->_chapo;
	}
	public function contenuArt() {
		return $this->_contenuArt;
	}
	public function aComm() {
		return $this->_aComm;
	}


	/* Mutateurs / Setters ------------------------------------*/

	public function setIdArt($idArt) {
		$this->_idArt = $idArt;
	}
	public function setAuteurArt($auteurArt) {
		$this->_auteurArt = $auteurArt;
	}
	public function setDateDerModifArt($dateDerModifArt) {
		$this->_dateDerModifArt = $dateDerModifArt;
	}
	public function setTitre($titre) {
		$this->_titre = $titre;
	}
	public function setChapo($chapo) {
		$this->_chapo = $chapo;
	}
	public function setContenuArt($contenuArt) {
		$this->_contenuArt = $contenuArt;
	}
	public function setAComm($aComm) {
		$this->_aComm = $aComm;
	}
	

}