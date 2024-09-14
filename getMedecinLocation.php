<?php
include_once('connect.php');

if (isset($_GET['nom'])) {
  $nom = $_GET['nom'];
  $sql = "SELECT endroit FROM medecins WHERE username = '$nom'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="' . $row['endroit'] . '">' . $row['endroit'] . '</option>';
    }
  }
}

$conn->close();
?>
