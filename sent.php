<?php
  include "db.php";
  # GET name and wish values
  $name = htmlspecialchars($_POST['name']);
  $wish = htmlspecialchars($_POST['wish']);
  # Check if someone of that name has already entered
  $sql = "SELECT count(pid) FROM ss_fw WHERE full_name='".$name."'";
  $result = $conn->query($sql); $r = $result->fetch_assoc();
  # If name is unique and not empty
  if ($r['count(pid)'] == 0 && ($name != "" && $wish != "")) {
    $conn->query("LOCK TABLES ss_fw WRITE");
    # Prepare just in case someone is hackerman
    if ($sql = $conn->prepare("INSERT INTO ss_fw (full_name, wish) VALUES (?, ?)")) {
      $sql->bind_param("ss", $name, $wish);
      $sql->execute();
    } else echo "Something definitely bork real bad if this happens";
    $conn->query("UNLOCK TABLES");
  # Otherwise flag that is something is fucky...
  } else $flag = true;
  ?>
<!DOCTYPE html>
<head>
  <title>You've been entered!</title>
  <meta charset='utf-8'>
  <link rel="icon" href="assets/hat.png">
  <link rel='stylesheet' href='assets/styles.css' type='text/css'>
  <!-- Import Pacifico for 'handwriting' -->
  <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet"> 
</head>
<body>
  <div class="container">
    <img class='img' src='assets/secret-santa.png' href='index.html'>
    <table><tbody>          
      <?php
        # Only if all clear
        if (!$flag) {
          # Prompt
          echo "<tr><td> <h1>Your letter has been sent! You will receive an update soon!</h1><hr>";
          echo "<tr><td> <h2>Save this secret code, you'll need it to reveal your partner later!</h2>";
          echo "<tr><td>";
          # Make a random, 4 digit code
          $code = "" . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
          # Get player id for update later bc update fucking hates strings
          $sql = "SELECT pid FROM ss_fw WHERE full_name='".$name."'";
          $result = $conn->query($sql); $r = $result->fetch_assoc();
          $pid = $r["pid"];
          
          # Update row with random code
          $conn->query("LOCK TABLES ss_fw WRITE");
          if ($sql = $conn->prepare("UPDATE ss_fw SET secret_code=? WHERE pid=?")) {
              $sql->bind_param("si", $code, $pid);
              $sql->execute();
          } else
              echo "Nice you definitely fucked up pretty bad this time";
          $conn->query("UNLOCK TABLES");
          echo "<h1 class='code'>".$code."</h2>";
        } else {
          echo "<h1>Someone with that name has already entered! Try again.</h1>";
          echo "<a href='index.html'><h1>Return</h1></a>";
        }
        ?>
    </tbody></table>
  </div>
  <h3>&copy; Nick Barrow 2019</h3>
</body>
</html>