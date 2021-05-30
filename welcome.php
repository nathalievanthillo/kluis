<?php
  //session wordt gestart
  session_start();
  if($_SESSION["allowed"] != true){ // wanneer je niet bent toegestaan wordt je terug naar kluis.php gestuurd
    header("Location: kluis.php"); 

  } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style2.css">
 

    <title>De kluis</title>
</head>
<body>

<button><a href="kluis.php">Ga terug</a></button>


<div class="wrapper">
  <div class="modal">
    <span class="emoji round">🍾</span>
    <h1>Proficiat, Je hebt de kluis geopend!</h1>
    <a href="#" class="modal-btn">Geniet van uw drankje!</a>
  </div>
  <div id="confetti-wrapper">
  </div>
</div>

</body>

<script>
for(i=0; i<100; i++) {
    // Willekeurige rotatie
    var randomRotation = Math.floor(Math.random() * 360);
      // Random scale
    var randomScale = Math.random() * 1;
    // Willekeurige breedte & hoogte tussen 0 en viewport
    var randomWidth = Math.floor(Math.random() * Math.max(document.documentElement.clientWidth, window.innerWidth || 0));
    var randomHeight =  Math.floor(Math.random() * Math.max(document.documentElement.clientHeight, window.innerHeight || 500));
    
    // Willekeurige animatie-vertraging
    var randomAnimationDelay = Math.floor(Math.random() * 15);
    console.log(randomAnimationDelay);
  
    // Willekeurige klauren
    var colors = ['#0CD977', '#FF1C1C', '#FF93DE', '#5767ED', '#FFC61C', '#8497B0']
    var randomColor = colors[Math.floor(Math.random() * colors.length)];
  
    // Create confetti piece
    var confetti = document.createElement('div');
    confetti.className = 'confetti';
    confetti.style.top=randomHeight + 'px';
    confetti.style.right=randomWidth + 'px';
    confetti.style.backgroundColor=randomColor;
    // confetti.style.transform='scale(' + randomScale + ')';
    confetti.style.obacity=randomScale;
    confetti.style.transform='skew(15deg) rotate(' + randomRotation + 'deg)';
    confetti.style.animationDelay=randomAnimationDelay + 's';
    document.getElementById("confetti-wrapper").appendChild(confetti);
  }



</script>
  

</html>

