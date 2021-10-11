<?php
session_start(); 
$isSuccessful = false;

if (isset($_POST['submit'])) {
    $target_dir = "../imgs/";
    $dir_length = strlen($target_dir);
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    };
    $target_file = substr($target_file, $dir_length - 6);
    echo $target_file; 

    $dom = new DOMDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);

    $root = $dom->documentElement;
    $aisles = $root->getElementsByTagName('aisle');

    $SKU = 0;
    $product_section = $root->getElementsByTagName('products');
    $products = $product_section[0]->getElementsByTagName('product');
    foreach ($products as $checkSKU) {
        $compareSKU = intval($checkSKU->getAttribute('SKU'));
        if ($SKU < $compareSKU) {
            $SKU = $compareSKU;
        }
    };
    $SKU++;

    foreach ($aisles as $aisle) {
        if ($aisle->getAttribute('id') == $_POST['aisle']) {
            $product = $dom->createElement('product');
            $product->setAttribute('SKU', $SKU);
            $newProduct = $aisle->appendChild($product);
            $newProduct->appendChild($dom->createElement('name', $_POST['product_name']));
            $newProduct->appendChild($dom->createElement('price', $_POST['price']));
            $newProduct->appendChild($dom->createElement('totalquantity', $_POST['totalquantity']));
            $newProduct->appendChild($dom->createElement('unitsperquantity', $_POST['quantity']));
            $newProduct->appendChild($dom->createElement('description', $_POST['description']));
            $newProduct->appendChild($dom->createElement('img', $target_file));
            $dom->save('mirchidatabase.xml') or die('XML Create Error');
            break;
        };
    };

};
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirchi Grocery | Add Product</title>



    <link rel="stylesheet" href="/Back Store/editproduct.css">

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


    <div class="user_info">
        <h1>Add Product</h1>

        <form action="addProduct.php" method="POST" class="user_data" id="product_form" enctype="multipart/form-data">
            <div class="user_attribute">
                <label for="first_name" class="labels">Product Name:</label><br>
                <input type="text" id="first_name" name="product_name" placeholder="Edit product name..." class="inputs" required><br>
            </div>

            <div class="user_attribute">
                <label for="last_name" class="labels">Price:</label><br>
                <input type="text" id="last_name" name="price" placeholder="Edit price..." class="inputs" required><br>
            </div>

            <div class="user_attribute">
                <label for="aisle" class="labels">Aisle:</label><br>
                <select name="aisle">
                    <option value="FruitsAndVegetables">Fruits & Vegetables</option>
                    <option value="DairyProducts">Dairy Products</option>
                    <option value="MeatAndPoultry">Meat & Poultry</option>
                    <option value="FishAndSeafood">Fish & Seafood</option>
                    <option value="HerbsAndSpices">Herbs & Spices</option>
                    <option value="Bakery">In-store Bakery</option>
                </select><br>
            </div>
            <div class="user_attribute">
                <label for="email" class="labels">Total Quantity</label><br>
                <input type="text" id="email" name="totalquantity" placeholder="Edit total quantity..." class="inputs" required><br>
            </div>
            <div class="user_attribute">
                <label for="email" class="labels">Units/Quantity:</label><br>
                <input type="text" id="email" name="quantity" placeholder="Edit units/quantity..." class="inputs" required><br>
            </div>
            <div class="user_attribute">
                <label for="email" class="labels">Select image to upload:</label><br>
                <input type="file" name="fileToUpload" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg" required><br>
            </div>
            <div class="user_attribute">
                <label for="email" class="labels">Description:</label><br>
                <textarea name="description" rows="5" cols="50" form="product_form" required></textarea></br>
            </div>

            <input type="submit" name="submit" value="Save Edit" class="user_buttons">
        </form>

    </div>


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
