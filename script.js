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

window.addEventListener('resize', (event) => {
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
})

function handleSignInClick() {
  // Prevent the default form submission behavior
  console.log("email and input have been taken")
 // event.preventDefault();

  // Retrieve the email and password from the input fields
  var email =  document.getElementById("login").elements[1].value;
  var password =  document.getElementById("login").elements[3].value;

  // Perform validation if needed

  // Perform sign-in logic (e.g., send AJAX request to the server)
  // Here, you can use fetch() or any other method to send the data to the server
  // For demonstration purposes, we'll simply log the email and password

  console.log('Email:', email);
  console.log('Password:', password);
  var formData = new FormData();
          formData.append('command', 'connect');
          formData.append('email', document.getElementById("login").elements[1].value);
          formData.append('password', document.getElementById("login").elements[3].value);
      fetch('/server.php', {
              method: 'POST',
              body: formData,
          })
      .then(data => {
  // Handle the data returned by the server
      console.log('Response:', data);

  // Check the status field in the response
      if (data.status === 200) {
          alert('user online !');
      // User data retrieval was successful
      // You can access the user data from the 'message' field in the response
      console.log('User data:', data.message);
  } else {
      // User data retrieval failed
      console.error('Error:', data.message);
      alert('wrong user!');
  }
})
        
}

function handleSignupClick() {

window.location.href = "signup.php";


}

function submit() {
  // need to collect all data and send to db..
  
  var formData = new FormData();
  formData.append('command', 'deadlines');
  formData.append('username', 'userAA');
  console.log(document.getElementById("addDeadlineForm").elements[0].value);
  formData.append('course', document.getElementById("addDeadlineForm").elements[0].value);
  formData.append('deadline_name', document.getElementById("addDeadlineForm").elements[1].value);
  //formData.append('description', document.getElementById("addDeadlineForm").elements[2].value);
  formData.append('duedate', document.getElementById("addDeadlineForm").elements[3].value);
  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Deadline submitted.');
}

function addNote() {
  // Add logic to send the note to the server and store it in the database
  var formData = new FormData();
  formData.append('command', 'notes');
  formData.append('username', 'userAA');
  formData.append('title', document.getElementById("addNoteForm").elements[0].value);
  formData.append('content', document.getElementById("addNoteForm").elements[1].value);
  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Note added!');
}

function handleDeadlineDelete(event) {
    var id = event.target.getAttribute('id');

    fetch('server.php/deadlines/' + id, {
        method: 'DELETE'
    });

    // this is where the http req is made

    alert('Deadline successfully deleted!');
}
