<?php
include_once('connect.php');

if (isset($_GET['pharmacie'])){
  $pharmacie = $_GET['pharmacie'];
  $sql = "SELECT localisation FROM pharmacie WHERE nom_pharmacie = '$pharmacie'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="' . $row['localisation'] . '">' . $row['localisation'] . '</option>';
    }
  }
}

$conn->close();
?>
