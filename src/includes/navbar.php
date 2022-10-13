<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-blue w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container ">
  <a href=index.php><img style="margin-bottom:-13px" width="220px" src="<?php echo $path; ?>images/Etown_Black_&_White.png"></a>
  <h3 class="w3-padding-34" style="margin-left:2px; font-size: 24.5 px; font-family:'Oswald', sans-serif;">  DATABASE</h3>
   <!-- <h3 class="w3-padding-34"><b>Database</b></h3> -->
  </div>
  <div class="w3-bar-block">
    <br/>
    <a href="<?php echo $path; ?>index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> 
    <a href="<?php echo $path; ?>students.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Students</a>
    <a href="<?php echo $path; ?>profile.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Profile</a>
    <a href="<?php echo $path; ?>companies.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Companies</a> 
    <a href="<?php echo $path; ?>contacts.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Industry Contacts</a> 
    <a href="<?php echo $path; ?>internships.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Internships</a>
    <a href="<?php echo $path; ?>first_landings.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">First Landings</a> 
    <a href="<?php echo $path; ?>meetings.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Meetings</a> 
    <a href="<?php echo $path; ?>survey.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Student Interest Survey</a> 
    <a href="<?php echo $path; ?>import.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Data Import</a> 
    <a href="<?php echo $path; ?>about.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">About</a>
    <a href="<?php echo $path; ?>login.php?logout=true" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white" style="color: #FF4444;">Logout</a>
  </div>

</nav>
<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-blue w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-blue w3-margin-right" onclick="w3_open()">☰</a>
  <span>EMCS Career Database</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

