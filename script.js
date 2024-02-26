const toggle_open = document.getElementById('toggle-open')
const toggle_closed = document.getElementById('toggle-closed')
const sidebar = document.getElementById('sidebar')
const nav = document.getElementById('sidebar-nav')
const closed_ham = document.getElementById('sidebar-closed-hamburger')
const open_ham = document.getElementById('sidebar-open-hamburger')
const secretKey = "1Q2W3E4RT5YFDSAQ";




function encryptMessage(key, message) {
  let encryptedMessage = '';
  for (let i = 0; i < message.length; i++) {
      // XOR operation with key character
      encryptedMessage += String.fromCharCode(message.charCodeAt(i) ^ key.charCodeAt(i % key.length));
  }
  return encryptedMessage;
}
// Decryption function


// Example usage: Generate a secret key of length 16


var isUserOnline = sessionStorage.getItem('isUserOnline'); // check the user being onlien
var onlineUsers = sessionStorage.getItem('onlineUsers');

console.log(isUserOnline, onlineUsers)

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
  var passi = encryptMessage(document.getElementById("login").elements[3].value, secretKey);
          formData.append('command', 'connect');
          formData.append('email', document.getElementById("login").elements[1].value);
          formData.append('password', passi);
      fetch('/server.php', {
              method: 'POST',
              body: formData,
          })
          .then(response => {
            if (!response.ok) {
              console.error('Error:');
              alert('wrong user!');
              throw new Error('Network response was not ok');
            }
            // Handle the response object
            return response.json(); // This returns a promise
          })
      .then(data => {
      // Handle the data returned by the server
      console.log('Response:', data.message);

  // Check the status field in the response
          alert('user online !');
          sessionStorage.setItem('isUserOnline', 'true');
          const message = data.message;

// Extract the username from the response
         onlineUsers = message;
        sessionStorage.setItem('onlineUsers', onlineUsers);
          isUserOnline = sessionStorage.getItem('isUserOnline');
     
      console.log('User data:', data.message);
      location.reload();
      
})

}





function handleSignUpClick() {
  // Prevent the default form submission behavior
  console.log(document.getElementById("signup").elements)
 // event.preventDefault();

  // Retrieve the email and password from the input fields
  var firstname = document.getElementById("firstName").value;
  var lastname = document.getElementById("lastName").value;
  var email =  document.getElementById("email").value;
  var username =  document.getElementById("username").value;
  var password =  document.getElementById("password").value;
  
  // Perform validation if needed
  var passi = encryptMessage(password, secretKey);
  // Perform sign-in logic (e.g., send AJAX request to the server)
  // Here, you can use fetch() or any other method to send the data to the server
  // For demonstration purposes, we'll simply log the email and password
  var formData = new FormData();
          formData.append('command', 'users');
          formData.append('first_name', document.getElementById("firstName").value);
          formData.append('last_name', document.getElementById("lastName").value);
          formData.append('email', document.getElementById("email").value);
          formData.append('username', document.getElementById("username").value);
          formData.append('password', passi);

      fetch('/server.php', {
              method: 'POST',
              body: formData,
          })
      .then(data => {
  // Handle the data returned by the server
      console.log('Response:', data);

  // Check the status field in the response
      if (data.status ===  200) {
          alert('user online !');
      // User data retrieval was successful
      // You can access the user data from the 'message' field in the response
      console.log('User data:', data.message);
  } else {
      // User data retrieval failed
      console.error('Error:', data.message);
  }
})
  
        
}

function handleSignupClick() {

window.location.href = "signup.php";


}


function handlelogout() {
  var formData = new FormData();
  formData.append('command', 'logout');

fetch('/server.php', {
      method: 'POST',
      body: formData,
  }).then(response => {
    sessionStorage.setItem('isUserOnline', 'false');
    sessionStorage.setItem('onlineUsers', 'false');
    location.reload();
    location.reload();
  })
  
}

function addDeadline() { // insert a deadline
  // need to collect all data and send to db..
  console.log(onlineUsers)
  var formData = new FormData();
  formData.append('command', 'deadlines');
  formData.append('username',onlineUsers);
  formData.append('course', document.getElementById("addDeadlineForm").elements[0].value);
  formData.append('deadline_name', document.getElementById("addDeadlineForm").elements[1].value);
  formData.append('duedate', document.getElementById("addDeadlineForm").elements[2].value);
  
  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Deadline submitted.');
}

function addNote() { // insert a note
  // Add logic to send the note to the server and store it in the database
  var formData = new FormData();
  formData.append('command', 'notes');
  formData.append('username', onlineUsers);
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

function handleNoteDelete(event) {
    var id = event.target.getAttribute('id');

    fetch('server.php/notes/' + id, {
        method: 'DELETE'
    });

    // this is where the http req is made

    alert('Note successfully deleted!');
}

function addFlashcard() { // insert a flashcard
  // Add logic to send the note to the server and store it in the database
  var formData = new FormData();
  formData.append('command', 'flashcards');
  formData.append('username', onlineUsers);
  formData.append('cue', document.getElementById("addFlashcardForm").elements[0].value);
  formData.append('response', document.getElementById("addFlashcardForm").elements[1].value);
  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Flashcard added!');
}

// DEADLINE UPDATES

// Front-end note view elements
const course = document.querySelector('.deadline_course');
const deadline_name = document.querySelector('.deadline_name');
const date = document.querySelector('.deadline_date');
const updateDeadlineBtn = document.querySelector('.update-deadline');

// deadline data 
function getDeadlines() { // get all the user's deadlines as (id, course, deadline_name, due_date) objects
  return fetch(`/server.php?command=deadlines&username=${encodeURIComponent(onlineUsers)}`)
    .then(response => response.json())
    .then(json => {
      return json.message.map(entry => {
        return {
          id: entry.id,
          course: entry.course,
          deadline_name: entry.deadline_name,
          due_date: entry.due_date
        };
      });
    })
    .catch(error => {
      console.error('Error fetching deadlines:', error);
      throw error;
    });
}

// given a deadline id, load its information from the DB, returning an object with (course, deadline_name, due_date) attributes
async function getDeadline($deadlineID){
  try {
    const notes = await getDeadlines();
    const note = notes.find(note => note.id == $deadlineID);
    return note || null;
  } catch (error) {
    console.error('Error fetching deadline by ID:', error);
    throw error;
  }
}

// given a deadline object, display its course in the deadline_course section, name in the deadline_name section and date in the deadline_date section
async function loadDeadline($deadlineID){
  try {
    const data = await getDeadline($deadlineID);
    course.innerHTML = `${data.course}`;
    deadline_name.innerHTML = `${data.deadline_name}`;
    // Convert due_date to string format "yyyy-MM-ddThh:mm"
    const dueDate = new Date(data.due_date);
    const dateString = dueDate.toISOString().slice(0, 16);
    date.value = dateString;
    alert('Deadline Loaded!');
  } catch (error) {
    // Handle errors
    console.error('Error:', error);
  }
}

// update the user's deadline in the DB with this deadlineID based on the info stored in deadline_course, deadline_name, and deadline_date elements

function updateDeadline($deadlineID) {
  var formData = new FormData();
  formData.append('command', 'deadline-update');
  formData.append('id', $deadlineID);
  formData.append('username', onlineUsers);
  formData.append('course', course.value);
  formData.append('deadline_name', deadline_name.value);
  formData.append('due_date', date.value);
  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Deadline updated!');
}

// button click listener
if (updateDeadlineBtn){
  updateDeadlineBtn.addEventListener('click', function(){ // reveal response
  const deadlineID = document.getElementById('hiddenDeadlineId').value; // Get the note ID from the hidden input
  updateDeadline(deadlineID); // was hard coded before
  });
}

// NOTE UPDATES
// Front-end note view elements
const title = document.querySelector('.note-title');
const body = document.querySelector('.note-body');
const updateNoteBtn = document.querySelector('.update-note');

// note data 
function getNotes() { // get all the user's notes as (id, title, content) objects
  

  return fetch(`/server.php?command=notes&username=${encodeURIComponent(onlineUsers)}`)
    .then(response => response.json())
    .then(json => {
      return json.message.map(entry => {
        return {
          id: entry.id,
          title: entry.title,
          content: entry.content
        };
      });
    })
    .catch(error => {
      console.error('Error fetching notes:', error);
      throw error;
    });
}

// given a note id, load its information from the DB, returning an object with (title, content) attributes
async function getNote($noteID){
  try {
    const notes = await getNotes();
    const note = notes.find(note => note.id == $noteID);
    return note || null;
  } catch (error) {
    console.error('Error fetching note by ID:', error);
    throw error;
  }
}

// given a note object, display its title in the note-title section and content in the note-body section
async function loadNote($noteID){
  try {
    const data = await getNote($noteID);
    title.innerHTML = `${data.title}`;
    body.innerHTML = `${data.content}`;
    alert('Note Loaded!');
  } catch (error) {
    // Handle errors
    console.error('Error:', error);
  }
}

// update the user's note in the DB with this noteID based on the info stored in note-title and note-body
function updateNote($noteID) {
  var formData = new FormData();
  formData.append('command', 'note-update');
  formData.append('id', $noteID);
  formData.append('username', onlineUsers);
  formData.append('title', title.innerText);
  formData.append('content', body.value);
  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Note updated!');
}

if (updateNoteBtn) {
  updateNoteBtn.addEventListener('click', function(){
    const noteID = document.getElementById('hiddenNoteId').value; // Get the note ID from the hidden input
    updateNote(noteID);
  });
}


// FLASHCARDS

// Front-end flashcard reivew elements
const cue = document.querySelector('.cue');
const response = document.querySelector('.response');
const reveal = document.querySelector('.reveal');
const next = document.querySelector('.next');

// button click listeners
if (reveal){
  reveal.addEventListener('click', function(){ // reveal response
    response.style.display = 'flex';
  });
}

if (next){
  next.addEventListener('click', function(){ // populate cue, response with a random flashcard
    getRandomFlashcard();
    response.style.display = 'none';
  });
}


// flashcard data 
function getFlashcards() { // get all the user's flashcards as (cue, response) objects
  return fetch(`/server.php?command=flashcards&username=${encodeURIComponent(onlineUsers)}`)
    .then(response => response.json())
    .then(json => {
      return json.message.map(entry => {
        return {
          cue: entry.cue,
          response: entry.response
        };
      });
    })
    .catch(error => {
      console.error('Error fetching flashcards:', error);
      throw error;
    });
}

function getRandomFlashcard() {
  getFlashcards()
  .then(data => {
    randomFlashcard = data[Math.floor(Math.random() * data.length)];
    cue.innerHTML = `<h3>${randomFlashcard.cue}</h3>`;
    response.innerHTML = `<h3>${randomFlashcard.response}</h3>`;
    alert('Flashcards Loaded!');
  })
  .catch(error => {
    // Handle errors
    console.error('Error:', error);
  });
}

function addCourse() {
    var formData = new FormData();
    formData.append('command', 'courses');
    formData.append('username', onlineUsers);
    formData.append('course_name', document.getElementById("addCourseForm").elements[0].value);

    fetch('/server.php', {
        method: 'POST',
        body: formData
    });
    alert('Course added!');
}

function addTimeslot() {
    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');

    var formData = new FormData();
    formData.append('command', 'timeslots');
    formData.append('course_id', id);
    //formData.append('course_id', document.getElementById("addTimeslotsForm").elements[0].value);
    formData.append('day_of_week', document.getElementById("addTimeslotForm").elements[0].value);
    formData.append('start_time', document.getElementById("addTimeslotForm").elements[1].value);
    formData.append('num_hours', document.getElementById("addTimeslotForm").elements[2].value);


    fetch('/server.php', {
        method: 'POST',
        body: formData
    });
    alert('Timeslot added!');

}

function showCourses() {

    fetch(`/server.php?command=courses&username=${encodeURIComponent(onlineUsers)}`)
    .then(console.log(response))
    .then(response => response.json())
    .then(data => {
        const main = document.getElementById('course-main');

        data.forEach(item => {

            const container = document.createElement('div');
            container.classList.add('note-container');
            const div = document.createElement('div');
            div.innerHTML = `
                <div class='note-title'>${item.course_name}</div>
            `;
            const button = document.createElement('button');
            button.classList.add('edit-button');
            button.textContent = 'View/Add Timeslots';

            button.addEventListener('click', function() {
                window.location.href = "course_view.php?id=" + item.id;
            });

            container.appendChild(div);
            container.appendChild(button);
            main.appendChild(container);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function showTimeslots() {

    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');

    fetch('/server.php?command=timeslots&course_id=' + id)
    .then(console.log(response))
    .then(response => response.json())
    .then(data => {
        const main = document.getElementById('course-main');
        const button = document.createElement('button');
        button.classList.add('edit-button');
        button.textContent = 'Add a timeslot';

        button.addEventListener('click', function() {
            window.location.href = "timeslot_insertion.php?id=" + id;
        });
        main.appendChild(button);

        data.forEach(item => {

            const container = document.createElement('div');
            container.classList.add('note-container');
            const div1 = document.createElement('div');
            const div2 = document.createElement('div');
            const div3 = document.createElement('div');
            div1.innerHTML = `
                <div class="note-title">${item.day_of_week}</div>
            `;
            div2.innerHTML = `
                <div class="note-title">Begins at ${item.start_time}</div>
            `;
            div3.innerHTML = `
                <div class="note-title">${item.num_hours} hours</div><h1>
            `;
            container.appendChild(div1);
            container.appendChild(div2);
            container.appendChild(div3);
            main.appendChild(container);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}