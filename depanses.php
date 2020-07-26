<?php
require __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."Depanses.php";
require __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."Formulaire.php";

require __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."Price.php";


$depensesNow = null;
$error = null;

if (isset($_GET["id"])){
    setcookie("id",$_GET["id"]);
}

if(isset($_POST['farines'], $_POST['oignons'], $_POST['huiles'], $_POST['jumbo'], $_POST['levur_chimique'], $_POST['perciles'], $_POST['charbons'], $_POST['viande_hachee']))
{
    $depensesNow = new Depanses(null ,$_POST['farines'], $_POST['oignons'], $_POST['huiles'], $_POST['jumbo'], $_POST['levur_chimique'], $_POST['perciles'], $_POST['charbons'], $_POST['viande_hachee']);
    if($depensesNow->Is_Valid())
    {  
        if(isset($_COOKIE["id"])){
            $depensesNow->putDB($_COOKIE["id"]);
            header("Location: /projet samosa/detaille.php");
        }
           
    }else{
        $error = $depensesNow->getError();
    }
};
require __DIR__.DIRECTORY_SEPARATOR."elements".DIRECTORY_SEPARATOR."header.php";
?>
<div class="container">
    <div class="card card-body">
        <form action="" method="post"> 
        <h2>les depenses d'aujourd'hui :</h2>
            <div class="row">
                <div class="col-md-6">
                   <?= Formulaire::formulaireDepanses("farines",$error)?>
                   <?= Formulaire::formulaireDepanses("huiles",$error)?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= Formulaire::formulaireDepanses("levur_chimique",$error)?>
                        </div>
                        <div class="col-sm-6">
                            <?= Formulaire::formulaireDepanses("jumbo",$error)?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                <?= Formulaire::formulaireDepanses("oignons",$error)?>
                <?= Formulaire::formulaireDepanses("perciles",$error)?>
                <?= Formulaire::formulaireDepanses("charbons",$error)?>
                </div>
            </div> 
            <div class="row">
                <div class="col-md-2"><button class="btn btn-primary">ajouter</button></div>
            </div>
        </form>
    </div>
</div>

<div class="container p-5">
    <h2>les cinq recents donneés</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class= "text-center">farines</th>
                <th class= "text-center">oignons</th>
                <th class= "text-center">huiles</th>
                <th class= "text-center">jumbo</th>
                <th class= "text-center">levur chimique</th>
                <th class= "text-center">perciles</th>
                <th class= "text-center">charbons</th>
                <th class= "text-center">totales</th>
            </tr>
        </thead>
        <tbody>
        
            <?php foreach (Depanses::getExept() as $one_day): ?>
                <?php
                $day = new Depanses (null,$one_day->farines, $one_day->oignons, $one_day->huiles, $one_day->jumbo, $one_day->levure_chimique,$one_day->perciles, $one_day->charbons);
                ?>
                <tr>
                    <td class= "text-center"><?=Price::priceAr($day->farines)?></td>
                    <td class= "text-center"><?=Price::priceAr($day->oignons)?></td>
                    <td class= "text-center"><?=Price::priceAr($day->huiles)?></td>
                    <td class= "text-center"><?=Price::priceAr($day->jumbo)?></td>
                    <td class= "text-center"><?=Price::priceAr($day->levur_chimique)?></td>
                    <td class= "text-center"><?=Price::priceAr($day->perciles)?></td>
                    <td class= "text-center"><?=Price::priceAr($day->charbons)?></td>
                    <td class= "text-center"><?=Price::priceAr($day->totale_Depenses())?></td>
                </tr>
            <?php endforeach?>
        </tbody>
    </table>
</div>
<?php
require __DIR__.DIRECTORY_SEPARATOR."elements".DIRECTORY_SEPARATOR."footer.php";

?>