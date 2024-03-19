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
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <h2>Enter a new deadline below</h2>
                <form id="addDeadlineForm">
                    <p>Enter Course: </p>
                    <textarea rows="1" cols="50" name="tags" id="tags" placeholder="Type your course here..."></textarea>
                    </select>
                    <p>Enter Deadline Name:</p>
                    <textarea rows="1" cols="50" name="title" id="title" placeholder="Enter the name of your deadline here..."></textarea>
                    <input
                        type="datetime-local"
                        id="date"
                        name="date"
                        value="2024-02-05T15:00"
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
            <div id="deadline info">
        <h2>Recent Deadlines</h2>
        <?php
            if ($numDeadlines > 0) {
                while ($deadline = mysqli_fetch_assoc($deadlines)) {
                    echo '<div class="info-block">' . htmlspecialchars($deadline["course"]) . '</div>';
                }
                // Reset the data pointer for $notes
                mysqli_data_seek($deadlines, 0);
            }
        ?>
        </div>
        <?php
        if ($numDeadlines > 0) {
            while ($deadline = mysqli_fetch_assoc($deadlines)) {
                echo '<div class="note-container">';
                echo '<div class="deadline-course">' . htmlspecialchars($deadline['course']) . '</div>';
                echo '<div class="note-content">' . htmlspecialchars(substr($deadline['deadline_name'], 0, 50)) . '...</div>'; // preview
                echo '<div class="deadline-date">Due: ' . htmlspecialchars($deadline['due_date']) . '</div>'; // Displaying the due date

            
                // Update the onclick attribute below
                echo '<button class="edit-button" onclick="location.href=\'deadlines-view.php?id=' . $deadline['id'] . '\'">View/Edit</button>';
                echo '</div>';
            }
        } else {
            echo '<p>No deadlines found.</p>';
        }
    ?>
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

        case 'notes-all':
            ?>
            <div id="note info">
        <?php
            if ($numNotes > 0) {
                while ($note = mysqli_fetch_assoc($notes)) {
                    echo '<div class="info-block">' . htmlspecialchars($note["title"]) . '</div>';
                }
                // Reset the data pointer for $notes
                mysqli_data_seek($notes, 0);
            }
        ?>
        </div>
        <?php
        if ($numNotes > 0) {
            while ($note = mysqli_fetch_assoc($notes)) {
                echo '<div class="note-container">';
                echo '<div class="note-title">' . htmlspecialchars($note['title']) . '</div>';
                echo '<div class="note-content">' . htmlspecialchars(substr($note['content'], 0, 50)) . '...</div>'; // preview

                // Update the onclick attribute below
                echo '<button class="edit-button" onclick="location.href=\'notes-view.php?id=' . $note['id'] . '\'">View/Edit</button>';
                echo '</div>';
            }
        } else {
            echo '<p>No notes found.</p>';
        }
    ?>
        </div>
            
            <?php
            break;


        // FLASHCARDS PAGES
        case 'flashcards':
            ?>
            <!-- Add a Textbox Feature -->
            <div class="textbox-section">
                <div><a href="flashcard-insertion.php">Add Flashcards</a></div>
                <div><a href="flashcard-review.php">Review Flashcards</a></div>
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
                        <!-- Planning to give the user freedom to create their own category -->
                    </select>
                    <p>Response:</p>
                    <textarea rows="4" cols="50" name="response" id="enter-response" placeholder="Type your response here..."></textarea>
                    <br>
                    <input type="button" value="Add Flashcard" onclick="addFlashcard()">
                </form>
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