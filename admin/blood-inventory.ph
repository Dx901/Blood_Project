<?php

// Check if the user is an administrator
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
  header('Location: /login.php');
  exit;
}

// Get the list of blood groups and their quantities
$bloodGroups = getBloodGroups();

// Display the list of blood groups and their quantities
foreach ($bloodGroups as $bloodGroup) {
  echo '<tr>';
  echo '<td>' . $bloodGroup['BloodGroup'] . '</td>';
  echo '<td>' . $bloodGroup['Quantity'] . '</td>';
  echo '<td><a href="/delete-blood-group.php?id=' . $bloodGroup['id'] . '">Delete</a></td>';
  echo '<td><a href="/approve-blood-request.php?id=' . $bloodGroup['id'] . '">Approve</a></td>';
  echo '</tr>';
}

// If a blood group is deleted, reduce the quantity of blood by 1
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $bloodGroupId = $_GET['delete'];
  $bloodGroup = getBloodGroupById($bloodGroupId);
  $bloodGroup['Quantity']--;
  updateBloodGroup($bloodGroup);
}

// If a blood request is approved, reduce the quantity of blood by 1
if (isset($_GET['approve']) && is_numeric($_GET['approve'])) {
  $bloodGroupId = $_GET['approve'];
  $bloodGroup = getBloodGroupById($bloodGroupId);
  $bloodGroup['Quantity']--;
  updateBloodGroup($bloodGroup);
}

?>
