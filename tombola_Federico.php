<?php

// Cartella vuota punto di partenza per tutte le cartelle
$cartellaVuota = array ( 
	array ( 0, 0, 0, 0, 0, 0, 0, 0, 0), 
	array ( 0, 0, 0, 0, 0, 0, 0, 0, 0),
	array ( 0, 0, 0, 0, 0, 0, 0, 0, 0));

/* mi trova un valore da inserire nella tabella, decina mi permette di determinare la colonna ed il numero finale è $valore */
function candidato() {
	global $decina, $unità, $valore, $row;
	$row = rand(0, 2);
	$decina = rand(0, 8); 
	$unità = rand(0, 9);
	if ($unità == 0) {
		$valore = ($decina + 1)*$unità;
	}
	else {
		$valore = $decina*10 + $unità;
	}
	return $valore;
}

//conta quanti valori ho inserito nella tabella
function conta($array){ 
	Global $numeriTabella;
	$numeriTabella = 0;
	foreach ($array as $riga => $colonna) {
		foreach ($colonna as $numero => $value) {
			if ($value != 0) {
				$numeriTabella++;
			}
		}
	}
}

/* funzione orripilante, controlla che non ci siano valori doppi
e che rispettino l'ordine di grandezza prima di essere inseriti */
function controlloColonna($colonna, $riga, $valore, $array){
	if (($array[0][$colonna] == 0)&&($array[1][$colonna] == 0)&&($array[2][$colonna] == 0)) {
		return 0;
	}
	elseif ($array[$riga][$colonna] == 0) {
		if ($riga == 0) {
			if ((($array[1][$colonna] > $valore)||($array[1][$colonna] == 0))&&(($array[2][$colonna] > $valore)||($array[2][$colonna] == 0))) {
				return 0;
			}
		}
		elseif ($riga == 1) {
			if ((($array[0][$colonna] < $valore)||($array[0][$colonna] == 0))&&(($array[2][$colonna] > $valore)||($array[2][$colonna] == 0))) {
				return 0;
			}
		}
	}
	return 1;
}

/* questa funzione controlla che ci siano al massimo 5 valori per riga */
function controlloRiga ($riga, $array) {
	$numeriRiga = 0;
	for ($i=0; $i < count($array[$riga]); $i++) {
		if ($array[$riga][$i] != 0) {
			$numeriRiga++;
		}
	}
	if ($numeriRiga >= 5) {
		return 1;
	}
	return 0; 
}

// inserisce i valori dentro l'array dopo aver controllato se sono adatti
function inserimento($colonna, $riga, $valore, &$array){
	if ((controlloColonna($colonna, $riga, $valore, $array)==0)&&(controlloRiga ($riga, $array)==0)) {
		$array[$riga][$colonna] = $valore;
	}
}

/* Crea una cartella della tombola, ricomincia se dopo 10000 iterazioni 
non ho ottenuto una cartella completa */
function generaCartella(){
	global $decina, $unità, $valore, $row, $cartellaVuota, $cartella, $numeriTabella;
	while ($numeriTabella < 15) {
	$cartella = $cartellaVuota;
		for ($i=0; $i < 10000; $i++) {
			candidato();
			inserimento($decina, $row, $valore, $cartella);
			conta($cartella);
			if ($numeriTabella == 15) {
				return $cartella;
			}
		}
	}
}

// Genera una grafica più leggibile per la cartella creata
function graficaCartella($array){
	foreach ($array as $riga => $numeroRiga) {
		echo "<br>___________________________<br>";
		foreach ($numeroRiga as $colonna => $value) {
			if ($value < 10) {
				echo " | ".$value;
			}
			else {
			echo " | ".$value;
			}
		}
		echo " |";
	}
	echo "<br>___________________________<br>";
}

$cartella1 = generaCartella();
//print_r($cartella);
//echo "<br>".$numeriTabella;
graficaCartella($cartella1);