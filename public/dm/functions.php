<?php

/* Алмазная картина по фото. Файл функций ядра */
if (!defined('_SY')) {
	die();
}

/*
	Ответ JSON
	$status - Статус ответа
	$text - Текст ответа
*/
function json_response($status, $text = '') {
	
	$result = [
	
		'status' => $status,
		'text' => $text,
	
	];
	
	die(json_encode($result));
	
}

/*
	Функция обрабатывает поступившие $_POST данные
*/
function filter_post($post) {
	
	if (!is_array($post)) {
		return false;
	}
	
	$data = [];
	foreach ($post as $key => $value) {
		
		$key = trim($key);
		$data[$key] = trim(strip_tags(stripslashes($value)));
		
	}
	
	return $data;
	
}
	

/* Обработка POST */
if (isset($_POST['action'])) {
	
	$post = filter_post($_POST);
	
	/* Загрузка изображения */
	if ($post['action'] == 'upload') {
		
		$result = upload_image($_FILES['image']);
		
		/* Выдаём ошибку при попытке загрузки файла */
		if (isset($result['error'])) {
			json_response('error', $result['error']);
		}
		
		/* Имя файла-изображения в самом конце */
		$image_info = explode('/', $result['url']);
		$image_name = trim(end($image_info));
		
		/* Формируем форму */
		$html = '<div class="photo_editor">';
		
		$html .= '<h2>Выберите участок фото</h2>';
		
		$html .= '<div class="photo"><img id="preview_photo" src="'.$result['url'].'" /></div>';
		$html .= '<ul class="tools">';
		
		$html .= '<li><a href="javascript:void(0);" data-cmd="rotate_b90" class="photo_cmd">-O</a></li>';
		$html .= '<li><a href="javascript:void(0);" data-cmd="rotate_t90" class="photo_cmd">+O</a></li>';
		$html .= '<li><a href="javascript:void(0);" data-cmd="zoom_in" class="photo_cmd">+</a></li>';
		$html .= '<li><a href="javascript:void(0);" data-cmd="zoom_out" class="photo_cmd">-</a></li>';
		
		$html .= '</ul>';
		
		$html .= '<input type="hidden" name="action" value="crop" />';
		$html .= '<input type="hidden" name="image" value="'.$image_name.'" />';
		$html .= '<input id="p_x" type="hidden" name="p_x" value="0" />';
		$html .= '<input id="p_y" type="hidden" name="p_y" value="0" />';
		$html .= '<input id="p_width" type="hidden" name="p_width" value="0" />';
		$html .= '<input id="p_height" type="hidden" name="p_height" value="0" />';
		$html .= '<input id="p_angle" type="hidden" name="p_angle" value="0" />';
		
		$html .= '<button id="p_crop" type="button" class="btn btn_flat">Продолжить</button>';
		
		$html .= '</div>';
		
		/* Отдаём HTML */
		json_response('ok', $html);
		
	}
	/* Обрезка изображения */
	elseif ($post['action'] == 'crop') {
		
		/* Необходимые параметры */
		$required = ['image', 'p_x', 'p_y', 'p_width', 'p_height', 'p_angle'];
		foreach ($required as $key) {
			
			if (!isset($post[$key]) or strlen($post[$key]) == 0) {
				json_response('error', 'Недостаточно данных '.$key);
			}
			
		}
		
		/* Существует ли изображение */
		$image_path = _STARTERS_DIR.$post['image'];
		if (!file_exists($image_path)) {
			json_response('error', 'Не найдено изображение!');
		}
		
		require_once(_INC.'img_base.php');
		
		/* Название файла-изображения */
		$image_name = explode('.', $post['image']);
		$new_name = trim($image_name[0]).'_cropped.'.trim(end($image_name));
		$new_pixelated_name = trim($image_name[0]).'_pixelated.'.trim(end($image_name));
		$new_pixelated_color = trim($image_name[0]).'_color.'.trim(end($image_name));
		$new_pixelated_vintage = trim($image_name[0]).'_vintage.'.trim(end($image_name));
		
		/* Обрезаем */
		$crop_result = do_img_crop($image_path, _STARTERS_DIR.$new_name, $post['p_x'], $post['p_y'], $post['p_width'], $post['p_height'], $post['p_angle']);
		if (!$crop_result) {
			json_response('error', 'Не удалось обработать изображение');
		}
		
		/* Размер пикселя */
		$dia_size = floor($crop_result['width'] / 84);
		
		/* Пикселизация */
		$pixels = image_pixels($crop_result['path'], _STARTERS_DIR.$new_pixelated_name, $dia_size, $dia_size, true, true);
		$pixels_color = image_pixels($crop_result['path'], _STARTERS_DIR.$new_pixelated_color, $dia_size, $dia_size);
		
		/* Цвет картины. 3 варианта */
		$gray = $pixels['path'];
		$vintage = $pixels['path'];
		$color = $pixels['path'];
		
		/* Формируем HTML */
		$html = '<div class="photo_editor">';
		$html .= '<h2>Выберите вариант мозайки</h2>';
		
		$html .= '<div class="photos">';
				
		$html .= '<div class="photo select_photo selected" data-var="gray" style="background-image: url('._STARTERS_URL.$new_pixelated_name.');"></div>';
		$html .= '<div class="photo select_photo" data-var="vintage" style="background-image: url('._STARTERS_URL.$new_pixelated_name.');"></div>';
		$html .= '<div class="photo select_photo" data-var="color" style="background-image: url('._STARTERS_URL.$new_pixelated_color.');"></div>';
		
		$html .= '</div>';

		$html .= '<input type="hidden" name="action" value="select" />';
		$html .= '<input type="hidden" name="image" value="'.$new_name.'" />';
		$html .= '<input id="p_variant" type="hidden" name="p_variant" value="gray" />';
		$html .= '<button id="p_select" type="button" class="btn btn_flat">Продолжить</button>';
		
		$html .= '</div>';
		
		json_response('ok', $html);
		
	}
	/* Выбран вариант */
	elseif ($post['action'] == 'select') {
		
		/* Картина */
		$image_name = $post['image'];
		if ($post['p_variant'] == 'vintage') {
			$image_name = $post['image'];
		}
		elseif ($post['p_variant'] == 'color') {
			$image_name = trim(str_replace('_cropped', '_color', $image_name));
		}
		
		$original_name = trim(str_replace('_cropped', '', $image_name));
		$name_result = trim(str_replace('_result', '', $image_name));
		$sizes = getimagesize(_STARTERS_DIR.$original_name);
		$dia_size = floor($sizes[0] / 84);
		
		require_once(_INC.'img_base.php');
		
		$data = image_pixels(_STARTERS_DIR.$original_name, $name_result, $dia_size, $dia_size, true, true);
		$scheme = $data['scheme'];
		$data = $data['data'];

		/* Подготавливаем схему PDF */
		
		/* Делим на 3 колонки */
		$html = '<html><head><meta charset="utf-8" /><title>Результат</title></head><body>';
		$html .= '<div class="result" style="width: 100vw; height: 100vh; padding: 30px; box-sizing: border-box;">';
		$html .= '<h1 style="display: block; text-align: center; font-size: 24px; font-weight: bolder;">РЕЗУЛЬТАТ</h1><br />';
		//$html .= '<a href="'._STARTERS_URL.$name_result.'" style="display: block; text-align: center;">Как выглядит в собранном виде?</a><br />';
		$html .= '<div class="pdf">';
		
		foreach ($data as $row => $row_data) {
			
			$third_part = sizeof($row_data) - 1;
			$third_part = round($third_part / 3);
			$this_parts = array_chunk($row_data, $third_part, true);
			
			/*
			var_dump($row);
			print_r($this_parts);
			exit;
			*/
			
			$letters = [];
			
			$html .= '<div class="row">';
			 
			//for ($a = 0; $a < 3; $a++) {
				
				//$html .= '<div class="col">';
				
				foreach ($this_parts as $part_k => $diamonds) {
					
					if ($part_k >= 3) {
						break;
					}
					
					$html .= '<div class="col">';
					
					foreach ($diamonds as $dia) {
						
						$this_color = $dia['color'];
						$letter = $scheme[$this_color];

						$this_color = explode('-', $dia['color']);
						$this_bg = $this_color[0].', '.$this_color[1].', '.$this_color[2];
						$html .= '<div class="diamond" style="background-color: rgba('.$this_bg.');">'.$letter.'</div>';
					
					}
					
					$html .= '</div>';
					
				}
			
				//$html .= '</div>';
				
			//}
			
			$html .= '</div>';
			
		}
		
		$html .= '</div>';
		$html .= '</div>';	
		$html .= '	<style>
		.pdf {
			margin: 30px auto;
			width: 210mm;
		}
		.row {
			width: 100%;
			position: relative;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.col {
			width: calc(100% / 3);
			min-height: 2.5mm;
			display: flex;
			justify-content: space-between;
			font-size: 8px !important;
			text-align: center;
		}
		.col .diamond {
			flex: 1;
		}
		body {
			width: 100vw;
			height: 100vh;
			overflow-x: hidden;
		}
		* {
			margin: 0;
			padding: 0;
			outline: none;
			font-family: Arial;
			font-size: 12px;
		}
		.wrapper {
			width: 100vw;
			height: 100vh;
		}
		.wrapper form {
			width: 100%;
			height: 100%;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.drop_here {
			background: #f1f1f1;
			border: 3px dashed gray;
			padding: 30px;
			display: flex;
			justify-content: center;
			flex-direction: column;
		}
		.drop_here p {
			font-size: 18px;
			display: block;
		}
		.drop_here button {
			margin: 10px 0;
			background: #333;
			color: white;
			border: none;
			font-size: 14px;
			padding: 10px 25px;
		}
		.drop_here button.done {
			background: red;
			color: white;
			border: none;
			margin: 0;
		}
		button[type=submit] {
			margin: 10px 0;
			background: red;
			color: white;
			border: none;
			font-size: 14px;
			padding: 10px 25px;
		}
		.drop_here input {
			//display: none;
			margin: 30px 0;
		}
		.msg {
			background: #44b7c2;
			color: white;
			margin-top: 15px;
			padding: 10px 25px;
			text-decoration: none;
			text-align: center;
			font-size: 18px;
		}
		.msg a {
			text-decoration: none;
			color: white;
		}
		.desk {
			position: relative;
			background: red;
			width: 300px;
			height: 300px;
			background: #f2f2f2;
		}
		.desk .image {
			height: 100%;
			position: relative;
			background: #f2f2f2;
			border: 1px solid #cdcdcd;
		}
		.desk .image #image {
			width: 100%;
			height: 100%;
			position: absolute;
			display: inline !important;
			top: 0 !important;
			left: 0 !important;
			background: #f2f2f2;
		}
	</style>';
	$html .= '</body></html>';
	file_put_contents(_STARTERS_DIR.'result.html', $html);
		//echo $html;
		
		$html = '<div class="photo_editor">';
		$html .= '<h2>Ваш результат готов!</h2>';
		$html .= '<p>Пока нет оплаты, и промокоды не проверены, просто оставлю кнопку на результат тут!</p>';
		$html .= '<br />';
		$html .= '<a href="http://indesiv4.beget.tech/dm/uploads/starters/result.html" class="btn btn-flat">Посмотреть результат</a>';
		$html .= '<br />';
		$html .= '<a href="http://indesiv4.beget.tech/dm/" class="btn btn-flat">Начать заново</a>';
		json_response('ok', $html);
		
	}
	
}

/*
	Действия. Загрузка изображения
*/
function upload_image($file) {
	
	if (!is_array($file)) {
		return ['error' => 'Произошла ошибка'];
	}
	
	/* Разрешенные форматы файлов */
	$allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
	
	/* Название файла разбиваем */
	$file_info = explode('.', $file['name']);
	$file_ext = trim(end($file_info));
	
	if (!in_array($file_ext, $allowed_ext)) {
		return ['error' => 'Некорректный тип файла'];
	}
	
	/* Новое название файла */
	$file_id = rand(1000, 9999);
	$new_name = $file_id.'.'.$file_ext;
	$full_path = _STARTERS_DIR.$new_name;
	
	if (!move_uploaded_file($file['tmp_name'], $full_path)) {
		return ['error' => 'Не удалось загрузить изображение!'];
	}
	
	$result = [
	
		'path' => $full_path,
		'url' => _STARTERS_URL.$new_name,
	
	];
	
	return $result;
	
}