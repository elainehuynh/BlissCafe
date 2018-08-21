<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Orders</title>
<!-- 5/19/2014 Huynh, Elaine ADD 2L - Included two stylesheets. -->
<link rel="stylesheet" href="../stylesheets/style.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<?php include '../logout.inc.html.php'; ?>

	<!-- 5/19/2014 Huynh, Elaine ADD 1L - Added Image to Header -->
	<h1><img src="../../images/pie.png" /> <br />Manage Orders</h1>
	
	<!-- 5/19/2014 Huynh, Elaine ADD 8L-10L - Deleted out of place links, and made it part of a navigation. -->
	<nav>
		<div align="center">
			<ul>
				<li><a href=".."><i class="fa fa-home"></i> Home</a></li>
				<li><a href="?add">Add New Orders</a></li>
			</ul>
		</div>
	</nav>
    <form action="" method="get">
      <h4>View orders satisfying the following criteria</h4>
	<table>
		<tr>
			<td><label for="employee">By employee:</label></td>
			<td>
				<select name="employee" id="employee"><option value="">Any employee</option>
				<?php foreach ($employees as $employee): ?>
				<option value="<?php htmlout($employee['id']); ?>"><?php
				htmlout($employee['name']); ?></option>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>

		<tr>
			<td><label for="dessertType">By Types of Dessert:</label></td>
			<td>
				<select name="dessertType" id="dessertType">
				<option value="">Dessert Types</option>
				<?php foreach ($categories as $dessertType): ?>
				<option value="<?php htmlout($dessertType['id']); ?>"><?php
				htmlout($dessertType['name']); ?></option>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>

		<tr>
			<td><label for="text">Order containing the following text:</label></td>
			<td><input type="text" name="text" id="text"><td>
		</tr>

		<tr>
			<td><input type="hidden" name="action" value="search"><input type="submit" value="Search"></td>
		</tr>
	</table>
	</form>
</body>
</html>
