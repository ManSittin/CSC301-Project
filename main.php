<div class="main">
    <h1><?php echo $header_text; ?></h1>
    <?php
    switch ($page) {
        // DEADLINE PAGES
        case 'deadlines':
            ?>
            <div class="textbox-section">
                <div><a href="deadlines-insertion.php">Add Deadline</a></div>
                <div><a href="deadlines-all.php">View Deadlines</a></div>
            </div>
            <?php
            break;
        case 'deadlines-insertion':
            $currentDateTime = date('Y-m-d\TH:i'); // Format: YYYY-MM-DDTHH:MM
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Enter a new deadline below</h2>
                <form id="addDeadlineForm">
                    <p>Enter Course: </p>
                    <textarea rows="1" cols="50" name="tags" id="tags" placeholder="Type your course here..."></textarea>
                    <p>Enter Deadline Name:</p>
                    <textarea rows="1" cols="50" name="title" id="title" placeholder="Enter the name of your deadline here..."></textarea>
                    <br>
                    <input
                        type="datetime-local"
                        id="date"
                        name="date"
                        value="<?php echo $currentDateTime; ?>" 
                        min="0000-00-00T00:00"
                        max="9999-12-31T23:59"
                     />
                    <br><br>
                    <input type="button" value="Submit deadline" onclick="addDeadline()">
                </form>
            </div>
            <?php
            break;
        
        case 'deadlines-view':
            ?>
             <div class="textbox-section">
                <!-- Loaded deadline info preloads here... -->
                <h2>Edit Deadline</h2> 
                <form id="editDeadlineForm" method="post" action="deadlines-view.php">
                <input type="hidden" name="hiddenDeadlineId" id="hiddenDeadlineId" value="<?php echo isset($deadlineForEditing['id']) ? $deadlineForEditing['id'] : ''; ?>">
                <p>Edit Course: </p>
                <textarea rows="1" cols="50" name="course" class="deadline_course"><?php echo isset($deadlineForEditing['course']) ? $deadlineForEditing['course'] : ''; ?></textarea>
                <p>Edit Deadline Name:</p>
                <textarea rows="1" cols="50" name="deadline_name" class="deadline_name"><?php echo isset($deadlineForEditing['deadline_name']) ? $deadlineForEditing['deadline_name'] : ''; ?></textarea>
                <p>Edit Date:</p>
                <input
                    type="datetime-local"
                    id="date"
                    name="due_date"
                    value="<?php echo isset($deadlineForEditing['due_date']) ? str_replace(' ', 'T', $deadlineForEditing['due_date']) : ''; ?>"
                    class="deadline_date"
                />
                <br><br>
                <input type="submit" value="Update Deadline" class="update-deadline">
            </div>
        
            <?php
            break;

        case 'deadlines-all':
            ?>
            <form action="javascript:void(0);" method="get" class="search-box" onsubmit="handleDeadlineSearch(event)">
            <input type="hidden" name="action" value="deadlines-all">
            <input type="text" name="search" placeholder="Search by course name..." id="deadline-search-input">
            <button type="submit" id="search-button">Search</button>
            <button type="button" id="reset-deadline-search-button" onclick="resetDeadlineSearch()">Reset Search</button>
        </form>
        <div id="deadline-info">
            <!-- Dynamically inserted deadlines will go here -->
        </div>  
            <?php
            break;

        // NOTES PAGES
        case 'notes':
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <div><a href="notes-insertion.php">Add Notes</a></div>
                <div><a href="notes-all.php">View Notes</a></div>
            </div>
            
            <?php
            break;
        
        case 'notes-insertion':
            ?>
             <!-- Add a Textbox Feature -->
             <div class="textbox-section">
                <h2>Enter a new note</h2>
                <form id="addNoteForm">
                    <p>Enter title:</p>
                    <textarea rows="4" cols="50" name="title" id="title" placeholder="Type your title here..."></textarea>
                    <br>
                        <!-- Planning to give the user freedom to create their own category -->
                    </select>
                    <p>Enter your note:</p>
                    <textarea rows="4" cols="50" name="note" id="note" placeholder="Type your note here..."></textarea>
                    <br>
                    <input type="button" value="Add Note" onclick="addNote()">
                </form>
            </div>

            <!-- Placeholder for displaying notes by category -->
            <div class="notes-by-category" id="notesByCategory">
                <!-- Display notes here based on the selected category -->
            </div>
            
            <?php
            break;
        
        case 'notes-view':
            ?>
            <div class="textbox-section">
                <!-- Loaded note info preloads here... -->
                <h2 class="note-title">Your Note</h2> 
                <form id="editNoteForm" method="post" action="notes-view.php">
                <input type="hidden" id="hiddenNoteId" value="<?php echo isset($noteForEditing['id']) ? $noteForEditing['id'] : ''; ?>">
                <textarea rows="4" cols="50" name="noteContent" class="note-body"><?php echo isset($noteForEditing['content']) ? $noteForEditing['content'] : ''; ?></textarea>
                <br>
                <input type="submit" value="Update Note" class="update-note">
                </form>
            </div>
            
            <?php
            break;

        case 'flashcards-view':
            ?>
            <div class="textbox-section">
                <!-- Loaded flashcard info preloads here... -->
                <h2 class="flashcard-title">Your Flashcard</h2> 
                <form id="editFlashcardForm" method="post" action="flashcards-view.php">
                <input type="hidden" id="hiddenFlashcardId" value="<?php echo isset($flashcardForEditing['id']) ? $flashcardForEditing['id'] : ''; ?>">
                    
                <label for="cue">Cue:</label>
                <textarea rows="2" cols="50" name="flashcardCue" class="flashcard-cue"><?php echo isset($flashcardForEditing['cue']) ? $flashcardForEditing['cue'] : ''; ?></textarea>
                    
                <label for="response">Response:</label>
                <textarea rows="4" cols="50" name="flashcardResponse" class="flashcard-response"><?php echo isset($flashcardForEditing['response']) ? $flashcardForEditing['response'] : ''; ?></textarea>
                    
                <label for="reviewDate">Review Date:</label>
                <input type="date" id="reviewDate" name="flashcardReviewDate" value="<?php echo isset($flashcardForEditing['review_date']) ? $flashcardForEditing['review_date'] : ''; ?>">
                    
                <br>
                <input type="submit" value="Update Flashcard" class="update-flashcard">
                </form>
            </div>
            <?php
            break;
            
            case 'notes-all':
                ?>
                <form action="javascript:void(0);" method="get" class="search-box" onsubmit="handleSearch(event)">
                <input type="hidden" name="action" value="notes-all">
                <input type="text" name="search" placeholder="Search by title..." id="search-input">
                <button type="submit" id="search-button">Search</button>
                <button type="button" id="reset-search-button" onclick="resetSearch()">Reset Search</button>
            </form>
            <div id="note-info">
                <!-- Dynamically inserted notes will go here -->
            </div>

            <?php
            break;


        // FLASHCARDS PAGES
        case 'flashcards':
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <div><a href="flashcard-insertion.php">Add Flashcards</a></div>
                <div><a href="flashcard-all.php">View Flashcards</a></div>
                <div><a href="flashcard-review.php">Review Flashcards</a></div>
                <div><a href="flashcard-algorithms.php">Modify Flashcard Algorithm</a></div>
            </div>
            
            <?php
            break;
            
        case 'flashcard-insertion':
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Add a new flashcard</h2>
                <form id="addFlashcardForm">
                    <p>Cue:</p>
                    <textarea rows="2" cols="50" name="cue" id="enter-cue" placeholder="Type your cue here..."></textarea>
                    <br>
                    <p>Response:</p>
                    <textarea rows="4" cols="50" name="response" id="enter-response" placeholder="Type your response here..."></textarea>
                    <br>
                    <input type="button" value="Add Flashcard" onclick="addFlashcard()">
                </form>
            </div>
            
            <?php
            break;

        case 'flashcard-all':
                ?>
                <form action="javascript:void(0);" method="get" class="search-box" onsubmit="handleSearch(event)">
                <input type="hidden" name="action" value="notes-all">
                <input type="text" name="search" placeholder="Search by title..." id="search-input">
                <button type="submit" id="search-button">Search</button>
                <button type="button" id="reset-search-button" onclick="resetFlashcardSearch()">Reset Search</button>
            </form>
            <div id="flashcard-info">
                <!-- Dynamically inserted notes will go here -->
            </div>

            <?php
            break;

        case 'flashcard-review':
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Review Flashcards</h2>
                <div class="flashcards">
                    <div class="cue"><h3>Cue</h3></div>
                    <div class="response"><h3>Response</h3></div>
                </div>

                <div class="flashcard-buttons">
                    <div class="reveal"><button>Reveal Response</button></div>
                    <div class="correct"><button><img src="images/thumbs-up.png"></button></div>
                    <div class="incorrect"><button><img src="images/thumbs-down.png"></button></div>
                    <div class="next"><button>Next Cue</button></div>
                </div>

            </div>
            
            <?php
            break;

            case 'flashcard-algorithms':
                ?>
                <!-- Add a Textbox Feature -->
                <div class="textbox-section">
                    <div class="algorithm-buttons">
                        <div class="randomAlg"><button>Random</button></div>
                        <div class="leitnerAlg"><button>Leitner</button></div>
                    </div>
                </div>
                <?php
                break;



        // SCHEDULE PAGES
        case 'schedule':
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <div><a href="course-insertion.php">Add Course</a></div>
                <div><a href="courses-all.php">View Courses</a></div>
                <div><a href="#">Generate Schedule</a></div>
            </div>
            
            <?php
            break;
        case 'course-insertion':
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Enter a new course below</h2>
                <form id="addCourseForm">
                    <p>Enter Course Name: </p>
                    <textarea rows="1" cols="50" name="tags" id="tags" placeholder="Type your course name here..."></textarea>
                    <br><br>
                    <input type="button" value="Add course" onclick="addCourse()">
                </form>
            </div>
            
            <?php
            break;

        case 'course_view':
            ?>
            
            
            <?php
            break;

        case 'courses-all':
            ?>
            
            
            <?php
            break;

        // OTHER PAGES
        case 'profile':
            ?>
            <div>

                <div className='userlogin'>
                <div className='signin'>
                <h1>Sign in</h1>
                <span>or use your account</span>
                <form className='form' id = "login">
                <fieldset>
                <input type='email'
                placeholder='Email' />
                </fieldset>
                <fieldset>
                <input type='password'
                placeholder='Password' />
                </fieldset>
                <button type='button' className='btnsignin' onClick="handleSignInClick()">
                SIGN In
                </button>

                </form>
                <span className='forgotpassword' onClick={handlePassword}>
                <a href="Index.php">Home </a>
                </span>
                </div>

                <div className='signup'>
                <div className='signup1'>
                <h1> Join us today</h1>
                </div>
                <button type='button' className='btnsignup' onClick="handleSignupClick()">
                SIGN UP
                </button>
        </div>
            
            <?php
            break;
        case 'signup':
            ?>
            <div className='signuppage'>
      <div className='signupform'>
        <h1>Join Us Today!</h1>
        <p>Sign up and start exploring our platform!</p>
        <form id = "signup" className="formReg">
          <div className="inputField">
            <label htmlFor="firstName">First Name*</label>
            <input type="text" id="firstName" placeholder="Enter your first name" 
            />
          </div>
          <div className="inputField">
            <label htmlFor="lastName">Last Name*</label>
            <input type="text" id="lastName" placeholder="Enter your last name"
            />
            
          </div>


          <div className="inputField">
            <label htmlFor="email">Email*</label>
            <input type="email" id="email" placeholder="Enter your email"
            />

          
          
          </div>

          <div className="inputField">
            <label htmlFor="user">Username*</label>
            <input type="user" id="username" placeholder="Enter your username"

            /> 
          </div>

          <div className="inputField">
            <label htmlFor="password">Password*</label>
            <input type="password" id="password" placeholder="Enter your password" 
            />
          </div>
          <span className="password-length-info">(Password must be longer than 8 characters)</span>
          <button type="button" className="btnformReg" onClick="handleSignUpClick()">
            SIGN UP
          </button>
        </form>
        <span>Already have an account? <a href="profile.php">Sign In</a></span>
      </div>
    </div>

            <!-- Placeholder for displaying notes by category -->
            <div class="notes-by-category" id="notesByCategory">
                <!-- Display notes here based on the selected category -->
            </div>
        </div>
            
            <?php
            break;
    }
    ?>


</div>