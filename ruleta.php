<?php
  session_start();
  if(!$_SESSION['sess_usuari']){
    header("Location: index.php"); 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FULL-STACK</title>
  <link rel="stylesheet" href="css/reset.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
  <script src="index.js" defer></script>
</head>
<body>

<?php
if(isset($_POST["sumbit"])){  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['add-chips'])){
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "fullstack";
      
      // Create connection
      $conn = new mysqli($servername, $username, $password, $database);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $sql = "SELECT * FROM usuaris WHERE nom='".$_SESSION["sess_usuari"]."'";
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()) 
      {  
        if($_POST["add-chips"] > 0){
          $total = $row['fitxes'] + $_POST["add-chips"] ;
        }else{
          $_POST["add-chips"] = -$_POST["add-chips"];
          $total = $row['fitxes'] - $_POST["add-chips"] ;
        }
      }  
      $sql = "UPDATE usuaris SET fitxes=".$total." WHERE nom='".$_SESSION["sess_usuari"]."'";
      if ($conn->query($sql) === TRUE) {
        $_SESSION['fitxes']=$total;  
      } else {
        echo "Error updating record: " . $conn->error;
      }
    }
  }
}
if(isset($_POST["sortir"])){  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_destroy();
    header("Location: index.php"); 
  }
}
?>
  <div id="divBoto">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
      <button id="sortir" name="sortir">SORTIR</button>
    </form>
  </div>
  <div class="myChips">
    <h1>CHIPS:</h1>
    <p id="chips"><?php echo $_SESSION['fitxes'];?></p>
  </div>
  <div class="addChips">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
      <button id="add-chips-btn" type="submit" name="sumbit">+</button>
      <input class="inputs" type="number" id="add-chips" name="add-chips">
    </form>
  </div>
  <div class="apostar">
    <div class="chipsAposta">
      <h1 class="tituls">Aposta:</h1>
      <input type="text" id="bet" class="inputs" oninput="controlChips()">
    </div>
    <div class="tipusAposta">
      <h1 class="tituls">Tipus</h1>
      <select name="tipus" id="bet-type" class="inputs">
        <option value="parell">Parell</option>
        <option value="imparell">Imparell</option>
      </select>
    </div>
    <div class="numeroAposta">
      <h1 class="tituls">Numero a Apostar</h1>
      <input type="text" id="bet-number" class="inputs" oninput="controlAposta()">
    </div>
  </div>
  <div class="apostar" id="divGirar">
    <button id="botoGirar">
      Girar
    </button>
  </div>
  <div class="divResult">
    <p id="result"></p>

  </div>
  <div class="divTest">
    <h1>TESTER:</h1>
    <select name="test-mode" id="test-mode" class="inputs">
      <option value="test-win">test-win</option>
      <option value="test-loose">test-loose</option>
      <option value="no-test" selected>no-test</option>
    </select>
  </div>
</body>
</html>