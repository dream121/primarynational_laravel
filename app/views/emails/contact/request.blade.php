<!DOCTYPE html>
 <html lang="en-US">
 	<head>
 		<meta charset="utf-8">
 	</head>
 	<body>
 		<h2>Request For Contact from {{HTML::mailto($email,$first_name.' '.$last_name)}}</h2>

 		<div>
 			<p>
 			Phone No: {{@$phone_number}}
 			</p>
 			<p>
 			Interested In: {{@$interested_in}}
 			</p>
 			<p>
 			Comments: {{@$comments}}
 			</p>
 		</div>
 	</body>
 </html>