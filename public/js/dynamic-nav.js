$(function () {
    const pathname = window.location.pathname;
    const page = pathname.split('/').pop();
    const active = "active fw-bold bg-success-subtle rounded-pill"

    $(".nav-link").removeClass(active);

    if (page === "" || page === "index.php") {
        $('a.nav-link[href$="/"], a.nav-link[href$="/index.php"]').addClass(active);
    } else if (
        pathname.includes("/shop.php") ||
        pathname.includes("/user/cart.php") ||
        pathname.includes("/user/thank-page.php") ||
        pathname.includes("/product/product-page.php")
    ) {
        $('a[href$="/shop.php"]').addClass(active);
    } else if (page === "about.php") {
        $('a[href$="/about.php"]').addClass(active);
    } else if (page === "contacts.php") {
        $('a[href$="/contacts.php"]').addClass(active);
    }
});