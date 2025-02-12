<?php
include("process/conn.php");

$msg ="";

if(isset($_SESSION["msg"])){
    $msg = $_SESSION["msg"];
    $status= $_SESSION["status"];

    $_SESSUIB["msg"]="";
    $_SESSION["status"]= "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu pedido</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <!-- APP CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg">
        <a href="index.php" class="navbar-brand">
        <img src="img/pizza.svg" alt="Pizzaria do João" id="brand-logo">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="index.php" class="nav-link">Peça sua pizza</a>
                </li>
            </ul>
        </div>
    </nav>
    </header>
    <?php if (!empty($msg)): ?>
    <div class="alert alert-<?= $status ?>" id="alert-box">
        <p><?= $msg ?></p>
    </div>

    <script>
        // Aguarda 3 segundos e remove a mensagem
        setTimeout(function() {
            var alertBox = document.getElementById("alert-box");
            if (alertBox) {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = "0";
                setTimeout(function() {
                    alertBox.remove();
                }, 500);
            }
        }, 3000);
    </script>
<?php endif; ?>

    