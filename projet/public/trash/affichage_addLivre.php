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
        <input type="text" name="titre" id="titre_livre" /><label for="titre_livre">Titre</label>
        <input type="url" name="lien_photo" id="lien_photo_livre"/> <label for="lien_photo_livre">Lien_photo</label>
        <input type="date" name="date_sortie" id="date_sortie_livre"/> <label for="date_sortie_livre">Date de sortie</label>

        <input type="number" name="" id="nb_pages"/><label for="nb_pages">Nombre de pages</label>
        <input type="text" name="genre_livre" id="genre_livre"/> <label for="genre_livre">Genre</label>
        <input type="text" name="langue" id="langue"/> <label for="langue">Langue</label>
        <input type="submit" value="Envoyer">
        <input type="reset" value="Recommencer">
    </form>
</body>
</html>