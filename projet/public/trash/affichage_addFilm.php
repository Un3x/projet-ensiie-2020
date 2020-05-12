<!DOCTYPE html
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Medialiste</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>
    <form name="form" action="/addFilm.php" method="post">
        <input type="text" name="titre" id="titre_film" /><label for="titre_film">Titre</label>
        <input type="url" name="lien_photo" id="lien_photo_film"/> <label for="lien_photo_film">Lien_photo</label>
        <input type="date" name="date_sortie" id="date_sortie_film"/> <label for="date_sortie_film">Date de sortie</label>

        <input type="text" name="realisateur" id="realisateur"/><label for="realisateur">Réalisateur</label>
        <input type="text" name="genre_film" id="genre_film"/> <label for="genre_film">Genre</label>
        <input type="number" name="duree_film" id="duree_film"/> <label for="duree_film">Durée</label>
        <input type="text" name="producteur" id="producteur"/> <label for="producteur">Producteur</label>
        <input type="submit" value="Envoyer">
        <input type="reset" value="Recommencer">
    </form>
</body>
</html>