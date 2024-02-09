import React, { useEffect } from 'react';
import './Home.css'; // Import your CSS file
import { Outlet, Link } from "react-router-dom";
const Home = () => {

  useEffect(() => {
    const toggle_open = document.getElementById('toggle-open');
    const toggle_closed = document.getElementById('toggle-closed');
    const sidebar = document.getElementById('sidebar');
    const nav = document.getElementById('sidebar-nav');
    const closed_ham = document.getElementById('sidebar-closed-hamburger');
    const open_ham = document.getElementById('sidebar-open-hamburger');

    const handleToggleOpenChange = (event) => {
      if (event.currentTarget.checked) {
        sidebar.style.display = 'inline-block';
        nav.style.display = 'flex';
        nav.style.flexDirection = 'column';
        nav.style.alignItems = 'space-around';
        closed_ham.style.transform = 'translate(-200%)';
        closed_ham.checked = false;
      }
    };

    const handleToggleClosedChange = (event) => {
      if (event.currentTarget.checked) {
        closed_ham.style.transform = 'translate(0)';
        sidebar.style.display = 'none';
        nav.style.flexDirection = 'row';
        open_ham.checked = false;
      }
    };

    const handleResize = () => {
      if (window.innerWidth > 768) {
        sidebar.style.display = 'inline-block';
        closed_ham.checked = false;
        open_ham.checked = false;
        nav.style.flexDirection = 'row';
        closed_ham.style.transform = 'translate(0)';
      } else {
        sidebar.style.display = 'none';
      }
    };

    toggle_open.addEventListener('change', handleToggleOpenChange);
    toggle_closed.addEventListener('change', handleToggleClosedChange);
    window.addEventListener('resize', handleResize);

    // Cleanup event listeners on component unmount
    return () => {
      toggle_open.removeEventListener('change', handleToggleOpenChange);
      toggle_closed.removeEventListener('change', handleToggleClosedChange);
      window.removeEventListener('resize', handleResize);
    };
  }, []);




  return( <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet' />
    <title>CourseBind</title>
  </head>
  <body>
    <div id="sidebar">
      <div className="nav" id="sidebar-nav">
        <label className="non-desktop hamburger-menu" id="sidebar-open-hamburger">
          <input type="checkbox" id="toggle-closed" />
        </label>
        <a>profile</a>
        <a>settings</a>
      </div>
    </div>
    <div className="not-sidebar">
      <div className="nav" id="pages-nav">
        <label className="non-desktop hamburger-menu" id="sidebar-closed-hamburger">
          <input type="checkbox" id="toggle-open" />
        </label>
        <a>notes</a>
        <a>flashcards</a>
        <a>assignments</a>
        <a>schedule</a>
      </div>
      <div className="main">
        <h1>
          Welcome to CourseBind! Use the links at the top of the page to access each of our core features :&rpar; 
          The page will adapt dynamically to your chosen feature!
        </h1>

        <li id="login">
                <Link to="/Signinup">Login</Link>
              </li>
      </div>
    </div>
  </body>
</html>)
};
// oh i changed the css sorry let me put the sameyou have nah let me do it 
export default Home;
