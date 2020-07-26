<?php
class Samosa
{
    const PRICE_1_SAMOSA = 200;
    const MIN_SAMOSA_PER_DAY = 50;

    public $Day_Nb;
    public $Price_Day_Nb;
    public $dates;
    public $id;


    public function __construct($id =  null, $Day_Nb ,?string $dates = null)
    {
        $this->Day_Nb = $Day_Nb;
        $this->Price_Day_Nb = self::PRICE_1_SAMOSA * (int)$Day_Nb;
        if ($dates != null){
            $this->dates = $dates;
        }else{
            $this->dates = new DateTime();
            $this->dates->getTimestamp();
        };
        $this->id = $id ?: 0; 
    }
    public function Is_Valid():bool
    {
        return $this->Day_Nb > self::MIN_SAMOSA_PER_DAY;
    }
    public function getError(): string
    {
        if (!$this->Is_Valid()){
            return "le nombre de samosa doit etre superieure à 50";
        }
    }

    public function putDB ():int
    {
        $pdo = new PDO('sqlite:data/Samosa.db');
        $query = $pdo->prepare('INSERT INTO Samosa (nb_Samosa, date_Samosa) VALUES (:nb_Samosa, :date_Samosa)');
        $query->execute([
            'nb_Samosa'=>$this->Day_Nb,
            'date_Samosa'=>$this->formatDate()
        ]);
        return $pdo->lastInsertId();
    }

    public static function getExept()
    {
        $pdo = new PDO('sqlite:data/Samosa.db');
        $query = $pdo->query('SELECT nb_Samosa, date_Samosa FROM Samosa ORDER BY id_Samosa DESC LIMIT 5 ');
        return  $query->fetchAll(PDO::FETCH_OBJ);    
    }
    public static function getDB($nb)
    {
        $pdo = new PDO('sqlite:data/Samosa.db');
        $query = $pdo->query("SELECT id_Samosa, nb_Samosa, date_Samosa FROM Samosa ORDER BY id_Samosa DESC LIMIT 10 OFFSET $nb");
        return  $query->fetchAll(PDO::FETCH_OBJ);
    }
    public static function getRecherchDB($q)
    {
        $pdo = new PDO('sqlite:data/Samosa.db');
        $query = 'SELECT id_Samosa, nb_Samosa, date_Samosa FROM Samosa  WHERE date_Samosa LIKE :date_Samosa ';
        $param["date_Samosa"] = "%".$q."%";
        $query.='LIMIT 10' ;
        $Stat = $pdo->prepare($query);
        $Stat->execute($param);
    
        return  $Stat->fetchAll(PDO::FETCH_OBJ);
    }
    private function getDay()
    {
        $this->dates->setTimezone(new DateTimeZone("+4"));
        $jour = [
            1 =>'lundi',2 =>'mardi',3 =>'mercredi',4 =>'jeudi',5 =>'vendredi',6 =>'samedi',7 =>'dimanche',
        ];
        return $jour[$this->dates->format('N')];
    }
    private function getMonth()
    {
        $mois = [
            1 =>'janvier',2 =>'fevrier',3 =>'mars',4 =>'avril',5 =>'may',6 =>'juin',7 =>'juillet',8 =>'aout',9 =>'septambre',10 =>'ocobre',11 =>'novambre',12 =>'decembre',
        ];
        return $mois[$this->dates->format('n')];
    }
    private function formatDate()
    {  
        return $this->getDay() .' '. $this->dates->format("d").' '.$this->getMonth().' '.$this->dates->format("Y");
    }
    public static function getCount()
    {
        $pdo = new PDO('sqlite:data/Samosa.db');
        $query = $pdo->query("SELECT COUNT(id_Samosa) as count FROM Samosa");
        return  $query->fetch()['count'];
    }
    public static function getCountRecherch($q)
    {
        $pdo = new PDO('sqlite:data/Samosa.db');
        $query = $pdo->prepare("SELECT COUNT(id_Samosa) as count FROM Samosa WHERE date_Samosa LIKE :date_Samosa");
        $param["date_Samosa"] = "%".$q."%";
        $query->execute($param);
        return  $query->fetch()['count'];
    }
}