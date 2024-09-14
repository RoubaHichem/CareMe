<?php
session_start();
include_once('connect.php');

if (isset($_POST['envoyer'])) {
    $nom = $_POST['Nom'];
    $prenom = $_POST['prenom'];
    $numero = $_POST['numero'];
    $naissance = $_POST['naissance'];
    $email = $_POST['email'];
    $genre = $_POST['genre'];
    $jour = $_POST['jour'];
    $lheure = $_POST['lheure'];
    $specialite = $_POST['specialite'];
    $medecin = $_POST['nom'];
    $username = $_SESSION['username'];

    // Vérifier si le rendez-vous existe déjà pour un autre patient
    $stmt = $conn->prepare("SELECT * FROM rendezvous WHERE jour = ? AND lheure = ?");
    $stmt->bind_param("ss", $jour, $lheure);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        // Le rendez-vous existe déjà pour un autre patient
        echo '<script type="text/javascript">';
        echo ' alert("Ce rendez-vous est déjà pris par un autre patient. Veuillez changer lheure ou la date")';
        echo '</script>';
    } else {
        // Le rendez-vous n'existe pas pour un autre patient, on l'insère dans la base de données
        $stmt = $conn->prepare("INSERT INTO rendezvous(Nom, prenom, numero, naissance, email, genre, jour, lheure, specialite, medecin, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $nom, $prenom, $numero, $naissance, $email, $genre, $jour, $lheure, $specialite, $medecin, $username);
        $stmt->execute();
        $stmt->close();

        echo '<script type="text/javascript">';
        echo ' alert("Votre rendez-vous a bien été envoyé.")';
        echo '</script>';
    }
}

?>



<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Patient Page</title>
        <link rel="stylesheet" href="home.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
     
        <header class="header">

            <a href="#" class="logo"> <i class="fas fa-heartbeat"></i> <strong>Medecin</strong>Care</a>
            
            <?php
             
             echo '<span style="color: #16a085; font-weight: bold; font-size: 1.7em; display: inline-block;">Bienvenue ' . $_SESSION['username'] . '</span>';
             ?>
            

            <nav class="nav">
                <a href="#home">Accueil</a>
                <a href="#about">À propos</a>
                <a href="#appointment">Rendez-Vous</a>
                <a href="#Pharmacie">Pharmacie</a>
                <a href="#Laboratoire">Laboratoire</a>
                <a href="logout.php">Déconnexion</a>
               
             </nav>
    
        </header>

<!-- Home section -->        
         
<section class="home" id="home">

    <div class="image">
        <img src="img/home-img.svg">
    </div>

    <div class="content">
        <h3>Restez en bonne santé</h3>
        <p>"La santé est une richesse qui ne peut être achetée, mais qui peut être cultivée à travers de saines habitudes de vie."</p>
        <a href="#appointment" class="btn">rendez-vous<span class="fas fa-chevron-right"></span> </a>
    </div>

</section> 

<!------------------------------->

<!-- about section -->

<section class="about" id="about">

    <h1 class="heading"> <span>à </span> propos </h1>

    <div class="row">

        <div class="image">
            <img src="img/about-img.svg" alt="">
        </div>

        <div class="content">
        <p>Bienvenue sur notre site dédié à la santé.
          Nous sommes une plateforme en ligne qui facilite la prise de rendez-vous chez n'importe quel médecin et vous permet d'envoyer des ordonnances à n'importe quelle pharmacie ou laboratoire. 
          Notre mission est de simplifier l'accès aux soins de santé pour tous en offrant une solution pratique et efficace. 
          Grâce à notre service, vous pouvez réserver une consultation médicale en quelques clics et éviter les longues files d'attente. 
        </p> 
        </div>

    </div>

</section>

<!------------------------------->


<!-- appointment section -->

<section class="appointment" id="appointment">
     
    <h1 class="rendez"> <span>Rendez-Vous</span></h1>    

    <div class="row">
        
        <form id="form-patient" method="POST">
            <h2>Informations du patient</h2>
            
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="Nom" placeholder="Nom" required />
            </div>
            
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="prenom" placeholder="Prénom" required />
            </div>
            
            <div class="input-field">
            <i class="fas fa-phone"></i>
              <input type="text" name="numero" placeholder="Numéro de téléphone" required maxlength="10"/>
            </div>
            
            <div class="input-field">
              <i class="fas fa-calendar-alt"></i>
              <input type="date" name="naissance" placeholder="Date de naissance" required />
            </div>

            
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email"  required/>
            </div>
               
            <div class="radio-group">
            <label> <input type="radio" name="genre" value="homme"> Homme </label>
            <label> <input type="radio" name="genre" value="femme"> Femme </label>
            </div>
            </br>
             
            <h2>Prendre un rendez-vous</h2>
            <label for="date">Date</label>
            <input type="date" id="date" name="jour" required>
            <label for="heure">Heure</label>
            <input type="time" id="heure" name="lheure" required>

          <script>
            
            var heureInput = document.getElementById("heure");
            heureInput.addEventListener("input", function() {
            var heureSelectionnee = new Date("1970-01-01T" + heureInput.value + ":00");
            var heureDebut = new Date("1970-01-01T08:00:00");
            var heureFin = new Date("1970-01-01T17:00:00");
  
            if (heureSelectionnee < heureDebut || heureSelectionnee > heureFin) {
               heureInput.value = "08:00";
            } else {
                var minutes = heureSelectionnee.getMinutes();
                var reste = minutes % 15;
                var ajoutMinutes = reste > 7.5 ? 15 - reste : -reste;
                heureSelectionnee.setMinutes(minutes + ajoutMinutes);
    
               var heureAffichee = heureSelectionnee.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
               heureInput.value = heureAffichee;
              }
          });

         </script>

            <label for="specialite">Spécialité</label>
            <select class="pharmacie-select" id="specialite" name="specialite" required>
            <option value="">Sélectionnez une spécialité</option>

            <?php
            include_once('connect.php');

            $sql = "SELECT DISTINCT spécialité FROM medecins";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
             while ($row = $result->fetch_assoc()) {
             echo '<option value="' . $row['spécialité'] . '">' . $row['spécialité'] . '</option>';
            }
            }

            ?>
            </select>

            <label for="nom">Nom du médecin</label>
            <select class="pharmacie-select" id="nom"  name="nom" required>
            <option value="">Sélectionnez d'abord une spécialité</option>
            </select>

              <script>
              // Fonction pour charger les noms de médecins correspondant à la spécialité sélectionnée
               document.getElementById('specialite').addEventListener('change', function() {
               var specialite = this.value;
               var xhr = new XMLHttpRequest();
               xhr.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200) {
               document.getElementById('nom').innerHTML = this.responseText;
              }
              };
              xhr.open('GET', 'getMedecins.php?specialite=' + specialite, true);
              xhr.send();
              });
              </script>

               <label for="localisation">Localisation du Cabinet</label>
               <select class="pharmacie-select" id="localisation" name="localisation" required>
               <option value="">Sélectionnez d'abord un medecin</option>
               </select>
               
               
               <button type="submit" id="copierLocalisation">Copier</button>
               
               <script>

              // Fonction pour charger la localisation du médecin sélectionné
               document.getElementById('nom').addEventListener('change', function() {
               var localisation = this.value;
               var xhr = new XMLHttpRequest();
               xhr.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200) {
               document.getElementById('localisation').innerHTML = this.responseText;
              }
              };
               xhr.open('GET', 'getMedecinLocation.php?nom=' + localisation, true);
               xhr.send();
              });
              // Fonction pour copier la localisation
              document.getElementById('copierLocalisation').addEventListener('click', function() {
              var localisation = document.getElementById('localisation');
              if (localisation.value !== "") {
              var tempInput = document.createElement('input');
              tempInput.setAttribute('type', 'text');
              tempInput.setAttribute('value', localisation.value);
              document.body.appendChild(tempInput);
              tempInput.select();
              document.execCommand('copy');
              document.body.removeChild(tempInput);
             
            } 
          });
               </script>

           
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d103667.50195312737!2d-0.7207657117456621!3d35.7112275908876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7e8854841f537d%3A0x4187f63762f7290f!2sOran!5e0!3m2!1sen!2sdz!4v1681478828430!5m2!1sen!2sdz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            
        <button type="submit" name="envoyer">envoyer</button>

        </form>
          
    </div>
    
</section>

<!------------------------------->

<!-- Pharmacie section -->

<section class="pharmacie" id="Pharmacie">

    <h1 class="heading"><span>Pharmacie</span></h1>
    
    <div class="row">
        <div class="image">
            
            <img src="img/undraw_mobile_pay_re_sjb8.svg" alt="">
        </div>
            
        
            <form id="pharmacy-form"  method="POST" enctype="multipart/form-data">
                
                <h2>Envoyer une ordonnance à une pharmacie</h2>
                <h1>Choisissez une pharmacie</h1>

                <label for="pharmacie-select">Sélectionnez une pharmacie :</label>
                <select class="pharmacie-select" name="pharmacie" id="pharmacie" required>
                <option value="">Choisissez une pharmacie</option>

    
                <?php
                include_once('connect.php');
                $sql = "SELECT DISTINCT nom_pharmacie, email_pharmacie FROM pharmacie";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                 while ($row = $result->fetch_assoc()) {
                 echo '<option value="' . $row['nom_pharmacie'] . '">' . $row['nom_pharmacie'] . '</option>';
                }
                }
                ?>
              </select>

             


              <div class="map-container">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d103667.50195312737!2d-0.7207657117456621!3d35.7112275908876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7e8854841f537d%3A0x4187f63762f7290f!2sOran!5e0!3m2!1sen!2sdz!4v1681478828430!5m2!1sen!2sdz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>

              <label for="patient-email">Votre adresse e-mail :</label>
              <input type="email" id="patient-email" name="patient-email" required>

             <label for="ordonnance-file">Joindre une ordonnance (PDF ou JPG) :</label>
             <input type="file" id="ordonnance-file" name="ordonnance-file" required>

             <?php
             include_once('connect.php');
             $success = false;

             if(isset($_POST['send'])) {
             $pharmacie = $_POST['pharmacie'];
             $email_pharmacie = "";
             $patientEmail = $_POST['patient-email'];
  
             // Récupérer l'adresse email de la pharmacie à partir de la base de données
             $sql = "SELECT email_pharmacie FROM pharmacie WHERE nom_pharmacie = '$pharmacie'";
             $result = $conn->query($sql);

             if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email_pharmacie = $row['email_pharmacie'];
              }

             // Envoyer l'email avec l'ordonnance en pièce jointe
            
             if (isset($_FILES['ordonnance-file']) && is_uploaded_file($_FILES['ordonnance-file']['tmp_name'])) {
               $file = $_FILES['ordonnance-file'];
               $content = chunk_split(base64_encode(file_get_contents($file['tmp_name'])));
               $filename = $file['name'];
               $filetype = $file['type'];

                // Ajoutez les lignes suivantes pour ajouter l'ordonnance en tant que pièce jointe
                 $attachment = "Content-Type: \"$filetype\"; name=\"$filename\"\r\n" .
                 "Content-Transfer-Encoding: base64\r\n" .
                 "Content-Disposition: attachment; filename=\"$filename\"\r\n" .
                 "\r\n" .
                 "$content\r\n";

                // Modifiez le code de la fonction mail() comme suit pour ajouter l'ordonnance en tant que pièce jointe
                $to = $email_pharmacie;
                $subject = 'Nouvelle ordonnance';
                $message = 'Une nouvelle ordonnance a été envoyée par le patient' . ' : ' . $patientEmail;
                $boundary = md5(time());

                $headers = "From: " . $patientEmail . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: multipart/mixed; boundary=" . $boundary . "\r\n";
 
                $email_body = "--" . $boundary . "\r\n";
                $email_body .= "Content-Type: text/plain; charset='utf-8'\r\n";
                $email_body .= "Content-Transfer-Encoding: 7bit\r\n";
                $email_body .= "\r\n" . $message . "\r\n";

                $email_body .= "--" . $boundary . "\r\n"; 
                $email_body .= "Content-Type: application/pdf; name=\"" . $filename . "\"\r\n";
                $email_body .= "Content-Transfer-Encoding: base64\r\n";
                $email_body .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n";
                $email_body .= "\r\n";
                $email_body .= chunk_split(base64_encode(file_get_contents($file['tmp_name']))) . "\r\n";

                $email_body .= "--" . $boundary . "--\r\n";

                if (mail($to, $subject, $email_body, $headers)) {
                  $success = true;
                }
              }
              }
              ?>
<?php if ($success): ?>
    <h1>L'ordonnance a été envoyée avec succès.</h1>
<?php endif; ?>

             <button type="submit" name="send">Envoyer</button>
           
          
          </form>
            
    
    </div>
    
   
</section>

<!---------------------------->

<!-- Laboratoire section -->

<section class="Laboratoire" id="Laboratoire">

    <h1 class="rendez"><span>Laboratoire d'analyse médicale</span></h1>
    
    <div class="row">
        <div class="image">
            
            <img src="img/labo.svg" alt="">
        </div>
            
        
            <form id="Laboratoire-form">
                
                <h2>Envoyer une ordonnance à un Laboratoire</h2>
                <h1>Choisissez un Laboratoire</h1>
                <form id="Laboratoire-form">
                  <label for="Laboratoire-select">Sélectionnez un Laboratoire :</label>
                  <select class="pharmacie-select" name="pharmacie-select" id="Laboratoire-select" required>
                  <option value="">Choisissez un Laboratoire</option>

    
                <?php
                include_once('connect.php');
                $sql = "SELECT DISTINCT nom_laboratoire, email_laboratoire FROM laboratoire";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                 while ($row = $result->fetch_assoc()) {
                 echo '<option value="' . $row['nom_laboratoire'] . '">' . $row['nom_laboratoire'] . '</option>';
                }
                }
                ?>
              </select>
        
                  <div class="map-container">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d103667.50195312737!2d-0.7207657117456621!3d35.7112275908876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7e8854841f537d%3A0x4187f63762f7290f!2sOran!5e0!3m2!1sen!2sdz!4v1681478828430!5m2!1sen!2sdz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                   
                  <label for="patient-Laboratoire">Votre adresse e-mail :</label>
                  <input type="email" id="patient-email" name="patient-email" required>
                 
                  <label for="ordonnance-file">Joindre une ordonnance (PDF ou JPG) :</label>
                  <input type="file" id="ordonnance-file" name="ordonnance">
                  
                 
                  <button type="submit">Envoyer</button>
                </form>
            </form>
            
    
     </div>
    
   
</section>

<!---------------------------->


<script src="ess.js"></script>
<script src="rd.js"></script>


    </body>
       
</html>