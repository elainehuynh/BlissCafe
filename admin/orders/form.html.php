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

	<!-- 5/19/2014 Huynh, Elaine ADD 57L - Created and organized a table. -->
	<form action="?<?php htmlout($action); ?>" method="post">
		<table>
			<tr>
				<td><label for="text">Type Your Order Here:</label></td>
				<td><textarea id="text" name="text" rows="3" cols="40"><?php htmlout($text); ?></textarea></td>
			</tr>

			<tr>
				<td><label for="employee">Employee:</label></td>
				<td><select name="employee" id="employee">
				<option value="">Select One</option>
				<?php foreach ($employees as $employee): ?>
				<option value="<?php htmlout($employee['id']); ?>"<?php
				if ($employee['id'] == $employeeID)
				{
				echo ' selected';
				}
				?>><?php htmlout($employee['name']); ?></option>
				<?php endforeach; ?>
				</select></td>
			</tr>

			<tr>
				<td colspan="2">
					<fieldset>
					<legend>Dessert Types:</legend>
					<?php foreach ($categories as $desserttype): ?>
					<div><label for="desserttype<?php htmlout($desserttype['id']);
					?>"><input type="checkbox" name="categories[]"
					id="desserttype<?php htmlout($desserttype['id']); ?>"
					value="<?php htmlout($desserttype['id']); ?>"<?php
					if ($desserttype['selected'])
					{
					echo ' checked';
					}
					?>><?php htmlout($desserttype['name']); ?></label></div>
					<?php endforeach; ?>
					</fieldset>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="hidden" name="id" value="<?php htmlout($id); ?>">
					<input type="submit" value="<?php htmlout($button); ?>">
				</td>
			</tr>
		</table>

	</form>
</body>
</html>