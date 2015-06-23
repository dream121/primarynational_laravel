<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Account Activation</h2>

		<div>
			To activate your your Account , goto the link: {{ URL::to('activate', array($email,$token)) }}.
		</div>
	</body>
</html>
