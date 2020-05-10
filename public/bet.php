<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';
include '../src/Participation.php';
include '../src/ParticipationRepository.php';
include '../src/Paris.php';
include '../src/ParisRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include 'scheduleTools.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$reunionRepository = new \Reunion\ReunionRepository($dbAdaper);
$assoRepository = new \Asso\AssoRepository($dbAdaper);
$participationRepository = new \Participation\ParticipationRepository($dbAdaper);
$parisRepository = new \Paris\ParisRepository($dbAdaper);
?>

<script>
function toggleMeetings(id) {
    var targetElement;
	targetElement = document.getElementById("asso-"+id) ;
	if (targetElement.style.display == "block") {
		targetElement.style.display = "none" ;
	}
    else targetElement.style.display = "block";
    var arrowR;
    var arrowD;
    arrowR = document.getElementById("arrow-r-"+id);
    arrowD = document.getElementById("arrow-d-"+id);
    if (arrowD.style.display == "block") {
		arrowD.style.display = "none";
        arrowR.style.display = "block";
	}
    else {
        arrowD.style.display = "block";
        arrowR.style.display = "none";
    }
}
function toggleBetPannel() {
    var targetElement;
    targetElement = document.getElementById('bpBi');
    var targetElement2;
    targetElement2 = document.getElementById('bpBic');
    if (targetElement.style.display == "none") {
	targetElement.style.display = "block" ;
    targetElement2.style.display = "none" ;
    }
    else {
        targetElement.style.display = "none";
        targetElement2.style.display = "block" ;
    }
}
function printCote(avgDelayArray,avgDelayAssoArray,nbParisCoeff){
    var cote;
    var miseInput = document.getElementById("bi-retard");
    var gaindiv = document.getElementById("bi-cote");
    var membre = document.getElementById("bi-username-input").value;
    var avgDelay;
    var avgDelayAsso;
    var tmp;
    var avgDelayA = avgDelayArray.split('/');
    for(var i=0;i<avgDelayA.length;i++) {
        tmp = avgDelayA[i].split('-');
        avgDelayA[i]=tmp;
    }
    var avgDelayAssoA = avgDelayAssoArray.split('/');
    for(var i=0;i<avgDelayAssoA.length;i++) {
        tmp = avgDelayAssoA[i].split('-');
        avgDelayAssoA[i]=tmp;
    }
    for(var i=0;i<avgDelayA.length;i++) {
        if (avgDelayA[i][0] == membre) avgDelay = avgDelayA[i][1];
    }
    for(var i=0;i<avgDelayAssoA.length;i++) {
        if (avgDelayAssoA[i][0] == membre) avgDelayAsso = avgDelayAssoA[i][1];
    }
    var y = new Date("2000-01-01 "+avgDelay+":00");
    var z = new Date("2000-01-01 00:00:00");
    avgDelay = (+y - +z)/1000;
    var y = new Date("2000-01-01 "+avgDelayAsso+":00");
    var z = new Date("2000-01-01 00:00:00");
    avgDelayAsso = (+y - +z)/1000;

    var avg = (avgDelay + avgDelayAsso)/2;

    var a = 0.9/(1200*1200);
    var b = -2*a*avg;
    var c = 1.15 + a*avg*avg;

    var y = new Date("2000-01-01 "+miseInput.value+":00");
    var z = new Date("2000-01-01 00:00:00");
    var delay = (+y - +z)/1000;
    
    cote = (a*delay*delay + b*delay + c) * nbParisCoeff;
    cote = Math.round(cote*1000)/1000;
    const cotestr = cote.toString();
    const str = "Cote : ";
    gaindiv.innerHTML = str+cote;
}
</script>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Projet web Ensiie</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">

<body>
<header>
    <link rel="stylesheet" href="Bet.css" media="screen" type="text/css" />
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link" href="/agenda.php"><span>Home</span></a>
                </li>
				<a href='profil.php' class="nav-link"><span>Profil</span></a> 
				<a href='/userlist.php' class="nav-link"><span>Userlist</span></a> 
                <a href='userlist.php?deconnexion=true' class="nav-link"><span>Déconnexion</span></a>  
                <a href='bet.php' class="nav-link"><span>Paris</span></a>  
                <?php session_start();
		    	if($_SESSION['username'] !== ""){
                    $user = $_SESSION['username'];
                    $points = $_SESSION['user']->getPoints();
                   	// afficher un message
                   	echo "<div class='connection_id nav-link' id='idco'>";
                  	echo "$user";
                    echo "</div>";
                    echo "<div class='nav-link'>$points</div>";
				   }
				if(isset($_GET['deconnexion'])) { 
                    if($_GET['deconnexion']==true) {  
                  	    session_unset();
                  	    header("location:index.php");
                    }
               
                if (!isset($_GET['transition'])) {
                    $_SESSION['btMeeting'] = NULL;
                }  
				}  
                ?>
            </ul>
        </div>
    </nav>
</header>

<div class = "ReuListe">
    <ul>
    <?php
        $AssoListe = $assoRepository->fetchAll();
        foreach($AssoListe as $Asso) {
            $nomAsso = $Asso->getNomAssoc();
            $idAsso = $Asso->getIdAssoc();
            $nowDate  = date('Y-m-d H:i:s');
            $ReuListe = $reunionRepository->getMeetingForBetList($idAsso,$nowDate);
            if (!empty($ReuListe)) {
                echo "<li class ='rl-deroulant'>";
                echo "<button class = 'rl-deroulant-content' onclick ='toggleMeetings($idAsso)'> $nomAsso
                            <div id = 'arrow-r-$idAsso' class='arrow-right'>.</div>
                            <div id = 'arrow-d-$idAsso' class='arrow-down'>.</div>
                        </button>";
                echo "<div id ='asso-$idAsso' class = 'rl-subderoulant'>";
                foreach($ReuListe as $Reu) {
                    $idReu = $Reu->getIdReu();
                    $dateDebutReu = $Reu->getDateDebutReu()->format('H:i');
                    $dateFinReu = $Reu->getDateFinReu()->format('H:i');
                    $jourReu = $Reu->getDateDebutReu()->format('d/m/Y');
                    echo "<button id ='reu-$idReu' class='rl-content' onclick = 'window.location.href = \"transitionParis.php?setreu=$idReu\"'>
                            Réunion du $jourReu - $dateDebutReu - $dateFinReu
                    </button>";
                }
                echo "</div></li>";
            }
        }
    ?>
    </ul>
</div>

<div class = "BetPanel">
    <div class = "bp-ReuInfos">
        <div class = "bp-ReuInfos-main">
            <?php
                if (isset($_SESSION['btMeeting'])) {
                    $idReu = $_SESSION['btMeeting'];
                    $Reu = $reunionRepository->getReunion($idReu);
                    $dateDebutReu = $Reu->getDateDebutReu()->format('H:i');
                    $dateFinReu = $Reu->getDateFinReu()->format('H:i');
                    $jourReu = $Reu->getDateDebutReu()->format('d/m/Y');
                    $duration = ($Reu->getDateFinReu()->getTimestamp() - $Reu->getDateDebutReu()->getTimestamp()) - 3600;
                    $nomAsso = $reunionRepository->getNameAssoc($idReu);

                    echo "<div> <div class ='bp-ReuInfos-main-content'>Réunion du $jourReu </div> 
                                <div class ='bp-ReuInfos-main-content'>$nomAsso</div>
                                <div class ='bp-ReuInfos-main-content'>$dateDebutReu - $dateFinReu</div>";

                    if (date('G',$duration) == "0") {
                        $duration = date('i',$duration);
                        echo "<div class ='bp-ReuInfos-main-content'>Durée : $duration min</div>";
                    }
                    else {
                        $heure = date('G',$duration);
                        $min = date('i',$duration);
                        echo "<div class ='bp-ReuInfos-main-content'>Durée : $heure h $min min</div>";
                    }
                    

                    $Paris = $parisRepository->getParisByIdReu($idReu);
                    $nombreParis = count($Paris);
                    echo "<div class ='bp-ReuInfos-main-content'>Paris: $nombreParis</div>";

                    echo "</div>";
                }
            ?>
        </div>
        <div class = 'bp-ReuInfos-membres'>
            <table class = 'bp-ReuInfos-table'>
                <thead>
                    <th>Nom du participant</th>
                    <th>Retard Moyen</th>
                    <th>Retard Moyen dans l'Asso</th>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['btMeeting'])) {
                        $idReu = $_SESSION['btMeeting'];
                        $Reu = $reunionRepository->getReunion($idReu);
                        $idAsso = $Reu->getIdAssoc();
                        $Participations = $participationRepository->getParticipationsReu($idReu,0);
                        if (!empty($Participations)) {
                            foreach ($Participations as $participation) {
                                $idParticipant = $participation->getIdMembre();
                                $participant = $userRepository->getUserById($idParticipant);
                                $participantName = $participant->getUsername();
                                $avgLate = $participationRepository->getAverageDelay($idParticipant);
                                $avgLateAsso = $participationRepository->getAverageDelayAsso($idParticipant,$idAsso);
                                echo "<tr> 
                                        <td>$participantName</td>
                                        <td>$avgLate</td>
                                        <td>$avgLateAsso</td>
                                     </tr>";
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class = 'bp-BetInput'>
        <?php 
        if (isset($_SESSION['btMeeting'])) {
            $Participations = $participationRepository->getParticipationsReu($idReu,0);
            $nombreParticipations = 0;
            if (!empty($Participations)) {
                foreach ($Participations as $participation) {
                    $idParticipant = $participation->getIdMembre();
                    $participant = $userRepository->getUserById($idParticipant);
                    $participantName = $participant->getUsername();
                    if ($participantName!=$_SESSION['username']) $nombreParticipations++;
                }
                if ($nombreParticipations>0) echo "<button id = 'bpBi' class = 'bp-BetInput-parier' onclick ='toggleBetPannel();'> PARIER </button>";
            }
        }
        ?>
        
        <div id = 'bpBic' class = 'bp-BetInput-content'>
            <form action='transitionParis.php?betSubmit=<?php echo $idReu?>' name="betSubmit" method="post">
                <div class = 'bi-username'>
                    <label for="username">Membre</label>
                    <select size="1" id ='bi-username-input' name="betUsername">
                        <?php
                        if (isset($_SESSION['btMeeting'])) {
                            $idReu = $_SESSION['btMeeting'];
                            $Participations = $participationRepository->getParticipationsReu($idReu,0);
                             if (!empty($Participations)) {
                                foreach ($Participations as $participation) {
                                    $idParticipant = $participation->getIdMembre();
                                    $participant = $userRepository->getUserById($idParticipant);
                                    $participantName = $participant->getUsername();
                                    if ($participantName!=$_SESSION['username']) echo "<option value='$idParticipant'>$participantName</option>";
                                }
                            }
                            else echo "<option value='Jony'>Jony</option>
                                    <option value='Franck'>Franck</option>
                                    <option value='Francus'>Francus</option>
                                    <option value='Popaul'>Popaul</option>
                                    <option value='Rodolphf'>Rodolphf</option>";
                        }
                        else echo "<option value='Jony'>Jony</option>
                                <option value='Franck'>Franck</option>
                                <option value='Francus'>Francus</option>
                                <option value='Popaul'>Popaul</option>
                                <option value='Rodolphf'>Rodolphf</option>";
                        ?>
                    </select>
                </div>
                <?php
                    if (isset($_SESSION['btMeeting'])) {
                        $idReu = $_SESSION['btMeeting'];
                        $Paris = $parisRepository->getParisByIdReu($idReu);
                        $nombreParis = count($Paris);
                        $nbParisCoeff = 100/(100+$nombreParis);
                        $Reunion = $reunionRepository->getReunion($idReu);
                        $idAsso = $Reunion->getIdAssoc();
                        $Participations = $participationRepository->getParticipationsReu($idReu,0);
                        if (!empty($Participations)) {
                            $avgDelayArray = "xx-xx:xx";
                            $avgDelayAssoArray = "xx-xx:xx";
                            foreach ($Participations as $participation) {
                                $idMembre = $participation->getIdMembre();
                                $avgDelay = $participationRepository->getAverageDelay($idMembre);
                                $avgDelayAsso = $participationRepository->getAverageDelayAsso($idMembre,$idAsso);
                                $avgDelayArray = $avgDelayArray ."/". $idMembre."-".$avgDelay;
                                $avgDelayAssoArray = $avgDelayAssoArray ."/". $idMembre."-".$avgDelay;
                            }        
                        }
                    }
                ?>
                <div class = 'bi-retard'>
                    <label for="retard">Retard</label>
                    <?php 
                        $idReu = $_SESSION['btMeeting'];
                        $Reu = $reunionRepository->getReunion($idReu);
                        $duration = ($Reu->getDateFinReu()->getTimestamp() - $Reu->getDateDebutReu()->getTimestamp()) - 3600;

                        echo "<input type='time' id='bi-retard' name='betRetard' required
                        onblur='printCote(\"$avgDelayArray\",\"$avgDelayAssoArray\",$nbParisCoeff);'
                        max =' date('H:i',$duration);'
                            
                        placeholder='10 min'>"
                    ?>
                </div>
                <div class = 'bi-mise'>
                    <label for="mise">Mise</label>
                    <input type="number" id="bi-mise" name="betMise" min="1" max="<?php echo $_SESSION['user']->getPoints();?>"placeholder="10 points" required>
                </div>
                <div class = 'bi-cote' id='bi-cote'>
                        Cote : 
                </div>
                <div class = 'bi-valider'>
                    <input type="submit" value="Valider">
                </div>
            </form>
            <button class = 'bi-annuler' onclick ='toggleBetPannel()'>Annuler</button>
            
        </div>
    </div>
</div>

<div class = "MyBets">
    <div class = "mb-title">Mes Paris</div>
    <div class = "mb-list">
        <?php
            $myBets = $parisRepository->getParisByPlayer($_SESSION['user']->getId());
            if (!empty($myBets)) {
                foreach ($myBets as $bet) {
                    $bet
                ->setIdParis($bet_row['id_paris'])
                ->setPlayer($bet_row['player'])
                ->setIdReu($bet_row['id_reu'])
                ->setIdUser($bet_row['id_user'])
                ->setRetard($bet_row['retard'])
                ->setMise($bet_row['mise'])
                ->setDateParis($bet_row['date_paris']);
                    $participant = $bet->getIdUser();
                    $delay = $bet->getRetard();
                    $mise = $bet->setMise();
                    $idReu = $bet->getIdReu();
                    $Reu = $reunionRepository->getReunion($idReu);
                    $dateDebutReu = $Reu->getDateDebutReu()->format('H:i');
                    $dateFinReu = $Reu->getDateFinReu()->format('H:i');
                    $jourReu = $Reu->getDateDebutReu()->format('d/m/Y');
                    $nomAsso = $reunionRepository->getNameAssoc($idReu);
                    echo " <div>
                            <div>Réunion $nomAsso du $jourReu $dateDebutReu - $dateFinReu<div>
                            <div> $participant -> retard: $delay  Mise: $mise<div>
                           </div>";

                }
            }
        ?>
    </div>
</div>



</body>
</html>