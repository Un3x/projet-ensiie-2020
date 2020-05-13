<?php

namespace Report;

class ReportRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $reportsData = $this->dbAdapter->query('SELECT * FROM "report" NATURAL JOIN "Ad"');
        $reports = [];
        foreach ($reportsData as $reportsDatum) {
            $report = new Report();
            $report
                ->setId($reportsDatum['id'])
                ->setText($reportsDatum['text'])
                ->setTextId($reportsDatum['email'])
                ->setCreatedAt(new \DateTime($reportsDatum['created_at']))
		->setAuthorId($reportsDatum['name'])
		->setConfirmed($reportsDatum['Confirmed']);
            $reports[] = $report;
        }
        return $reports;
    }

    public function delete ($reportId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "report" where id = :reportId');

        $stmt->bindParam('reportId', $reportId);
        $stmt->execute();
    }
}
