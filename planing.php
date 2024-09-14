<?php
session_start();
include_once('connect.php');

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM rendezvous WHERE medecin = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Medecin Page</title>
    <link rel="stylesheet" href="medecin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header class="header">
        <a href="#" class="logo"><i class="fas fa-heartbeat"></i><strong>Medecin</strong>Care</a>
        <?php
        echo '<span style="color: #16a085; font-weight: bold; font-size: 1.7em; display: inline-block;">Bienvenue ' . $_SESSION['username'] . '</span>';

        ?>
        <nav class="nav">
            <a href="#homesection">À propos</a>
            <a href="#home">Planning</a>
            <a href="logout.php">Déconnexion</a>
            
        </nav>
    </header>

<!-- Home section -->        
         
<section class="homesection" id="homesection">



   <div class="image">
        <img src="img/medecin.svg">
    </div>

    <div class="content">
    <h2>À propos</h2>
    
        <p>Nous sommes ravis de vous accueillir en tant que médecin.

          Notre site est conçu pour offrir une expérience de prise de rendez-vous en ligne simple et pratique. En tant que médecin, vous trouverez ici un moyen facile de gérer votre calendrier et de gérer vos rendez-vous avec vos patients.
          Nous sommes convaincus que notre site vous permettra de gagner du temps et d'optimiser votre emploi du temps.
        
        </p>
    </div>

</section> 

<!------------------------------->
<!---------Planing---------------------->
<section class="home" id="home">
        <h2>Planning Des Rendez-Vous</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro de téléphone</th>
                    <th>Date de naissance</th>
                    <th>Email</th>
                    <th>genre</th>
                    <th>jour</th>
                    <th>L'heure</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['Nom']; ?></td>
                        <td><?php echo $row['prenom']; ?></td>
                        <td><?php echo $row['numero']; ?></td>
                        <td><?php echo $row['naissance']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['genre']; ?></td>
                        <td><?php echo $row['jour']; ?></td>
                        <td><?php echo $row['lheure']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
<!------------------------------->
    <script src="medecin.js"></script>
</body>
</html>
