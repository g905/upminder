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

    for($y = 0;$y < $height; $y += $pixelate_y + 1) {

        for($x = 0; $x < $width; $x += $pixelate_x + 1) {
			
			/*
				Предв. обработка пикселей
				gd_functions.php (str 0 - 303)
			*/
			
			/* Цвет пикселя */
            $rgb = imagecolorsforindex($img, imagecolorat($img, $x, $y));
			
			/* Цвет данного пикселя. Рисуем элемент мозайки (позиция X + размер элемента мозайки) */
            $color = imagecolorclosest($img, $rgb['red'], $rgb['green'], $rgb['blue']);
            imagefilledrectangle($img, $x, $y, $x + $pixelate_x, $y + $pixelate_y, $color);

        }  
		
    }
	
    $output_name = $output .'.jpg';

	//imagefilter($img, IMG_FILTER_GRAYSCALE);
    imagejpeg($img, $output_name);
    imagedestroy($img);
	
}

/* Проверяем */
if ($_FILES) {

	if ($_FILES['image']['tmp_name']) {
		
		$new_name = rand(1000, 9999);
		$new_name_jpg = $new_name.'.jpg';
		$new_name_result_jpg = $new_name.'_result';
		if (move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__).'/'.$new_name_jpg)) {

			image_pixels($new_name_jpg, $new_name_result_jpg, 3, 3);
			$msg = '<a href="'.$new_name_result_jpg.'.jpg" target="_blank">Открыть обработанную</a>';
			
		}
		
	}
	
}

//image_pixels("prague1.jpg", "testing", 1, 1);


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