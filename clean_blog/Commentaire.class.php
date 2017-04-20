<?php
class Commentaire {
	
	private $_idComm;
	private $_auteurComm;
	private $_dateDerModifComm;
	private $_contenuComm;
	private $_articleId;

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

	public function idComm() {
		return $this->_idComm;
	}
	public function auteurComm() {
		return $this->_auteurComm;
	}
	public function dateDerModifComm() {
		return $this->_dateDerModifComm;
	}
	public function contenuComm() {
		return $this->_contenuComm;
	}
	public function articleId() {
		return $this->_articleId;
	}

	/* Mutateurs / Setters ------------------------------------*/

	public function setIdComm($idComm) {
		$this->_idComm = $idComm;
	}
	public function setAuteurComm($auteurComm) {
		$this->_auteurComm = $auteurComm;
	}
	public function setDateDerModifComm($dateDerModifComm) {
		$this->_dateDerModifComm = $dateDerModifComm;
	}
	public function setContenuComm($contenuComm) {
		$this->_contenuComm = $contenuComm;
	}
	public function setArticleId($articleId) {
		$this->_articleId = $articleId;
	}

}

?>