// menu.js
function toggleMenu() {
    var x = document.getElementById("my-nav");
    if (x.className === "nav") { 
        x.className += " responsive";
    } else {
        x.className = "nav";
    }
}
// You may need to update your pages to use <nav id="my-nav" class="nav">
// and include this new script file!
