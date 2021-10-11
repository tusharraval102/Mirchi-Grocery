<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mirchi Grocery | Home</title>

  <link rel="icon" type="image/x-icon" href="/favicon.ico">

  <link rel="stylesheet" href="/styles/homepage.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">



</head>

<body>
  <header>
    <a href="/index.php">
      <img src="imgs/Mirchi_Logo_oval_B.png" alt="Mirchi">
    </a>

    <nav id="nav-bar">
    <a href="../index.php" class="nav-item">Home</a>

            <a href="../ShoppingCart.php" class="nav-item">Shopping Cart</a>
            <span class="nav-item">
                <?php

if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "<a href=\"../Login/login.php\" class=\"nav-item\">Log in</a>";
}

?>
                </span>

                <?php
if (isset($_SESSION['username'])) {
    echo "<a href=\"../Login/logout.php\" class=\"nav-item\">Log Out</a>";
}

?>

                <?php
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin']) {
        echo "<a href=\"/Back Store/productList.php\" class=\"nav-item\">Back Store</a>";
    }
}

?>
    </nav>
  </header>


  <section id="aisle-bar">
    <a href="/Aisles/fruitsAndVegetables.php">Fruits & Vegetables</a>
    <a href="/Aisles/dairy.php">Dairy Products</a>
    <a href="/Aisles/meatAndPoultry.php">Meat & Poultry</a>
    <a href="/Aisles/fishAndSeafood.php">Fish & Seafood</a>
    <a href="/Aisles/Spices.php">Herbs & Spices</a>
    <a href="/Aisles/bakery.php">In-store Bakery</a>
</section>

  <section id="aisle-bar" class="resp">
    <img id="logo-resp" src="imgs/logo-resp.png" alt="Mirchi">

    <div id="hamburger-icon">
      <svg viewBox="0 0 100 80" width="40" height="40">
        <rect width="100" height="20"></rect>
        <rect y="30" width="100" height="20"></rect>
        <rect y="60" width="100" height="20"></rect>
      </svg>
    </div>


    <div id="dropdown-nav">
        <a href="/Aisles/fruitsAndVegetables.php">Fruits & Vegetables</a>
        <a href="/Aisles/dairy.php">Dairy Products</a>
        <a href="/Aisles/meatAndPoultry.php">Meat & Poultry</a>
        <a href="/Aisles/fishAndSeafood.php">Fish & Seafood</a>
        <a href="/Aisles/Spices.php">Herbs & Spices</a>
        <a href="/Aisles/bakery.php">In-store Bakery</a>
        <a> <?php
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "<a href=\"/Login/login.php\" class=\"nav-item\">Log in</a>";
}

?>
            </a>
            <a href="/ShoppingCart.php">Shopping Cart</a>

            <a>                 <?php
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin']) {
        echo "<a href=\"/Back Store/productList.php\" class=\"nav-item\">Back Store</a>";
    }
}
?>
  </div>

  </section>

  <section id="splash">

    <div>
      <p>Experience Mirchi today! <br> <?php
if (!isset($_SESSION['username'])) {
    echo "<a href=\"/signup.php\">Become a Member</a> | <a href=\"/Login/login.php\"> Sign in</a>";
} else {
    echo "Welcome, " . $_SESSION['username'];
}

?></p>
    </div>

  </section>

  <div>
    <p>
      <br>
      Shop our products
    </p>
  </div>

  <section id="aisle-grid" class="container">
    <div class="row">
      <div id="fruit-vegetable" class="col-sm aisle">

        <div class="selectionbox">
          <img src="imgs/sajad-nori-pDjL38RrLFA-unsplash.jpg" alt="Fruits and Vegetables" style="width: 100%;">
          <div class="content"> <a href="/Aisles/fruitsAndVegetables.php">Fruits & Vegetables</a> </div>
        </div>

      </div>
      <div id="dairy" class="col-sm aisle">

        <div class="selectionbox">
          <img src="imgs/alexander-maasch-KaK2jp8ie8s-unsplash.jpg" alt="DairyProducts" style="width: 100%;">
          <div class="content"> <a href="/Aisles/dairy.php">Dairy Products</a> </div>
        </div>

      </div>
      <div id="meat-poultry" class="col-sm aisle">

        <div class="selectionbox">
          <img src="imgs/edson-saldana-J88no2vCrTs-unsplash.jpg" alt="Steak" style="width: 100%;">
          <div class="content"> <a href="/Aisles/meatAndPoultry.php">Meat & Poultry</a> </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div id="fish-seafood" class="col-sm aisle">

        <div class="selectionbox">
          <img src="imgs/caroline-attwood-kC9KUtSiflw-unsplash.jpg" alt="Salmon" style="width: 100%;">
          <div class="content"> <a href="/Aisles/fishAndSeafood.php">Fish & Seafood</a> </div>
        </div>

      </div>
      <div id="spices" class="col-sm aisle">

        <div class="selectionbox">
          <img src="imgs/tiard-schulz-V5Bqsot6UCg-unsplash.jpg" alt="Spices" style="width: 100%;">
          <div class="content"> <a href="/Aisles/Spices.php">Herbs & Spices</a> </div>
        </div>

      </div>
      <div id="bakery" class="col-sm aisle">

        <div class="selectionbox">
          <img src="imgs/syed-f-hashemi-ht8LS00RUWA-unsplash.jpg" alt="Naan" style="width: 100%;">
          <div class="content"> <a href="/Aisles/bakery.php">In-store Bakery</a> </div>
        </div>

      </div>
    </div>
  </section>

  <section id="aisle-long" class="aisle-long">

    <div id="fruitandveg" class="aisle-long">
      <img src="imgs/sajad-nori-pDjL38RrLFA-unsplash.jpg" alt="Fruits and Vegetables" style="width: 100%;">
      <div class="content"> <a href="/Aisles/fruitsAndVegetables.php">Fruits & Vegetables</a> </div>
    </div>

    <div id="dairy_products" class="aisle-long">
      <img src="imgs/alexander-maasch-KaK2jp8ie8s-unsplash.jpg" alt="DairyProducts" style="width: 100%;">
      <div class="content"> <a href="/Aisles/dairy.php">Dairy Products</a> </div>
    </div>

    <div id="meats" class="aisle-long">
      <img src="imgs/edson-saldana-J88no2vCrTs-unsplash.jpg" alt="Steak" style="width: 100%;">
      <div class="content"> <a href="/Aisles/meatAndPoultry.php">Meat & Poultry</a> </div>
    </div>

    <div id="fish" class="aisle-long">
      <img src="imgs/caroline-attwood-kC9KUtSiflw-unsplash.jpg" alt="Salmon" style="width: 100%;">
      <div class="content"> <a href="/Aisles/fishAndSeafood.php">Fish & Seafood</a> </div>
    </div>

    <div id="spice" class="aisle-long">
      <img src="imgs/tiard-schulz-V5Bqsot6UCg-unsplash.jpg" alt="Spices" style="width: 100%;">
      <div class="content"> <a href="/Aisles/Spices.php">Herbs & Spices</a> </div>
    </div>

    <div id="bread" class="aisle-long">
      <img src="imgs/syed-f-hashemi-ht8LS00RUWA-unsplash.jpg" alt="Naan" style="width: 100%;">
      <div class="content"> <a href="/Aisles/bakery.php">In-store Bakery</a> </div>
    </div>

    <div id="space" class="aisle-long">
      <br>
    </div>


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