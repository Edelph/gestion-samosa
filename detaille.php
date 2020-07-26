<?php

require __DIR__.DIRECTORY_SEPARATOR."elements".DIRECTORY_SEPARATOR."header.php";
require_once __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."Samosa.php";
require __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."Depanses.php";
require __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."Price.php";

$pdo = new PDO('sqlite:data/Depanses.db');
$query = $pdo->query('TRUNCATE TABLE depanses');
$pdo = new PDO('sqlite:data/Samosa.db');
$query = $pdo->query('TRUNCATE TABLE Samosa');

$page = (int)($_GET['p']?? 1);

$offset = ($page-1) *10 ;
?>

<div class="container-fluide m-1">
    <div class="row">
        <div class="col-md-4">
            <h1>tout les donnes :</h1>
        </div>
        <div class="col-md-8">
            <div class="container">
                <form action="">
                    <div class="form-inline text-right  align-items-end">
                        <input value="<?=htmlentities($_GET['q']?? null )?>" type="text" name="q" class="form-control d-flex" placeholder="recherche par date">
                        <button class="btn btn-outline-primary ml-3">recherche</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
   
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th rowspan="2" class= "text-center pb-5">dates</th>
                <th colspan="9" class= "text-center" >depanses</th>
                <th colspan="2" class= "text-center">recettes</th>
                <th rowspan="2" class= "text-center pb-5">bennefices</th>
            </tr>
            <tr>
                <th class= "text-center ">farines</th>
                <th class= "text-center">oignons</th>
                <th class= "text-center">huiles</th>
                <th class= "text-center">jumbo</th>
                <th class= "text-center">levur chimique</th>
                <th class= "text-center">perciles</th>
                <th class= "text-center">charbons</th>
                <th class= "text-center">viande hachee</th>
                <th class= "text-center">totales</th>
                <th class= "text-center">nb Samosa</th>
                <th class= "text-center">prix</th> 
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($_GET['q'])): ?>
                  <?php 
                  $donnes = Samosa::getRecherchDB($_GET['q']);
                  $pages = ceil( Samosa::getCountRecherch($_GET['q'])/10);
       
                  ?>
            <?php else:?>
                <?php 
                
                $donnes = Samosa::getDB($offset);
                $pages = ceil( Samosa::getCount()/10);

                ?>
            <?php endif?>
                <?php foreach ($donnes as $one_day): ?>

                    <?php
                    $dayS = new Samosa ($one_day->id_Samosa, $one_day->nb_Samosa, $one_day->date_Samosa);
                    $one_day = Depanses::getDB($dayS->id);
                    $day = new Depanses ($one_day->id_depanse, $one_day->farines, $one_day->oignons, $one_day->huiles, $one_day->jumbo, $one_day->levure_chimique,$one_day->perciles,$one_day->charbons, $one_day->viande_hachee);
                    ?>
                    <tr>
                        <td class= "text-center p-1"><?=$dayS->dates?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->farines)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->oignons)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->huiles)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->jumbo)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->levur_chimique)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->perciles)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->charbons)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->viande_hachee)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($day->totale_Depenses())?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($dayS->Day_Nb)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($dayS->Price_Day_Nb)?></td>
                        <td class= "text-center p-1"><?=Price::priceAr($dayS->Price_Day_Nb - $day->totale_Depenses())?></td>
                    </tr>
                <?php endforeach?>
            
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-4"> 
            <?php if ($pages > 1 && $page > 1) : ?>
                <a href="?p=<?=$page-1?>" class="btn btn-primary m-3" >precedant</a>
            <?php endif ?>
            <?php if ($pages > 1 && $page < $pages) : ?>
                <a href="?p=<?=$page+1?>" class="btn btn-primary m-3">suivant</a>
            <?php endif ?>
        </div>
        <div class="col-md-8 text-right ">
            page <?=$page?>/<?=$pages?>
        </div>
    </div>
   
    
    
</div>


<?php
require __DIR__.DIRECTORY_SEPARATOR."elements".DIRECTORY_SEPARATOR."footer.php";
 ?>
