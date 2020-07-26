<?php 
class Formulaire 
{
    public static function formulaireDepanses(string $nom,?array $data=null):string
    {
        $class = "form-control ";
        $mess = null;
        $value = $_POST[$nom] ?? null;
    
        if(!is_null($data))
        {
            if(isset($data[$nom]))
            {
                $class .= "is-invalid";
                $mess ="<div class='invalid-feedback'>$data[$nom]</div>";
            }
            else{
                $class .= "is-valid";
            }   
        }
        return <<<html
        <div class="form-group">
            <label for="farines">$nom :</label>
            <input value="$value" type="text" class="$class" name="$nom" id="$nom">
            $mess
        </div>
html;
    }
}