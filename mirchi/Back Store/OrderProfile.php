<?php
session_start();

if(isset($_POST['orderSave'])) {
    $dom = new DomDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);
    $root = $dom->documentElement;

    $orders = $root->getElementsByTagName('order');
    foreach($orders as $order) {
        if($order->getAttribute('id') == $_POST['changeID']) {
            $orderProducts = $order->getElementsByTagName('orderProduct');
            $number = 0;
            foreach($orderProducts as $orderProduct) {
                $product_name = $orderProduct->childNodes[0]->childNodes[0]->nodeValue;
                $orderProduct->childNodes[1]->childNodes[0]->nodeValue = $_POST[$product_name . $number];
                $number++;
            }
            break;
        }
    }
    $dom->save('mirchidatabase.xml') or die('XML Create Error');
    header("Location: orderList.php");
}

if(isset($_POST['edit'])) {
    $dom = new DomDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);
    $root = $dom->documentElement;

    $orders = $root->getElementsByTagName('order');
    foreach($orders as $order) {
        if($order->getAttribute('id') == $_POST['orderID']) {
            $userOrder = $order;
            $orderEmail = $order->childNodes[0]->childNodes[0]->nodeValue;
            break;
        }
    }

    $emails = $root->getElementsByTagName('email');
    foreach($emails as $email) {
        if($email->childNodes[0]->nodeValue == $orderEmail) {
            $user = $email->parentNode;
            $userID = $user->getAttribute('id');
            $first_name = $user->childNodes[0]->childNodes[0]->nodeValue;
            $last_name = $user->childNodes[1]->childNodes[0]->nodeValue;
            $address = $user->childNodes[5]->childNodes[0]->nodeValue;
            $city = $user->childNodes[6]->childNodes[0]->nodeValue;
            $postalcode = $user->childNodes[7]->childNodes[0]->nodeValue;
            $province = $user->childNodes[8]->childNodes[0]->nodeValue;
            $phone = $user->childNodes[9]->childNodes[0]->nodeValue;
            $fullAddress = $address . ", " . $city . ", " . $province . ", " . $postalcode;
            break;
        }
        else {
            $user = "User has been deleted";
            $userID = "User has been deleted";
            $first_name = "User has been deleted";
            $last_name = "User has been deleted";
            $fullAddress = "User has been deleted";
            $phone = "User has been deleted";
        }
    }
    $addedProducts = $userOrder->getElementsByTagName('orderProduct');

    $counting = 0;
}



?>


 <!DOCTYPE html>
 <html lang="en">

 <head>

     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>MG | Profile</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

     <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="//fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="/Back Store/OrderProfile.css">

    

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
        <a href="/Back Store/productList.php">Product List</a>
        <a href="/Back Store/userlist.php">User List</a>
        <a href="/Back Store/orderList.php">Order List</a>
    </section>



     <section id="order">
         <h1>Edit Order ID #<?php echo $_POST['orderID']; ?></h1>

         
         <h4>Customer Information</h4>
         <div id="customer-info">
            <div id="user-id" class="field">
             <span class="title">User ID: </span>
             <span class="data"><?php echo $userID;?></span>
            </div>  
            <div id="first-name" class="field">
             <span class="title">First Name: </span>
             <span class="data"><?php echo $first_name;?></span> 
            </div> 
            <div id="last-name" class="field">
             <span class="title">Last Name: </span>
             <span class="data"><?php echo $last_name;?></span>
            </div> 
            <div id="email" class="field">
             <span class="title"> Email:</span>
             <span class="data"><?php echo $orderEmail;?></span>
            </div> 
            <div id="address" class="field">
             <span class="title">Address: </span>
             <span class="data"><?php echo $fullAddress;?></span>
            </div> 
            <div id="phone" class="field">
             <span class="title"> Phone:</span>
             <span class="data"><?php echo $phone;?></span>
            </div> 
         </div>
           

         <h4>Order Products</h4>
         <form action="" method="post">
            <table id="product-table" class="table table-striped table-bordered table-hover">
                <thead><tr><th scope="col">Product Name</th><th scope="col">Quantity</th><th scope="col">Price per Quantity</th></tr></thead>
                <tbody>
                    <?php
                    foreach($addedProducts as $addedProduct) {
                        echo "<tr><td>" . $addedProduct->childNodes[0]->childNodes[0]->nodeValue . "</td><td><input type='number' name='" . $addedProduct->childNodes[0]->childNodes[0]->nodeValue . $counting++ . "' min='0' value='" . $addedProduct->childNodes[1]->childNodes[0]->nodeValue . "'></td><td>" . $addedProduct->childNodes[2]->childNodes[0]->nodeValue . "</td></tr>";
                    }
                    
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="changeID" value="<?php echo $_POST['orderID']?>">
            <input type="submit" name="orderSave" value="Save Changes">
        </form>
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
         var table =  "<table><tr><th>ID</th><th>SKU</th><th>Aisle</th><th>Product Name</th><th>units per quantity</th><th>quantity</th><th>total cost</th><th>delete</th></tr>";

         var x = xmlDoc.getElementsByTagName("order");
            for (i = 0; i < x.length; i++) {
                let id = x[i].getAttribute('id');
                
                
                table += "<tr><td id=\"sku\">" +
                    x[i].getAttribute('id') +
                    "</td><td>" +
                    x[i].getElementsByTagName("first_name")[0].childNodes[0].nodeValue +
                    "</td><td>" +
                    x[i].getElementsByTagName("last_name")[0].childNodes[0].nodeValue +
                    "</td><td>" +
                    x[i].getElementsByTagName("email")[0].childNodes[0].nodeValue +
                    "</td><td>" +
                    x[i].getElementsByTagName("address")[0].childNodes[0].nodeValue + ", " +
                    x[i].getElementsByTagName("city")[0].childNodes[0].nodeValue + ", " +
                    x[i].getElementsByTagName("province")[0].childNodes[0].nodeValue + ", " +
                    x[i].getElementsByTagName("postalcode")[0].childNodes[0].nodeValue +
                    "</td><td>" +
                    "<button class=\"atc_button\" type=\"button\" id=\"minus_atc_button\">-</button>" +
                                        
                                        "<button class=\"atc_button\" type=\"button\" id=\"plus_atc_button\">+"
                                        +"</button>"+ "<span id=\"quantity_of_item\">3</span></td>"+
                    
                    
                    
                    
                      "<td>price here</td>" +
                    "</td><td>" +
                    
                    "<form method=\"POST\" action=\"\">" +
                    "<input name=\"deleteUser\" type=\"submit\" value=\"Delete\" id=\"" + id + "\" onclick=\"delUser(" + id + ")\" ></form>" +
                    "</td></tr>";
            }

            table += "</table>";
            document.getElementById("product-table").innerHTML = table;
            
        }


     function delProduct(sku) {
             var x = document.getElementById(sku);
             if (x.hasAttribute("value"))
                 x.setAttribute("value", sku);
         
     }
</script>


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