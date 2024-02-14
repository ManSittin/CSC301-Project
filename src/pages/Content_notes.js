import React, { useEffect, useState } from 'react';
import notesContent from '../../public/notes.html'; 
//import '../../public/styles.css';
const ContentNotes = () => {
  const [notes, setNotes] = useState('');

  useEffect(() => {
    // Execute inline scripts after rendering HTML content
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.type="text/css"
    link.href = 'styles.css'; // Adjust the path to match your CSS file

    // Append the link element to the document head
    document.head.appendChild(link);

    // Execute inline scripts after rendering HTML content
    const scriptTags = document.querySelectorAll('script');
    scriptTags.forEach(script => {
      const scriptContent = script.textContent || script.innerText;
      eval(scriptContent); // Execute inline script
    });
  }, []);
  useEffect(() => { // but it doesnt lmao yok 
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

  return <div class = "root" dangerouslySetInnerHTML={{ __html: notesContent }} />;

}
export default ContentNotes;