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

// button click listener
updateNoteBtn.addEventListener('click', function(){ // reveal response
  updateNote(4); // hard-coded right now...
});

// FLASHCARDS

// Front-end flashcard reivew elements
const cue = document.querySelector('.cue');
const response = document.querySelector('.response');
const reveal = document.querySelector('.reveal');
const next = document.querySelector('.next');

// button click listeners
reveal.addEventListener('click', function(){ // reveal response
  response.style.display = 'flex';
});

next.addEventListener('click', function(){ // populate cue, response with a random flashcard
  getRandomFlashcard();
  response.style.display = 'none';
});

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

// }

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