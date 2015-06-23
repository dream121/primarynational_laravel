<!DOCTYPE html>
 <html lang="en-US">
 	<head>
 		<meta charset="utf-8">
 	</head>
 	<body>
 		<h2>Comments on {{$blog_slug}} by {{HTML::mailto($author_email,$author_name)}}</h2>

 		<div>
 			<p>
 			Phone No: {{$phone_no}}
 			</p>
 			<p>
 			Comment: {{$comment}}
 			</p>
 		</div>
 	</body>
 </html>