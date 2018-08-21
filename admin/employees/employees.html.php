<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Employees</title>
<!-- 5/19/2014 Huynh, Elaine ADD 2L - Included two stylesheets. -->
<link rel="stylesheet" href="../stylesheets/style.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<?php include '../logout.inc.html.php'; ?>

	<!-- 5/19/2014 Huynh, Elaine ADD 1L - Added Image to Header -->
	<h1><img src="../../images/happy.png" /> <br />Manage Employees</h1>

	<!-- 5/19/2014 Huynh, Elaine ADD 8L-10L - Deleted out of place links, and made it part of a navigation. -->
	<nav>
		<div align="center">
			<ul>
				<li><a href=".."><i class="fa fa-home"></i> Home</a></li>
				<li><a href="?add">Add New Employee</a></li>
			</ul>
		</div>
	</nav>

	<!-- 5/19/2014 Huynh, Elaine ADD 25L - Organized a table to edit and delete employees. -->
	<div style="margin: 50px;">
	<table>
		<?php foreach ($employees as $employee): ?>
		<tr>
			<form action="" method="post">
				<div>
					<td><?php htmlout($employee['name']); ?></td>
					<input type="hidden" name="id" value="<?php
					echo $employee['id']; ?>">
					<td><input type="submit" name="action" value="Edit"></td>
					<td><input type="submit" name="action" value="Delete"></td>
				</div>
			</form>
		</tr>
		<?php endforeach; ?>
	</table>
	</div>
</body>
</html>
