<?php

/* Алмазная картина по фото. Файл функций базовой обработки изображений */
if (!defined('_SY')) {
	die();
}

/*
	Функция обрезает изображение
	$path - Путь до картинки-оригинала
	$save_path - Путь с названием файла для сохранения
	$x - X координата начала
	$y - Y координата начала
	$width - Ширина
	$height - Высота
	$quality - Качество изображения в % (по умолчанию: 100)
*/
function do_img_crop($path, $save_path, $x, $y, $width, $height, $quality = 100) {
	
	if (!file_exists($path)) {
		return false;
	}
	
	/* Распознаем формат файла */
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	
	if ($ext == 'jpg' || $ext == 'jpeg') {
		$image = imagecreatefromjpeg($path);
	}
	elseif ($ext == 'png') {
		$image = imagecreatefrompng($path);
	}
	elseif ($ext == 'gif') {
		$image = imagecreatefromgif($path);
	}
	
	/* Обрезаем картинку */
	$image_cropped = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
	
	/* Сохраняем картинку, возвращаем путь и URL */
	if ($ext == 'jpg' || $ext == 'jpeg') {
		imagejpeg($image_cropped, $save_path);
	}
	elseif ($ext == 'png') {
		imagepng($image_cropped, $save_path);
	}
	elseif ($ext == 'gif') {
		imagegif($image_cropped, $save_path);
	}

	imagedestroy($image_cropped);
	imagedestroy($image);
	
	/* Название файла-изображения */
	$image_name = explode('/', $save_path);
	$image_name = trim(end($image_name));
	
	$result = [
	
		'width' => $width,
		'height' => $height,
		'path' => $save_path,
		'url' => _STARTERS_URL.$image_name,
	
	];
	
	return $result;
	
}

function image_filter($path, $save_path, $filter = 'gray') {
	
	if (!file_exists($path)) {
		return ['error' => 'Изображение не найдено'];
	}
	
	/* Распознаем формат файла */
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	
	if ($ext == 'jpg' || $ext == 'jpeg') {
		$image = imagecreatefromjpeg($path);
	}
	elseif ($ext == 'png') {
		$image = imagecreatefrompng($path);
	}
	elseif ($ext == 'gif') {
		$image = imagecreatefromgif($path);
	}
	
	/* Фильтры */
	if ($filter == 'vintage') {
		imagefilter($image, IMG_FILTER_COLORIZE, 196, 187, 151);
	}
	if ($filter == 'color') {
		imagefilter($image, IMG_FILTER_COLORIZE, 196, 51, 151);
	}
	
	/* Сохраняем картинку, возвращаем путь и URL */
	if ($ext == 'jpg' || $ext == 'jpeg') {
		imagejpeg($image, $save_path);
	}
	elseif ($ext == 'png') {
		imagepng($image, $save_path);
	}
	elseif ($ext == 'gif') {
		imagegif($image, $save_path);
	}
	
	imagedestroy($image);
	
	/* Название файла-изображения */
	$image_name = explode('/', $save_path);
	$image_name = trim(end($image_name));
	
	$result = [
	
		'path' => $save_path,
		'url' => _STARTERS_URL.$image_name,
	
	];
	
	return $result;	
	
}

/*
	Функция преобразует изображение в пиксели
	$image - Путь к изображению
	$output - Название файла на выходе
	$pixelate_x - Размер пикселя по X (по умолчанию: 10)
	$pixelate_y - Размер пикселя по Y (по умолчанию: 10)
*/
function image_pixels($image, $output, $pixelate_x = 10, $pixelate_y = 10, $contrast = false, $gray = false) {
	
	if (!file_exists($image)) {
		echo 'Файл не найден';
	}
	
    /* Тип (формат) файла */
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    if($ext == "jpg" || $ext == "jpeg" || $ext == 'JPG')
        $img = imagecreatefromjpeg($image);
    elseif($ext == "png" || $ext == 'PNG')
        $img = imagecreatefrompng($image);
    elseif($ext == "gif" || $ext == 'GIF')
        $img = imagecreatefromgif($image);
    else
        echo 'Неверный формат';

    $size = getimagesize($image);
    $height = $size[1];
    $width = $size[0];
	
	if ($contrast) {
		imagefilter($img, IMG_FILTER_CONTRAST, -20);
	}
	if ($gray) {
		imagefilter($img, IMG_FILTER_GRAYSCALE);
	}
	imagetruecolortopalette($img, false, 8);
	
	$pixels = true;
	
	$total_x = $total_y = 0;
	$lines_x = $lines_y = [];
	$pixel_data = [];
	
	$line_color = imagecolorallocate($img, 255, 255, 255);
	
	if ($pixels) {
		
		for($y = 0;$y < $height; $y += $pixelate_y + 1) {
			
			$lines_y[] = $y;

			for($x = 0; $x < $width; $x += $pixelate_x + 1) {
				
				if ($y == 0) {
					$total_x++;
				}
				if ($x == 0) {
					$total_y++;
				}
				
				$lines_x[] = $x;
				
				/* Цвет пикселя */
				$rgb = imagecolorsforindex($img, imagecolorat($img, $x, $y));
				
				/* Цвет данного пикселя. Рисуем элемент мозайки (позиция X + размер элемента мозайки) */
				$color = imagecolorclosest($img, $rgb['red'], $rgb['green'], $rgb['blue']);
				$rgb_key = $rgb['red'].'-'.$rgb['green'].'-'.$rgb['blue'];
				imagefilledrectangle($img, $x, $y, $x + $pixelate_x, $y + $pixelate_y, $color);
				
				$pixel_data[$y][] = ['x' => $x, 'y' => $y, 'color' => $rgb_key];

			}  
			
		}
		
		$line_color_index = 130;
		$line_color = imagecolorallocate($img, $line_color_index, $line_color_index, $line_color_index);

		foreach ($lines_x as $pos) {
			
			imageline($img, $pos, 0, $pos, 5000, $line_color);
	
		}
		
		foreach ($lines_y as $pos) {
			
			imageline($img, 0, $pos, 5000, $pos, $line_color);
	
		}
	
	}

	$colors = [];
	
	$alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	
	for ($y = 0; $y < $height; $y += $pixelate_y) {
		
		for ($x = 0; $x < $width; $x += $pixelate_x) {
						
			/* Цвет пикселя */
			$rgb = imagecolorsforindex($img, imagecolorat($img, $x, $y));
			$rgb_key = $rgb['red'].'-'.$rgb['green'].'-'.$rgb['blue'];
			$colors[$rgb_key] = $rgb_key;
			
		}
		
	}
	
	$colors = array_unique($colors);
	$colors = array_values($colors);
	$scheme = [];
	
	foreach ($colors as $color_key => $color_rgb) {
		
		$letter = $alphabet[$color_key];
		$scheme[$letter] = $color_rgb;
		
	}
	
	$scheme_reverse = array_flip($scheme);

	/* Scheme */
	for ($y = 0; $y < $height; $y += $pixelate_y + 1) {
		
		for ($x = 0; $x < $width; $x += $pixelate_x + 1) {
						
			/* Цвет пикселя */
			$rgb = imagecolorsforindex($img, imagecolorat($img, $x, $y));
			$rgb_key = $rgb['red'].'-'.$rgb['green'].'-'.$rgb['blue'];
			
			/* Буква */
			$this_letter = $scheme_reverse[$rgb_key];
			
		}
		
	}
	
	$position_a4_y = $pixelate_y * 118;
    //imagejpeg($img, $output_name);
    if($ext == "jpg" || $ext == "jpeg" || $ext == 'JPG')
        imagejpeg($img, $output);
    elseif($ext == "png" || $ext == 'PNG')
        imagepng($img, $output);
    elseif($ext == "gif" || $ext == 'PNG')
        imagegif($img, $output);
    else
        echo 'Неверный формат';
    imagedestroy($img);
	
	$image_name = explode('/', $output);
	$image_url = _STARTERS_URL.trim($image_name[0]).'.'.trim(end($image_name));
	
	return [
		
		'path' => $output,
		'url' => $image_url,
		'scheme' => $scheme_reverse,
		'data' => $pixel_data,
	
	];
	
	
}