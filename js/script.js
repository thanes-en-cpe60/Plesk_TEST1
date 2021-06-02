let mainNav = document.getElementById('Sidebar');
let navBartoggle = document.getElementById('js-nav');

navBartoggle.addEventListener("click", function() {
    if (document.getElementById("Sidebar").style.display == "block"){
      document.getElementById("Sidebar").style.display = "none"
    } else {
      document.getElementById("Sidebar").style.display = "block"
    }
    });