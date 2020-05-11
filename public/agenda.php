<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/Participation.php';
include '../src/ParticipationRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include 'scheduleTools.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$reunionRepository = new \Reunion\ReunionRepository($dbAdaper);
$participationRepository = new \Participation\ParticipationRepository($dbAdaper);
?>

<script>
function deployDiv(x,h,w,id) {
	h2 = h*getOffsetHeight(id)/100;
	if (h2<=x.scrollHeight) x.style.height = "auto";
  	else x.style.height = String(h)+"%";
  	x.style.width = String(w)+"%";
}

function concentrateDiv(x,h,w) {
  	x.style.height = String(h)+"%";
 	x.style.width = String(w)+"%";
}

function getOffsetHeight(id) {
	return document.getElementById(id).offsetHeight;
}

function printInfo(){
	var targetElement;
	targetElement = document.getElementById("idinfos") ;
	if (targetElement.style.display == "none") {
		targetElement.style.display = "block" ;
	}
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
    <link rel="stylesheet" href="schedule.css" media="screen" type="text/css" />
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Parions Retard</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                           <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                </li>
                    <a href='agenda.php' class="nav-link"><span>Agenda</span></a> 
                    <a href='profil.php' class="nav-link"><span>Profil</span></a> 
                    <a href='OrgaReu.php' class="nav-link"><span>Réunions</span></a>
                    <a href='bet.php' class="nav-link"><span>Paris</span></a>
                    <?php session_start();
                    if($_SESSION['username'] !== ""){
                    $points = $_SESSION['user']->getPoints();
                    echo "<div class='nav-link'>$points \$ </div>";
                    }
                    ?>
                    <?php if($userRepository->IsSuperAdmin($_SESSION['user']->getId()))
                      echo "<a href='home_super_admin.php' class='nav-link'><span>Gestion</span></a>";
                      ?>

                <?php session_start();
                        if($_SESSION['username'] !== ""){
                         $user = $_SESSION['username'];
                     // afficher un message
                     echo "<div class='connection_id nav-link' id='idco' >";
                     echo "$user";
                     echo "</div>";
		                  if(isset($_GET['deconnexion'])) { 
                       if($_GET['deconnexion']==true) {  
                  	    session_unset();
                  	    header("location:index.php");
                       }
             	    }

               	    }
                ?>
                    <a href='userlist.php?deconnexion=true' class="nav-link" style="align-text:right;"><span>Déconnexion</span></a> 
                 <?php 

				if (!isset($_GET['transition']))  $_SESSION['week'] = get_week(time());
				if (!isset($_GET['transition']))  $_SESSION['monthcal'] = time();
				if (!isset($_GET['transition']))  $_SESSION['sc-meeting'] = NULL;
                ?>
            </ul>
        </div>
    </nav>
</header>

<div class="Calendar">
	<div class="ca-month">
	<ul>
		<button class="ca-prev" onclick="window.location.href = 'transition.php?lastmonthcal=true'">&#10094;</button>
		<button class="ca-next" onclick="window.location.href = 'transition.php?nextweekcal=true'">&#10095;</button>
		<?php
			$timestamp = $_SESSION['monthcal'];
			$actual_month = trad_month(date('n',$timestamp));
			$actual_year = date('Y',$timestamp);
			echo "<li>$actual_month<br><span style='font-size:18px'>$actual_year</span></li>";
		?>
	</ul>
	</div>
	<ul class="ca-weekdays">
	<li>Lu</li>
	<li>Ma</li>
	<li>Me</li>
	<li>Je</li>
	<li>Ve</li>
	<li>Sa</li>
	<li>Di</li>
	</ul>
	<ul class="ca-days">
	<?php
	$timestamp = $_SESSION['monthcal'];
	for ($nday = 0; $nday <= 5; $nday++) {
		for ($day = 1; $day <= 7; $day++) {
			$actual_day = get_actual_timestamp($day,$nday,$timestamp);
			$num_actual_day = date('j',$actual_day);
			$month_actual_day = date('n',$actual_day);
			$year_actual_day = date('Y',$actual_day); 
			$isInMonth = ($month_actual_day == date('n',$_SESSION['monthcal']));
			$isSameNum = ($num_actual_day == date('j',$_SESSION['week']['timestamp']));
			$isSameMonth = ($month_actual_day == date('n',$_SESSION['week']['timestamp']));
			$isSameYear = ($year_actual_day == date('Y',$_SESSION['week']['timestamp']));
			if ($isInMonth) $daycolor = 'black';
			else $daycolor = '#777';
			if ($isSameNum && $isSameMonth && $isSameYear) {
				if (date('j',$_SESSION['week']['timestamp'])<10) {
					echo "<li>
							<span class='ca-smol'>
							<button class='ca-day-button' onclick='window.location.href = \"transition.php?setday=$actual_day\"'>$num_actual_day</button>
							</span>
							</li>";
				}
				else echo "<li>
							<span class='ca-big'>
							<button class='ca-day-button' onclick='window.location.href = \"transition.php?setday=$actual_day\"'>$num_actual_day</button>
							</span>
							</li>";
			}
			else echo "<li>
						<button style = 'color: $daycolor;' class='ca-day-button' onclick='window.location.href = \"transition.php?setday=$actual_day\"'>$num_actual_day</button>
						</li>";
		}
	}

	/**<li><span class="ca-active">10</span></li>*/
	?>
	</ul> 
</div>

<?php 
if (isset($_SESSION['sc-meeting'])) $display = "block";
else $display = "none";
echo "<div class='Infos' id='idinfos' style='display:$display;'>";

	if (isset($_SESSION['sc-meeting'])) {

		$iduser = $_SESSION['user']->getId();
		$infopackage = $_SESSION['sc-meeting'].":".$iduser;

		if ($participationRepository->isEnCours($_SESSION['sc-meeting'],$iduser) ){
			echo "<div class ='info-ouinon-container'>
					<div style = 'width: 60%; color: black; font-weight: bold;'>Souhaitez-vous participer à cette réunion? </div>
					<div class ='info-ouinon'>
						<button class ='info-oui' onclick='window.location.href = \"transition.php?checkparticipate=$infopackage\"'> Oui</button>
						<button class ='info-non' onclick='window.location.href = \"transition.php?dontparticipate=$infopackage\"'> Non</button>
					</div>
				</div>";
		}
		else if ($participationRepository->isOui($_SESSION['sc-meeting'],$iduser) ){
			echo "<div class ='info-change-container'> 
					<div style = 'width: 60%; color: black; font-weight: bold;'>Vous participez à cette réunion. </div>
					<div class ='info-change-inter'>		
						<button class ='info-change' onclick='window.location.href = \"transition.php?changemind=$infopackage\"'> Changer d'avis </button>
					</div>
				</div>";
		}
		else if ($participationRepository->isNon($_SESSION['sc-meeting'],$iduser) ){
			echo "<div class ='info-change-container'> 
					<div style = 'width: 75%; color: black; font-weight: bold;'> Vous ne participez pas à cette réunion. </div>
					<div class ='info-change-inter'>		
						<button class ='info-change' onclick='window.location.href = \"transition.php?changemind=$infopackage\"'> Changer d'avis </button>
					</div>
				</div>";
		}

		echo "<div style = 'margin-top: 2%;'>";
		$reunion =  $reunionRepository->getReunion($_SESSION['sc-meeting']);
		$nameAssoc = $reunionRepository->getNameAssoc($_SESSION['sc-meeting']);
		echo "<ul>Association : $nameAssoc</ul>";
		$duration = ($reunion->getDateFinReu()->getTimestamp() - $reunion->getDateDebutReu()->getTimestamp()) - 3600;
		if (date('G',$duration) == "0") {
			$duration = date('i',$duration);
			echo "<ul> Durée : $duration min</ul>";
		}
		else {
			$heure = date('G',$duration);
			$min = date('i',$duration);
			echo "<ul> Durée : $heure h $min min</ul>";
		}
		echo "</div>";
	
		$descriptif = $reunion->getDescriptif();
		if (isset($descriptif)) echo "<ul> Descriptif : $descriptif</ul>";

		echo "<ul> Participants :";
		$Participants = $participationRepository->getParticipationsReu($_SESSION['sc-meeting'],0);
		if ($participationRepository->isEnCours($_SESSION['sc-meeting'],$iduser) ) $divclass = 'info-participants-smol';
		else $divclass = 'info-participants';
		if (!empty($Participants)) {
			echo "<div class = $divclass>";
			foreach ($Participants as $part) {
				$u = $userRepository->getUserById($part->getIdMembre());
				$nameParticipant = $u->getUsername();
				echo "<li>$nameParticipant</li>";
			}
			echo "</div>";
		}
		else echo " Aucuns";
	}
	
echo "</ul></div>";
?>
	

<div class="Schedule">
    <div class="sc-toolBar">
		<div class="tb-left">
			<button class="tb-button" onclick="window.location.href = 'transition.php?lastweek=true'">Semaine précédente</button>
		</div>
	    <div class="tb-center">
			<?php 
			$weekname = $_SESSION['week']['week'];
			echo "<div>$weekname</div>"; ?>
		</div>
		<div class="tb-right">
			<button class="tb-button" onclick="window.location.href = 'transition.php?nextweek=true'">Semaine suivante</button>
		</div>
	</div>
  <table class="sc-table">
    <thead class="sc-head">
		<td class="sc-day-header sc-axis" ></td>
		<th class="sc-day-header text-center" >Lundi</th>
		<th class="sc-day-header text-center" >Mardi</th>
		<th class="sc-day-header text-center" >Mercredi</th>
		<th class="sc-day-header text-center" >Jeudi</th>
		<th class="sc-day-header text-center" >Vendredi</th>
		<tr class="sc-bg">
			<td class="sc-day sc-axis"></td>
			<td class="sc-day" align="center" >
				<?php 
				$l = explode("/",$_SESSION['week'][0]); 
				$day = add_zero($l[2])." / ".add_zero($l[1]);
				echo "$day";
				?>
			</td>
			<td class="sc-day" align="center" >
				<?php 
				$l = explode("/",$_SESSION['week'][1]); 
				$day = add_zero($l[2])." / ".add_zero($l[1]);
				echo "$day";
				?>
			</td>
			<td class="sc-day" align="center" >
				<?php 
				$l = explode("/",$_SESSION['week'][2]); 
				$day = add_zero($l[2])." / ".add_zero($l[1]);
				echo "$day";
				?>	
			</td>
			<td class="sc-day" align="center" >
				<?php 
				$l = explode("/",$_SESSION['week'][3]); 
				$day = add_zero($l[2])." / ".add_zero($l[1]);
				echo "$day";
				?>	
			</td>
			<td class="sc-day" align="center" >
				<?php 
				$l = explode("/",$_SESSION['week'][4]); 
				$day = add_zero($l[2])." / ".add_zero($l[1]);
				echo "$day";
				?>
			</td>
		</tr>
    </thead>
    <tbody class="sc-body">
	    <td class="sc-slats sc-td">
			<table class="sc-table-axis">
			<tbody>
				<tr class= "sc-axis-tr" data-time="08:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>08h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="09:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>09h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="10:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>10h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="11:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>11h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="12:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>12h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="13:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>13h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="14:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>14h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="15:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>15h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="16:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>16h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="17:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>17h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="18:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>18h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="19:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>19h</span></td>
				</tr>
				<tr class= "sc-axis-tr"data-time="20:00:00">
				<td class="sc-axis sc-time " style="width: 17px;"><span>20h</span></td>
				</tr>
			</tbody>
			</table>
		</td>
		    <td class ="sc-td">
			  <div class="sc-event-container" id ="lundi-container">
			  <?php
			  $id = $_SESSION['user']->getId();
			  $meetings = $reunionRepository->getMeeting($id,$_SESSION['week'][0]);
			  $formated_meetings = [];
			  foreach ($meetings as $meeting) {
				  $nom_asso = $reunionRepository->getNameAssoc($meeting->getIdReu());
				  $date_debut = $meeting->getDateDebutReu()->format('H:i');
				  $date_fin = $meeting->getDateFinReu()->format('H:i');
				  $id_reu = $meeting->getIdReu();
				  $formats = $meeting->formatMeetingDate();
				  $top = $formats[0];
				  $height = $formats[1];
				  $m = array(
					  "nom_asso"=>$nom_asso,
					  "date_debut"=>$date_debut,
					  "date_fin"=>$date_fin,
					  "id_reu"=>$id_reu,
					  "height"=>$height,
					  "top"=>$top,
					  "absolute_top"=>$top,
					  "overlap_rank"=>0,
					  "overlap_size"=>1,
					  "new"=>$participationRepository->isEnCours($id_reu,$id)
				  );
				  $m = determine_overlap_rank($formated_meetings,$m);
				  $formated_meetings[] = $m;
			  }
			  $formated_meetings = determine_overlap_sizes($formated_meetings);
			  foreach ($formated_meetings as $meeting) {
				  $height = $meeting['height'];
				  $top = $meeting['top'];
				  $absolute_top = $meeting['absolute_top'];
				  $id_reu = $meeting['id_reu'];
				  $nom_asso = $meeting['nom_asso'];
				  $date_debut = $meeting['date_debut'];
				  $date_fin = $meeting['date_fin'];
				  $overlap_rank = $meeting['overlap_rank'];
				  $overlap_size = $meeting['overlap_size'];
				  $width = 100/$overlap_size;
				  $left = $overlap_rank * $width;
				  $width = $width -0.5;
				  $height = $height -0.05;
				  if ($meeting['new']) $content_class = 'sc-content-new';
				  else $content_class = 'sc-content';
				  echo "<a class='sc-content-href'>
						  <button class='$content_class' onclick = 'window.location.href = \"transition.php?setreu=$id_reu\"' onmouseover='deployDiv(this,$height,$width,\"lundi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
						  <div class='sc-time'><span>  $date_debut - $date_fin  </span></div>
						  <div class='sc-title'>  Réunion $nom_asso </div>
						  </button>
						  <div class='sc-bg'></div>
					  </a>";
			  }
				?>
			  </div>
		      </td>
		      <td class ="sc-td" >
			  <div class="sc-event-container" id ="mardi-container">
				<?php
				$id = $_SESSION['user']->getId();
				$meetings = $reunionRepository->getMeeting($id,$_SESSION['week'][1]);
				$formated_meetings = [];
				foreach ($meetings as $meeting) {
					$nom_asso = $reunionRepository->getNameAssoc($meeting->getIdReu());
					$date_debut = $meeting->getDateDebutReu()->format('H:i');
					$date_fin = $meeting->getDateFinReu()->format('H:i');
					$id_reu = $meeting->getIdReu();
					$formats = $meeting->formatMeetingDate();
					$top = $formats[0];
					$height = $formats[1];
					$m = array(
						"nom_asso"=>$nom_asso,
						"date_debut"=>$date_debut,
						"date_fin"=>$date_fin,
						"id_reu"=>$id_reu,
						"height"=>$height,
						"top"=>$top,
						"absolute_top"=>$top,
						"overlap_rank"=>0,
						"overlap_size"=>1,
						"new"=>$participationRepository->isEnCours($id_reu,$id)
					);
					$m = determine_overlap_rank($formated_meetings,$m);
					$formated_meetings[] = $m;
				}
				$formated_meetings = determine_overlap_sizes($formated_meetings);
				foreach ($formated_meetings as $meeting) {
					$height = $meeting['height'];
					$top = $meeting['top'];
					$absolute_top = $meeting['absolute_top'];
					$id_reu = $meeting['id_reu'];
					$nom_asso = $meeting['nom_asso'];
					$date_debut = $meeting['date_debut'];
					$date_fin = $meeting['date_fin'];
					$overlap_rank = $meeting['overlap_rank'];
					$overlap_size = $meeting['overlap_size'];
					$width = 100/$overlap_size;
					$left = $overlap_rank * $width;
					$width = $width -0.5;
					$height = $height -0.05;
					if ($meeting['new']) $content_class = 'sc-content-new';
				  	else $content_class = 'sc-content';
					echo "<a class='sc-content-href'>
							<button class='$content_class' onclick = 'window.location.href = \"transition.php?setreu=$id_reu\"' onmouseover='deployDiv(this,$height,$width,\"mardi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
							<div class='sc-time'><span>  $date_debut - $date_fin </span></div>
							<div class='sc-title'>  Réunion $nom_asso </div>
							</button>
							<div class='sc-bg'></div>
						</a>";
				}
				?>
			  </div>
		      </td>
		      <td class ="sc-td">
			  <div class="sc-event-container" id ="mercredi-container">
				<?php
				$id = $_SESSION['user']->getId();
				$meetings = $reunionRepository->getMeeting($id,$_SESSION['week'][2]);
				$formated_meetings = [];
				foreach ($meetings as $meeting) {
					$nom_asso = $reunionRepository->getNameAssoc($meeting->getIdReu());
					$date_debut = $meeting->getDateDebutReu()->format('H:i');
					$date_fin = $meeting->getDateFinReu()->format('H:i');
					$id_reu = $meeting->getIdReu();
					$formats = $meeting->formatMeetingDate();
					$top = $formats[0];
					$height = $formats[1];
					$m = array(
						"nom_asso"=>$nom_asso,
						"date_debut"=>$date_debut,
						"date_fin"=>$date_fin,
						"id_reu"=>$id_reu,
						"height"=>$height,
						"top"=>$top,
						"absolute_top"=>$top,
						"overlap_rank"=>0,
						"overlap_size"=>1,
						"new"=>$participationRepository->isEnCours($id_reu,$id)
					);
					$m = determine_overlap_rank($formated_meetings,$m);
					$formated_meetings[] = $m;
				}
				$formated_meetings = determine_overlap_sizes($formated_meetings);
				foreach ($formated_meetings as $meeting) {
					$height = $meeting['height'];
					$top = $meeting['top'];
					$absolute_top = $meeting['absolute_top'];
					$id_reu = $meeting['id_reu'];
					$nom_asso = $meeting['nom_asso'];
					$date_debut = $meeting['date_debut'];
					$date_fin = $meeting['date_fin'];
					$overlap_rank = $meeting['overlap_rank'];
					$overlap_size = $meeting['overlap_size'];
					$width = 100/$overlap_size;
					$left = $overlap_rank * $width;
					$width = $width -0.5;
					$height = $height -0.05;
					if ($meeting['new']) $content_class = 'sc-content-new';
				  	else $content_class = 'sc-content';
					echo "<a class='sc-content-href'>
							<button class='$content_class' onclick = 'window.location.href = \"transition.php?setreu=$id_reu\"' onmouseover='deployDiv(this,$height,$width,\"jeudi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
							<div class='sc-time'><span>  $date_debut - $date_fin  </span></div>
							<div class='sc-title'>  Réunion $nom_asso </div>
							</button>
							<div class='sc-bg'></div>
						</a>";
				}
				?>
			  </div>
		      </td>
		      <td class ="sc-td">
			  <div class="sc-event-container" id ="jeudi-container">
				<?php
				$id = $_SESSION['user']->getId();
				$meetings = $reunionRepository->getMeeting($id,$_SESSION['week'][3]);
				$formated_meetings = [];
				foreach ($meetings as $meeting) {
					$nom_asso = $reunionRepository->getNameAssoc($meeting->getIdReu());
					$date_debut = $meeting->getDateDebutReu()->format('H:i');
					$date_fin = $meeting->getDateFinReu()->format('H:i');
					$id_reu = $meeting->getIdReu();
					$formats = $meeting->formatMeetingDate();
					$top = $formats[0];
					$height = $formats[1];
					$m = array(
						"nom_asso"=>$nom_asso,
						"date_debut"=>$date_debut,
						"date_fin"=>$date_fin,
						"id_reu"=>$id_reu,
						"height"=>$height,
						"top"=>$top,
						"absolute_top"=>$top,
						"overlap_rank"=>0,
						"overlap_size"=>1,
						"new"=>$participationRepository->isEnCours($id_reu,$id)
					);
					$m = determine_overlap_rank($formated_meetings,$m);
					$formated_meetings[] = $m;
				}
				$formated_meetings = determine_overlap_sizes($formated_meetings);
				foreach ($formated_meetings as $meeting) {
					$height = $meeting['height'];
					$top = $meeting['top'];
					$absolute_top = $meeting['absolute_top'];
					$id_reu = $meeting['id_reu'];
					$nom_asso = $meeting['nom_asso'];
					$date_debut = $meeting['date_debut'];
					$date_fin = $meeting['date_fin'];
					$overlap_rank = $meeting['overlap_rank'];
					$overlap_size = $meeting['overlap_size'];
					$width = 100/$overlap_size;
					$left = $overlap_rank * $width;
					$width = $width -0.5;
					$height = $height -0.05;
					if ($meeting['new']) $content_class = 'sc-content-new';
				  	else $content_class = 'sc-content';
					echo "<a class='sc-content-href'>
							<button class='$content_class' onclick = 'window.location.href = \"transition.php?setreu=$id_reu\"' onmouseover='deployDiv(this,$height,$width,\"jeudi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
							<div class='sc-time'><span>  $date_debut - $date_fin  </span></div>
							<div class='sc-title'>  Réunion $nom_asso </div>
							</button>
							<div class='sc-bg'></div>
						</a>";
				}
				?>		
			  </div>
		      </td>
		      <td class ="sc-td">
			  <div class="sc-event-container" id ="vendredi-container">
				<?php
				$id = $_SESSION['user']->getId();
				$meetings = $reunionRepository->getMeeting($id,$_SESSION['week'][4]);
				$formated_meetings = [];
				foreach ($meetings as $meeting) {
					$nom_asso = $reunionRepository->getNameAssoc($meeting->getIdReu());
					$date_debut = $meeting->getDateDebutReu()->format('H:i');
					$date_fin = $meeting->getDateFinReu()->format('H:i');
					$id_reu = $meeting->getIdReu();
					$formats = $meeting->formatMeetingDate();
					$top = $formats[0];
					$height = $formats[1];
					$m = array(
						"nom_asso"=>$nom_asso,
						"date_debut"=>$date_debut,
						"date_fin"=>$date_fin,
						"id_reu"=>$id_reu,
						"height"=>$height,
						"top"=>$top,
						"absolute_top"=>$top,
						"overlap_rank"=>0,
						"overlap_size"=>1,
						"new"=>$participationRepository->isEnCours($id_reu,$id)
					);
					$m = determine_overlap_rank($formated_meetings,$m);
					$formated_meetings[] = $m;
				}
				$formated_meetings = determine_overlap_sizes($formated_meetings);
				foreach ($formated_meetings as $meeting) {
					$height = $meeting['height'];
					$top = $meeting['top'];
					$absolute_top = $meeting['absolute_top'];
					$id_reu = $meeting['id_reu'];
					$nom_asso = $meeting['nom_asso'];
					$date_debut = $meeting['date_debut'];
					$date_fin = $meeting['date_fin'];
					$overlap_rank = $meeting['overlap_rank'];
					$overlap_size = $meeting['overlap_size'];
					$width = 100/$overlap_size;
					$left = $overlap_rank * $width;
					$width = $width -0.5;
					$height = $height -0.05;
					if ($meeting['new']) $content_class = 'sc-content-new';
				  	else $content_class = 'sc-content';
					echo "<a class='sc-content-href'>
							<button class='$content_class' onclick = 'window.location.href = \"transition.php?setreu=$id_reu\"' onmouseover='deployDiv(this,$height,$width,\"vendredi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
							<div class='sc-time'><span>  $date_debut - $date_fin  </span></div>
							<div class='sc-title'>  Réunion $nom_asso </div>
							</button>
							<div class='sc-bg'></div>
						</a>";
				}
				?>
			  </div>
		    </td>
		<hr class="sc-divider ui-widget-header" style="display: none;">
    </tbody>
  </table>
</div>

<?php
if (isset($_GET['overlapparticipate'])) {
	echo "<div class='sc-alert'>";
	echo "<div class='sc-alert-text'> Vous participez déjà aux réunions suivantes, 
			êtes vous sûr de vouloir participer à cette réunion? 
			(Vous serez automatiquement désincrit des autres réunions)</div>";
	echo "<ul class='sc-alert-content'>";
	$infopackage = explode(":",$_GET['overlapparticipate']);
	$overlapingmeetings = array_slice($infopackage, 2);
	foreach ($overlapingmeetings as $om) {
		$omeeting = $reunionRepository->getReunion($om);
		$start = date('H:i',$omeeting->getDateDebutReu()->getTimestamp());
		$end = date('H:i',$omeeting->getDateFinReu()->getTimestamp());
		$association = $reunionRepository->getNameAssoc($om);
		echo "<li >Réunion $association $start-$end</li>";
	}
	$infopackage = $_GET['overlapparticipate'];
	echo "</ul>";
	echo "<div class ='sc-alert-button-container'>
				<button class ='sc-alert-button-oui' onclick='window.location.href = \"transition.php?confirmparticipate=$infopackage\"'> Confirmer</button>
				<button class ='sc-alert-button-non' onclick='window.location.href = \"transition.php?cancelalert=true\"'> Annuler</button>
			</div>
	</div>";
}
?>


</body>
</html>