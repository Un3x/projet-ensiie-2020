<?php

namespace Oeuvre;

class FilmRepository extends OeuvreRepository
{
    /**
     * @var \PDO
     */
    private $dbAdaper;

    public function __construct(\PDO $dbAdaper)
    {
        $this->dbAdaper = $dbAdaper;
    }

    public function add_film ($id,$realisateur,$genre,$duree,$producteur){
        
        $stmt = $this
            ->dbAdaper
            ->prepare('INSERT INTO Film(M2_cle,realisateur,genre,duree,producteur) VALUES (:id,:realisateur,:genre,:duree,:producteur)');

        $stmt->bindParam('M2_cle', $id);
        $stmt->bindParam('realisateur', $realisateur);
        $stmt->bindParam('genre', $genre);
        $stmt->bindParam('duree', $duree);
        $stmt->bindParam('producteur', $producteur);
        $stmt->execute();
    }

    public function fetchGenre($genre)
    {
        $genreData = $this->dbAdaper->prepare('SELECT * FROM Film JOIN Oeuvre ON numero=M2_cle WHERE genre = :genre ');
        $genreData->bindParam('genre', $genre);
        $genreData->execute();

        $genres = [];
        foreach ($genreData as $genreDatum) {
            $genre_film = new Film();
            $genre_film
                ->setNumero($genreDatum['M2_cle'])
                ->setTitre($genreDatum['titre'])
                ->setLienPhoto($genreDatum['lien_photo'])
                ->setDateSortie($genreDatum['date_sortie'])
                ->setRealisateur($genreDatum['realisateur'])
                ->setGenreFilm($genreDatum['genre'])
                ->setDureeFilm($genreDatum['duree'])
                ->setProducteur($genreDatum['producteur']);
            $genres[] = $genre_film;
        }
        return $genres;
    }
}