<?php
session_start();
if (isset($_SESSION['loggedIn'])) {
    if ($_SESSION['loggedIn']) {
        if (isset($_POST['quantity_of_item'])) {
            $dom = new DOMDocument();
            $dom->formatOutput = true;
            $dom->load('../Back Store/mirchidatabase.xml', LIBXML_NOBLANKS);
            $root = $dom->documentElement;
            $users = $root->getElementsByTagName('users');
            $emails = $users[0]->getElementsByTagName('email');
            foreach ($emails as $email) {
                if ($email->nodeValue == $_SESSION['username']) {
                    $cart = $email->parentNode->lastChild;
                    $addedProduct = $cart->appendChild($dom->createElement('addedProduct'));
                    $addedProduct->appendChild($dom->createElement('addedProduct_name', $_REQUEST['name']));
                    $addedProduct->appendChild($dom->createElement('addedProduct_price', $_REQUEST['price']));
                    $addedProduct->appendChild($dom->createElement('addedproduct_quantity', $_POST['quantity_of_item']));
                    $addedProduct->appendChild($dom->createElement('addedproduct_img', $_REQUEST['img']));
                    $dom->save('../Back Store/mirchidatabase.xml') or die('XML Create Error');
                    break;
                }
            }
        }
    } else {
        if (isset($_POST['quantity_of_item'])) {
            echo '<div style="font-size: 2rem; border-radius: 5px;  color: #d66663; height:15%; width:20%; position:fixed; top:42.5%;left: 40%; background-color:white; text-align: center; padding: 10px auto;padding-top: 30px; z-index: 10"><p id="login-success">You need to be logged in!</p>' .
                '<img width="30px" height="30px" src="../imgs/login.gif"></div>';
            header("refresh: 5; url=../Login/login.php");
        }
    }
} else {
    if (isset($_POST['quantity_of_item'])) {
        echo '<div style="font-size: 2rem; border-radius: 5px;  color: #d66663; height:15%; width:20%; position:fixed; top:42.5%;left: 40%; background-color:white; text-align: center; padding: 10px auto;padding-top: 30px; z-index: 10"><p id="login-success">You need to be logged in!</p>' .
          '<img width="30px" height="30px" src="../imgs/login.gif"></div>';
        header("refresh: 5; url=../Login/login.php");
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirchi Grocery | <?php echo $_REQUEST['name'] ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/productpage.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">

    <style>
    #splash {
        background-image: url("/imgs/Fruits-and-Vegetables-Banner.jpg");
    }
    </style>
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
    echo "<a href=\"../Login/login.php\" class=\"nav-item\">Log in</a>";
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
    <a href="fruitsAndVegetables.php">Fruits & Vegetables</a>
        <a href="dairy.php">Dairy Products</a>
        <a href="meatAndPoultry.php">Meat & Poultry</a>
        <a href="fishAndSeafood.php">Fish & Seafood</a>
        <a href="Spices.php">Herbs & Spices</a>
        <a href="bakery.php">In-store Bakery</a>
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
        <a href="/">Home</a>
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
                     echo "<a href=\"../Login/login.php\" class=\"nav-item\">Log in</a>";
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
        <div id="inner-splash">
            <p>Fruits And Vegetables</p>
        </div>
    </section>

    <div class="container" id="product">
        <div class="back-button"><a href="/Aisles/fruitsAndVegetables.php">Back</a></div>
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src=<?php echo $_REQUEST['img'] ?> alt="Naan" class="product-img" width="100%">
            </div>
            <div class="col-md-6">

                <div class="row">

                    <div class="col-md-12">
                        <h1 class="product-title"><?php echo $_REQUEST['name'] ?></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p class="sku">SKU: <?php echo $_REQUEST['sku'] ?></p>
                        <p><?php echo $_REQUEST['unitsperquantity'] ?>/quantity</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p id="description">
                            <?php echo $_REQUEST['description'] ?> <br>
                            <!--line above was adapted from https://rasamalaysia.com/naan/-->
                        </p>
                        <button onclick="addDescription()" id="more_description" type="button">More Description</button>
                        <script src="/JavaScript/description_button.js"></script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 bottom-rule">
                        <div class="product-price">
                            <p>$<span id="item_price"><?php echo $_REQUEST['price'] ?></span> ea.</p>
                        </div>
                    </div>
                </div>
                <div class="addcart">
                    <div class="row add-to-cart">
                        <div class="col-md-12">
                            <div class="input-group mb-3">

                                <div id="product_quantity_info">

                                    <form action="" method="POST">
                                        <div id="total_product_price">
                                            <span id="quantity_label">Quantity:</span>
                                            <button class="atc_button" type="button" id="minus_atc_button">-</button>
                                            <input type="number" id="quantity_of_item" name="quantity_of_item"
                                                size="1" min="1"></input>
                                            <button class="atc_button" type="button" id="plus_atc_button">+</button>
                                        </div>
                                        <div id="add_to_cart_button_div">
                                            <input class="button" type="submit" name="submit" id="add_to_cart"
                                                value="Add to cart">
                                        </div>
                                        <br>
                                    </form>

                                    <span id="total_product_price_statement"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script src="\JavaScript\Quantity.js" charset="utf-8"></script>
</body>

</html>