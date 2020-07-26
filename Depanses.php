<?php

class Depanses
{
    public $farines;

    public $oignons;

    public $huiles;

    public $jumbo;

    public $levur_chimique;

    public $perciles;

    public $id ;

    public $charbons;

    public $viande_hachee;
    

    public function __construct(?string $id = null, ?string $farines = null, ?string $oignons = null,?string $huiles = null, ?string $jumbo = null, ?string $levur_chimique = null, ?string $perciles = null, ?string $charbons = null, ?string $viande_hachee = null)
    {
        $this->id = $id?:0;
        $this->farines = $farines?:0;
        $this->oignons = $oignons?:0;
        $this->huiles = $huiles?:0;
        $this->jumbo = $jumbo?:0;
        $this->levur_chimique = $levur_chimique?:0;
        $this->perciles = $perciles?:0;
        $this->charbons = $charbons?:0;
        $this->viande_hachee = $viande_hachee?:0;

    }

    public function totale_Depenses():int
    {
       return $this->farines + $this->oignons + $this->huiles + $this->jumbo + $this->levur_chimique + $this->perciles +  $this->charbons + $this->viande_hachee;
    }

    public function Is_Valid():bool
    {
        return empty($this->getError());
    }

    public function putDB($id)
    {
            $pdo = new PDO('sqlite:data/Depanses.db');
            $query = $pdo->prepare('INSERT INTO depanses (id_depanse, farines ,oignons, huiles, jumbo, levure_chimique, perciles, charbons, viande_hachee) VALUES (:id_depanse, :farines ,:oignons, :huiles, :jumbo, :levure_chimique, :perciles, :charbons, :viande_hachee)');
            $query ->execute([
                'id_depanse' => $id,
                'farines'=> $this->farines,
                'oignons'=> $this->oignons,
                'huiles'=> $this->huiles,
                'jumbo'=> $this->jumbo,
                'levure_chimique'=> $this->levur_chimique,
                'perciles'=> $this->perciles,
                'charbons'=>$this->charbons,
                'viande_hachee'=>$this->viande_hachee
            ]);
    }

    public function getError():array
    {
        $error = [];
        if(empty(trim($this->farines)))
        {
            $error ["farines"]= "vous devez remplire cet formulaire";
        }
        if(empty(trim($this->oignons)))
        {
            $error ["oignons"]= "vous devez remplire cet formulaire";
        }
        if(empty(trim($this->huiles)))
        {
            $error ["huiles"]= "vous devez remplire cet formulaire";
        }
        if(empty(trim($this->perciles)))
        {
            $error ["perciles"]= "vous devez remplire cet formulaire";
        }
        if(empty(trim($this->charbons)))
        {
            $error ["charbons"]= "vous devez remplire cet formulaire";
        }
        if(empty(trim($this->charbons)))
        {
            $error ["levur_chimique"]= "vous devez remplire cet formulaire";
        }
        if(empty(trim($this->charbons)))
        {
            $error ["jumbo"]= "vous devez remplire cet formulaire";
        }
        if(empty(trim($this->charbons)))
        {
            $error ["viande_hachee"]= "vous devez remplire cet formulaire";
        }
        return $error;
    }
    public static function getExept()
    {
        $pdo = new PDO('sqlite:data/Depanses.db');
        $query = $pdo->query('SELECT farines ,oignons, huiles, jumbo, levure_chimique, perciles, charbons, viande_hachee FROM depanses ORDER BY id_depanse DESC LIMIT 5 ');
        return  $query->fetchAll(PDO::FETCH_OBJ);    
    }
    public static function getDB($id)
    {      
        $pdo = new PDO('sqlite:data/Depanses.db');
        $query = $pdo->prepare('SELECT id_depanse, farines ,oignons, huiles, jumbo, levure_chimique, perciles, charbons, viande_hachee FROM depanses WHERE id_depanse = :ID ');
        $query->execute([
            "ID"=>$id
        ]);
        return  $query->fetch(PDO::FETCH_OBJ);
    }
    public static function getCount()
    {
        $pdo = new PDO('sqlite:data/Depanses.db');
        $query = $pdo->query("SELECT COUNT(id_depanse) as count FROM depanses");
        return  $query->fetch()['count'];
    }
}