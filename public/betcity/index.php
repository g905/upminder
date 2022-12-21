<?php

header('Content-Type: text/html; charset=utf-8');

/* Получаем IDS */
$url = 'https://ad.betcity.ru/d/on_air/events?rev=5&md=1661619856&ver=290&csn=ooca9s';

$ci = curl_init();

curl_setopt($ci, CURLOPT_URL, $url);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);

$ce = curl_exec($ci);
curl_close($ci);

/* JSON */
$json = json_decode($ce, true);
if (!is_array($json)) {
	die(json_encode(['status' => 'error', 'step' => 1]));
}

$reply = $json['reply'];

/* Футбол */
$list = $reply['sports'][1];

/* Формируем ID */
$ids = [];
foreach ($list['chmps'] as $ch) {
	$ids[] = array_keys($ch['evts']);
}

/* В одномерный */
$ids_new = [];
foreach ($ids as $id_list) {
	foreach ($id_list as $id) {
		$ids_new[] = $id;
	}
}

/* Формируем URL */
$url_params = [

	'rev' => 8,
	'add' => 'dep_event',
	'ver' => 290,
	'csn' => 'ooca9s',
	'ids' => $ids_new,

];

$url = 'https://ad.betcity.ru/d/on_air/bets?';
$params .= http_build_query($url_params);
$url = $url.$params;

//echo $url;
//exit;

/* Запрос */
$ci = curl_init();

curl_setopt($ci, CURLOPT_URL, $url);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);

$ce = curl_exec($ci);
curl_close($ci);

/* JSON */
$json = json_decode($ce, true);
if (!is_array($json)) {
	die(json_encode(['status' => 'error']));
}

$reply = $json['reply'];

/* Футбол */
$data = $reply['sports'][1];
$list = $data['chmps'];

/* Формируем массив */
$form = [];

foreach ($list as $ch_id => $ch_data) {
	
	$name = trim($ch_data['name_ch']);
	
	/* Фора */
	foreach ($ch_data['evts'] as $evt_id => $evt_data) {
		
		$team = trim($evt_data['name_ht'].' - '.$evt_data['name_at']);
		$time_name = $evt_data['time_name'];
		
		foreach ($evt_data['main'] as $ext) {
			
			$ext_name = trim($ext['name']);
			if ($ext_name !== 'Фора') {
				continue;
			}
			
			$form[$name][$team][$time_name] = [];
			foreach ($ext['data'] as $ext_id => $ext_d) {
			
				$form[$name][$team][$time_name] = [
				
					'F1' => $ext_d['blocks']['F1m']['F1'],
					'F2' => $ext_d['blocks']['F1m']['F2'],
				
				];
				
			}
			
		}
	
	}
	
}

foreach ($form as $ch => $ch_games) {

	echo '<p>Чемпионат <strong>'.$ch.'</strong></p>';
	echo '<table width="100%" border="1">';
	echo '<tr><td width="70%">Команды</td><td align="center">Ф1</td><td align="center">Ф2</td></tr>';
		
	foreach ($ch_games as $game => $times) {
	
		foreach ($times as $time_name => $data) {
			
			echo '<tr>';
			
			echo '<td>'.$game.' ('.$time_name.')</td>';
			echo '<td align="center">'.$data['F1'].'</td>';
			echo '<td align="center">'.$data['F2'].'</td>';
			
			echo '</tr>';
			
		}	
		
	}
	
	echo '</table>';
	
}