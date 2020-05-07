<?php
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
* @param $num un int
* @return $res une chaine composée de 0 et $num si $num est un chiffre et $num sinon
*/
function add_zero($num) {
    switch($num) {
		case 1 : return "0{$num}"; break;
		case 2 : return "0{$num}"; break;
		case 3 : return "0{$num}"; break;
		case 4 : return "0{$num}"; break;
		case 5 : return "0{$num}"; break;
		case 6 : return "0{$num}"; break;
		case 7 : return "0{$num}"; break;
		case 8 : return "0{$num}"; break;
        case 9 : return "0{$num}"; break;
        default : return "{$num}";
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
	$i=1;
	foreach($tempweek as $j) {
		$jour = $timestamp - ($wday-$i)*86400;
		$jour = getdate($jour);
		$j = "{$jour['year']}/{$jour['mon']}/{$jour['mday']}";
		$week[] = $j;
		$i=$i+1;
	}
	$sun =  getdate($timestamp - ($wday-7)*86400);
	$week['sun'] = "{$sun['year']}/{$sun['mon']}/{$sun['mday']}";

	$first = explode("/",$week[0]);
	$last = explode("/",$week['sun']);
	$faa = $first[0];
	$fm = $first[1];
	$fd = $first[2]." ";
	$laa = " ".$last[0];
	$lm = $last[1];
	$ld = " " .$last[2];
	if ($fm == $lm) $fm = "";
	else $fm = trad_month($fm)." ";
	$lm = " ".trad_month($lm);
	if ($faa == $laa) $faa ="";
	$week['week'] = "{$fd}{$fm}{$faa}—{$ld}{$lm}{$laa}";
    $week['timestamp'] = $timestamp;
	return $week;
}

/**
* @param $timestamp un jour du mois, $day compris entre 1 et 7 et $nday entre 0 et 5
* @return $date le jour correspondant au $nday eme jour $day du mois
*/
function get_actual_timestamp($day,$nday,$timestamp){
    $month = date('n',$timestamp);
    $year = date('Y',$timestamp);
    $first_day = mktime(0, 0, 0, $month, 1, $year);
    $name_first_day = date('w',$first_day);
    $day_dur = 86400;
    $week_dur = 604800;
    $date = $first_day + ($day - $name_first_day) * $day_dur + $nday * $week_dur;
    return $date;
}


/**
* @param $timestamp un jour du mois
* @return $date le numero du $nday eme jour $day du mois
*/
function get_day_num($day,$nday,$timestamp) {
    $month = date('n',$timestamp);
    $year = date('Y',$timestamp);
    $first_day = mktime(0, 0, 0, $month, 1, $year);
    $name_first_day = date('w',$first_day);
    $day_dur = 86400;
    $week_dur = 604800;
    $right_day = $first_day + ($day - $name_first_day) * $day_dur + $nday * $week_dur;
    $date = date('j',$right_day);
    return $date;
}

/**
* @param $timestamp un jour du mois
* @return true si le $nday eme jour $day appartient au mois et false sinon
*/
function get_day_font($day,$nday,$timestamp) {
    $month = date('n',$timestamp);
    $year = date('Y',$timestamp);
    $first_day = mktime(0, 0, 0, $month, 1, $year);
    $name_first_day = date('w',$first_day);
    $day_dur = 86400;
    $week_dur = 604800;
    $right_day = $first_day + ($day - $name_first_day) * $day_dur + $nday * $week_dur;
    $actual_month = date('n',$right_day);
    return ($month == $actual_month);
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