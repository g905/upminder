<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DIAMOND.Photo</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" integrity="sha512-0SPWAwpC/17yYyZ/4HSllgaK7/gg9OlVozq8K7rf3J8LvCjYEEIfzzpnA2/SSjpGIunCSD18r3UhvDcu/xncWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="<?php echo _HOME; ?>assets/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo _HOME; ?>assets/css/styles.css">
</head>
<body class="home">
	<div class="page centered">
		<div class="desk_cols">
			<div class="col_left">
				<a href="<?php echo _HOME; ?>" title="На главную" class="logo">Diamond.<span>Photo</span></a>
				<div class="centered_all text">
					<h2>Незабываемый подарок от <span>Diamond.Photo</span></h2>
					<p>Загрузите фото справа, чтобы начать!</p>
				</div>
			</div>
			<div class="col_right col_form">
				<form id="p_start_form" action="<?php echo _HOME; ?>" method="POST" enctype="multipart/form-data">
					<div id="p_drop" class="drop_area">
						<p>Выберите или перетащите фото сюда...</p>
						<input id="p_image" type="file" />
						<button id="p_image_select" type="button" class="btn btn_flat">Выбрать фото...</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js" integrity="sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo _HOME; ?>assets/js/scripts.js"></script>
</body>
</html>