<!DOCTYPE html>
<html lang="fr">
<div class="centrer">
<div class="titreInscription">Page de recherche : </div>
<form method="GET" class="buscar-caja">
    <input type="search" class="buscar-txt" name="q" placeholder="Tapez un prénom..." autocomplete="off"/>
    <a class="buscar-btn">
    <input type ="submit" value="O" class="fa_search"/>
   </a>
</form>
<div class="erreur">
<?php
 if( ! empty($data))
 {
    echo $data['erreur'];
 }
?>
</div>
</div>
<ul>
<?php
if(!empty($data)){
for($i = 0; $i<2*$data['nbrRow'];$i=$i+2){?>
    <li>
    <?php echo $data[$i];
    echo " ";
    echo $data[$i+1];
    ?>
    </li>
<?php }
}
?>
</lu>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>


</html>