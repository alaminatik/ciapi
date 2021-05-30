<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="format-detection" content="telephone=no" />
	<meta name="msapplication-tap-highlight" content="no" />
	<meta name="viewport"
		content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />
	<link href="Frontend/dist/bootstrap.min.css" rel="stylesheet">
	<link rel='stylesheet' href="Frontend/font-awesome/css/font-awesome.css" type='text/css'>
	<link rel="stylesheet" href="Frontend/dist/normalize.min.css" type="text/css">
	<link rel="stylesheet" href="Frontend/dist/typography.css" type="text/css">
	<link rel='stylesheet' href="Frontend/font-awesome/css/font-awesome.css" type='text/css'>
	<link rel="stylesheet" href="Frontend/dist/sidenav.css" type="text/css">
	<link rel="stylesheet" href="Frontend/dist/responsive.css" type="text/css">

	<title>Api App| Home</title>
</head>

<body>
	<div id="content">
		<div class="main-body-content">
			<div class="container">
				<div class="home-page-content">

					<img class="logo-top" src="Frontend/images/avatar7.png" alt="" style="height: 70px;width:70px;">
					<h2 class="logo-title">Api </h2>
					<div class="login-content">
						<form id="logForm">
							<div id="responseDiv" class="alert text-center" style="margin-top:20px; display:none;">
								<button type="button" class="close" id="clearMsg"><span
										aria-hidden="true">&times;</span></button>
								<span id="message"></span>
							</div>
							<div class="input-container">
								<i class="fa fa-envelope icon"></i>
								<input class="input-field" autocomplete="off" type="text" placeholder="Email"
									name="email" id="email">
							</div>

							<div class="input-container">
								<i class="fa fa-lock icon"></i>
								<input class="input-field" autocomplete="off" type="password" placeholder="Password"
									name="password" id="password">
							</div><br>
							<div class="input-container">
								<button id="logText" type="submit" class="login-signup-btn mb-0">
									Submit
								</button>
							</div>
							<div class="input-container">
								<ul class="bottom-menu">
									<li><a href="#">Create a accont</a></li>
								</ul>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
	<script src="Frontend/dist/jquery.min.js"></script>
	<script type="text/javascript" src="Frontend/js/sweetalert.min.js"></script>
	<script type="text/javascript" src="cordova.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript">
		app.initialize();

	</script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#logText').html('Login');
			$('#logForm').submit(function (e) {
				e.preventDefault();
				// $('#logText').html('Checking...');
				var user = $('#logForm').serialize();

				var login = function () {
					$.ajax({
						type: 'POST',
						url: 'http://localhost/ciapi/userlogin-submit',
						dataType: 'json',
						data: user,
						success: function (response) {
							// alert(response.name);
							$('#message').html(response.message);
							$('#logText').html('Login');
							if (response.error) {
								location.reload();
							} else {

								localStorage.setItem('id', response.id);
								$('#responseDiv').removeClass('alert-danger').addClass(
									'alert-success').show();
								window.location.href = 'http://localhost/ciapi/userdashboard';
							}
						}
					});
				};
				setTimeout(login, 3000);
			});

			$(document).on('click', '#clearMsg', function () {
				$('#responseDiv').hide();
			});
		});

	</script>
	<script src="Frontend/dist/sidenav.js"></script>
	<script>
		$('[data-sidenav]').sidenav();

	</script>
	<script>
		function goBack() {
			window.history.back();
		}

	</script>
</body>

</html>
