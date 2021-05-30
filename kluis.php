<?php


if (!empty($_POST)) {


    //zodat je niet zomaar naar de welcome.php kan gaan
    session_start();
    $file = fopen("open_close.txt", "w") or die("Doesn't work"); //txt file 
    if ($_POST['code'] == "2021") { // code van de kluis
        $_SESSION["allowed"] = true; // als je code juist hebt wordt je doorverwijst naar welcome.php
        header("Location: welcome.php");
        $open = "open";
        fwrite($file, $open);
    } else {
        $error = "sorry, probeer nog eens"; //foutieve code ingevoerd
        $fail = "close";
        fwrite($file,  $fail);
    }
    fclose($file);
};

if (!empty($_POST['reset'])) { // reset knop om terug te gaan en kluis te sluiten
    $reset_msg = "";
    $file = fopen("open_close.txt", "w") or die("Doesn't work"); //txt file 
    $fail = "close";
    fwrite($file,  $fail);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <title>Kluis</title>
</head>

<body>
    <div class="container">
        <div class="text">OPEN DE KLUIS!</div>
        <div class="page">
            <div class="title">
                <img src="images/closed-locker.svg">

            </div>

            <form action="#" method="POST">

                <p><?php echo $error; ?><?php echo $success; ?></p>

                <label>Vul de code in</label>
                <input type="password" id="code" name="code" placeholder="Voer de code in">
                <button type="submit" name="open" id="btnSubmit">CONTROLEER CODE</button>
                <button type="submit" name="reset" id="btnReset">RESET</button>

            </form>

</body>

</html>
