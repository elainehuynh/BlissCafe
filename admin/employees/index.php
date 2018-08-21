<?php
include_once '../../includes/magicquotes.inc.php';

require_once '../../includes/access.inc.php';

if (!userIsLoggedIn())
{
  include '../login.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 3L - Make sure the user is an employee in human resources.
if (!userHasRole('Human Resource'))
{
  $error = 'Only those who work in Human Resources may access this page.';
  include '../accessdenied.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 51L - Add employees.
if (isset($_GET['add']))
{
  include '../../includes/db.inc.php';

  $pageTitle = 'New Employee';
  $action = 'addform';
  $name = '';
  $email = '';
  $id = '';
  $button = 'Add Employee';

  // Build the list of roles
  try
  {
    $result = $pdo->query('SELECT id, description FROM role');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of roles.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $roles[] = array(
      'id' => $row['id'],
      'description' => $row['description'],
      'selected' => FALSE);
  }

  include 'form.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 62L - Insert employees.
if (isset($_GET['addform']))
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO employee SET
        name = :name,
        email = :email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':email', $_POST['email']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted employee.';
    include 'error.html.php';
    exit();
  }

  $employeeID = $pdo->lastInsertId();

  if ($_POST['password'] != '')
  {
    $password = md5($_POST['password'] . 'ijdb');

    try
    {
      $sql = 'UPDATE employee SET
          password = :password
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':password', $password);
      $s->bindValue(':id', $employeeID);
      $s->execute();
    }
    catch (PDOException $e)
    {
      $error = 'Error setting employee password.';
      include 'error.html.php';
      exit();
    }
  }

  if (isset($_POST['roles']))
  {
    foreach ($_POST['roles'] as $role)
    {
      try
      {
        $sql = 'INSERT INTO employeerole SET
            employeeID = :employeeID,
            roleid = :roleid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':employeeID', $employeeID);
        $s->bindValue(':roleid', $role);
        $s->execute();
      }
      catch (PDOException $e)
      {
        $error = 'Error assigning selected role to employee.';
        include 'error.html.php';
        exit();
      }
    }
  }

  header('Location: .');
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 71L - Edit employees.
if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'SELECT id, name, email FROM employee WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching employee details.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Edit Employee';
  $action = 'editform';
  $name = $row['name'];
  $email = $row['email'];
  $id = $row['id'];
  $button = 'Update employee';

  // Get list of roles assigned to this employee
  try
  {
    $sql = 'SELECT roleid FROM employeerole WHERE employeeID = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $id);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of assigned roles.';
    include 'error.html.php';
    exit();
  }

  $selectedRoles = array();
  foreach ($s as $row)
  {
    $selectedRoles[] = $row['roleid'];
  }

  // Build the list of all roles
  try
  {
    $result = $pdo->query('SELECT id, description FROM role');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of roles.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $roles[] = array(
      'id' => $row['id'],
      'description' => $row['description'],
      'selected' => in_array($row['id'], $selectedRoles));
  }

  include 'form.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 71L - Edit employees.
if (isset($_GET['editform']))
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE employee SET
        name = :name,
        email = :email
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':email', $_POST['email']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating submitted employee.';
    include 'error.html.php';
    exit();
  }

  if ($_POST['password'] != '')
  {
    $password = md5($_POST['password'] . 'ijdb');

    try
    {
      $sql = 'UPDATE employee SET
          password = :password
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':password', $password);
      $s->bindValue(':id', $_POST['id']);
      $s->execute();
    }
    catch (PDOException $e)
    {
      $error = 'Error setting employee password.';
      include 'error.html.php';
      exit();
    }
  }

  try
  {
    $sql = 'DELETE FROM employeerole WHERE employeeID = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing obsolete employee role entries.';
    include 'error.html.php';
    exit();
  }

  if (isset($_POST['roles']))
  {
    foreach ($_POST['roles'] as $role)
    {
      try
      {
        $sql = 'INSERT INTO employeerole SET
            employeeID = :employeeID,
            roleid = :roleid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':employeeID', $_POST['id']);
        $s->bindValue(':roleid', $role);
        $s->execute();
      }
      catch (PDOException $e)
      {
        $error = 'Error assigning selected role to employee.';
        include 'error.html.php';
        exit();
      }
    }
  }

  header('Location: .');
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 46L - Delete employees.
if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include '../../includes/db.inc.php';

  // Delete role assignments for this employee
  try
  {
    $sql = 'DELETE FROM employeerole WHERE employeeID = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing employee from roles.';
    include 'error.html.php';
    exit();
  }

  // Get orders belonging to employee
  try
  {
    $sql = 'SELECT id FROM orders WHERE employeeID = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error getting list of orders to delete.';
    include 'error.html.php';
    exit();
  }

  $result = $s->fetchAll();

  // Delete order desserttype entries
  try
  {
    $sql = 'DELETE FROM orderdesserttype WHERE orderid = :id';
    $s = $pdo->prepare($sql);

    // For each order
    foreach ($result as $row)
    {
      $orderId = $row['id'];
      $s->bindValue(':id', $orderId);
      $s->execute();
    }
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting desserttype entries for order.';
    include 'error.html.php';
    exit();
  }

  // Delete orders belonging to employee
  try
  {
    $sql = 'DELETE FROM orders WHERE employeeID = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting orders for employee.';
    include 'error.html.php';
    exit();
  }

  // Delete the employee
  try
  {
    $sql = 'DELETE FROM employee WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting employee.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// Display employee list
include '../../includes/db.inc.php';

// 5/19/2014 Huynh, Elaine MOD 56L - Spit errors out.  
try
{
  $result = $pdo->query('SELECT id, name FROM employee');
}
catch (PDOException $e)
{
  $error = 'Error fetching employees from the database!';
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $employees[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'employees.html.php';
