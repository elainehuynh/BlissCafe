<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php htmlout($pageTitle); ?></title>
<!-- 5/19/2014 Huynh, Elaine ADD 2L - Included two stylesheets. -->
<link rel="stylesheet" href="../stylesheets/style.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<h1><?php htmlout($pageTitle); ?></h1>


	<form action="?<?php htmlout($action); ?>" method="post">
		<div>
		<!-- 5/19/2014 Huynh, Elaine MOD 1L - Changed label name from Categories -> Dessert Types. -->
		<label for="name">Dessert Types: <input type="text" name="name"
		id="name" value="<?php htmlout($name); ?>"></label>
		</div>
		<div>
		<input type="hidden" name="id" value="<?php htmlout($id); ?>">
		<input type="submit" value="<?php htmlout($button); ?>">
		</div>
	</form>
</body>
</html>
