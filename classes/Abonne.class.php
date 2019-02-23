<?php
class Abonne
{
    private $_id;
    private $_nom;
    private $_prenom;

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
    public function getNom()
    {
        return $this->_nom;
    }
    public function getPrenom()
    {
        return $this->_prenom;
    }
    private function setId($id)
    {
        $this->_id = $id;
    }
    public function setNom($nom)
    {
        $this->_nom = $nom;
    }
    public function setPrenom($prenom)
    {
        $this->_prenom = $prenom;
    }
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }
}
?>