<?php


namespace Interest;

include '../src/Interest.php';

use Exception;
use PDO;

class InterestRepository
{
    /**
     * @var PDO
     */
    private $dbAdapter;

    public function __construct(PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    public function fetchAll()
    {
        $interestsData = $this->dbAdapter->query('SELECT * FROM "Interest"');
        $interests = [];
        foreach ($interestsData as $interestsDatum) {
            $interest = new Interest();
            try {
                $interest
                    ->setTheme($interestsDatum['theme'])
                    ->setSubscribers($interestsDatum['subscribers']);
            } catch (Exception $e) {
            }
            $interests[] = $interest;
        }
        return $interests;
    }


    public function delete($theme)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Interest" where theme = :theme');

        $stmt->bindParam('theme', $theme);
        $stmt->execute();
    }

    public function add($theme)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Interest" (theme, subscribers) VALUES (:theme,0)');
        $stmt->bindParam('theme', $theme);
        $stmt->execute();
    }
    public function addsub($theme){
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "Interest" SET subscribers=subscribers+1 WHERE theme=:theme');
        $stmt->bindParam('theme', $theme);
        $stmt->execute();
    }



}