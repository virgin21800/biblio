<?php
class Emprunt
{
    private $_id;
    private $_idabonne;
    private $_idlivre;

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
    public function getIdabonne()
    {
        return $this->_idabonne;
    }
    public function getIdlivre()
    {
        return $this->_idlivre;
    }
    private function setId($id)
    {
        $this->_id = $id;
    }
    public function setLivre($livre)
    {
        $this->_livre = $livre;
    }
    public function setIdlivre($idlivre)
    {
        $this->_idlivre = $idlivre;
    }
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }
}
?>