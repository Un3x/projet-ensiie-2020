<?php

namespace Tweet;

class TweetRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;


    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }


    public function sendTweet ($content,$sender)    // envoi du message $content à l'utilisateur $sender
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "tweet" (content,written_at,is_answer,author) VALUES (:content,NOW(), false,:sender)');

        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':sender', $sender);

        $stmt->execute();
        $stmt = null;

       return $this->dbAdapter->lastInsertId();
    }


    public function getMyTweets($userName)     // récupération des tweets de $userName sous la forme d'une Array d'objets Tweet
    {
        $stmt = $this->dbAdapter->prepare('SELECT * FROM "tweet" WHERE author = :userName ORDER BY written_at DESC');
        $stmt->bindParam('userName', $userName);
        $stmt->execute();
        $userTweets = $stmt->fetchAll();

        $tweets = [];
        foreach ($userTweets as $userTweet) {
            $tweet = new Tweet();
            $tweet
                ->setIdTweet($userTweet['id_tweet'])
                ->setContent($userTweet['content'])
                ->setDate(new \DateTime($userTweet['written_at']))
                ->setIsAnswer($userTweet['is_answer'])
                ->setAuthor($userTweet['author'])
                ->setNbLike($userTweet['nblike']);
            $tweets[] = $tweet;
        }
        return $tweets;
    }


    public function showTweets($tweets){    // affichage de chacun des tweets contenus dans l'Array $tweets

        foreach($tweets as $unTweet) {

            $id_tweet = $unTweet->getIdTweet();
            $authorName = $unTweet->getAuthor();
            $getDate = ($unTweet->getDate());
            $nbLike = $unTweet->getNbLike();
            $formattedDate = $getDate -> format('d/m/Y');
            $formattedHour = $getDate -> format('H:i');?>

            <div id="tweetFormatter">

                <div id="content"> <?php echo $unTweet->getContent(); ?> </div>

                <div id="sentHour">
                    <?php echo "Envoyé par " . $authorName . " le " . $formattedDate ." à " .$formattedHour ?>
                </div>

                <div id="actions">

                    <form id="sendLike" method="POST" action="../../src/Utils/like.php">

                        <button name = "like" id="btn_like" type="submit" value=<?php echo $id_tweet; ?>>
                            <img id="logolike" src="../../public/img/logolike.png"></button>
                    </form>

                    <form id="sendRetweet" method="POST" action="../../src/Utils/retweet.php">

                        <button name = "retweet" id="retweet" type="submit" value=<?php echo $id_tweet; ?>>
                            <img id="logolike" src="../../public/img/logoretweet.png"></button>
                    </form>
                </div>

                <p id="countLike"> <?php echo $nbLike; ?> </p>
            </div>

    <?php }
    }




    public function retweet($id_tweet,$userName) {      // ajout au feed de $userName le tweet $id_tweet que celui-ci a retweeté

        $this->addToFeed($id_tweet,$userName);
    }


    public function isLiked ($id_tweet,$userName)   {   // vérification que $userName n'a pas déjà liké le tweet $id_tweet

      $stmt = $this
            ->dbAdapter
            ->prepare('SELECT COUNT(*) AS isliked FROM "like" WHERE id_tweet = :id_tweet AND username = :username');

        $stmt->bindValue(':id_tweet', $id_tweet);
        $stmt->bindValue(':username', $userName);

        $stmt->execute();
        $row = $stmt->fetch();
        $stmt = null;

        return $row['isliked'];
    }



    public function likeTweet($id_tweet,$userName) {    // l'utilisateur $userName like le tweet $id_tweet + mise à jour du nombre de likes


        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "tweet" SET nblike = nblike + 1 WHERE id_tweet = :id_tweet');

        $stmt->bindValue(':id_tweet', $id_tweet);
        $stmt->execute();
        $stmt = null;

        $stmt2 = $this
            ->dbAdapter
            ->prepare('INSERT INTO "like" VALUES (:id_tweet,:username)');

        $stmt2->bindValue(':username', $userName);
        $stmt2->bindValue(':id_tweet', $id_tweet);
        $stmt2->execute();

        $stmt2 = null;

    }


    public function addToFeed ($id_tweet,$taggedUser) {     // ajout au feed de $taggedUser du tweet $id_tweet

        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "feed" VALUES (:id_tweet,:username)');

        $stmt->bindValue(':id_tweet', $id_tweet);
        $stmt->bindValue(':username', $taggedUser);
        $stmt->execute();

        $stmt = null;

    }


     public function getMyFeed ($taggedUser) {  // récupération du feed de $taggedUser, la fonction renvoyant une Array d'object Tweet

        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT id_tweet,content,written_at,is_answer,nblike,author FROM "feed" NATURAL JOIN "tweet" WHERE username = :username');

        $stmt->bindValue(':username', $taggedUser);
        $stmt->execute();
        $userTweets = $stmt->fetchAll();


        $stmt = null;
        $tweets = [];
        foreach ($userTweets as $userTweet) {
            $tweet = new Tweet();
            $tweet
                ->setIdTweet($userTweet['id_tweet'])
                ->setContent($userTweet['content'])
                ->setDate(new \DateTime($userTweet['written_at']))
                ->setIsAnswer($userTweet['is_answer'])
                ->setAuthor($userTweet['author'])
                ->setNbLike($userTweet['nblike']);
            $tweets[] = $tweet;
        }
        return $tweets;

    }

}
