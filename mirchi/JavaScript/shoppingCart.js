document.getElementById("gst").innerHTML = (0.05 * subTotal()).toFixed(2);
document.getElementById("qst").innerHTML =  (0.09975 * subTotal()).toFixed(2);
document.getElementById("total").innerHTML = (subTotal() + qst() + gst()).toFixed(2);


function subTotal() {
    
    return document.getElementById("subtotal").value|0;
}

function total() {
    document.getElementById("total").innerHTML = (subTotal() + qst() + gst()).toFixed(2)
}

function gst() { 
    document.getElementById("gst").innerHTML = (0.05 * subTotal()).toFixed(2)
    return (0.05 * subTotal())
}

function qst() {
    document.getElementById("qst").innerHTML =  (0.09975 * subTotal()).toFixed(2)
    return (0.09975 * subTotal())
}