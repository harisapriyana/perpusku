$('document').ready(function(){
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

})
