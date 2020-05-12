<?php

namespace Oeuvre;

class OeuvreRepository
{
	/**
     * @var \PDO
     */
    private $dbAdaper;

    public function __construct(\PDO $dbAdaper)
    {
        $this->dbAdaper = $dbAdaper;
    }

    public function fetchAllLivre()
    {
        $livresData = $this->dbAdaper->query('SELECT * FROM Oeuvre JOIN Livre ON Oeuvre.numero = Livre.M1_cle');
        $livres = [];
        foreach ($livresData as $livresDatum) {
            $livre = new Livre();
            $livre
                ->setNumero($livresDatum['numero'])
                ->setTitre($livresDatum['titre'])
                ->setLienPhoto($livresDatum['lien_photo'])
                ->setDateSortie(new \DateTime($livresDatum['date_sortie']))
                ->setNbPages($livresDatum['nb_pages'])
                ->setLangue($livresDatum['langue'])
                ->setGenreLivre($livresDatum['genre']);
            $livres[] = $livre;
        }
        return $livres;
    }
    
     public function fetch($id_liste)
    {
        $oeuvresData = $this->dbAdaper->prepare('SELECT * FROM Oeuvre JOIN EtreDans ON Oeuvre.numero = EtreDans.numero WHERE EtreDans.id_liste = ?');
        $oeuvresData->execute(array($id_liste));
        $oeuvres = [];
        foreach ($oeuvresData as $oeuvresDatum) {
            $oeuvre = new Oeuvre();
            $oeuvre
                ->setTitre($oeuvresDatum['titre'])
                ->setNumero($oeuvresDatum['numero'])
                ->setLienPhoto($oeuvresDatum['lien_photo']);
            $oeuvres[] = $oeuvre;
        }
        return $oeuvres;
    }

    public function fetchAllFilm()
    {
    	$filmsData = $this->dbAdaper->query('SELECT * FROM Oeuvre JOIN Film ON Oeuvre.numero = Film.M2_cle');
        $films = [];
        foreach ($filmsData as $filmsDatum) {
            $film = new Film();
            $film
                ->setNumero($filmsDatum['numero'])
                ->setTitre($filmsDatum['titre'])
                ->setLienPhoto($filmsDatum['lien_photo'])
                ->setDateSortie(new \DateTime($filmsDatum['date_sortie']))
                ->setRealisateur($filmsDatum['realisateur'])
                ->setGenreFilm($filmsDatum['genre'])
                ->setDureeFilm($filmsDatum['duree'])
                ->setProducteur($filmsDatum['producteur']);
            $films[] = $film;
        }
        return $films;
    }

    public function fetchAllSerie()
    {
    	$seriesData = $this->dbAdaper->query('SELECT * FROM Oeuvre JOIN Serie ON Oeuvre.numero = Serie.M3_cle');
        $series = [];
        foreach ($seriesData as $seriesDatum) {
            $serie = new Serie();
            $serie
                ->setNumero($seriesDatum['numero'])
                ->setTitre($seriesDatum['titre'])
                ->setLienPhoto($seriesDatum['lien_photo'])
                ->setDateSortie(new \DateTime($seriesDatum['date_sortie']))
                ->setNbEp($seriesDatum['nb_ep'])
                ->setNbSaisons($seriesDatum['nb_saisons'])
                ->setDureeSerie($seriesDatum['duree'])
                ->setGenreSerie($seriesDatum['genre'])
                ->setAnime($seriesDatum['anime']);
            $series[] = $serie;
        }
        return $series;
    }

    public function delete ($oeuvreId)
    {
        $stmt = $this
            ->dbAdaper
            ->prepare('DELETE FROM Oeuvre where numero= :oeuvreId');

        $stmt->bindParam('oeuvreId', $oeuvreId);
        $stmt->execute();
    }

    public function add ($titre_oeuvre,$lien_photo,$date_oeuvre){
        $stmt = $this
            ->dbAdaper
            ->prepare('INSERT INTO Oeuvre(titre,lien_photo,date_sortie) VALUES (:titre_oeuvre, :lien_photo, :date_oeuvre)');
        $stmt->bindParam(':titre_oeuvre', $titre_oeuvre);
        $stmt->bindParam(':lien_photo', $lien_photo);
        $stmt->bindParam(':date_oeuvre', $date_oeuvre);
        $stmt->execute();
    }
    
}