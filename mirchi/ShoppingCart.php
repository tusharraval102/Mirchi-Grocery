<?php
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header("refresh: 2; url=../Login/login.php");
    echo '<div style="font-size: 2rem; border-radius: 5px;  color: #79b572; height:15%; width:20%; position:fixed; top:42.5%;left: 40%; background-color:white; text-align: center; padding: 10px auto;padding-top: 30px; z-index: 10"><p id="login-success">Error: Must be logged in</p>' .
        '<img width="30px" height="30px" src="../imgs/login.gif"></div>';
}

if(isset($_POST['product_number'])){
    $dom = new DOMDocument();
    $dom->formatOutput = true;
    $dom->load('Back Store/mirchidatabase.xml', LIBXML_NOBLANKS);
    $root = $dom->documentElement;

    $users = $root->getElementsByTagName('user');
    $user = $users[intval($_POST['user_number'])];
    $cart = $user->getElementsByTagName('cart')[0];
    $product = $cart->getElementsByTagName('addedProduct')[intval($_POST['product_number'])];
    $product->childNodes[2]->childNodes[0]->nodeValue = $_POST['quantity_of_item'];
    $dom->save('Back Store/mirchidatabase.xml') or die('XML Manipulate Error');
}

if(isset($_POST['deleteProduct'])) {
    $dom = new DomDocument();
    $dom->formatOutput = true;
    $dom->load('Back Store/mirchidatabase.xml', LIBXML_NOBLANKS);
    $root = $dom->documentElement;
    $users = $root->getElementsByTagName('user');
    $user = $users[intval($_POST['user_product_delete'])];
    $cart = $user->getElementsByTagName('cart')[0];
    $products = $cart->getElementsByTagName('addedProduct');
    if($products->length >= intval($_POST['product_delete']) + 1) {
        $product = $products[intval($_POST['product_delete'])];
        $product_to_delete = $product->childNodes[0]->childNodes[0]->nodeValue;
        if ($product_to_delete == $_POST['product_name_delete']) { 
            $cart->removeChild($product); 
        }
    }
    $dom->save('Back Store/mirchidatabase.xml') or die('XML Manipulate Error');
}

if(isset($_POST['checkout'])) {
    $dom = new DomDocument();
    $dom->formatOutput = true;
    $dom->load('Back Store/mirchidatabase.xml', LIBXML_NOBLANKS);
    $root = $dom->documentElement;
    $emails = $root->getElementsByTagName('email');
    foreach($emails as $email) {
        if($email->childNodes[0]->nodeValue == $_SESSION["username"]) {
            $cart = $email->parentNode->childNodes[10];
            if($cart->hasChildNodes()) {

                $orders = $root->getElementsByTagName('orders');
                $order = $dom->createElement('order');
                $newOrder = $orders[0]->appendChild($order);
                $orderEmail = $dom->createElement('orderProductEmail', $_SESSION['username']);
                $newOrder->appendChild($orderEmail);
                $orderList = $root->getElementsByTagName('order');
                if($orderList->length == 1) {
                    $newOrder->setAttribute('id', 1);
                }
                else {
                    $id = $orderList[$orderList->length - 2]->getAttribute('id');
                    $newOrder->setAttribute('id', intval($id) + 1);
                }

                $emails = $root->getElementsByTagName('email');
                foreach($emails as $email) {
                    if($email->childNodes[0]->nodeValue == $_SESSION["username"]) {
                        echo $email->childNodes[0]->nodeValue;
                        $cart = $email->parentNode->childNodes[10];
                        $products = $cart->getElementsByTagName('addedProduct');
                        foreach($products as $product) {
                            $orderProduct = $dom->createElement('orderProduct');
                            $newOrderProduct = $newOrder->appendChild($orderProduct);

                            $name = $product->childNodes[0]->childNodes[0]->nodeValue;
                            $productName = $dom->createElement('orderProductName', $name);
                            $newOrderProduct->appendChild($productName);

                            $quantity = $product->childNodes[2]->childNodes[0]->nodeValue;
                            $productQuantity = $dom->createElement('orderProductQuantity', $quantity);
                            $newOrderProduct->appendChild($productQuantity);

                            $price = $product->childNodes[1]->childNodes[0]->nodeValue;
                            $productPrice = $dom->createElement('orderProductPrice', $price);
                            $newOrderProduct->appendChild($productPrice);
                        }
                        while($cart->hasChildNodes()) {
                            $cart->removeChild($cart->firstChild);
                        }
                        break;
                    }
                }
                $dom->save('Back Store/mirchidatabase.xml') or die('XML Manipulate Error');
                header("Location: index.php");
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MG | Shopping Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="/styles/homepage.css">
    <link rel="stylesheet" href="/styles/shoppingCart.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">
</head>

<body onload="loadDoc()">
    <header>
        <a href="/index.php"><img src="/imgs/Mirchi_Logo_oval_B.png" alt="Mirchi"></a>


        <nav id="nav-bar">
            <a href="../index.php" class="nav-item">Home</a>

            <a href="../ShoppingCart.php" class="nav-item">Shopping Cart</a>
            <span class="nav-item">
                <?php
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "<a href=\"/Login/login.php\" class=\"nav-item\">Log in</a>";
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

    <div class="container">
        <a class="back-button" id="back-button" type="button" href="/index.php">Back to Shopping</a>
        <div class="row">
            <div class="col-md-8">
                <div class="row" id="shippingAndbilling">
                    <div class="col-md-4">
                        <form action="">
                            <h4>Shipping Address</h4>
                            <label for="name">Surname: </label>
                            <br>
                            <input type="text" name="shippingAddress" id="surname" placeholder="John">
                            <br>
                            <label for="name">Name: </label>
                            <br>
                            <input type="text" name="shippingAddress" id="name" placeholder="Washington">
                            <br>
                            <label for="address">Address: </label>
                            <br>
                            <input type="text" name="address" id="address" placeholder="1455 Boulevard de Maisonneuve"
                                size="28">
                            <br>
                            <label for="country">Country: </label>
                            <br>
                            <input type="text" name="country" id="country" placeholder="Argentina">
                            <br>
                            <label for="phone">Phone: </label>
                            <br>
                            <input type="text" name="phone" id="phone" placeholder="514-673-5746">
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form action="">
                            <h4>Billing Address</h4>
                            <label for="name">Surname: </label>
                            <br>
                            <input type="text" name="shippingAddress" id="surname" placeholder="John">
                            <br>
                            <label for="name">Name: </label>
                            <br>
                            <input type="text" name="shippingAddress" id="name" placeholder="Washington">
                            <br>
                            <label for="address">Address: </label>
                            <br>
                            <input type="text" name="address" id="address" placeholder="1455 Boulevard de Maisonneuve"
                                size="28">
                            <br>
                            <label for="country">Country: </label>
                            <br>
                            <input type="text" name="country" id="country" placeholder="Argentina">
                            <br>
                            <label for="phone">Phone: </label>
                            <br>
                            <input type="text" name="phone" id="phone" placeholder="514-673-5746">
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form action="">
                            <h4>Credit Card Information</h4>
                            <label for="name">Name: </label>
                            <br>
                            <input type="text" name="cardname" id="cname">
                            <br>
                            <label for="address">Card Number: </label>
                            <br>
                            <input type="text" name="cardnumber" id="ccnum">
                            <br>
                            <label for="country">CVV: </label>
                            <br>
                            <input type="text" name="cvv" id="cvv">
                            <br>
                            <label for="expiry">Expiry: </label>
                            <br>
                            <input type="text" name="expiry" id="exp" placeholder="mm/yy">
                        </form>
                    </div>
                </div>

                <div class="row" id="cart-items">
                </div>
            </div>

            <div class="col-md-4">
                <div id="border-receipt">
                    <div class="row receipt-elements">
                        <div class="col-md">
                            <h4>Order Summary</h4>
                        </div>
                    </div>

                    <div class="row receipt-elements">
                        <p class="name-product-price">Shipping & Handling:</p>
                        <p class="price-charge">free</p>
                    </div>
                    <div class="row seperating-bar">
                        <p class="price-charge">_________________________</p>
                    </div>
                    <div class="row receipt-elements">
                        <p class="name-product-price">Total before tax ($):</p>
                        <p class="price-charge" id="subtotal"></p>
                    </div>
                    <div class="row receipt-elements">
                        <p class="name-product-price">QST($):</p>
                        <p class="price-charge" id="qst"></p>
                    </div>
                    <div class="row receipt-elements">
                        <p class="name-product-price">GST($):</p>
                        <p class="price-charge" id="gst"></p>
                    </div>
                    <div class="row seperating-bar">
                        <p class="price-charge">_________________________</p>
                    </div>
                    <div class="row order-total">
                        <p class="name-product-price">Order Total:</p>
                        <p class="price-charge" id="total"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <input type="submit" name="checkout" id="checkout" class="btn btn-outline-secondary" value="Checkout and Pay">
                            </form>
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


    <script>
    var xmlDoc;
    var session = eval('(<?php echo json_encode($_SESSION) ?>)');
    var subTotal = 0;
    console.log(session.loggedIn);
    console.log(session.username);

    function loadDoc() {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myFunction(this);
            }
        };
        xhttp.open("GET", "/Back Store/mirchidatabase.xml", true);
        xhttp.send();
    }

    function myFunction(xml) {
        var i;
        xmlDoc = xml.responseXML;
        var cartItem =
            "<table><thead><tr><th></th> <th>Product</th><th>Quantity</th><th>Price</th><th>Delete</th></tr></thead>";
        var x = xmlDoc.getElementsByTagName("email");
        for (i = 0; i < x.length; i++) {
            if (x[i].childNodes[0].nodeValue == session.username) {
                var cart = x[i].parentNode.getElementsByTagName('cart')[0];
                var products = cart.getElementsByTagName('addedProduct');
                for (count = 0; count < products.length; count++) {
                    let name = products[count].getElementsByTagName('addedProduct_name')[0].childNodes[0].nodeValue;
                    let price = products[count].getElementsByTagName('addedProduct_price')[0].childNodes[0].nodeValue;
                    let cartQuantity = products[count].getElementsByTagName('addedproduct_quantity')[0].childNodes[0]
                        .nodeValue;
                    let img = products[count].getElementsByTagName('addedproduct_img')[0].childNodes[0].nodeValue;
                    
                    quantityTotal = price * cartQuantity;
                    subTotal += quantityTotal;

                    cartItem += "<tr><td class=\"cart-img\"><img src=\"" + img + "\" width=50%></td><td>" + name +
                        "</td><td><form action=\"\" method=\"POST\"><input type=\"number\" name=\"quantity_of_item\" id=\"quantity_of_item\" min=\"1\" value=\"" +
                        cartQuantity +
                        "\" style=\"width:60px;\"><input type=\"hidden\" name=\"product_number\" value=\"" + count +
                        "\"><input type=\"hidden\" name=\"user_number\" value=\"" + i +
                        "\"><input type=\"submit\" name=\"update_quantity\" value=\"Update\"></form></td><td>$ <span class=\"item_price\">" +
                        quantityTotal.toFixed(2) +
                        "</span></td><td><form action=\"\" method=\"POST\"><input type=\"hidden\" name=\"product_delete\" value=\"" +
                        count +
                        "\"><input type=\"hidden\" name=\"user_product_delete\" value=\"" +
                        i +
                        "\"><input type=\"hidden\" name=\"product_name_delete\" value=\"" +
                        name +
                        "\"><input type=\"submit\" name=\"deleteProduct\" value=\"x\" class=\"btn btn-outline-secondary\"></form></td></tr>"
                }
            }
        }
        cartItem += "<t/body></table>"
        document.getElementById("cart-items").innerHTML = cartItem;
        document.getElementById("subtotal").innerHTML = parseFloat(subTotal.toFixed(2));
        totalCart();
    }
    
    function totalCart(){
        document.getElementById("total").innerHTML = total();
    }

    function total() {
        return (subTotal + qst() + gst()).toFixed(2);
    }

    function gst() {
        document.getElementById("gst").innerHTML = (0.05 * subTotal).toFixed(2); 
        return (0.05 * subTotal);
    }

    function qst() {
        document.getElementById("qst").innerHTML = (0.09975 * subTotal).toFixed(2);
        return (0.09975 * subTotal);
    }

    function delProduct(sku) {
        var x = document.getElementById(sku);
        if (x.hasAttribute("value"))
            x.setAttribute("value", sku);
    }
    
    </script>

   
    </body>

    
    </html>