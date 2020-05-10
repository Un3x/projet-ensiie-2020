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
	return $moyenne;

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



}

?>











