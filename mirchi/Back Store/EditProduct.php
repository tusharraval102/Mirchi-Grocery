<?php
session_start();

if (isset($_REQUEST['sku'])) {
    $_SESSION['sku'] = $_REQUEST['sku'];
}
$target_file = "";
if (isset($_POST['submit'])) {
    if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
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
        }
        $target_file = substr($target_file, $dir_length - 6);
    }

    $dom = new DOMDocument();
    $dom->formatOutput = true;
    $dom->load('mirchidatabase.xml', LIBXML_NOBLANKS);

    $root = $dom->documentElement;
    $products = $root->getElementsByTagName('product');
    foreach ($products as $product) {
        if ($product->getAttribute('SKU') == $_SESSION['sku']) {
            $product->childNodes[0]->childNodes[0]->nodeValue = $_POST['name'];
            $product->childNodes[1]->childNodes[0]->nodeValue = $_POST['price'];
            $product->childNodes[2]->childNodes[0]->nodeValue = $_POST['totalquantity'];
            $product->childNodes[3]->childNodes[0]->nodeValue = $_POST['unitsperquantity'];
            $product->childNodes[4]->childNodes[0]->nodeValue = $_POST['description'];
            if ($target_file != "") {
                $product->childNodes[5]->childNodes[0]->nodeValue = $target_file;
            } else {
                $product->childNodes[5]->childNodes[0]->nodeValue = $_REQUEST['img'];
            }
            $dom->save('mirchidatabase.xml') or die('XML Create Error');
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MG | Edit Product</title>



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
        <h1>Edit Product</h1>

        <form action="" method="POST" class="user_data" id="product_form" enctype="multipart/form-data">
            <div class="user_attribute">
                <label for="name" class="labels">Product Name:</label><br>
                <input type="text" id="name" name="name" value="<?php echo $_REQUEST['name']; ?>" class="inputs" required><br>
            </div>

            <div class="user_attribute">
                <label for="price" class="labels">Price:</label><br>
                <input type="text" id="price" name="price" value="<?php echo $_REQUEST['price']; ?>" class="inputs" required><br>
            </div>
            <div class="user_attribute">
                <label for="totalquantity" class="labels">Total Quantity</label><br>
                <input type="text" id="totalquantity" name="totalquantity" value="<?php echo $_REQUEST['totalquantity']; ?>" class="inputs" required><br>
            </div>
            <div class="user_attribute">
                <label for="unitsperquantity" class="labels">Units/Quantity:</label><br>
                <input type="text" id="unitsperquantity" name="unitsperquantity" value="<?php echo $_REQUEST['unitsperquantity']; ?>" class="inputs" required><br>
            </div>
             <div class="user_attribute">
                <label for="fileToUpload" class="labels">Select image to upload:</label><br>
                <input type="file" name="fileToUpload" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg"><br>
            </div>
            <div class="user_attribute">
                <label for="description" class="labels">Description:</label><br>
                <textarea name="description" rows="5" cols="50"><?php echo $_REQUEST['description']; ?></textarea></br>
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