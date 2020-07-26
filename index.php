<?php 

require_once __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."Samosa.php";
require __DIR__.DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."Price.php";

$error = null;

if (isset($_GET['Day_Nb'])){
    if (!empty(trim($_GET['Day_Nb'])))
    {
    $samosaNow = new Samosa(null, $_GET['Day_Nb'], null);
    if(!$samosaNow->Is_Valid()){
        $error = $samosaNow->getError();
    }else{
        header("Location: /projet samosa/depanses.php?id=".$samosaNow->putDB());
    }
}

}
require __DIR__.DIRECTORY_SEPARATOR."elements".DIRECTORY_SEPARATOR."header.php";
?>
    <div class="container">
        <h2>ajouter de samosa</h2>
        <form action="" method="get">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?=$error?>
                </div>
            <?php endif ?>
            <div class="form-group">
                <label for="Day_Nb">Entrez le nombre des samosa aujourd'hui :</label>
                <input value="<?=htmlentities(($error)?trim($_GET['Day_Nb']):'')?>" type="text" id="Day_Nb" name="Day_Nb" class="form-control">
            </div>
            <button class="btn btn-primary">ajouter</button>
            </form>
    </div>
    <div class="container p-5 ">
        <h2>les cinq recents donneés </h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class= "text-center">nb Samosa</th>
                        <th class= "text-center">prix</th>
                        <th class= "text-center">date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Samosa::getExept() as $one_day): ?>
                        <?php
                        $day = new Samosa( null,$one_day->nb_Samosa,$one_day->date_Samosa);
                        ?>
                        <tr>
                            <td class= "text-center"><?=$day->Day_Nb?></td>
                            <td class= "text-center"><?=Price::priceAr($day->Price_Day_Nb)?></td>
                            <td class= "text-center"><?=$day->dates?></td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
    </div>
<?php 
require __DIR__.DIRECTORY_SEPARATOR."elements".DIRECTORY_SEPARATOR."footer.php";
?>