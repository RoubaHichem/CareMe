<?php
include_once('connect.php');

if (isset($_GET['specialite'])) {
  $specialite = $_GET['specialite'];
  $sql = "SELECT username FROM medecins WHERE spécialité = '$specialite'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="' . $row['username'] . '">' . $row['username'] . '</option>';
    }
  }
}

$conn->close();
?>
