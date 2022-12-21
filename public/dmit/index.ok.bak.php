<?php

/*
	Функция преобразует изображение в пиксели
	$image - Путь к изображению
	$output - Название файла на выходе
	$pixelate_x - Размер пикселя по X (по умолчанию: 10)
	$pixelate_y - Размер пикселя по Y (по умолчанию: 10)
*/
function image_pixels($image, $output, $pixelate_x = 10, $pixelate_y = 10) {
	
	if (!file_exists($image)) {
		echo 'Файл не найден';
	}
	
    /* Тип (формат) файла */
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    if($ext == "jpg" || $ext == "jpeg")
        $img = imagecreatefromjpeg($image);
    elseif($ext == "png")
        $img = imagecreatefrompng($image);
    elseif($ext == "gif")
        $img = imagecreatefromgif($image);
    else
        echo 'Неверный формат';

    $size = getimagesize($image);
    $height = $size[1];
    $width = $size[0];
	
	imagefilter($img, IMG_FILTER_GRAYSCALE);
	imagetruecolortopalette($img, false, 8);
	
	$pixels = true;
	
	$line_color = imagecolorallocate($img, 255, 255, 255);
	
	$total_x = $total_y = 0;
	$lines_x = $lines_y = [];
	
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
				imagefilledrectangle($img, $x, $y, $x + $pixelate_x, $y + $pixelate_y, $color);

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
	
    $output_name = $output .'.jpg';

	//imagefilter($img, IMG_FILTER_GRAYSCALE);
	//imagetruecolortopalette($img, false, 15);
	//imagetruecolortopalette($img, false, 35);
	
	$colors = [];
	
	$alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	
	for ($y = 0; $y < $height; $y += $pixelate_y + 1) {
		
		for ($x = 0; $x < $width; $x += $pixelate_x + 1) {
						
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
	imagefilledrectangle($img, 0, $position_a4_y - 1, $pixelate_x, ($position_a4_y + $pixelate_y) - 1, imagecolorallocate($img, 0, 255, 149));
	$img = imagecrop($img, ['x' => 0, 'y' => 0, 'width' => imagesx($img), 'height' => $pixelate_y * 118]);
    imagejpeg($img, $output_name);
    imagedestroy($img);
	var_dump($total_x, $total_y);
	exit;
	
}

/* На листе А4 алмазов = 84. Вычисляем размер пикселя */
$dia_size = floor(173 / 84);

image_pixels("test_img1.jpg", "w12", $dia_size, $dia_size);
//image_pixels("dm2.jpg", "w122", 29, 29);

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>Для тестирования</title>
	<style>
		body {
			width: 100vw;
			height: 100vh;
			overflow: hidden;
		}
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
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
	</style>
</head>
<body>
	<div class="wrapper">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="drop_here">
				<p>Выберите изображение и нажмите "Продолжать"</p>
				<?php
				
				if (isset($msg)) {
					echo '<div class="msg">'.$msg.'</div>';
				}
				
				?>
				<input id="select_img" type="file" name="image" />
				<button type="button" class="select_img" style="display: none;">Выбрать файл...</button>
				<button class="done">Продолжить</button>
			</div>
		</form>
	</div>
</body>
</html>