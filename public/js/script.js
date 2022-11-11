$('document').ready(function(){

    // memanggil function hitung cart
    recalculateCart()
    
});
    // ketika pengunjung scroll kebawah 20px dari atas dokumen, maka tampilkan tombol scroll-btn
    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            document.querySelector(".button-atas").style.display = "block";
        } else {
            document.querySelector(".button-atas").style.display = "none";
        }
    }

    const scrollToTop = () => {
        window.scroll({
            top: 0,
            behavior: "smooth",
        });
    };

    document.querySelector(".button-atas").onclick = scrollToTop;



    //cart
    /* Set rates + misc */
    var taxRate = 0.05;
    var shippingRate = 15.00; 
    var fadeTime = 300;


    /* Assign actions */
    $('.product-quantity input').change( function() {
        updateQuantity(this);
    });

    $('.product-removal button').click( function() {
        removeItem(this);
    });


    /* Recalculate cart */
    function recalculateCart()
    {
        var subtotal = 0;
        
        /* Sum up row totals */
        $('.product').each(function () {
            subtotal += parseFloat($(this).children('.product-line-price').text());
        });

               
        /* Calculate totals */
        var tax = subtotal * taxRate;
        var shipping = (subtotal > 0 ? shippingRate : 0);
        var total = subtotal + tax + shipping;
        
        /* Update totals display */
        $('.totals-value').fadeOut(fadeTime, function() {
            $('#cart-subtotal').html(rupiah(subtotal));
            $('#cart-tax').html(rupiah(tax));
            $('#cart-shipping').html(rupiah(shipping));
            $('#cart-total').html(rupiah(total));
            if(total == 0){
                $('.checkout').fadeOut(fadeTime);
            }else{
                $('.checkout').fadeIn(fadeTime);
            }
            $('.totals-value').fadeIn(fadeTime);
        });
        $('#grandTotal').val(total);

    }
    /* Fungsi formatRupiah */
    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR"
        }).format(number);
    }


    /* Update quantity */
    function updateQuantity(quantityInput)
    {
        /* Calculate line price */
        var productRow = $(quantityInput).parent().parent();
        var price = parseFloat(productRow.children('.product-price').text());
        var quantity = $(quantityInput).val();
        var linePrice = price * quantity;
        
        /* Update line price display and recalc cart totals */
        productRow.children('.product-line-price-show').each(function () {
            $(this).fadeOut(fadeTime, function() {
            $(this).text(rupiah(linePrice));
            recalculateCart();
            $(this).fadeIn(fadeTime);
            });
        });
        
        /* Update line price and recalc cart totals */
        productRow.children('.product-line-price').each(function () {
            $(this).fadeOut(fadeTime, function() {
            $(this).text(linePrice);
            recalculateCart();
            $(this).fadeIn(fadeTime);
            });
        });
    }


    /* Remove item from cart */
    function removeItem(removeButton)
    {
        /* Remove row from DOM and recalc cart total */
        var productRow = $(removeButton).parent().parent();
        productRow.slideUp(fadeTime, function() {
            productRow.remove();
            recalculateCart();
        });
    }

    // CheckOut
    $(function() {
        $('.card-input').payment('formatCardNumber');
        $('.expiry-input').payment('formatCardExpiry');
        $('.cvc-input').payment('formatCardCVC');
    
        $('.form').on('submit', function(e) {
            e.preventDefault();
        });
    });
    
    