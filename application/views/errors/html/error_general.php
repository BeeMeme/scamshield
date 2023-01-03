<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Error</title>
	<style type="text/css">
		::selection {
			background-color: #E13300;
			color: white;
		}

		::-moz-selection {
			background-color: #E13300;
			color: white;
		}

		body {
			background-color: #fff;
			margin: 40px;
			font: 13px/20px normal Helvetica, Arial, sans-serif;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 19px;
			font-weight: normal;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
		}

		code {
			font-family: Consolas, Monaco, Courier New, Courier, monospace;
			font-size: 12px;
			background-color: #f9f9f9;
			border: 1px solid #D0D0D0;
			color: #002166;
			display: block;
			margin: 14px 0 14px 0;
			padding: 12px 10px 12px 10px;
		}

		#container {
			margin: 10px;
			border: 1px solid #D0D0D0;
			box-shadow: 0 0 8px #D0D0D0;
		}

		p {
			margin: 12px 15px 12px 15px;
		}

		#countdown {
			font-weight: bold;
			color: #845EC2;
			font-size: 20px;
		}
	</style>
</head>

<body>
	<div id="container">
		<?php
		$normalCsrf = 0;
		if ($message == '<p>The action you have requested is not allowed.</p>' && !isset($_GET['__cf_chl_jschl_tk__'])) {
			$message = '<p>It looks like that you opened multiple forms and submit them one by one without reloading. You will be redirected in <span id="countdown">5</span></p>';
			$normalCsrf = 1;
		} else if ($message == '<p>The action you have requested is not allowed.</p>' && isset($_GET['__cf_chl_jschl_tk__'])) {
			$heading = '<p>You are being redirected ...</p>';
			$message = '';
			$normalCsrf = 2;
		}
		?>
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
	<?php if ($normalCsrf == 1) { ?>
		<script>
			const counter = document.getElementById('countdown');
			const cnt = setInterval(() => {
				let timer = parseInt(counter.innerHTML);
				if (timer === 0) {
					const url = window.location.origin + window.location.pathname;
					location.href = url;
					clearInterval(cnt);
				} else {
					counter.innerHTML = --timer;
				}
			}, 1000);
		</script>
	<?php } else if ($normalCsrf == 2) { ?>
		<script>
			const url = window.location.origin + window.location.pathname;
			location.href = url;
		</script>
	<?php } ?>
</body>

</html>