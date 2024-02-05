const toggle_open = document.getElementById('toggle-open')
const toggle_closed = document.getElementById('toggle-closed')
const sidebar = document.getElementById('sidebar')
const nav = document.getElementById('sidebar-nav')
const closed_ham = document.getElementById('sidebar-closed-hamburger')
const open_ham = document.getElementById('sidebar-open-hamburger')

toggle_open.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    sidebar.style.display = "inline-block";
    nav.style.display = "flex";
    nav.style.flexDirection = "column";
    nav.style.alignItems = "space-around";
    closed_ham.style.transform = "translate(-200%)";
    closed_ham.checked = false;
  }
})

toggle_closed.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    closed_ham.style.transform = "translate(0)"
    sidebar.style.display = "none";
    nav.style.flexDirection = "row";
    open_ham.checked = false;
  }
})

window.addEventListener('resize', event => {
    closed_ham.style.transform = "translate(0)";

    if (window.innerWidth > 768){
        sidebar.style.display = "inline-block";
        closed_ham.checked = false;
        open_ham.checked = false;
        nav.style.flexDirection = "row";
    } 
    else {
        sidebar.style.display = "none";
    }
});