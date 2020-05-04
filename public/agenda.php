<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$reunionRepository = new \Reunion\ReunionRepository($dbAdaper);

/**
* @param $month un int correspondant à un mois de l'année
* @return $trad la traduction française
*/
function trad_month($month) {
	switch($month) {
		case 1 : return "Janvier"; break;
		case 2 : return "Février"; break;
		case 3 : return "Mars"; break;
		case 4 : return "Avril"; break;
		case 5 : return "Mai"; break;
		case 6 : return "Juin"; break;
		case 7 : return "Juillet"; break;
		case 8 : return "Août"; break;
		case 9 : return "Septembre"; break;
		case 10 : return "Octobre"; break;
		case 11 : return "Novembre"; break;
		case 12 : return "Décembre"; break;
	}
}

/**
* @param $timestamp un jour de la semaine au format timestamp
* @return $week un tableau contenant les jours de la semaine commençant par lundi
*/
function get_week($timestamp) {
	$day = getdate($timestamp);
	$wday = $day['wday'];
	$tempweek = [];
	$week = [];
	$tempweek['mon'] = 0;
	$tempweek['tue'] = 0;
	$tempweek['wed'] = 0;
	$tempweek['thu'] = 0;
	$tempweek['fri'] = 0;
	foreach($tempweek as $j) {
		$jour = $timestamp - ($wday-1)*86400;
		$jour = getdate($jour);
		$j = "{$jour['year']}/{$jour['mon']}/{$jour['mday']}";
		$week[] = $j;
	}
	$sun =  getdate($timestamp - $wday*86400);
	$week['sun'] = "{$sun['year']}/{$sun['mon']}/{$sun['mday']}";

	$first = 
	$faa = substr($week[0],0,4)." ";
	$fm = substr($week[0],6,7);
	$fd = substr($week[0],9,10)." ";
	$laa = " ".substr($week['sun'],0,4);
	$lm = substr($week['sun'],6,7);
	$ld = " " . substr($week['sun'],9,10);
	if ($fm == $lm) $fm = "";
	else $fm = trad_month($fm)." ";
	$lm = " ".trad_month($lm);
	if ($faa == $laa) $faa ="";
	$week['week'] = "{$fd}{$fm}{$faa}—{$ld}{$lm}{$laa}";
	return $week;
}
/**
* @param $fm et $m des array représentant des réunions
* @return true si les réunions se chevauchent et false sinon
*/
function determine_overlap($fm,$m) {
	if (($fm['absolute_top']>=$m['absolute_top'] && $fm['absolute_top']<$m['absolute_top']+$m['height']) 
	or ($m['absolute_top']>=$fm['absolute_top'] && $m['absolute_top']<$fm['absolute_top']+$fm['height'])){
		return true;
	}
	return false;
}

/**
* @param $mo une liste de réunions et $rank un entier
* @return $rank le rang minimal non attribué aux réunions 
*/
function determine_rank($mo,$rank) {
	$goodrank = true;
	foreach($mo as $m) {
		if ($m['overlap_rank']==$rank) {
			$goodrank = false;
		}
	}
	if ($goodrank) return $rank;
	else return determine_rank($mo,$rank+1);
}

/**
* @param $formated_meetings une liste des réunions au bon format et $meeting une réunion
* @return $formated_meetings et $meeting les versions reformatées des paramètres
*/
function determine_overlap_rank($formated_meetings,$meeting) {
	$meetings_overlaped = [];
	$meetings_not_overlaped = [];
	foreach($formated_meetings as $fm) {
		if (determine_overlap($fm,$meeting)) {
			$meetings_overlaped[]=$fm;
		}
		else $meetings_not_overlaped[]=$fm;
	}
	$meeting['overlap_rank']= determine_rank($meetings_overlaped,0);
	return $meeting;
}

/**
* @param $formated_meetings une liste des réunions au bon format
* @return $return la version reformatée de $formated_meetings
*/
function determine_overlap_sizes($formated_meetings) {
	$return1 = [];
	foreach($formated_meetings as $fm) {
		$maxrank = $fm['overlap_rank'];
		foreach($formated_meetings as $m) {
			if ($fm!=$m && determine_overlap($fm,$m)) {
				if ($m['overlap_rank']>$maxrank) $maxrank = $m['overlap_rank'];
			}
		}
		$fm['overlap_size']=$maxrank+1;
		$return1[] = $fm;
	}
	$return = [];
	foreach($return1 as $fm) {
		$maxsize = $fm['overlap_size'];
		foreach($return1 as $m) {
			if ($fm!=$m && determine_overlap($fm,$m)) {
				if ($m['overlap_size']>$maxsize) $maxsize = $m['overlap_size'];
			}
		}
		$fm['overlap_size']=$maxsize;
		$return[] = $fm;
	}

	return $return;
}
?>

<script>
function deployDiv(x,h,w,id) {
	h2 = h*get_offset_height(id)/100;
	if (h2<=x.scrollHeight) x.style.height = "auto";
  	else x.style.height = String(h)+"%";
  	x.style.width = String(w)+"%";
}

function concentrateDiv(x,h,w) {
  	x.style.height = String(h)+"%";
 	x.style.width = String(w)+"%";
}

function get_offset_height(id) {
	return document.getElementById(id).offsetHeight;
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
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link" href="/index.php"><span>Home</span></a>
                </li>
				<a class= "nav-link" href='agenda.php?deconnexion=true'><span>Déconnexion</span></a>	
                <?php session_start();
		    	if($_SESSION['username'] !== ""){
                    $user = $_SESSION['username'];
                   	// afficher un message
                   	echo "<div class='connection_id' id='idco'>";
                  	echo "$user";
                  	echo "</div>";
				   }
				if(isset($_GET['deconnexion'])) { 
                    if($_GET['deconnexion']==true) {  
                  	    session_unset();
                  	    header("location:index.php");
                    }
				 }   
				$week = get_week(time());
				print_r($week);
                ?>
            </ul>
        </div>
    </nav>
</header>
<div class="Schedule">
    <div class="sc-toolBar">
	    <div class="tb-left">Semaine précédente</div>
	    <div class="tb-center">
			<?php $weekname = $week['week'];
			echo "<div>$weekname</div>"; ?>
		</div>
		<div class="tb-right">Semaine suivante</div>
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
			<td class="sc-day" align="center" >2020-04-27</td>
			<td class="sc-day" align="center" >2020-04-28</td>
			<td class="sc-day" align="center" >2020-04-29</td>
			<td class="sc-day" align="center" >2020-04-30</td>
			<td class="sc-day" align="center" >2020-05-01</td>
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
			  $meetings = $reunionRepository->getMeeting($id,"2008/01/01");
			  $formated_meetings = [];
			  foreach ($meetings as $meeting) {
				  $nom_asso = $reunionRepository->getNameAssoc($meeting);
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
				  echo "<a class='sc-content-href'>
						  <div class='sc-content' onmouseover='deployDiv(this,$height,$width,\"lundi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
						  <div class='sc-time' data-start='16:00' data-full='4:00 PM - 5:45 PM'><span>  $date_debut - $date_fin  </span></div>
						  <div class='sc-title'>  Réunion $nom_asso </div>
						  </div>
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
				$meetings = $reunionRepository->getMeeting($id,"2009/01/01");
				$formated_meetings = [];
				foreach ($meetings as $meeting) {
					$nom_asso = $reunionRepository->getNameAssoc($meeting);
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
					echo "<a class='sc-content-href'>
							<div class='sc-content' onmouseover='deployDiv(this,$height,$width,\"mardi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
							<div class='sc-time' data-start='16:00' data-full='4:00 PM - 5:45 PM'><span>  $date_debut - $date_fin </span></div>
							<div class='sc-title'>  Réunion $nom_asso </div>
							</div>
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
				$meetings = $reunionRepository->getMeeting($id,"2010/01/01");
				$formated_meetings = [];
				foreach ($meetings as $meeting) {
					$nom_asso = $reunionRepository->getNameAssoc($meeting);
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
					echo "<a class='sc-content-href'>
							<div class='sc-content' onmouseover='deployDiv(this,$height,$width,\"jeudi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
							<div class='sc-time' data-start='16:00' data-full='4:00 PM - 5:45 PM'><span>  $date_debut - $date_fin  </span></div>
							<div class='sc-title'>  Réunion $nom_asso </div>
							</div>
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
				$meetings = $reunionRepository->getMeeting($id,"2011/01/01");
				$formated_meetings = [];
				foreach ($meetings as $meeting) {
					$nom_asso = $reunionRepository->getNameAssoc($meeting);
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
					echo "<a class='sc-content-href'>
							<div class='sc-content' onmouseover='deployDiv(this,$height,$width,\"jeudi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
							<div class='sc-time' data-start='16:00' data-full='4:00 PM - 5:45 PM'><span>  $date_debut - $date_fin  </span></div>
							<div class='sc-title'>  Réunion $nom_asso </div>
							</div>
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
				$meetings = $reunionRepository->getMeeting($id,"2012/01/01");
				$formated_meetings = [];
				foreach ($meetings as $meeting) {
					$nom_asso = $reunionRepository->getNameAssoc($meeting);
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
					echo "<a class='sc-content-href'>
							<div class='sc-content' onmouseover='deployDiv(this,$height,$width,\"vendredi-container\")' onmouseout='concentrateDiv(this,$height,$width)' style='width:$width%; height:$height%; top:$top%; left:$left%;'>
							<div class='sc-time' data-start='16:00' data-full='4:00 PM - 5:45 PM'><span>  $date_debut - $date_fin  </span></div>
							<div class='sc-title'>  Réunion $nom_asso </div>
							</div>
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


</body>
</html>