var product = document.querySelector(".product-title").innerHTML;
var product_quantity = product + "quantity";
var total_price = product + "price";
var quantity_of_an_item = getQuantity();
var amount_added_to_cart = getAmount();
var product_price = document.getElementById("item_price").innerHTML;  /* item_price.innerHTML */
var x;

document.getElementById("quantity_of_item").value = quantity_of_an_item;
document.getElementById("total_product_price_statement").innerHTML = ("Total amount to be added to cart: " + quantity_of_an_item + " x $" + product_price + " = $" + amount_added_to_cart);

const minus_button = document.getElementById("minus_atc_button");
const plus_button = document.getElementById("plus_atc_button");
const quantity = document.getElementById("quantity_of_item");

function main() {
    minus_button.addEventListener('click', function() {
        minus();
    })
    
    plus_button.addEventListener('click', function() {
        plus();
    })

    quantity.addEventListener('change', function() {
        setQuantity();
    })

}

function getQuantity(){
    if (!sessionStorage.getItem(product_quantity)){
        return 0;
    }

    return sessionStorage.getItem(product_quantity);
}

function getAmount(){
    if (!sessionStorage.getItem(total_price)){
        return 0.00;
    }

    return sessionStorage.getItem(total_price);
}

function minus() {
    console.log("minus")
    quantity_of_an_item--;

    if (quantity_of_an_item < 0) {
        quantity_of_an_item = 0;
    }

    quantity_of_item.value = quantity_of_an_item;

    x =  (quantity_of_an_item * product_price).toFixed(2);

    total_product_price_statement.innerHTML = ("Total amount to be added to cart: " + quantity_of_an_item + " x $" + product_price + " = $" + x);
    sessionStorage.setItem(product_quantity, quantity_of_an_item);
    sessionStorage.setItem(total_price, x);
    return quantity_of_an_item;
}

function plus() {
    console.log("plus")
    quantity_of_an_item++;

    quantity_of_item.value = quantity_of_an_item;

    x =  (quantity_of_an_item * product_price).toFixed(2);

    total_product_price_statement.innerHTML = ("Total amount to be added to cart: " + quantity_of_an_item + " x $" + product_price + " = $" + x);
    sessionStorage.setItem(product_quantity, quantity_of_an_item);
    sessionStorage.setItem(total_price, x);
    return quantity_of_an_item;
}

function setQuantity(){
    quantity_of_an_item = document.getElementById("quantity_of_item").value;
    if (quantity_of_an_item < 0) {
        quantity_of_an_item = 0;
    }

    quantity_of_item.value = quantity_of_an_item;

    x =  (quantity_of_an_item * product_price).toFixed(2);

    total_product_price_statement.innerHTML = ("Total amount to be added to cart: " + quantity_of_an_item + " x $" + product_price + " = $" + x);
    sessionStorage.setItem(product_quantity, quantity_of_an_item);
    sessionStorage.setItem(total_price, x);
    return quantity_of_an_item;
}


main();