<?php

namespace Story;

class StoryRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    /*
     * \brief Get all the stories in the database
     * \return \a stories a list of story objects containing the necessary
     * informations on a story
     */
    public function fetchAll()
    {
        $storyData = $this->dbAdapter->query('SELECT storyid, title, author, summary  FROM story');
        $stories = [];
        foreach ($storyData as $storyDatum) {
          // Create a story object and add it to the stories list
          $story = new Story();
          $story
            ->setId($storyDatum['storyid'])
            ->setTitle($storyDatum['title'])
            ->setAuthor($storyDatum['author'])
            ->setSummary($storyDatum['summary']);
          $stories[] = $story;
        }
        return $stories;
    }

    /*
     * \brief Delete the story given it's id
     * \param \a storyId id of the story to delete from the database
     */
    public function delete_story (int $storyId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM story WHERE storyid = :storyId');

        $stmt->bindParam(':storyId', $userId);
        $stmt->execute();
    }
    
    public function fetchStory(int $storyId) {
        $query = 'SELECT storyid, title, author, summary FROM story WHERE storyid = :storyId';
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':storyId', $storyId);
        $result->execute();
        $storyResult = $result->fetch();
        $story = new Story();
        $story
          ->setId($storyResult[0]['storyid'])
          ->setTitle($storyResult[0]['title'])
          ->setAuthor($storyResult[0]['author'])
          ->setSummary($storyResult[0]['summary']);
    }

}
?>
