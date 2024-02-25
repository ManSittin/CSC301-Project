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

function submit() { // insert a deadline
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

function addNote() { // insert a note
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

function addFlashcard() { // insert a flashcard
  // Add logic to send the note to the server and store it in the database
  var formData = new FormData();
  formData.append('command', 'flashcards');
  formData.append('username', 'userAA');
  formData.append('cue', document.getElementById("addFlashcardForm").elements[0].value);
  formData.append('response', document.getElementById("addFlashcardForm").elements[1].value);
  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Flashcard added!');
}

// NOTE UPDATES

// Front-end note view elements
const title = document.querySelector('.note-title');
const body = document.querySelector('.note-body');
const updateNoteBtn = document.querySelector('.update-note');

// note data 
function getNotes() { // get all the user's notes as (id, title, content) objects
  return fetch('/server.php?command=notes&username=userAA')
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
  formData.append('username', 'userAA');
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

if (reveal) {
// button click listeners
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
  return fetch('/server.php?command=flashcards&username=userAA')
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













