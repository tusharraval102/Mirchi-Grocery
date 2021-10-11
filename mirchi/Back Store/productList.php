<?php
session_start();

/* if( $_SESSION["loggedIn"] && $_SESSION['logMeOut']) {
    session_destroy(); 
}*/

if (isset($_POST["deleteProduct"])) {

    $sku = $_POST["deleteProduct"];

    $dom = new DomDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);
    $root = $dom->documentElement;
    $products = $root->getElementsByTagName('products');
    $nbProducts = $root->getElementsByTagName('product');
    foreach ($nbProducts as $product) {
        if ($product->getAttribute('SKU') == $sku) {
            $product->parentNode->removeChild($product);
            break;
        }
    }
    $dom->save('mirchidatabase.xml') or die('XML Create Error');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MG | Product List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Back Store/userlist.css">

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
        <a href="/Back Store/productList.php">Product List</a>
        <a href="/Back Store/userlist.php">User List</a>
        <a href="/Back Store/orderList.php">Order List</a>
    </section>

    <section id="user-list">
        <h1>Product List</h1>

        <div id="user-count"></div>
        <section id="add-product" class="container">
            <div class="row">
                <div class="col-sm">
                    <a href="addProduct.php" id="new-product">Add product</a>
                </div>
            </div>
        </section>
        <table id="user-table" class="table table-striped table-bordered table-hover"></table>
    </section>



    <script>
    var xmlDoc;

    function loadDoc() {

        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myFunction(this);
            }
        };
        xhttp.open("GET", "mirchidatabase.xml", true);
        xhttp.send();
    }

    function myFunction(xml) {
        var i;
        xmlDoc = xml.responseXML;
        var table =
            "<table><tr><th>Image</th><th>SKU</th><th>Name</th><th>Aisle</th><th>Price</th><th>Total Quanity</th><th>Units per Quantity</th><th>Description</th><th>Edit</th><th>Delete</th></tr>";

        var x = xmlDoc.getElementsByTagName("aisle");
        let length = 0;
        for (i = 0; i < x.length; i++) {
            var products = x[i].getElementsByTagName('product');
            for (count = 0; count < products.length; count++) {
                length++;
                let aisle = x[i].getAttribute('id');
                let sku = products[count].getAttribute('SKU');
                let name = products[count].getElementsByTagName('name')[0].childNodes[0].nodeValue;
                let price = products[count].getElementsByTagName('price')[0].childNodes[0].nodeValue;
                let totalquantity = products[count].getElementsByTagName('totalquantity')[0].childNodes[0].nodeValue;
                let unitsperquantity = products[count].getElementsByTagName('unitsperquantity')[0].childNodes[0].nodeValue;
                let description = products[count].getElementsByTagName('description')[0].childNodes[0].nodeValue;
                let img = products[count].getElementsByTagName('img')[0].childNodes[0].nodeValue;

                table += "<tr><td id=\"user-id\">" +
                    "<div id=\"img-container\"><img class=\"product-img\" src=\"" + img + "\"></div>" +
                    "</td><td>" +
                    sku +
                    "</td><td>" +
                    name +
                    "</td><td>" +
                    aisle +
                    "</td><td>" +
                    price +
                    "</td><td>" +
                    totalquantity +
                    "</td><td>" +
                    unitsperquantity +
                    "</td><td>" +
                    description +
                    "</td><td>" +
                    "<a href=\"EditProduct.php?sku=" + sku + "&name=" + name + "&aisle=" + aisle + "&price=" +
                    price + "&totalquantity=" + totalquantity + "&unitsperquantity=" + unitsperquantity +
                    "&description=" + description + "&img=" + img + "\">" +
                    "<button onclick='editproduct(" + "\"" + sku + "\"" + ", " + "\"" + name + "\"" + ", " + "\"" +
                    aisle + "\"" + price + "\"" + totalquantity + "\"" + unitsperquantity + "\"" +
                    description + "\")'>Edit</button></a>" + "</td><td>" +
                    "<form method=\"POST\" action=\"\">" +
                    "<input name=\"deleteProduct\" type=\"submit\" value=\"Delete\" id=\"" + sku +
                    "\" onclick=\"delProduct(" + sku + ")\"></form>" +
                    "</td></tr>";
            }




        }


        table += "</table>";
        document.getElementById("user-table").innerHTML = table;
        var userCount = "There are currently " + length + " entries";
        document.getElementById("user-count").innerHTML = userCount;

    }

       /* function logOut() {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "logOut.php", true);
        xhttp.send();
    }*/

    function delProduct(sku) {
        var x = document.getElementById(sku);
        if (x.hasAttribute("value"))
            x.setAttribute("value", sku);
    }
</script>


<footer>
        <ul>
            <li><a href="/Back Store/productlist.php">Product List</a></li>

            <li><a href="/Back Store/userlist.php">User List</a></li>

            <li><a href="/Back Store/orderList.php">Order List</a></li>
        
        </ul>

        <p class="copyright">Copyright 2021 MirchiGrocery</p>
    </footer>

</body>
</html>