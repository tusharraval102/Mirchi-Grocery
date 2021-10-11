<?php
session_start();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirchi Grocery | Fruit & Veg</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/aislepages.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">

    <style>
    #splash {
        background-image: url("/imgs/Fruits-and-Vegetables-Banner.jpg");
    }
    </style>
</head>

<body onload="loadDoc()">
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
        <a href="/Aisles/fruitsAndVegetables.php">Fruits & Vegetables</a>
        <a href="/Aisles/dairy.php">Dairy Products</a>
        <a href="/Aisles/meatAndPoultry.php">Meat & Poultry</a>
        <a href="/Aisles/fishAndSeafood.php">Fish & Seafood</a>
        <a href="/Aisles/Spices.php">Herbs & Spices</a>
        <a href="/Aisles/bakery.php">In-store Bakery</a>
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
            <a href="/Aisles/dairy.php">Dairy Products</a>
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
            <p>Fruits & Vegetables</p>
        </div>

    </section>

    <div class="container">
        <br>
        <div class="row align-items-center" id="product">
           <!-- dynamic content here-->
        </div>
    </div>

    <script>
    var xmlDoc;

    function loadDoc() {

        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myFunction(this);
            }
        };
        xhttp.open("GET", "../Back Store/mirchidatabase.xml", true);
        xhttp.send();
    }

    function myFunction(xml) {
        var i;
        xmlDoc = xml.responseXML;
        var productCard = "";

        var x = xmlDoc.getElementsByTagName("aisle");
        for (i = 0; i < x.length; i++) {
            if (x[i].getAttribute('id') == "FruitsAndVegetables") {
                var products = x[i].getElementsByTagName('product');
                for (count = 0; count < products.length; count++) {
                    let aisle = x[i].getAttribute('id');
                    let sku = products[count].getAttribute('SKU');
                    let name = products[count].getElementsByTagName('name')[0].childNodes[0].nodeValue;
                    let price = products[count].getElementsByTagName('price')[0].childNodes[0].nodeValue;
                    let totalquantity = products[count].getElementsByTagName('totalquantity')[0].childNodes[0]
                        .nodeValue;
                    let unitsperquantity = products[count].getElementsByTagName('unitsperquantity')[0].childNodes[0]
                        .nodeValue;
                    let description = products[count].getElementsByTagName('description')[0].childNodes[0].nodeValue;
                    let img = products[count].getElementsByTagName('img')[0].childNodes[0].nodeValue;

                    productCard += "<div class=\"col-md-4\"><div class=\"card\"><div><img class=\"product-img\" src=" +
                        img + " /></div><div class=\"m-auto\"><span class=\"product-tag\">" + name +
                        "</span></div><div class=\"product-body\"><div class=\"product-title\"><h5><a href=\"/Aisles/fruitProduct.php?sku=" +
                        sku + "&name=" + name + "&price=" + price + "&description=" + description + "&img=" + img +
                        "&unitsperquantity=" + unitsperquantity + "&aisle=" + aisle + "\">" +
                        name + "</a></h5></div><div class=\"product-price\"><p>" + price +
                        "</p></div></div><div class=\"m-auto\"><div class=\"add-to-cart\"><button class=\"btn btn-outline-secondary\" type=\"button\">Add to cart</button>" +
                        "</div></div></div></div>";
                }
                break;
            }
        }

        productCard += "</div></div>";
        document.getElementById("product").innerHTML = productCard;

    }
    </script>

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

<!--All photos used in the bakery section of this website were obtained from https://unsplash.com-->

</html>