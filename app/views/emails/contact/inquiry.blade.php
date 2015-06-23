<!DOCTYPE html>
 <html lang="en-US">
 	<head>
 		<meta charset="utf-8">
 	</head>
 	<body>
 		<h2>Inquiry from {{HTML::mailto($email,$first_name.' '.$last_name)}}</h2>

 		<div>
 			<p>
 			Phone No: {{$phone_number}}
 			</p>
 			<p>
 			Comments: {{$comments}}
 			</p>
 		</div>
 	</body>
 </html>