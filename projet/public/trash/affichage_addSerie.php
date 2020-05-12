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
    <form name="form" action="/addSerie.php" method="post">
        <input type="text" name="titre" id="titre_serie" /><label for="titre_serie">Titre</label>
        <input type="url" name="lien_photo" id="lien_photo_serie"/> <label for="lien_photo_serie">Lien_photo</label>
        <input type="date" name="date_sortie" id="date_sortie_serie"/> <label for="date_sortie_serie">Date de sortie</label>

        <input type="number" name="nb_ep" id="nb_ep"/><label for="nb_ep">Nombre d'épisodes</label>
        <input type="number" name="nb_saisons" id="nb_saisons"/> <label for="nb_saisons">Nombre de saisons</label>
        <input type="number" name="duree_serie" id="duree_serie"/> <label for="duree_serie">Durée</label>
        <input type="text" name="genre_serie" id="genre_serie"/> <label for="genre_serie">Genre</label>
        <input type="radio" name="anime" id="anime"/><label for="anime">Anime</label>
        <input type="radio" name="non_anime" id="non_anime"><label for="non_anime">Non anime</label>
        <input type="submit" value="Envoyer">
        <input type="reset" value="Recommencer">
    </form>
</body>
</html>