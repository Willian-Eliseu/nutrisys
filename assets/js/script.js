var navBar = document.getElementById('navbarControl');
window.addEventListener('scroll', function(event) {
    let teste = this.scrollY;
    if (teste > 56) {
        navBar.classList.add('fixed-top');
    } else {
        navBar.classList.remove('fixed-top');
    }
});