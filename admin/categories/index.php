<?php
include_once '../../includes/magicquotes.inc.php';

require_once '../../includes/access.inc.php';

if (!userIsLoggedIn())
{
  include '../login.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 3L - Make sure the user is a chef.
if (!userHasRole('Chef'))
{
  $error = 'Only chefs may enter this page.';
  include '../accessdenied.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 51L - Add dessert types.
if (isset($_GET['add']))
{
  $pageTitle = 'New Category';
  $action = 'addform';
  $name = '';
  $id = '';
  $button = 'Add Dessert Category';

  include 'form.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 62L - Insert dessert types.
if (isset($_GET['addform']))
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO desserttype SET
        name = :name';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted dessert category.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 71L - Edit dessert types.
if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'SELECT id, name FROM desserttype WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching desserttype details.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Edit Category';
  $action = 'editform';
  $name = $row['name'];
  $id = $row['id'];
  $button = 'Update Dessert Category';

  include 'form.html.php';
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 71L - Edit categories.
if (isset($_GET['editform']))
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE desserttype SET
        name = :name
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating submitted desserttype.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// 5/19/2014 Huynh, Elaine MOD 71L - Delete dessert types.
if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include '../../includes/db.inc.php';

  // Delete order associations with this desserttype
  try
  {
    $sql = 'DELETE FROM dessertcategory WHERE desserttypeid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing orders from desserttype.';
    include 'error.html.php';
    exit();
  }

  // Delete the desserttype
  try
  {
    $sql = 'DELETE FROM desserttype WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting desserttype.';
    include 'error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// Display desserttype list
include '../../includes/db.inc.php';

// 5/19/2014 Huynh, Elaine MOD 56L - Spit errors out.  
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

include 'categories.html.php';
