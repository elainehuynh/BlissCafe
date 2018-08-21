<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Desserts</title>
<!-- 5/19/2014 Huynh, Elaine ADD 2L - Included two stylesheets. -->
<link rel="stylesheet" href="../stylesheets/style.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<?php include '../logout.inc.html.php'; ?>
	<div style="clear: both;"></div>

	<!-- 5/19/2014 Huynh, Elaine ADD 1L - Added Image to Header -->
	<h1><img src="../../images/chocolate.png" /> <br />Manage Desserts</h1>

	<!-- 5/19/2014 Huynh, Elaine ADD 8L-10L - Deleted out of place links, and made it part of a navigation. -->
	<nav>
		<div align="center">
			<ul>
				<li><a href=".."><i class="fa fa-home"></i> Home</a></li>
				<li><a href="?add">Add Dessert Category</a></li>
			</ul>
		</div>
	</nav>

	<!-- 5/19/2014 Huynh, Elaine ADD 25L - Organized a table to edit and delete dessert types. -->
	<div style="margin: 50px;">
	<table>
		<?php foreach ($categories as $desserttype): ?>
		<tr>
			<form action="" method="post">
					<td><?php htmlout($desserttype['name']); ?></td>
					<input type="hidden" name="id" value="<?php echo $desserttype['id']; ?>">
					<td><input type="submit" name="action" value="Edit"></td>
					<td><input type="submit" name="action" value="Delete"></td>
			</form>
		</tr>
		<?php endforeach; ?>
	</table>
	</div>
</body>
</html>
