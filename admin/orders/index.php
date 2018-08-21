<?php
include_once '../../includes/magicquotes.inc.php';

require_once '../../includes/access.inc.php';

if (!userIsLoggedIn())
{
	include '../login.html.php';
	exit();
}

// 5/19/2014 Huynh, Elaine MOD 3L - Make sure the user is a cashier.
if (!userHasRole('Cashier'))
{
	$error = 'Only cashiers may access this page.';
	include '../accessdenied.html.php';
	exit();
}

// 5/19/2014 Huynh, Elaine MOD 51L - Add orders.
if (isset($_GET['add']))
{
  $pageTitle = 'New Order';
  $action = 'addform';
  $text = '';
  $employeeID = '';
  $id = '';
  $button = 'Add Order';

  include '../../includes/db.inc.php';

  // Build the list of employees
  try
  {
    $result = $pdo->query('SELECT id, name FROM employee');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of employees.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $employees[] = array('id' => $row['id'], 'name' => $row['name']);
  }

  // Build the list of desserttypes
  try
  {
    $result = $pdo->query('SELECT id, name FROM desserttype');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of categories.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $categories[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'selected' => FALSE);
  }

  include 'form.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 62L - Insert orders.
if (isset($_GET['addform']))
{
  include '../../includes/db.inc.php';

  if ($_POST['employee'] == '')
  {
    $error = 'You must choose an employee for this order.
        Click &lsquo;back&rsquo; and try again.';
    include 'error.html.php';
    exit();
  }

  try
  {
    $sql = 'INSERT INTO orders SET
        comment = :comment,
        orderDate = CURDATE(),
        employeeID = :employeeID';
    $s = $pdo->prepare($sql);
    $s->bindValue(':comment', $_POST['text']);
    $s->bindValue(':employeeID', $_POST['employee']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted order.';
    include 'error.html.php';
    exit();
  }

  $dessertid = $pdo->lastInsertId();

  if (isset($_POST['categories']))
  {
    try
    {
      $sql = 'INSERT INTO dessertcategory SET
          dessertid = :dessertid,
          desserttypeid = :desserttypeid';
      $s = $pdo->prepare($sql);

      foreach ($_POST['categories'] as $desserttypeid)
      {
        $s->bindValue(':dessertid', $dessertid);
        $s->bindValue(':desserttypeid', $desserttypeid);
        $s->execute();
      }
    }
    catch (PDOException $e)
    {
      $error = 'Error inserting order into selected categories.';
      include 'error.html.php';
      exit();
    }
  }

  header('Location: .');
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'SELECT id, comment, employeeID FROM orders WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching order details.';
    include 'error.html.php';
    exit();
  }
  $row = $s->fetch();

  $pageTitle = 'Edit Order';
  $action = 'editform';
  $text = $row['comment'];
  $employeeID = $row['employeeID'];
  $id = $row['id'];
  $button = 'Update order';

  // Build the list of employees
  try
  {
    $result = $pdo->query('SELECT id, name FROM employee');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of employees.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $employees[] = array('id' => $row['id'], 'name' => $row['name']);
  }

  // Get list of categories containing this order
  try
  {
    $sql = 'SELECT desserttypeid FROM dessertcategory WHERE dessertid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $id);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of selected categories.';
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $selectedCategories[] = $row['desserttypeid'];
  }

  // Build the list of all categories
  try
  {
    $result = $pdo->query('SELECT id, name FROM desserttype');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of categories.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $categories[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'selected' => in_array($row['id'], $selectedCategories));
  }

  include 'form.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 71L - Edit orders.
if (isset($_GET['editform']))
{
  include '../../includes/db.inc.php';

  if ($_POST['employee'] == '')
  {
    $error = 'You must choose an employee for this order.
        Click &lsquo;back&rsquo; and try again.';
    include 'error.html.php';
    exit();
  }

  try
  {
    $sql = 'UPDATE orders SET
        comment = :comment,
        employeeID = :employeeID
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':comment', $_POST['text']);
    $s->bindValue(':employeeID', $_POST['employee']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating submitted order.';
    include 'error.html.php';
    exit();
  }

  try
  {
    $sql = 'DELETE FROM dessertcategory WHERE dessertid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing obsolete order desserttype entries.';
    include 'error.html.php';
    exit();
  }

  if (isset($_POST['categories']))
  {
    try
    {
      $sql = 'INSERT INTO dessertcategory SET
          dessertid = :dessertid,
          desserttypeid = :desserttypeid';
      $s = $pdo->prepare($sql);

      foreach ($_POST['categories'] as $desserttypeid)
      {
        $s->bindValue(':dessertid', $_POST['id']);
        $s->bindValue(':desserttypeid', $desserttypeid);
        $s->execute();
      }
    }
    catch (PDOException $e)
    {
      $error = 'Error inserting order into selected categories.';
      include 'error.html.php';
      exit();
    }
  }

  header('Location: .');
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 46L - Delete orders.
if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include '../../includes/db.inc.php';

  // Delete desserttype assignments for this order
  try
  {
    $sql = 'DELETE FROM dessertcategory WHERE dessertid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing order from categories.';
    include 'error.html.php';
    exit();
  }

  // Delete the order
  try
  {
    $sql = 'DELETE FROM orders WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting order.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 50L - Search orders.
if (isset($_GET['action']) and $_GET['action'] == 'search')
{
  include '../../includes/db.inc.php';

  // The basic SELECT statement
  $select = 'SELECT id, comment';
  $from   = ' FROM orders';
  $where  = ' WHERE TRUE';

  $placeholders = array();

  if ($_GET['employee'] != '') // An employee is selected
  {
    $where .= " AND employeeID = :employeeID";
    $placeholders[':employeeID'] = $_GET['employee'];
  }

 if ($_GET['desserttype'] != '') // A desserttype is selected
  {
    $from  .= ' INNER JOIN dessertcategory ON id = dessertid';
    $where .= " AND desserttypeid = :desserttypeid";
    $placeholders[':desserttypeid'] = $_GET['desserttype'];
  }

  if ($_GET['text'] != '') // Some search text was specified
  {
    $where .= " AND comment LIKE :comment";
    $placeholders[':comment'] = '%' . $_GET['text'] . '%';
  }

  try
  {
	$sql = $select . $from . $where;
	$s = $pdo->prepare($sql);
	$s->execute($placeholders);
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching orders.';
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $orders[] = array('id' => $row['id'], 'text' => $row['comment']);
  }

  include 'orders.html.php';
  exit();
}

// Display search form
include '../../includes/db.inc.php';

// 5/19/2014 Huynh, Elaine MOD 56L - Spit errors out. 
try
{
  $result = $pdo->query('SELECT id, name FROM employee');
}
catch (PDOException $e)
{
  $error = 'Error fetching employees from database!';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $employees[] = array('id' => $row['id'], 'name' => $row['name']);
}

try
{
  $result = $pdo->query('SELECT id, name FROM desserttype');
}
catch (PDOException $e)
{
  $error = 'Error fetching categories from database!';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $categories[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'searchform.html.php';
