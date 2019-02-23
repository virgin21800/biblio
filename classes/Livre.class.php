<?php
class Livre
{
    private $_id;
    private $_titre;
    private $_auteur;

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set' . ucfirst($key);
            // Si le setter correspondant existe
            if (method_exists($this, $method)) {
                // On appelle le setter
                $this->$method($value);
            }
        }
    }

    public function getId()
    {
        return $this->_id;
    }
    public function getTitre()
    {
        return $this->_titre;
    }
    public function getAuteur()
    {
        return $this->_auteur;
    }
    private function setId($id)
    {
        $this->_id = $id;
    }
    public function setTitre($titre)
    {
        $this->_titre = $titre;
    }
    public function setAuteur($auteur)
    {
        $this->_auteur = $auteur;
    }
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }
}
?>