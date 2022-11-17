$('document').ready(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    //   let mobileNav = document.getElementById("mobile-nav-toggle");
    //   mobileNav.addEventListener("click", function(e) {
          
    //       alert(diklik);
    //   });

    // memanggil function hitung cart
    recalculateCart()
    
    // ketika pengunjung scroll kebawah 20px dari atas dokumen, maka tampilkan tombol scroll-btn
    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            document.querySelector(".button-atas").classList.add('active');
        } else {
            document.querySelector(".button-atas").classList.remove('active');
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
    var taxRate = 0.11;
    var shippingRate = 20000; 
    var fadeTime = 300;
    
    
    /* Assign actions */
    $('.product-quantity input').change( function() {
        updateQuantity(this);
    });

    $('.product-removal button').click( function() {
        const conf = confirm('Are You Sure?');
        if(conf) { 
            removeItem(this);
        }
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

        const id = $(quantityInput).data('id');
        const tempQty = $(quantityInput).val();
        $('#qty').val(tempQty);
        const newQuantity = $('#qty').val(); 
        // console.log(newQuantity);
        $.ajax({
            url: '/cart/' + id + '/edit',
            data: {quantity : newQuantity},
            method: 'put',
            dataType: 'json',
            success: function(response){
                console.log(response);
                recalculateCart();
            }
        });
    }

    
    /* Remove item from cart */
    function removeItem(removeButton)
    {
        /* Remove row from DOM and recalc cart total */
        var productRow = $(removeButton).parent().parent();
        productRow.slideUp(fadeTime, function() {
            // productRow.remove();
            
            const id =$(removeButton).data('id');
            // console.log(id);
            $.ajax({
                method: 'DELETE',
                url: '/cart/' + id,
                // data: data,
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    //   $('.errors-message').html('');
                    //   $('.errors-message').addClass('d-none');
                    //   $('.success-message').html('');
                    //   $('.success-message').addClass('alert alert-success');
                    //   $('.success-message').removeClass('d-none');
                    //   $('.success-message').text(response.message);
                    //   $('#deleteModal').find('input').val('');
                    //   $('#deleteModal').modal('hide');
                    //   fetchProducts();
                    recalculateCart();
                }
            });
        });
    }
    
    // CheckOut
    // $(function() {
        //     $('.card-input').payment('formatCardNumber');
        //     $('.expiry-input').payment('formatCardExpiry');
        //     $('.cvc-input').payment('formatCardCVC');
        
        //     $('.form').on('submit', function(e) {
            //         e.preventDefault();
            //     });
            // });
            const payButton = document.querySelector('#pay-button');
            payButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                const snapToken = document.querySelector('#snapToken').value;
                // console.log(snapToken);
                snap.pay(snapToken, {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        $('.alert-success').html('Thank you for your payment, your order on the process');
                        $('.alert-success').removeClass('d-none');
                        $('.alert-warning').addClass('d-none');
                        $('.alert-danger').addClass('d-none');
                    $('#pay-button').addClass('d-none');
                    // console.log(result)
                    // alert(JSON.stringify(result));
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.querySelector('.alert-error').innerHTML += JSON.stringify(result, null, 2);
                    // document.querySelector('.alert-error').classList.remove('d-none');
                    $('.alert-warning').html('Your transaction is waiting for payment');
                    $('.alert-warning').removeClass('d-none');
                    $('.alert-danger').addClass('d-none');
                    // alert(JSON.stringify(result));
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    $('.alert-danger').html('We got an error for your payment');
                    $('.alert-danger').removeClass('d-none');
                    // alert(JSON.stringify(result));
                }
            });
        });
        

        
        // Costumer side menu
        
            // "use strict";
            /**
             * Easy selector helper function
             */
        //     const select = (el, all = false) => {
        //         el = el.trim()
        //         if (all) {
        //             return [...document.querySelectorAll(el)]
        //         } else {
        //             return document.querySelector(el)
        //         }
        //     }
            
        //     /**
        //      * Easy event listener function
        //      */
        //     const on = (type, el, listener, all = false) => {
        //         let selectEl = select(el, all)
        //         if (selectEl) {
        //             if (all) {
        //                 selectEl.forEach(e => e.addEventListener(type, listener))
        //             } else {
        //                 selectEl.addEventListener(type, listener)
        //             }
        //         }
        //     }
            
        //     /**
        //      * Easy on scroll event listener 
        //  */
        // const onscroll = (el, listener) => {
        //     el.addEventListener('scroll', listener)
        // }
        
        /**
         * Navbar links active state on scroll
         */
        let navbarlinks = $('#navbar .scrollto')
        const navbarlinksActive = () => {
            let position = window.scrollY + 200
            navbarlinks.forEach(navbarlink => {
                if (!navbarlink.hash) return
                let section = $(navbarlink.hash)
                if (!section) return
                if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                    navbarlink.classList.add('active')
                } else {
                    navbarlink.classList.remove('active')
            }
        })
    }
    window.addEventListener('load', navbarlinksActive)
    onscroll(document, navbarlinksActive)
    
    /**
     * Scrolls to an element with header offset
     */
    const scrollto = (el) => {
        let elementPos = $(el).offsetTop
        window.scrollTo({
            top: elementPos,
            behavior: 'smooth'
        })
    }
    
    /**
     * Mobile nav toggle
     */
    $(window).on("resize", function() {
        if ($(window).width() < 846) {
            $('.mobile-nav-toggle').toggleClass('d-none')
            $(body).on('click', '.mobile-nav-toggle', function() {
                
                $('document').toggleClass('mobile-nav-active')
                this.toggleClass('bi-list')
                this.toggleClass('bi-x')
                console.log('diklik');
            })
        }
      });
    
    // $('document').click('#mobile-nav-toggle', function(){
    //     // e.preventDefault();
    //     console.log('diklik');
    // });
    
    /**
     * Scrool with ofset on links with a class name .scrollto
     */
    on('click', '.scrollto', function(e) {
        if (select(this.hash)) {
            e.preventDefault()
            
            let body = select('body')
            if (body.classList.contains('mobile-nav-active')) {
                body.classList.remove('mobile-nav-active')
                let navbarToggle = select('.mobile-nav-toggle')
                navbarToggle.classList.toggle('bi-list')
                navbarToggle.classList.toggle('bi-x')
            }
            scrollto(this.hash)
        }
    }, true)
    
    /**
     * Scroll with ofset on page load with hash links in the url
     */
    window.addEventListener('load', () => {
        if (window.location.hash) {
            if (select(window.location.hash)) {
                scrollto(window.location.hash)
            }
        }
    });


    // coba yang lain
    var toggle = document.getElementById("menu-toggle");
  var menu = document.getElementById("menu");
  var close = document.getElementById("menu-close");
  

  toggle.addEventListener("click", function(e) {
    if (menu.classList.contains("open")) {
      menu.classList.remove("open");
    } else {
      menu.classList.add("open");
    }
    alert('diklik');
  });

  close.addEventListener("click", function(e) {
    menu.classList.remove("open");
  });

  // Close menu after click on smaller screens
  $(window).on("resize", function() {
    if ($(window).width() < 846) {
      $(".main-menu a").on("click", function() {
        menu.classList.remove("open");
      });
    }
  });
    

});