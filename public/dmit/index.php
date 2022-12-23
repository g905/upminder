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
	
	imagefilter($img, IMG_FILTER_BRIGHTNESS, -15);
	imagefilter($img, IMG_FILTER_CONTRAST, -40);
	//imagefilter($img, IMG_FILTER_CONTRAST, -100);
	imagefilter($img, IMG_FILTER_GRAYSCALE);
	imagetruecolortopalette($img, false, 7);
	
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
				//imagefilledellipse($img, $x, $y, $x + $pixelate_x, $y + $pixelate_y, imagecolorallocate($img, 0, 255, 0));
				
				$pixel_data[$y][] = ['x' => $x, 'y' => $y, 'color' => $rgb_key];

			}  
			
		}
		
		$line_color_index = 130;
		$line_color = imagecolorallocate($img, $line_color_index, $line_color_index, $line_color_index);

		foreach ($lines_x as $pos) {
			
			//imageline($img, $pos, 0, $pos, 5000, $line_color);
	
		}
		
		foreach ($lines_y as $pos) {
			
			//imageline($img, 0, $pos, 5000, $pos, $line_color);
	
		}
	
	}
	
    $output_name = $output .'.jpg';

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
        imagejpeg($img, $output_name);
    elseif($ext == "png" || $ext == 'PNG')
        imagepng($img, $output_name);
    elseif($ext == "gif" || $ext == 'PNG')
        imagegif($img, $output_name);
    else
        echo 'Неверный формат';
    imagedestroy($img);
	
	return [
	
		'scheme' => $scheme_reverse,
		'data' => $pixel_data,
	
	];
	
	
}

/** Use X axis to scale image. */
define('IMAGES_SCALE_AXIS_X', 1);
/** Use Y axis to scale image. */
define('IMAGES_SCALE_AXIS_Y', 2);
/** Use both X and Y axes to calc image scale. */
define('IMAGES_SCALE_AXIS_BOTH', IMAGES_SCALE_AXIS_X ^ IMAGES_SCALE_AXIS_Y);
/** Compression rate for JPEG image format. */
define('JPEG_COMPRESSION_QUALITY', 90);
/** Compression rate for PNG image format. */
define('PNG_COMPRESSION_QUALITY', 9);

/**
 * Scales an image with save aspect ration for X, Y or both axes.
 *
 * @param string $sourceFile Absolute path to source image.
 * @param string $destinationFile Absolute path to scaled image.
 * @param int|null $toWidth Maximum `width` of scaled image.
 * @param int|null $toHeight Maximum `height` of scaled image.
 * @param int|null $percent Percent of scale of the source image's size.
 * @param int $scaleAxis Determines how of axis will be used to scale image.
 *
 * May take a value of {@link IMAGES_SCALE_AXIS_X}, {@link IMAGES_SCALE_AXIS_Y} or {@link IMAGES_SCALE_AXIS_BOTH}.
 * @return bool True on success or False on failure.
 */
function scaleImage($sourceFile, $destinationFile, $toWidth = null, $toHeight = null, $percent = null, $scaleAxis = IMAGES_SCALE_AXIS_BOTH) {
    $toWidth = (int)$toWidth;
    $toHeight = (int)$toHeight;
    $percent = (int)$percent;
    $result = false;

    if (($toWidth | $toHeight | $percent)
        && file_exists($sourceFile)
        && (file_exists(dirname($destinationFile)) || mkdir(dirname($destinationFile), 0777, true))) {

        $mime = getimagesize($sourceFile);

        if (in_array($mime['mime'], ['image/jpg', 'image/jpeg', 'image/pjpeg'])) {
            $src_img = imagecreatefromjpeg($sourceFile);
        } elseif ($mime['mime'] == 'image/png') {
            $src_img = imagecreatefrompng($sourceFile);
        }

        $original_width = imagesx($src_img);
        $original_height = imagesy($src_img);

        if ($scaleAxis == IMAGES_SCALE_AXIS_BOTH) {
            if (!($toWidth | $percent)) {
                $scaleAxis = IMAGES_SCALE_AXIS_Y;
            } elseif (!($toHeight | $percent)) {
                $scaleAxis = IMAGES_SCALE_AXIS_X;
            }
        }

        if ($scaleAxis == IMAGES_SCALE_AXIS_X && $toWidth) {
            $scale_ratio = $original_width / $toWidth;
        } elseif ($scaleAxis == IMAGES_SCALE_AXIS_Y && $toHeight) {
            $scale_ratio = $original_height / $toHeight;
        } elseif ($percent) {
            $scale_ratio = 100 / $percent;
        } else {
            $scale_ratio_width = $original_width / $toWidth;
            $scale_ratio_height = $original_height / $toHeight;

            if ($original_width / $scale_ratio_width < $toWidth && $original_height / $scale_ratio_height < $toHeight) {
                $scale_ratio = min($scale_ratio_width, $scale_ratio_height);
            } else {
                $scale_ratio = max($scale_ratio_width, $scale_ratio_height);
            }
        }

        $scale_width = $original_width / $scale_ratio;
        $scale_height = $original_height / $scale_ratio;

        $dst_img = imagecreatetruecolor($scale_width, $scale_height);

        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $scale_width, $scale_height, $original_width, $original_height);

        if (in_array($mime['mime'], ['image/jpg', 'image/jpeg', 'image/pjpeg'])) {
            $result = imagejpeg($dst_img, $destinationFile, JPEG_COMPRESSION_QUALITY);
        } elseif ($mime['mime'] == 'image/png') {
            $result = imagepng($dst_img, $destinationFile, PNG_COMPRESSION_QUALITY);
        }

        imagedestroy($dst_img);
        imagedestroy($src_img);
    }

    return $result;
}

header('Content-Type: image/jpeg');
$i = scaleImage('dm1.jpg', 'dm1_result.jpg', 704, 1008, null, IMAGES_SCALE_AXIS_X);
imagejpeg($i);
imagedestroy($i);

exit;

$size = getimagesize('w1.jpg');
$dia_size = $size[0] / 118;
var_dump($dia_size);
image_pixels('w1.jpg', 'dm1_result', $dia_size, $dia_size);

$step = 1;

if ($_FILES['image']['tmp_name']) {
	
	$ext = explode('.', $_FILES['image']['name']);
	$ext = trim(end($ext));
	
	$new_name = rand(500, 600);
	$upload_to = dirname(__FILE__).'/';
	$full_name = $upload_to.$new_name.'.'.$ext;
	$img_url = 'http://indesiv4.beget.tech/dmit/'.$new_name.'.'.$ext;
	
	if (move_uploaded_file($_FILES['image']['tmp_name'], $full_name)) {
		
		$step = 2;
		header('Location: ?s=2&i='.$new_name.'&e='.$ext);
		exit;
		
	}
	
}
if (isset($_GET['s']) && isset($_GET['i'])) {
	
	$s = trim($_GET['s']);
	$i = trim($_GET['i']);
	$e = trim($_GET['e']);
	$img_url = 'http://indesiv4.beget.tech/dmit/'.$i.'.'.$e;
	
	if ($s == 2) {
		$step = 2;
	}
	
}

if ($_POST) {
	
	$post = [];
	foreach ($_POST as $k => $v) {
		$post[$k] = trim(strip_tags(stripslashes($v)));
	}
	
	$name_full = explode('.', $post['image']);
	$name = trim($name_full[0]);
	$ext = trim(end($name_full));
	$name_cropped = $name.'_cropped';
	$name_result = $name.'_result';
	
	/* CROP */
	$i = imagecreatefromjpeg($post['image']);
	$i_cropped = imagecrop($i, ['width' => $post['width'], 'height' => $post['height'], 'x' => $post['x1'], 'y' => $post['y1']]);
	imagejpeg($i_cropped, $name_cropped.'.'.$ext);
	
	$dia_size = floor($post['width'] / 84);
	$data = image_pixels($name_cropped.'.'.$ext, $name_result, $dia_size, $dia_size);
	$scheme = $data['scheme'];
	$data = $data['data'];

	/* Делим на 3 колонки */
	$html = '<div class="result" style="width: 100vw; height: 100vh; padding: 30px; box-sizing: border-box;">';
	$html .= '<h1 style="display: block; text-align: center; font-size: 24px; font-weight: bolder;">РЕЗУЛЬТАТ</h1><br />';
	$html .= '<a href="'.$name_result.'.'.$ext.'" style="display: block; text-align: center;">Как выглядит в собранном виде?</a><br />';
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
	
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>Для тестирования</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" integrity="sha512-0SPWAwpC/17yYyZ/4HSllgaK7/gg9OlVozq8K7rf3J8LvCjYEEIfzzpnA2/SSjpGIunCSD18r3UhvDcu/xncWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<style>
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
	</style>
</head>
<body>
	<?php
	
	if (isset($html)) {
		
		?>
		<style>

		</style>
		<?php
		echo $html;
		exit;
		
	}
	
	?>
	<div class="wrapper">
		<form action="" method="POST" enctype="multipart/form-data">
			<?php
			
			if ($step == 1) {
				
			?>
			<div class="drop_here">
				<p>Выберите изображение и нажмите "Продолжить"</p>
				<?php
				
				if (isset($msg)) {
					echo '<div class="msg">'.$msg.'</div>';
				}
				
				?>
				<input id="select_img" type="file" name="image" />
				<button type="button" class="select_img" style="display: none;">Выбрать файл...</button>
				<button class="done">Продолжить</button>
			</div>
			<?php
			
			}
			elseif ($step == 2) {
			
			?>
				<style>
				.tools {
					margin: 20px 0;
				}
				.tools ul {
					list-style: none;
					display: flex;
					justify-content: space-between;
					margin: 0;
					padding: 0;
				}
				.tools ul li {
					width: 24%;
				}
				.tools ul li a {
					display: block;
					width: 100%;
					text-decoration: none;
					background: #333;
					color: white;
					padding: 15px 0;
					text-align: center;
				}
				.cropper-canvas, .cropper-crop-box, .cropper-drag-box, .cropper-modal, .cropper-wrap-box {
					background: #f2f2f2;
				}
				.cropper-drag-box {
					background: #f2f2f2 !important;
				}
				</style>
				<div class="desk">
					<div class="image"><img id="image" src="<?php echo $img_url; ?>" /></div>
					<div class="tools">
						<ul>
							<li><a href="javascript:void(0);" data-cmd="rotate_90m" class="cmd">+ 90</a></li>
							<li><a href="javascript:void(0);" data-cmd="rotate_90p" class="cmd">- 90</a></li>
							<li><a href="javascript:void(0);" data-cmd="zoom_in" class="cmd">+</a></li>
							<li><a href="javascript:void(0);" data-cmd="zoom_out" class="cmd">-</a></li>
						</ul>
					</div>
			<input type="hidden" name="image" value="<?php echo $i.'.'.$e; ?>" />
			<input id="x1" type="hidden" name="x1" value="0" />
			<input id="y1" type="hidden" name="y1" value="0" />
			<input id="width" type="hidden" name="width" value="0" />
			<input id="height" type="hidden" name="height" value="0" />
			<input id="angle" type="hidden" name="angle" value="0" />
				<div style="text-align: center;">
			<button type="submit">Далее</button>
				</div>
			<?php
			
			}
			
			?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		  <script>
			$(document).ready(function() {
				
				$(document).on('click', '.cmd', function() {
					
					var this_cmd = $(this).data('cmd');
					if (this_cmd == 'rotate_90m') {
						cropper.rotate(-90);
					}
					if (this_cmd == 'rotate_90p') {
						cropper.rotate(90);
					}
					if (this_cmd == 'zoom_in') {
						cropper.zoom(0.1);
					}
					if (this_cmd == 'zoom_out') {
						cropper.zoom(-0.1);
					}
					
				});
								
				var cropper = new Cropper($('#image')[0], {
					viewMode: 1,
					dragMode: 'move',
					aspectRatio: 0.7,
					autoCropArea: 0.65,
					restore: false,
					guides: true,
					center: true,
					highlight: true,
					cropBoxMovable: false,
					cropBoxResizable: false,
					toggleDragModeOnDblclick: false,
					ready: function(event) {
						update_fields(event.target.cropper);
					},
					zoom: function(event) {
						update_fields(event.target.cropper);
					},
					crop: function(event) {
						
						var img = $('#image')[0];
						update_fields(event.target.cropper);
					
					}
				});
				
				function update_fields(cx) {
					
					var dt = cx.getData();
					var img = $('#image')[0];
					$('#x1').val(Math.round(dt.x));
					$('#y1').val(Math.round(dt.y));
					$('#width').val(Math.round(dt.width));
					$('#height').val(Math.round(dt.height));
					$('#angle').val(dt.rotate);
				
				}
				
			});
		  </script>
		</form>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js" integrity="sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>