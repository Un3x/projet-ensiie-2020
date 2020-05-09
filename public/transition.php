<html>
<head>
</head>
<body>
<?php
include 'scheduleTools.php';
include '../src/Participation.php';
include '../src/ParticipationRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$reunionRepository = new \Reunion\ReunionRepository($dbAdaper);
$participationRepository = new \Participation\ParticipationRepository($dbAdaper);

session_start();
if (isset($_GET['lastweek'])) {
	if ($_GET['lastweek']==true) {
        $_SESSION['week'] = get_week($_SESSION['week']['timestamp']-604800);
        $_SESSION['monthcal'] = $_SESSION['week']['timestamp'];
        header('Location: agenda.php?transition=true');
	}
}
else if (isset($_GET['nextweek'])) {
	if ($_GET['nextweek']==true) {
        $_SESSION['week'] = get_week($_SESSION['week']['timestamp']+604800);
        $_SESSION['monthcal'] = $_SESSION['week']['timestamp'];
        header('Location: agenda.php?transition=true');
	}
}

if (isset($_GET['lastmonthcal'])) {
	if ($_GET['lastmonthcal']==true) {
        $_SESSION['monthcal'] = strtotime('-1 month', $_SESSION['monthcal'] );
        header('Location: agenda.php?transition=true');
	}
}
else if (isset($_GET['nextweekcal'])) {
	if ($_GET['nextweekcal']==true) {
        $_SESSION['monthcal'] = strtotime('+1 month', $_SESSION['monthcal'] );
        header('Location: agenda.php?transition=true');
	}
}

if (isset($_GET['setday'])) {
        $_SESSION['week'] = get_week($_GET['setday']);
        $_SESSION['monthcal'] = $_GET['setday'];
        header('Location: agenda.php?transition=true');
}

if (isset($_GET['setreu'])) {
        $_SESSION['sc-meeting'] = $_GET['setreu'];
        header('Location: agenda.php?transition=true');
}

if (isset($_GET['changemind'])) {
        $infopackage = explode(":",$_GET['changemind']);
        $participationRepository->updateStatus(intval($infopackage[0]),intval($infopackage[1]),2);
        header('Location: agenda.php?transition=true');
}

if (isset($_GET['checkparticipate'])){
        $infopackage = explode(":",$_GET['checkparticipate']);
        $overlapingmeetings = $reunionRepository->getOverlaping(intval($infopackage[0]),intval($infopackage[1]));
        $idoverlapings = "";
        $overlapingmeetingsY = [];
        if (!empty($overlapingmeetings)) {
                foreach ($overlapingmeetings as $om) {
                        if ($participationRepository->isOui($om->getIdReu(),intval($infopackage[1]))) $overlapingmeetingsY[]=$om;
                }
        }

        if (!empty($overlapingmeetingsY)) {
                foreach ($overlapingmeetingsY as $om) {
                        $idoverlapings = $idoverlapings.":".($om->getIdReu());
                }
                $infopackage = $infopackage[0].":".$infopackage[1].$idoverlapings;
                header('Location: agenda.php?transition=true&overlapparticipate='.$infopackage);     
        }
        else {
                $participationRepository->updateStatus(intval($infopackage[0]),intval($infopackage[1]),0);
                header('Location: agenda.php?transition=true');
        }
           
}

if (isset($_GET['participate'])) {
        $infopackage = explode(":",$_GET['participate']);
        $participationRepository->updateStatus(intval($infopackage[0]),intval($infopackage[1]),0);
        header('Location: agenda.php?transition=true');
}

if (isset($_GET['dontparticipate'])) {
        $infopackage = explode(":",$_GET['dontparticipate']);
        $participationRepository->updateStatus(intval($infopackage[0]),intval($infopackage[1]),1);
        header('Location: agenda.php?transition=true');
}

if (isset($_GET['confirmparticipate'])) {
        $infopackage = explode(":",$_GET['confirmparticipate']);
        $participationRepository->updateStatus(intval($infopackage[0]),intval($infopackage[1]),0);
        $overlapingmeetings = array_slice($infopackage, 2);
        foreach ($overlapingmeetings as $om) {
                $participationRepository->updateStatus(intval($om),intval($infopackage[1]),1);
        }
        header('Location: agenda.php?transition=true');
}


if (isset($_GET['cancelalert'])) {
        header('Location: agenda.php?transition=true');
}

?>
</body>
</html>