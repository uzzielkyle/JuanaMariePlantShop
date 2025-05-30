$(function () {
    const pathname = window.location.pathname;
    const page = pathname.split('/').pop();
    const active = "active fw-bold bg-success-subtle rounded-pill";

    // Target nav-links only inside #mainHeader
    const navbar = $('#mainHeader');
    navbar.find(".nav-link").removeClass(active);

    if (page === "" || page === "index.php") {
        navbar.find('a.nav-link[href$="/"], a.nav-link[href$="/index.php"]').addClass(active);
    } else if (
        pathname.includes("/shop.php") ||
        pathname.includes("/user/cart.php") ||
        pathname.includes("/user/thank-page.php") ||
        pathname.includes("/product/product-page.php")
    ) {
        navbar.find('a[href$="/shop.php"]').addClass(active);
    } else if (page === "about.php") {
        navbar.find('a[href$="/about.php"]').addClass(active);
    } else if (page === "contacts.php") {
        navbar.find('a[href$="/contacts.php"]').addClass(active);
    }
});
