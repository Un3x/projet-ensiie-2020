<?php include('includes/header_admin.php') ;?>

 <?php 
include('includes/dbh.inc.php');

 $sql='SELECT * FROM public."Beach"';
    $result = $conn->prepare($sql);
    $result->execute(array());
    ?> <table> <thead> <tr> <th> Nom </th> <th> Caractéristiques </th> <th> Privée/Publique </th> <th> Nudiste/Non nudiste </th> <th> Fréquentation </th> <th> Département </th> <th> Ville </th> <th> Description </th><th> Note </th></tr> </thead> 
     <colgroup>
    	<col span="1" width="200" style="background-color:#444" />
        <col span="1" width="150" style="background-color: #444" />
        <col span="1" width="150" style="background-color: #444" />
        <col span="1" width="150" style="background-color: #444" />
        <col span="1" width="150" style="background-color: #444" />
        <col span="1" width="150" style="background-color: #444" />
        <col span="1" width="150" style="background-color: #444" />
        <col span="1" width="150" style="background-color: #444" />
        <col span="1" width="150" style="background-color: #444" />
    </colgroup>
    <style type="text/css">
 
td /* Les cellules normales */
{
border:1px solid black;
font-family:'Montserrat', sans-serif;
text-align:center;
color : #fab005; /* Tous les textes des cellules seront centrés*/
padding:5px; /* Petite marge intérieure aux cellules pour éviter que le texte touche les bordures */
}
th
{
border:1px solid black;
font-family: 'Montserrat', sans-serif;
text-align:center;
color : #fab005; /* Tous les textes des cellules seront centrés*/
padding:5px; /* Petite marge intérieure aux cellules pour éviter que le texte touche les bordures */
}

</style>
    <?php
    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
        ?>
        
        <tr>
            <td> <?php echo $row['name_beach'] ; ?> </td>
            <td> <?php echo $row['caracteristics'] ; ?> </td>
            <td> <?php echo $row['privacy'] ?> </td>
            <td> <?php echo $row['nudity'] ?> </td>
            <td> <?php echo $row['frequentation'] ?> </td>
            <td> <?php echo $row['departement'] ?> </td>
            <td> <?php echo $row['localisation'] ?> </td>
            <td> <?php echo $row['description'] ?> </td>
            <td> <?php echo round($row['note'],1) ?> </td>
        </tr>
    
        <?php }?>
        </table>

 <div class="choix-compte">
     <form class="form-change" action="modification_plage.php" method="post">
         <input type="text" name="modif-name" placeholder="Nom de plage"/>
         <input type="text" name="modif-desc" placeholder="Description"/>
         <input type="text" name="modif-note" placeholder="Note"/>
         <input type="submit" name="modif_submit" value="Modifier"/>
</form>
</div>