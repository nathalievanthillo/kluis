<?php

    if(!empty($_POST)){

        //CONNECTION WITH DATABASE
        $conn = new mysqli("localhost", "root", "root", "kluis");
        $code = $_POST["code"];

        $q = $conn->prepare("SELECT * FROM kluis WHERE code = :code");
        $q->bindValue(":code", $code);
        $q->execute();


        $kluis = $q->fetch();

        //CODE IS NOT CORRECT
        if($kluis["code"] !== $code){
            $error = "Code is niet correct!";

        //CODE IS CORRECT
        } else if ($kluis["code"] === $code){
            $success = "Je hebt de kluis geopend!";
        };


    };

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <title>Locker</title>
</head>

<body>
    <div class="container">
        <div class="text">OPEN DE KLUIS!</div>
        <div class="page">
            <div class="title">
                <img src="images/closed-locker.svg">

            </div>

            <form action="#" method="POST">

            
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

                <label>Vul de code in</label>
                <input type="password" id="code" name="code" placeholder="Code">
                <button type="submit" name="Open Locker" id="btnSubmit">CONTROLEER CODE</button>

            </form>

</body>

</html>