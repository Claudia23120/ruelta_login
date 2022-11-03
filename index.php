<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/reset.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">

</head>
<?php
$usuari = $passwordI= "";
$usuariErr = $passErr = "";
$servername = "localhost";
$username = "root";
$password = "";
$database = "fullstack";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["usuari"])) {
    $usuariErr = "Nom Usuari obligatori";
  } else {
    $usuari = test_input($_POST["usuari"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$usuari)) {
      $usuariErr = "Nomes lletres i espais";
    }
    if (empty($_POST["password"])) {
      $passErr = "Escriu la contrasenya";
    }else{
      $passwordI = test_input($_POST["password"]);
      if (!preg_match("/^[0-9]*$/",$passwordI)) {
        $passErr = "Nomes numeros";
      }else{
        $passErr="";
      }
    }
  }
  
if(isset($_POST["submit"])){  
    if($usuariErr=="" && $passErr=="") {  
      $conn = new mysqli($servername, $username, $password, $database);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM usuaris WHERE nom='".$usuari."'";
      $result = $conn->query($sql);

      if ($result->num_rows == 0){
        $usuariErr = "No existeix aquest usuari";
        $passErr = "";
      }else{
        while($row = $result->fetch_assoc()) 
        { 
            $dbusername=$row['nom'];
            $dbPas=$row['password'];
            $dbchips=$row['fitxes']; 
        
        }  
       if($dbPas==$passwordI)  
        {  
          session_start();  
          $_SESSION['sess_usuari']=$usuari;
          $_SESSION['fitxes']=$dbchips;  
          header("Location: ruleta.php");  
        } else{
          $passErr = "Contrasenya incorrecta";
        }
      }
      $conn->close();
    }
        
  }
}
if(isset($_POST["registra"])){  
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($usuariErr=="" && $passErr=="") {  

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM usuaris WHERE nom='".$usuari."'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0){
      $sql="INSERT INTO usuaris(nom,password) VALUES('$usuari','$passwordI')";   
      if($conn->query($sql) === TRUE){  
        echo "Account Successfully Created";  
        session_start();  
        $_SESSION['sess_usuari']=$usuari;
        $_SESSION['fitxes']=0;  
        header("Location: ruleta.php");  
      } else {  
        echo "Failure!";  
      }  
    }else{
      $usuariErr="Ja existeix un usuari amb aquest nom";
    }
  }
  }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<body>
    
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"> 
    <div id="general">
      <div id="login">  
        <h1 id="titol">RULETA</h1>
        <div>
          <label for="nom" id="nom">NOM USUARI</label><br>
          <input type="text" id="usuari" name="usuari" class="inputs" value="<?php echo $usuari; ?>"><span class="error">*<br> <?php echo $usuariErr;?></span><br><br>
          <label id="contra">CONTRASENYA:</label><br> 
          <input type="password" id="password" name="password" class="inputs"><span class="error">*<br> <?php echo $passErr;?></span><br><br>

        </div>
        <div id="botons">
          <button type="submit" name="registra" id="boto">REGISTRA</button>
          <button type="submit" name="submit" id="boto">ENTRA</button>
        </div>
      </div>
    </div>
    
  </form> 
    
</body>
</html>