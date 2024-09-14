
<?php
              include_once('connect.php');
              if(isset($_POST['sinscrire'])){
                
                  $name =$_POST['username'];
                  $password =$_POST['pass'];
                  $email =$_POST['email'];
                  $role=$_POST['role'];
                  
                  $options = [
                    'cost' => 12,
                  ];
                  $hashpassword = password_hash($password, PASSWORD_BCRYPT, $options);
                  $stmt =$conn->prepare("insert into users(username,email,pass,role) values(?,?,?,?)");
                  $stmt->bind_param("ssss",$name,$email,$hashpassword,$role);
                  $stmt->execute();
                  echo '<script type="text/javascript">';
                  echo ' alert("Vous etes bien inscrit")';
                  echo '</script>';
                  
               
              }
?>
<?php
          session_start();
          if(isset($_POST['SeConnecter'])){
             
          include_once('connect.php');
         
          
           $name = $_POST['Nom'];
           $password = $_POST['passe'];
           $username = $name;
           $_SESSION['username'] = $username;

           while(mysqli_more_results($conn)) {
            mysqli_next_result($conn);
        }
        
          $stmt = $conn->prepare("SELECT pass, role FROM users WHERE username = ?");
          $stmt->bind_param("s",$name);
          $stmt->execute();
          $stmt->bind_result($hashed_password,$role);
          $stmt->fetch();
          $stmt->close();
         
          
          if(password_verify($password,$hashed_password)){
            if(!isset($_SESSION['role'])){
              $_SESSION['role'] = $role;
            }
            if(!empty($role)) {
              if(!isset($_SESSION['role'])){
                  $_SESSION['role'] = $role;
              }

              if ($role == "medecin") {
                // Vérifier si le médecin est déjà inscrit dans la table medecins
                while(mysqli_more_results($conn)) {
                  mysqli_next_result($conn);
              }
                $stmt = $conn->prepare("SELECT * FROM medecins WHERE username = ?");
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                
                if ($result->num_rows > 0) {
                    // Rediriger le médecin vers la page planning.php
                    $result->close();
                    header("Location: planing.php");
                    exit();
                }
                $result->close();

            }
            
              switch($_SESSION['role']) {
                case "patient":
                  header("Location: patient.php");
                  exit();
                  break;
                case "medecin":
                  header("Location: medecin.php");
                  exit();
                  break;
              }
            }
       
          
}
else{
  echo '<script type="text/javascript">';
  echo ' alert("Nom d utilisateur ou Mot de passe inccorect")';
  echo '</script>';
}
          }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">

          <form action="#" class="sign-in-form" method="post">
            <p class="logo"> <i class="fas fa-heartbeat"></i> <strong>Medecin</strong>Care</p>
            <h2 class="title">S'identifier</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="Nom" placeholder="Nom d'utilisateur" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="passe" placeholder="Mot de passe" required/>
            </div>
            
            <input type="submit" name="SeConnecter" class="btn" value="Se Connecter"/>
          </form>

          <form action="#" class="sign-up-form" method="post">
            <p class="logo"> <i class="fas fa-heartbeat"></i> <strong>Medecin</strong>Care</p>
            <h2 class="title">S'inscrire</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Nom d'utilisateur" required />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email"  required/>
            </div>
            <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="pass" placeholder="Mot de passe" required minlength="8" />
            </div>
            <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="pass_confirm" placeholder="Confirmer le mot de passe" required minlength="8" />
            </div>

            <div class="radio-group">
		        <label>
			      <input type="radio" name="role" value="patient">
			      <span>Patient</span>
		        </label>
		        <label>
			      <input type="radio" name="role" value="medecin">
			      <span>Médecin</span>
		        </label>
	          </div>
            <input type="submit" name="sinscrire" class="btn" value="S'inscrire" />
           
          </form>
           
          

        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Vous n’avez pas de compte ?</h3>
            <p>
              Inscrivez-vous
            </p>
            <button class="btn transparent" id="sign-up-btn">
              S'inscrire
            </button>
          </div>
          <img src="img/undraw_doctors_p6aq.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Vous avez un compte ?</h3>
            <p>
              Connectez-vous
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Se Connecter
            </button>
          </div>
          <img src="img/undraw_sign_up_n6im.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="app.js"></script>
    <script src="validationmdp.js"></script>
  </body>
</html>
