<?php include_once 'sidebar-db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Outfit' rel='stylesheet'>
    <title>CourseBind</title>
    <style>
       body, html {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  display: flex;
  font: #001858;
  font-family: Outfit;
}

#sidebar {
  width: 25vw;
  height: 100vh;
  background-color: #8BD3DD;
}

.not-sidebar {
  width: 75vw;
  height: 100vh;
  background-color: #FEF6E4;
}

.nav {
  display: flex;
  justify-content: space-around;
  position: absolute;
  top: 5vh;
}

a {
  text-decoration: none;
  all: unset;
}

#sidebar .nav {
  left: 2.5%;
  width: 20%;
}

#sidebar-info {
  position: absolute;
  top: 15vh;
  left: 2.5vw;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 20px;
}

.assignment-info, .note-info {
  display: flex;
  gap: 5px;
}

.not-sidebar .nav {
  right: 0px;
  width: 40%;
}
.main {
  height: 83%;
  margin: 10% 2% 2% 2%;
  border: 1px solid black;
  text-align: center;
}

.non-desktop {
  display: none;
}


.info-block {
    position: relative;
    background-color: #f582ae;
    text-align: center;
    width: 20vw;
    height: 15%;
}

.del-button {
    position: absolute;
    border: none;
    top: 0;
    right: 0;
    transition: opacity 0.1s;
    opacity: 0;
    height: 100%;
    cursor: pointer;
    background-color: white;
}

.info-block:hover .del-button {
    opacity: 0.5;
}

#sidebar-info h2 {
  word-wrap: break-word;
}

/* tablet view */

@media only screen and (max-width: 768px) {

  #sidebar {
      display: none;
  }

  .non-desktop {
      display: inline;
  }

  .not-sidebar {
      width: 100%;
  }

  .not-sidebar .nav {
      right: 0px;
      width: 100%;
  }

  .main {
      height: 90%;
  }

  .nav {
      top: 3vh;
  }

  .hamburger-menu {
      display: flex;
      flex-direction: column;
      gap: 6px;
      width: max-content;
      cursor: pointer;
      z-index: 2;
  }

  #sidebar-closed-hamburger::before, #sidebar-closed-hamburger::after, #sidebar-closed-hamburger input {
      background-color: #8BD3DD;
  }

  #sidebar-open-hamburger::before, #sidebar-open-hamburger::after, #sidebar-open-hamburger input {
      background-color: #f582ae;
  }

  .hamburger-menu::before, .hamburger-menu::after, .hamburger-menu input {
      content: "";
      width: 60px;
      height: 6px;
      border-radius: 9999px;
      transform-origin: left center;
  }

  .hamburger-menu input {
      appearance: none;
      padding: 0;
      margin: 0;
      outline: none;
      pointer-events: none;
  }

  #sidebar-info {
      position: absolute;
      top: 15vh;
      left: 4vw;
  }

  #sidebar-info h2 {
      font-size: 10px;
  }

  .info-block {
      background-color: #f582ae;
      text-align: center;
      width: 15vw;
      height: 15%;
  }
}


/* mobile view */
@media only screen and (max-width: 600px) {

  .nav {
      top: 2vh;
  }
}




.signuppage {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.signupform {
  width: 500px;
  height: 700px; /* Increased height to accommodate wrapped text */
  background-color: white;
  border-radius: 5px;
  padding: 40px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  margin-top: -50px;
  word-wrap: break-word; /* Added word-wrap to wrap long texts */
}


.signupform h1 {
  margin-bottom: 20px;
  color: #333;
}

.signupform p {
  color: #777;
  margin-bottom: 30px;
}

.inputField {
  margin-bottom: 15px;
}

.inputField label {
  display: block;
  margin-bottom: 5px;
  color: #333;
}

.inputField input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  outline: none;
}

.btnformReg {
  margin-top: 20px;
  border-radius: 4px;
  font-weight: bold;
  border: none;
  color: white;
  width: 100%;
  padding: 12px;
  background-color: rgb(112, 148, 210);
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btnformReg:hover {
  background-color: #7596cc;
}

span {
  color: #777;
}

a {
  color: rgb(112, 148, 210);
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

.password-length-info {
  font-size: 12px;
  color: #666;
  margin-top: 1px;
}

    </style>
</head>
<body>
    <?php include_once 'sidebar-content.php'; ?>
    <div class="not-sidebar">
      <?php include_once 'navbar.html';
        $header_text = ""; //none
        $page = "signup";
        include_once 'main.php';
        ?>
        
    </div>

    <script src="script.js">


    </script>
</body>
</html>
