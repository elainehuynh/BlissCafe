<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Log In</title>
<!-- 5/19/2014 Huynh, Elaine ADD 2L - Included two stylesheets. -->
<link rel="stylesheet" href="../stylesheets/style.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<!-- 5/19/2014 Huynh, Elaine ADD 2L - Made this into login. -->
	<div class="login">
		<h1>Log In</h1>

		<p>Please log in to view the page that you requested.</p>

		<?php if (isset($loginError)): ?>

		<p><?php htmlout($loginError); ?></p>

		<?php endif; ?>

		<form action="" method="post">
				<!-- 5/19/2014 Huynh, Elaine MOD 3L - Included placeholders, and removed label's text. -->
				<label for="email"><input type="text" name="email" id="email" placeholder="email@email.com"></label>
				<label for="password"><input type="password" name="password" id="password" placeholder="Password"></label>
				<input type="hidden" name="action" value="login">
				<input type="submit" value="Log In">
		</form>

		<p><a href="..">&#8678; Go Back</a></p>
	</div>
</body>
</html>
