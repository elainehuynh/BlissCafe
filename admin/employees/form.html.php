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
	<table>
		<form action="?<?php htmlout($action); ?>" method="post">
			<tr>
				<td><label for="name">Name:</td>
				<td><input type="text" name="name" id="name" value="<?php htmlout($name); ?>"></label></td>
			</tr>

			<tr>
				<td><label for="email">Email:</td>
				<td><input type="text" name="email" id="email" value="<?php htmlout($email); ?>"></label></td>
			</tr>

			<tr>
				<td><label for="password">Set password:</td>
				<td><input type="password" name="password" id="password"></label></td>
			</tr>

			<tr>
				<td colspan="2">
					<fieldset>
						<legend>Roles:</legend>
						<?php for ($i = 0; $i < count($roles); $i++): ?>
						<label for="role<?php echo $i; ?>">
							<input type="checkbox" name="roles[]" id="role<?php echo $i; ?>" value="<?php htmlout($roles[$i]['id']); ?>"
							<?php
								if ($roles[$i]['selected'])
								{
									echo ' checked';
								}
							?>>
							<?php htmlout($roles[$i]['id']); ?>
							</label>:
						<?php htmlout($roles[$i]['description']); ?><br />
						<?php endfor; ?>
					</fieldset>
				</td>
			</tr>

			<tr>
				<td><input type="hidden" name="id" value="<?php htmlout($id); ?>">
				<input type="submit" value="<?php htmlout($button); ?>"></td>
			</tr>
		</form>
	</table>
</body>
</html>
