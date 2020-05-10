<?php

namespace Rating;

class RatingRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function delete_ratings(int $userId)
    {
        $query = "UPDATE rate SET userId = 1 WHERE userId =:userId";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userId', $userId);
        $result->execute();        
    }


    /*
     * \brief Get all ratings for a story given its id
     * \return \all ratings of a given story
     */
    public function fetchRating(int $storyId) 
    {
	$query = 'SELECT rateid, rate FROM rate WHERE storyid = :storyId';
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':storyId', $storyId);
        $result->execute();
        $rates = [];
	foreach($result as $cur_rate) 
	{
	    $temp = new Rating();
	    $temp
	    ->setId($cur_rate['rateid'])
	    ->setRate($cur_rate['rate']);
	    $rates[] = $temp;
	}
	return $rates;
    }


    /*
     * \brief Get the average rate for a story, given its id
     * \return \an int which is the average rating of the given story
     */
    public function fetchAvgRating(int $storyId)
    {
	$query = 'SELECT rate FROM rate WHERE storyid= :storyId';
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':storyId', $storyId);
        $result->execute();
	$r=0;
	$i=0;
	foreach ($result as $cur)
	{
	    $i++;
	    $r=$r + $cur['rate'];
	}
	$moyenne=$r/$i;
	return round($moyenne, 1);

    }

    /*
     * \brief Get the amount of persons who voted for a given story
     * \return \an int which is the amount of votes for a given story
     */
    public function fetchCountRating(int $storyId)
    {
	$query = 'SELECT rate FROM rate WHERE storyid= :storyId';
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':storyId', $storyId);
        $result->execute();
	$i=0;
	foreach ($result as $cur)
	{
	    $i++;
	}
	return $i;

    }

    /*
     * \brief Get the amount of persons who gave a given rate to a given story
     * \return \an int which is the amount of votes for a given story and number of stars
     */
    public function fetchStarCount(int $storyId, int $stars)
    {
	$query = 'SELECT rate FROM rate WHERE storyid= :storyId';
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':storyId', $storyId);
        $result->execute();
	$i=0;
	foreach ($result as $cur)
	{
	    if ($cur['rate'] == $stars) 
	    {
		$i++;
	    }
	}
	return $i;

    }

    public function addRate(int $userId, int $storyId, int $stars)
    {
        if (is_int($userId) && is_int($storyId) && is_int($stars)) {
            $query = 'INSERT INTO rate (rate, userId, storyId) VALUES (:stars, :userid, :storyid)';
            $result = $this->dbAdapter->prepare($query);
            $result->bindParam(':stars', $stars);
            $result->bindParam(':userid', $userId);
            $result->bindParam(':storyid', $storyId);
            $result->execute();
        return $result;
        }else{
            return FALSE;
        }
    }

    public function alreadyRated(int $userId, int $storyId)
    {
        $query = 'SELECT * FROM rate WHERE userId=:userid AND storyId=:storyid';
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userid', $userId);
        $result->bindParam(':storyid', $storyId);
        $result->execute();
        return $result->rowCount() != 0;
    }



}

?>











