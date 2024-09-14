
<?php
    session_start();
    include_once('connect.php');
    if (isset($_POST['confirmer'])) {
        
    
    $specialite = $_POST['specialite'];
    $endroit = $_POST['cabinet'];
    $username = $_SESSION['username'];
    
    $stmt = $conn->prepare("INSERT INTO medecins(spécialité, endroit, username) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $specialite, $endroit, $username);
    $stmt->execute();
    $stmt->close();
 
    header("Location: planing.php");
    exit;

      
}

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
               
                <a href="logout.php">Déconnexion</a>
 
             </nav>
    </header>
    <main>
        <form method="POST">
        <h2>complétez votre inscription maintenant</h2>
        
       
        <div>
            <label for="specialite">Spécialité</label>
            <select id="specialite" name="specialite" required>
            <option value="">Sélectionnez une spécialité</option>
            <option value="Cardiologie">Cardiologie</option>
            <option value="Dermatologie">Dermatologie</option>
            <option value="Gynécologie">Gynécologie</option>
            <option value="Ophtalmologie">Ophtalmologie</option>
            <option value="Pédiatrie">Pédiatrie</option>
            <option value="Psychiatrie">Psychiatrie</option>
            <option value="Urologie">Urologie</option>
            <option value="ORL">ORL</option>
            </select>
        </div>

            <div>
                <label for="cabinet">Endroit du cabinet</label>
                <input type="text" id="cabinet" name="cabinet" required>
            </div>
            <button type="submit" name="confirmer">Confirmer</button>
        </form>
    </main>
</body>
</html>
