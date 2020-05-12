<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>acheter un objet</title>
    </head>
    <script type="text/javascript">
 $(function() {
	$('.range').next().text('--'); // Valeur par défaut
	$('.range').on('input', function() {
		var $set = $(this).val();
		$(this).next().text($set);
	});
});
</script>
    <form action="/coroshop/public/trouver_objet_page_complette.php" method="post">
    
  
   
        <label for="categorie">Catégorie:</label>
        <select name="categorie" id="categorie">
            <optgroup label="vêtement">
                <option value="slip" selected>slip</option>
                <option value="robe">robe</option>
                <option value="pantalon">pantalon</option>
            </optgroup>
            <optgroup label="maison">
                <option value="meuble">meuble</option>
                <option value="electromenager">électroménager</option>
            </optgroup>
        </select><br />

        <label for="prix" >Prix maximum en euro</label>
        <input type="range" name="prix" min="0" max="1000" step="1" value="100" oninput="result4.value=parseInt(prix.value)"/>
        <output name="result4">--</output>
        
        <input type="submit" value="Envoyer"/>
       
    </form>
</html>
