<?php

namespace Hashtag;

class HashtagRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll(){     // récupération de la liste des hashtags sous la forme d'une Array d'objets Hashtag

        $hashtagsData = $this->dbAdapter->query('SELECT * FROM "hashtag"');
        $hashtags = [];
        foreach ($hashtagsData as $hashtagDatum) {
            $hashtag = new Hashtag();
            $hashtag
                ->setIdHashtag($hashtagDatum['id_hashtag'])
                ->setNameHashtag($hashtagDatum['name']);
            $hashtags[] = $hashtag;
        }
        return $hashtags;
    }


   public function checkIfHashtagExists ($hashtag) {    // on vérifie si $hashtag eexiste déjà dans la BD

        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT COUNT(*) AS nbhashtag FROM "hashtag" WHERE name = :name');

        $stmt->bindParam(':name', $hashtag);

        $stmt->execute();
        $row = $stmt->fetch();
        $stmt = null;

        return $row['nbhashtag'];

    }


    public function addHashTag ($hashtag) {     // ajout du hashtag $hashtag dans la BD


        if($this->checkIfHashtagExists($hashtag) == 0) {    // le hashtag n'existe pas encore
            $stmt = $this
                ->dbAdapter
                ->prepare('INSERT INTO "hashtag" (name) VALUES (:hashtag)');

            $stmt->bindParam('hashtag', $hashtag);
            $stmt->execute();

            $stmt = null; 
        }
    }

    public function showHashtags($hashtags)     // affichage de la liste des hashtags, $hashtags étant une Array d'objets Hashtag
    {

        if(!empty($hashtags)) { ?>

            <table class="tableFollows">
                    <?php 
                    foreach($hashtags as $hashtag) { 

                        $currentHashtag = $hashtag->getNameHashtag(); ?>
                        <tr>
                            <td> 
                                <a href= <?php echo "home.php?action=viewHashtagTweetList&hashtag=". $currentHashtag; ?> > 
                                    <?php echo $currentHashtag; ?> 
                                </a> 

                                </a> 
                            </td>
                        </tr>

                    <?php } ?>
            </table>
            
        <?php
        }
    }
}
