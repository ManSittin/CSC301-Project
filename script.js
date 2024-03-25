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
      getFlashcardAlgorithm(flashcardAlgorithm);
      sessionStorage.setItem('flashcardAlgorithm', flashcardAlgorithm);
      alert(flashcardAlgorithm);
})

}









function handleSignUpClick() {
  // Prevent the default form submission behavior
  // console.log(document.getElementById("signup").elements)
 // event.preventDefault();

  // Retrieve the email and password from the input fields
  var firstname = document.getElementById("firstName").value;
  var lastname = document.getElementById("lastName").value;
  var email =  document.getElementById("email").value;
  var username =  document.getElementById("username").value;
  var password =  document.getElementById("password").value;

      // Clear previous warning messages
    passwordWarning.textContent = '';

    // Check if the password is longer than 8 characters
    if(password.length <= 8) {
        // If the password is not long enough, display the warning and exit the function
        passwordWarning.textContent = 'Password must be longer than 8 characters.';
        return; // Exit the function early
    }
  
  // Perform validation if needed
  var passi = encryptMessage(password, secretKey);
  // Perform sign-in logic (e.g., send AJAX request to the server)
  // Here, you can use fetch() or any other method to send the data to the server
  // For demonstration purposes, we'll simply log the email and password

  // CREATE NEW USER
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
  
  // CREATE NEW PREFERENCES FOR THE USER (can default some here if we want)
  var formData = new FormData();
  formData.append('command', 'preferences');
  formData.append('username', document.getElementById("username").value);
  formData.append('flashcard_algorithm', 'random'); // DEFAULT

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
  formData.append('tag', document.getElementById("addDeadlineForm").elements[3].value);
  
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
  formData.append('is_public', document.getElementById("addNoteForm").elements[2].checked ? 1 : 0);
  formData.append('tag', document.getElementById("addNoteForm").elements[3].value);
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


function handleFlashcardDelete(event) {
  var id = event.target.getAttribute('id');

  fetch('server.php/flashcards/' + id, {
      method: 'DELETE'
  });

  // this is where the http req is made

  alert('Flashcard successfully deleted!');
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


async function loadFlashcard($flashcardID){
  try {
    const data = await getFlashcard($flashcardID);
    course.innerHTML = `${data.course}`;
    flashcard_name.innerHTML = `${data.flashcard_name}`;
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
let currentFlashcard;
var flashcardAlgorithm = sessionStorage.getItem('flashcardAlgorithm');

function addFlashcard() { // insert a flashcard
  // Add logic to send the note to the server and store it in the database
  var formData = new FormData();
  formData.append('command', 'flashcards');
  formData.append('username', onlineUsers);
  formData.append('cue', document.getElementById("addFlashcardForm").elements[0].value);
  formData.append('response', document.getElementById("addFlashcardForm").elements[1].value);
  formData.append('tag', document.getElementById("addFlashcardForm").elements[2].value)
  formData.append('is_public', document.getElementById("addFlashcardForm").elements[3].checked ? 1 : 0);

  // default review_date to today
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0'); // Add leading zero if needed
  const day = String(today.getDate()).padStart(2, '0'); // Add leading zero if needed
  const formattedDate = `${year}-${month}-${day}`;
  formData.append('review_date', formattedDate);

  // default priority to 0
  formData.append('priority', 0);

  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Flashcard added!');
}

function updateFlashcardAlgorithm(algo) {
  var formData = new FormData();
  formData.append('command', 'preferences-update');
  formData.append('username', onlineUsers);
  formData.append('flashcard_algorithm', algo);
  fetch('/server.php', {
      method: 'POST',
      body: formData,
  });
  alert('Flashcard Algorithm Updated!');
}


// Front-end flashcard reivew elements
document.getElementById("result").innerHTML = "The number of flashcards is: " + getFlashcardsnum()
.then(num => {
  // This code block will execute once the promise is resolved
  document.getElementById("result").innerHTML = "The number of flashcards is: " + num.toString();
})
.catch(error => {
  // Handle any errors that might occur during the promise chain
  console.error('Error:', error);
  // Optionally, you can set a default value if there's an error
  document.getElementById("result").innerHTML = " The number of flashcards is: 0" ;
});



document.getElementById("flashcardnum").innerHTML = "The number of flashcard left to do is : " + Last_flashcard()
.then(num => {
  // This code block will execute once the promise is resolved
  document.getElementById("flashcardnum").innerHTML = "The number of flashcard left to do is : " +  num.toString();
})
.catch(error => {
  // Handle any errors that might occur during the promise chain
  console.error('Error:', error);
  // Optionally, you can set a default value if there's an error
  document.getElementById("flashcardnum").innerHTML = " Please connect and create flashcards to study" ;
})

function Last_flashcard(){
 return  getFlashcards()
  .then(data => {
    // Filter flashcards with review dates on or before today
    const validFlashcards = data.filter(flashcard => {
      const reviewDate = new Date(flashcard.review_date);
      return reviewDate <= new Date(); // Compare review date with today
    });
    return validFlashcards.length;


  })
  .catch(error => {
    // Handle errors
    console.error('Error:', error);
  });

}



const cue = document.querySelector('.cue');
const response = document.querySelector('.response');
const reveal = document.querySelector('.reveal');
const next = document.querySelector('.next');
const correct = document.querySelector('.correct');
const incorrect = document.querySelector('.incorrect');
const randomAlg = document.querySelector('.randomAlg');
const leitnerAlg = document.querySelector('.leitnerAlg');

// button click listeners
if (reveal){
  reveal.addEventListener('click', function(){ // reveal response
    response.style.display = 'flex';
  });
}

if (next){
  next.addEventListener('click', function(){ // populate cue, response with the next flashcard
    getFlashcard();
    response.style.display = 'none';
  });
}

if (correct){
    correct.addEventListener('click', function(){ // update flashcard review date and/or priority if loaded
    updateFlashcardReviewData(flashcardAlgorithm, "correct");
  });
}

if (incorrect){
  incorrect.addEventListener('click', function(){ // update flashcard review date and/or priority if loaded
    updateFlashcardReviewData(flashcardAlgorithm, "incorrect");
  });
}

if (randomAlg){
  randomAlg.addEventListener('click', function(){ // set flashcard algorithm to random
    if (flashcardAlgorithm == 'random'){
      alert("flashcard algorithm is already Random");
    }
    else{
      alert("flashcard algorithm set to Random");
      flashcardAlgorithm = 'random';
      sessionStorage.setItem('flashcardAlgorithm', flashcardAlgorithm);
      updateFlashcardAlgorithm(flashcardAlgorithm);
      setFlashcards(flashcardAlgorithm);
    }
  });
}

if (leitnerAlg){
  leitnerAlg.addEventListener('click', function(){ // set flashcard algorithm to leitner
    if (flashcardAlgorithm == 'leitner'){
      alert("flashcard algorithm is already Leitner");
    }
    else {
      alert("flashcard algorithm set to Leitner");
      flashcardAlgorithm = 'leitner';
      sessionStorage.setItem('flashcardAlgorithm', flashcardAlgorithm);
      updateFlashcardAlgorithm(flashcardAlgorithm);
      setFlashcards(flashcardAlgorithm);
    }
  })
}

function updateFlashcardReviewData(algorithm, state){

  if (algorithm == 'leitner'){
    updateFlashcardLeitner(state);
  }

  else if (algorithm == 'random'){
    if (state == "correct"){
      incrementReviewDate(1);
    }
    else if (state == "incorrect"){
      incrementReviewDate(3);
    }
  }
}

function updateFlashcardLeitner(state){
  /*
Pre: state = "correct" or "incorrect"
 */
  // flashcard variables for updating
  const id = currentFlashcard.id;
  const username = currentFlashcard.username;
  const cue = currentFlashcard.cue;
  const response = currentFlashcard.response;
  const review_date = currentFlashcard.review_date;
  alert(currentFlashcard.priority);

  if (state == "correct"){
    setPriority(id, username, cue, response, review_date, Math.min(currentFlashcard.priority + 1, 3)); // currently 3 is the highest priority
  }
  else {
    setPriority(id, username, cue, response, review_date, 1); // set to the lowest priority (other than today)
  }

  // update review date based on priority
  let priority = currentFlashcard.priority;
  switch(priority) {
    case 1:
      incrementReviewDate(1);
      break;
    case 2:
      incrementReviewDate(3)
      break;
    case 3:
      incrementReviewDate(7);
      break;
  }
}

// flashcard data 
function getFlashcards() { // get all the user's flashcards as (cue, response) objects
  return fetch(`/server.php?command=flashcards&username=${encodeURIComponent(onlineUsers)}`)
    .then(response => response.json())
    .then(json => {
      return json.message.map(entry => {
        return {
          id: entry.id,
          username: entry.username,
          cue: entry.cue,
          response: entry.response,
          review_date: entry.review_date,
          priority: entry.priority
        };
      });
    })
    .catch(error => {
      console.error('Error fetching flashcards:', error);
      throw error;
    });
}

// get the next flashcard to be reviewed, if available, based on chosen flashcardAlgorithm
function getFlashcard(){
  alert(flashcardAlgorithm);
  if (flashcardAlgorithm == 'random'){
    return getRandomFlashcard();
  }
  else if (flashcardAlgorithm == 'leitner'){
    return getLeitnerFlashcard();
  }
  else{
    alert("You must choose a flashcard algorithm first");
    console.error("Invalid flashcard algorithm or none chosen");
  }
}

function setPriorityAll(priority){

  // Get flashcards
  return getFlashcards()
    .then(flashcards => {
      // Iterate over each flashcard and sets its review date to date
      flashcards.forEach(flashcard => {
        setPriority(flashcard.id, flashcard.username, flashcard.cue, flashcard.response, flashcard.review_date, priority);
      });
    })
    .catch(error => {
      console.error('Error iterating over flashcards:', error);
      throw error;
    });
}

function setPriority(id, username, cue, response, review_date, priority) {

  if (currentFlashcard) {
    alert("flashcard found! - priority");
    currentFlashcard.priority = priority;
    const formData = new FormData();
    formData.append('command', 'flashcard-update');
    formData.append('id', id);
    formData.append('username', username);
    formData.append('cue', cue);
    formData.append('response', response);
    formData.append('review_date', review_date);
    formData.append('priority', priority);
    alert("hi");
    return fetch('/server.php', {
      method: 'POST',
      body: formData,
    })
    .then(response => response.json())
    .then(json => {
      if (json.status === 'Success') {
        return Promise.resolve();
      } else {
        return Promise.reject(json.message);
      }
    });
  }
  else {
    return;
  }
}

function getRandomFlashcard() {
  getFlashcards()
  .then(data => {
    // Filter flashcards with review dates on or before today
    const validFlashcards = data.filter(flashcard => {
      const reviewDate = new Date(flashcard.review_date);
      return reviewDate <= new Date(); // Compare review date with today
    });

    if (validFlashcards.length > 0) {
      // If there are valid flashcards, select a random one
      const randomIndex = Math.floor(Math.random() * validFlashcards.length);
      currentFlashcard = validFlashcards[randomIndex];

      // display the flashcard
      cue.innerHTML = `<h3>${currentFlashcard.cue}</h3>`;
      response.innerHTML = `<h3>${currentFlashcard.response}</h3>`;
      alert('Flashcards Loaded!');
    } else {
      // No valid flashcards found
      alert('No flashcards available for review.');
    }
  })
  .catch(error => {
    // Handle errors
    console.error('Error:', error);
  });
}

function groupBy(array, property) {
  return array.reduce((acc, obj) => {
    const key = obj[property];
    if (!acc[key]) {
      acc[key] = [];
    }
    acc[key].push(obj);
    return acc;
  }, {});
}

function getLeitnerFlashcard(){
   getFlashcards()
  .then(data => {
    // Filter flashcards with review dates on or before today
    const validFlashcards = data.filter(flashcard => {
      const reviewDate = new Date(flashcard.review_date);
      return reviewDate <= new Date(); // Compare review date with today
    });

    if (validFlashcards.length > 0) {

       // Group valid flashcards by priority
       const groupedByPriority = groupBy(validFlashcards, 'priority');

       // Find the group with the lowest priority
       const lowestPriorityGroup = Math.min(...Object.keys(groupedByPriority));

       // Select flashcards from the lowest priority group
       const lowestPriorityFlashcards = groupedByPriority[lowestPriorityGroup];

       // Randomly select a flashcard from the lowest priority group
       const randomIndex = Math.floor(Math.random() * lowestPriorityFlashcards.length);
       currentFlashcard = lowestPriorityFlashcards[randomIndex];

      // display the flashcard
      cue.innerHTML = `<h3>${currentFlashcard.cue}</h3>`;
      response.innerHTML = `<h3>${currentFlashcard.response}</h3>`;
      alert('Flashcards Loaded!');
    } else {
      // No valid flashcards found
      alert('No flashcards available for review.');
    }
  })
  .catch(error => {
    // Handle errors
    console.error('Error:', error);
  });
}

// set all flashcards to their default state as per the algorithm
function setFlashcards(algorithm){

  // set all flashcards review_date to today (all algorithms)
  dateToday = todaysDate();
  alert(dateToday);
  setReviewDateAll(dateToday);

  // set all priorities to 0 (leitner algorithm)
  if (algorithm == 'leitner'){
    setPriorityAll(0);
  }

}

async function getFlashcardAlgorithm(globalAlg) {
  try {
    const response = await fetch(`/server.php?command=preferences&username=${encodeURIComponent(onlineUsers)}`);
    const json = await response.json();
    const flashcardAlgorithm = json.message.map(entry => {
      return {
        flashcard_algorithm: entry.flashcard_algorithm,
      };
    });
    globalAlg = flashcardAlgorithm;
    return flashcardAlgorithm;
  } catch (error) {
    console.error('Error fetching flashcard algorithm:', error);
    throw error;
  }
}

// return today's date in 'YYYY-MM-DD' format; ready for POST requests
function todaysDate(){
  const dateToday = new Date();
  const isoDateString = dateToday.toISOString();
  const dateOnlyString = isoDateString.split('T')[0]; // Extract date part before 'T'
  return dateOnlyString;
}

// sets the review date of all flashcards to date
function setReviewDateAll(date){

  // Get flashcards
  return getFlashcards()
    .then(flashcards => {
      // Iterate over each flashcard and sets its review date to date
      flashcards.forEach(flashcard => {
        setReviewDate(date, flashcard.username, flashcard.id, flashcard.cue, flashcard.response, flashcard.priority);
      });
    })
    .catch(error => {
      console.error('Error iterating over flashcards:', error);
      throw error;
    });
}

// set the review date of a flashcard with a given username, id, cue, and response to date
function setReviewDate(date, username, id, cue, response, priority){
  const formData = new FormData();
  formData.append('command', 'flashcard-update');
  formData.append('id', id);
  formData.append('username', username);
  formData.append('cue', cue);
  formData.append('response', response);
  formData.append('review_date', date);
  formData.append('priority', priority);

  return fetch('/server.php', {
    method: 'POST',
    body: formData,
  })
  .then(response => response.json())
  .then(json => {
    if (json.status === 'Success') {
      return Promise.resolve();
    } else {
      return Promise.reject(json.message);
    }
  });
}

function incrementReviewDate(days) {

  if (currentFlashcard) {
    alert("flashcard found! - review date");
    const id = currentFlashcard.id;
    const username = currentFlashcard.username;
    const cue = currentFlashcard.cue;
    const response = currentFlashcard.response;
    const priority = currentFlashcard.priority;
    alert(cue);

    const formData = new FormData();
    formData.append('command', 'flashcard-update');
    formData.append('id', id);
    formData.append('username', username);
    formData.append('cue', cue);
    formData.append('response', response);
    formData.append('priority', priority);

    const newReviewDate = new Date();
    newReviewDate.setDate(newReviewDate.getDate() + days); // Increment review date by days
    const isoDateString = newReviewDate.toISOString();
    const dateOnlyString = isoDateString.split('T')[0]; // Extract date part before 'T'
    alert(dateOnlyString);
    formData.append('review_date', dateOnlyString);

    return fetch('/server.php', {
      method: 'POST',
      body: formData,
    })
    .then(response => response.json())
    .then(json => {
      if (json.status === 'Success') {
        return Promise.resolve();
      } else {
        return Promise.reject(json.message);
      }
    });
  }
  else {
    return;
  }
}




function getFlashcardsnum() {
  return getFlashcards()
      .then(flashcards => {
          return flashcards.length;
      })
      .catch(error => {
          console.error('Error:', error);
          return 0;
      });
}

function addOptions(courses, container) {

    courses.forEach(course => {
        const newOption = document.createElement('option');
        newOption.value = course.id;
        newOption.text = course.course_name;
        container.appendChild(newOption);
    });
}

function notesInsertionLoad() {
  //const notesContainer = document.getElementById('note-info');
  //notesContainer.innerHTML = '<p>Loading notes...</p>'; // Provide a loading indicator
  const tagsContainer = document.getElementById('tag');
  fetch('/server.php?command=courses&username=' + encodeURIComponent(onlineUsers))
      .then(response => response.json())
      .then(data => {
          if (data.courses && data.courses.length > 0) {
              addOptions(data.courses, tagsContainer);
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
}

// function getTimeslots($courseID){
//   return fetch('/server.php?command=timeslots&course_id=' + $courseID) // these commands don't exist???
//     .then(response => response.json())
//     .then(json => {
      
//     })
// }

// function createSchedule() { // this assumes they have inserted courses with appropriate times.
//   getCourses()
//     .then(data => {


//     })
//     .catch(error => {
//       console.error('Error creating schedule:', error);
//     })
// }

// // times will be stored as hour in the week
// function createFFGraph(courses){ // courses is a dictionary with courseid as key and a list of all timeslot/length pairs as a value
//   let timeslots = {}; //timeslots is a dictionary with all possible (used) timeslots as keys, and all courses using that timeslot as values
//   let slots = {};
//   var course_keys = Object.keys(courses); // enter course_keys[num] to get the corresponding courseid, used at end when translating back
//   var course_nums = {}; // enter course_nums[courseid] to get the corresponding position of the course
//   for(let i = 0; i < course_keys.length; i++){
//     course_nums[i] = course_keys[i];
//   }


//   for(let course in course_keys){ // MAKING TIMESLOTS DICTIONARY
//     var tempSlots = courses[course]; // tempslots is a list of all timeslots for the current course
//     for(let time in tempSlots){ // time is a section for the course
//       time = time[day]*24 + time[start_time];
//       for(let i = 0; i < time[length];i++){
//         timeslots[time[start]+i].push(course);
//       }
//     }
//   }

//   var timeslot_keys = Object.keys(timeslots); // enter timeslot_keys[num] to get the corresponding time, used at end when translating back
//   var timeslot_nums = {}; // enter timeslot_nums[time] to get the corresponding location of the time used to find locations in the graph creation
//   for(let i = 0; i < timeslot_keys.length; i++){
//     timeslot_nums[i] = timeslot_keys[i];
//   }

//   let numNodes = 2+timeslot_keys.length+course_keys.length;
//   var FFgraph = Array(numNodes).fill(Array(numNodes).fill(0));
  
//   for(let i = 2; i < timeslots.length+2;i++){ // creating all edges to times from source
//     FFgraph[0][i] = 1;
//   }

//   for(let time in timeslots){  // timeslots has all times, time is a possible time
//     for(let tempcourse in timeslots[time]){ // timeslots[time] is all courses at time, tempcourse is a course at the time
//       FFgraph[timeslot_nums[time]+2][course_nums[tempcourse]+2] = 1; // creating all edges from times to courses
//     }
//   }

//   for(let course in courses){
//     FFgraph[course_nums[course]+timeslot_keys.length+2][1] = courses[course][length];
//   }

//   return [FFgraph,course_keys,course_nums,timeslot_keys,timeslot_nums];
// function getCourses() {
//   return fetch('/server.php?commmand=courses&username=userAA') 
//     .then(response => response.json())
//     .then(json => {
//       return json.message.map(entry => {
//         return {
//           id: entry.id,
//           course_name: entry.course_name,
//         };
//       });
//     })
//     .catch(error => {
//       console.error('Error fetching courses:', error);
//       throw error;
//     });
// }

// function getTimeslots($courseID){
//   return fetch('/server.php?command=timeslots&course_id=' + $courseID) // these commands don't exist???
//     .then(response => response.json())
//     .then(json => {
      
//     })
// }

// function createSchedule() { // this assumes they have inserted courses with appropriate times.
//   getCourses()
//     .then(data => {


//     })
//     .catch(error => {
//       console.error('Error creating schedule:', error);
//     })
// }

// // times will be stored as hour in the week
// function createFFGraph(courses){ // courses is a dictionary with courseid as key and a list of all timeslot/length pairs as a value
//   let timeslots = {}; //timeslots is a dictionary with all possible (used) timeslots as keys, and all courses using that timeslot as values
//   let slots = {};
//   var course_keys = Object.keys(courses); // enter course_keys[num] to get the corresponding courseid, used at end when translating back
//   var course_nums = {}; // enter course_nums[courseid] to get the corresponding position of the course
//   for(let i = 0; i < course_keys.length; i++){
//     course_nums[i] = course_keys[i];
//   }


//   for(let course in course_keys){ // MAKING TIMESLOTS DICTIONARY
//     var tempSlots = courses[course]; // tempslots is a list of all timeslots for the current course
//     for(let time in tempSlots){ // time is a section for the course
//       time = time[day]*24 + time[start_time];
//       for(let i = 0; i < time[length];i++){
//         timeslots[time[start]+i].push(course);
//       }
//     }
//   }

//   var timeslot_keys = Object.keys(timeslots); // enter timeslot_keys[num] to get the corresponding time, used at end when translating back
//   var timeslot_nums = {}; // enter timeslot_nums[time] to get the corresponding location of the time used to find locations in the graph creation
//   for(let i = 0; i < timeslot_keys.length; i++){
//     timeslot_nums[i] = timeslot_keys[i];
//   }

//   let numNodes = 2+timeslot_keys.length+course_keys.length;
//   var FFgraph = Array(numNodes).fill(Array(numNodes).fill(0));
  
//   for(let i = 2; i < timeslots.length+2;i++){ // creating all edges to times from source
//     FFgraph[0][i] = 1;
//   }

//   for(let time in timeslots){  // timeslots has all times, time is a possible time
//     for(let tempcourse in timeslots[time]){ // timeslots[time] is all courses at time, tempcourse is a course at the time
//       FFgraph[timeslot_nums[time]+2][course_nums[tempcourse]+2] = 1; // creating all edges from times to courses
//     }
//   }

//   for(let course in courses){
//     FFgraph[course_nums[course]+timeslot_keys.length+2][1] = courses[course][length];
//   }

//   return [FFgraph,course_keys,course_nums,timeslot_keys,timeslot_nums];

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
    formData.append('day_of_week', document.getElementById("addTimeslotForm").elements[0].value);
    formData.append('start_time', document.getElementById("addTimeslotForm").elements[1].value);
    formData.append('num_hours', document.getElementById("addTimeslotForm").elements[2].value);
  
   fetch('/server.php', {
        method: 'POST',
        body: formData
    });
    alert('Timeslot added!');

 }


class FordFulkerson {
  constructor(graph, source, sink) {
    this.graph = graph;
    this.source = source;
    this.sink = sink;
  }

  maxFlow() {
    let residualGraph = this.graph.map(row => row.slice()); // Create a copy of the original graph'
    let parent = Array(this.graph.length).fill(-1);

    let maxFlow = 0;
    let iteration = 1;
    let paths = [];

    while (this.bfs(residualGraph,parent)) {
      let pathFlow = Infinity;
      let path = [];

      for (let v = this.sink; v != this.source; v = parent[v]) {
        let u = parent[v];
        pathFlow = Math.min(pathFlow, residualGraph[u][v]);
        path.unshift({ from: u, to: v });
      }

      for (let v = this.sink; v != this.source; v = parent[v]) {
        let u = parent[v];
        residualGraph[u][v] -= pathFlow;
        residualGraph[v][u] += pathFlow;
      }
      paths.unshift(path[1]);
      maxFlow += pathFlow;

      iteration++;
    }

    return [paths, maxFlow];
  }

  bfs(graph,parent) {
    let visited = Array(graph.length).fill(false);
    let queue = [this.source];
    visited[this.source] = true;
    //let parent = Array(graph.length).fill(-1);

    while (queue.length !== 0) {
      let u = queue.shift();

      for (let v = 0; v < graph.length; v++) {
        if (!visited[v] && graph[u][v] > 0) {
          queue.push(v);
          parent[v] = u;
          visited[v] = true;
        }
      }
    }

    return visited[this.sink];
  }
}

function showCourses() {

    fetch(`/server.php?command=courses&username=${encodeURIComponent(onlineUsers)}`)
    .then(console.log(response))
    .then(response => response.json())
    .then(data => {
        const main = document.getElementsByClassName('main')[0];

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
        const main = document.getElementsByClassName('main')[0];
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



document.addEventListener('DOMContentLoaded', function() {
  // Example: Check if the URL path contains "notes-all"
  if (window.location.pathname.includes('notes-all')) {
      loadNotes(); // Initially load all notes
      const searchButton = document.querySelector('.search-box button[type="submit"]');
      if (searchButton) {
          searchButton.addEventListener('click', handleSearch);
      }
  }
  // Example: Check if the URL path contains "deadlines-all"
  if (window.location.pathname.includes('deadlines-all')) {
      loadDeadlines(); // Initially load all deadlines
      const searchButton = document.querySelector('.search-box button[type="submit"]');
      if (searchButton) {
          searchButton.addEventListener('click', handleDeadlineSearch);
      }


    }

    if (window.location.pathname.includes('flashcard-review.php')) {
      // Code specific to 'flashcard-review.php'
      getFlashcard();
      alert('This is the flashcard review page.');
      // Fetch and display flashcard, etc.
  } 


  if (window.location.pathname.includes('flashcard-all')) {
    loadFlashcards(); // Initially load all notes
    const searchButton = document.querySelector('.search-box button[type="submit"]');
    if (searchButton) {
        searchButton.addEventListener('click', handleFlashcardSearch);
    }
  }

});

function handleFlashcardSearch(event) {
  event.preventDefault(); // Prevent the default form submission
  const searchQuery = document.querySelector('.search-box input[name="search"]').value;
  searchFlashcards(searchQuery);
}

function searchFlashcards(query) {
  const flashcardsContainer = document.getElementById('flashcard-info');
  flashcardsContainer.innerHTML = ''; // Always clear the current flashcards
  if (query.trim() === '') {
      flashcardsContainer.innerHTML = '<p>Please enter a search query.</p>';
      return; // Exit the function early if query is empty
  }
  var request = `/server.php?command=search_flashcards&query=${encodeURIComponent(query)}&username=`;
  if (window.location.pathname.includes('flashcard-all-public.php')) {
    request += -1;
  } else {
    request += encodeURIComponent(onlineUsers);
  }
  // Proceed with fetch if query is not empty
  fetch(request)
      .then(response => response.json())
      .then(data => {
          if (data.flashcards && data.flashcards.length > 0) {
              displayFlashcards(data.flashcards, flashcardsContainer);
          } else {
              flashcardsContainer.innerHTML = '<p>No flashcards found.</p>';
          }
      })
      .catch(error => {
          flashcardsContainer.innerHTML = '<p>Error fetching flashcards. Please try again later.</p>';
      });
}

function resetFlashcardSearch() {
  const searchInput = document.querySelector('.search-box input[name="search"]');
  if (searchInput) {
      searchInput.value = '';
  }
  loadFlashcards();
}

function loadFlashcards() {
  const flashcardsContainer = document.getElementById('flashcard-info');
  flashcardsContainer.innerHTML = '<p>Loading flashcards...</p>';
  var request = '/server.php?command=load_all_flashcards&username=';
  if (window.location.pathname.includes('flashcard-all-public')) {
    request += -1;
  } else {
    request += encodeURIComponent(onlineUsers);
  }
  fetch(request)
    .then(response => response.json())
    .then(data => {
      if (data.flashcards && data.flashcards.length > 0) {
        displayFlashcards(data.flashcards, flashcardsContainer);
      } else {
        flashcardsContainer.innerHTML = '<p>No flashcards found.</p>';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      flashcardsContainer.innerHTML = '<p>Error loading flashcards. Please try again later.</p>';
    });
}

function displayFlashcards(flashcards, container) {
  container.innerHTML = ''; // Clear container
  flashcards.forEach(flashcard => {
    const flashcardDiv = document.createElement('div');
    flashcardDiv.className = 'note-container'; // Use an appropriate class for styling
    flashcardDiv.innerHTML = `
      <div class="flashcard-cue">${flashcard.cue}</div>
      <div class="flashcard-response">${flashcard.response}</div>
      <div class="flashcard-review-date">Review Date: ${flashcard.review_date}</div>
      <button class="edit-button" onclick="location.href='deadlines-view.php?id=${flashcard.id}'">View/Edit</button>
    `;
    container.appendChild(flashcardDiv);
  });
}


function handleDeadlineSearch(event) {
  event.preventDefault(); // Prevent the default form submission
  const searchQuery = document.querySelector('.search-box input[name="search"]').value;
  searchDeadlines(searchQuery);
}

function searchDeadlines(query) {
  const deadlinesContainer = document.getElementById('deadline-info');
  deadlinesContainer.innerHTML = ''; // Always clear the current deadlines
  if (query.trim() === '') {
      deadlinesContainer.innerHTML = '<p>Please enter a search query.</p>';
      return; // Exit the function early if query is empty
  }
  // Proceed with fetch if query is not empty
  fetch(`/server.php?command=search_deadlines&query=${encodeURIComponent(query)}&username=${encodeURIComponent(onlineUsers)}`)
      .then(response => response.json())
      .then(data => {
          if (data.deadlines && data.deadlines.length > 0) {
              displayDeadlines(data.deadlines, deadlinesContainer);
          } else {
              deadlinesContainer.innerHTML = '<p>No deadlines found.</p>';
          }
      })
      .catch(error => {
          deadlinesContainer.innerHTML = '<p>Error fetching deadlines. Please try again later.</p>';
      });
}

function loadDeadlines() {
  const deadlinesContainer = document.getElementById('deadline-info');
  deadlinesContainer.innerHTML = '<p>Loading deadlines...</p>'; // Corrected text to "Loading deadlines..."
  fetch('/server.php?command=load_all_deadlines&username=' + encodeURIComponent(onlineUsers))
      .then(response => response.json())
      .then(data => {
          if (data.deadlines && data.deadlines.length > 0) { // Corrected from data.notes to data.deadlines
              displayDeadlines(data.deadlines, deadlinesContainer);
          } else {
              deadlinesContainer.innerHTML = '<p>No deadlines found.</p>';
          }
      })
      .catch(error => {
          console.error('Error:', error);
          deadlinesContainer.innerHTML = '<p>Error loading deadlines. Please try again later.</p>';
      });
}


function displayDeadlines(deadlines, container) {
  container.innerHTML = ''; // Clear container
  deadlines.forEach(deadline => {
    const deadlineDiv = document.createElement('div');
    deadlineDiv.className = 'note-container'; // Use the same class name as in PHP version
    deadlineDiv.innerHTML = `
        <div class="deadline-course">${deadline.course}</div>
        <div class="deadline-name">${deadline.deadline_name.substring(0, 50)}...</div>
        <div class="deadline-date">Due: ${deadline.due_date}</div>
        <button class="edit-button" onclick="location.href='deadlines-view.php?id=${deadline.id}'">View/Edit</button>
    `;
    container.appendChild(deadlineDiv);
  });
}

function resetDeadlineSearch() {
  const searchInput = document.querySelector('.search-box input[name="search"]');
  if (searchInput) {
      searchInput.value = '';
  }
  loadDeadlines();
}

function handleSearch(event) {
  event.preventDefault(); // Prevent the default form submission
  const searchQuery = document.querySelector('.search-box input[name="search"]').value;
  searchNotes(searchQuery);
}

function searchNotes(query) {
  const notesContainer = document.getElementById('note-info');
  notesContainer.innerHTML = ''; // Always clear the current notes
  if (query.trim() === '') {
      notesContainer.innerHTML = '<p>Please enter a search query.</p>';
      return; // Exit the function early if query is empty
  }
  // Proceed with fetch if query is not empty
  var request = `/server.php?command=search_notes&query=${encodeURIComponent(query)}&username=`;
  if (window.location.pathname.includes('notes-all-public')) {
    request += -1;
  } else {
    request += encodeURIComponent(onlineUsers);
  }
  fetch(request)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        console.log(data.notes.length);
          if (data.notes && data.notes.length > 0) {
              displayNotes(data.notes, notesContainer);
          } else {
              notesContainer.innerHTML = '<p>No notes found.</p>';
          }
      })
      .catch(error => {
        
          // console.error('Error:', error);
          notesContainer.innerHTML = '<p>Error fetching notes. Please try again later.</p>';
      });
}

function loadNotes() {
  const notesContainer = document.getElementById('note-info');
  notesContainer.innerHTML = '<p>Loading notes...</p>'; // Provide a loading indicator
  var request = '/server.php?command=load_all_notes&username=';
  if (window.location.pathname.includes('notes-all-public')) {
    request += '-1'
  } else {
    request += encodeURIComponent(onlineUsers);
  }
  fetch(request)
      .then(response => response.json())
      .then(data => {
          if (data.notes && data.notes.length > 0) {
              displayNotes(data.notes, notesContainer);
          } else {
              notesContainer.innerHTML = '<p>No notes found.</p>';
          }
      })
      .catch(error => {
          console.error('Error:', error);
          notesContainer.innerHTML = '<p>Error loading notes.</p>';
      });
}

function displayNotes(notes, container) {
  container.innerHTML = ''; // Clear container
  notes.forEach(note => {
      const noteDiv = document.createElement('div');
      noteDiv.className = 'note-container';
      noteDiv.innerHTML = `
          <div class="note-title">${note.title}</div>
          <div class="note-content">${note.content.substring(0, 50)}...</div>
          <button class="edit-button" onclick="location.href='notes-view.php?id=${note.id}'">View/Edit</button>
      `;
      container.appendChild(noteDiv);
  });
}

function resetSearch() {
  // Clear the search input
  const searchInput = document.querySelector('.search-box input[name="search"]');
  if (searchInput) {
      searchInput.value = '';
  }

  // Load all notes again
  loadNotes();
}

function handleSignupClick() {

  window.location.href = "signup.php";
  
  
  }


function addOptions(courses, container) {

    courses.forEach(course => {
        const newOption = document.createElement('option');
        newOption.value = course.id;
        newOption.text = course.course_name;
        container.appendChild(newOption);
    });
}

function getCoursesLoad() {
  //const notesContainer = document.getElementById('note-info');
  //notesContainer.innerHTML = '<p>Loading notes...</p>'; // Provide a loading indicator
  const tagsContainer = document.getElementById('tag');
  fetch('/server.php?command=courses&username=' + encodeURIComponent(onlineUsers))
      .then(response => response.json())
      .then(data => {
          if (data.courses && data.courses.length > 0) {
              addOptions(data.courses, tagsContainer);
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
}

