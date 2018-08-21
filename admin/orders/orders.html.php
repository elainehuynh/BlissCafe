<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Orders: Search Results</title>
<!-- 5/19/2014 Huynh, Elaine ADD 2L - Included two stylesheets. -->
<link rel="stylesheet" href="../stylesheets/style.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
	<?php include '../logout.inc.html.php'; ?>

	<h1>Search Results</h1>

	<!-- 5/19/2014 Huynh, Elaine ADD 8L-10L - Deleted out of place links, and made it part of a navigation. -->
	<nav>
		<div align="center">
			<ul>
				<li><a href=".."><i class="fa fa-home"></i> Home</a></li>
				<li><a href="?">New Search</a></li>
			</ul>
		</div>
	</nav>

	<?php if (isset($orders)): ?>

	<!-- 5/19/2014 Huynh, Elaine ADD 1L - Added header for list of orders. -->
	<h4>List of Orders</h4>

	<!-- 5/19/2014 Huynh, Elaine ADD 20L - Organized everything into a table. -->
	<table>
		<tr><th>Orders</th><th>Options</th></tr>

		<!-- 5/19/2014 Huynh, Elaine MOD 1L - Changed jokes -> orders and joke -> order. -->
		<?php foreach ($orders as $order): ?>

		<tr valign="top">
			<td>
				<?php markdownout($order['text']); ?>
			</td>
			<td>
				<form action="?" method="post">
				<div>
					<!-- 5/19/2014 Huynh, Elaine MOD 1L - Grab order ID. -->
					<input type="hidden" name="id" value="<?php htmlout($order['id']); ?>">
					<input type="submit" name="action" value="Edit">
					<input type="submit" name="action" value="Delete">
				</div>
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>

	<?php endif; ?>
</body>
</html>
