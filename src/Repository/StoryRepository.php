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
     * information on a story
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
     * \brief Delete the story given its id
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
    
    /*
     * \brief Get a story given its id
     * \return \a story a story object containing the necessary
     * information about it
     */
    public function fetchStory(int $storyId) {
        $query = 'SELECT storyid, title, author, summary FROM story WHERE storyid = :storyId';
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':storyId', $storyId);
        $result->execute();
        $storyResult = $result->fetch();
        $story = new Story();
        $story
          ->setId($storyResult['storyid'])
          ->setTitle($storyResult['title'])
          ->setAuthor($storyResult['author'])
          ->setSummary($storyResult['summary']);
        return $story;
    }

    /*
     * \brief Get the pages of a story given its id
     * \return \a pages a list of page objects, containing the necessary
     * information about them
     */
    public function fetchPages(int $storyId) {
        $query = 'SELECT pageid, txt, choiceint1, choiceint2, choiceint3, choicetext1,
                  choicetext2, choicetext3, firstpage, lastpage
                  FROM page WHERE storyid = :storyId';
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':storyId', $storyId);
        $result->execute();
        $pages = [];
        
        foreach($result as $pagesDatum) {
            //Create a page object and add it to the list of pages
            $page = new Page();
            $page
            ->setId($pagesDatum['pageid'])
            ->setText($pagesDatum['txt'])
            ->setChoice1($pagesDatum['choiceint1'])
            ->setChoice2($pagesDatum['choiceint2'])
            ->setChoice3($pagesDatum['choiceint3'])
            ->setText1($pagesDatum['choicetext1'])
            ->setText2($pagesDatum['choicetext2'])
            ->setText3($pagesDatum['choicetext3'])
            ->setFirst($pagesDatum['firstpage'])
            ->setLast($pagesDatum['lastpage']);
            $pages[] = $page;
        }
        return $pages;
    }
}
?>
