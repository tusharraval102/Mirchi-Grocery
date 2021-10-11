<?php
session_start();

$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 1800;

if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration && isset($_SESSION['username'])) {
    session_unset();
    session_destroy();
    session_start();
    echo 'LOGIN EXPIRED';
}

$_SESSION['LAST_ACTIVITY'] = $time;

$_SESSION["invalidLoginInformation"] = true;
$_SESSION["loggedIn"] = false;
$_SESSION['admin'] = false;

if (isset($_POST['username'])) {

    $dom = new DomDocument();
    $dom->formatOutput = true;
    $dom->load("../Back Store/mirchidatabase.xml", LIBXML_NOBLANKS);
    $root = $dom->documentElement;
    //$users = $root->getElementsByTagName('users');
    $nbUsers = $root->getElementsByTagName('user');
    $usernames = $root->getElementsByTagName('email');
    $passwords = $root->getElementsByTagName('password');

    for ($i = 0; $i < $usernames->length; $i++) {
        if ($usernames->item($i)->nodeValue == $_POST["username"] && $passwords->item($i)->nodeValue == $_POST["password"]) {
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["password"] = $_POST["password"];
            $_SESSION["invalidLoginInformation"] = false;
            $_SESSION["loggedIn"] = true;
            $admin = $nbUsers[$i]->getElementsByTagName('admin');
            if (!($admin->length == 0)) {
                $_SESSION['admin'] = true;
            }

            break;
        } else if ($i == $usernames->length - 1) {
            $_SESSION["invalidLoginInformation"] = true;
        }

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MG | Login</title>



    <link rel="stylesheet" href="/Login/login.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">



</head>

<body>
    <header>
        <a href="/index.php">
            <img src="/imgs/Mirchi_Logo_oval_B.png" alt="Mirchi">
        </a>

        <nav id="nav-bar">
            <a href="../index.php" class="nav-item">Home</a>

            <a href="../ShoppingCart.php" class="nav-item">Shopping Cart</a>
            <span class="nav-item">
                <?php
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "Log In";
}

?>
            </span>

<?php
if (isset($_SESSION['username'])) {
    echo "<a href=\"../Login/logout.php\" class=\"nav-item\">Log Out</a>";
}

?>
        </nav>
    </header>


    <section id="aisle-bar">
        <a href="../Aisles/fruitsAndVegetables.php">Fruits & Vegetables</a>
        <a href="../Aisles/dairy.php">Dairy Products</a>
        <a href="../Aisles/meatAndPoultry.php">Meat & Poultry</a>
        <a href="../Aisles/fishAndSeafood.php">Fish & Seafood</a>
        <a href="../Aisles/Spices.php">Herbs & Spices</a>
        <a href="../Aisles/bakery.php">In-store Bakery</a>
    </section>

    <section id="aisle-bar" class="resp">
        <img id="logo-resp" src="/imgs/logo-resp.png" alt="Mirchi">

        <div id="hamburger-icon">
            <svg viewBox="0 0 100 80" width="40" height="40">
                <rect width="100" height="20"></rect>
                <rect y="30" width="100" height="20"></rect>
                <rect y="60" width="100" height="20"></rect>
            </svg>
        </div>


        <div id="dropdown-nav">
            <a href="/index.php">Home</a>
            <a href="/Aisles/fruitsAndVegetables.php">Fruits & Vegetables</a>
            <a href="/Aisles/dairyProducts.php">Dairy Products</a>
            <a href="/Aisles/meatAndPoultry.php">Meat & Poultry</a>
            <a href="/Aisles/fishAndSeafood.php">Fish & Seafood</a>
            <a href="/Aisles/Spices.php">Herbs & Spices</a>
            <a href="/Aisles/bakery.php">In-store Bakery</a>
            <a> <?php
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                } else { 
                     echo "Log In";
                }

                ?>
            </a>
            <a href="/ShoppingCart.php">Shopping Cart</a>
        </div>


    </section>

    <section id="splash">

        <div>
            <p>Experience Mirchi today! <br> <a href="/signup.php">Become a Member</a>
        </div>

    </section>



    <section id="login">
        <a>
            <?php

if ($_SESSION["invalidLoginInformation"] && isset($_POST["username"]) && !$_SESSION["loggedIn"]) {
    echo '<p id="login-fail">Wrong username or password!</p>';
} else if (isset($_SESSION["username"]) && !$_SESSION["invalidLoginInformation"]) {
    if (!isset($_SESSION['timeToLogOut'])) {
        echo '<p id="login-success">Logging you in!</p>';
        echo '<img width="30px" height="30px" src="/imgs/login.gif">';
        if (!$_SESSION['admin']) {
            $_SESSION['timeToLogOut'] = true;
            header("refresh: 2; url=/index.php");
        } else {
            $_SESSION['timeToLogOut'] = true;
            header("refresh: 2; url=/Back Store/productList.php");
        }
    }

}

?>
        </a>
        <h1>Log into your account</h1>
        <form action="" method="POST" id="login-form">
            <input type="email" name="username" id="usrn-input" placeholder="username (email address)" required>
            <input type="password" name="password" id="pw-input" placeholder="password" required>
            <input type="submit" value="submit" id="submit-btn">
        </form>


    </section>



    <footer>
        <ul>
            <li><a href="">Events & Promotions</a></li>
            <li><a href="">Jobs in Stores</a>
            <li><a href="">Carreers at Head Office</a></li>
            <li><a href="">Contact us</a></li>
            <li><a href="">Store Locations</a></li>
            <li><a href="">About Us</a>
            <li><a href="">FAQ</a></li>
            <li><a href="">How can we do better?</a></li>
            <li><a href="">Terms and Conditions</a></li>
        </ul>

        <p class="copyright">Copyright 2021 MirchiGrocery</p>
    </footer>

</body>

</html>