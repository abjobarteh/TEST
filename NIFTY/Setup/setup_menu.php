<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<title>Setup Menu Dashboard</title>
    <!-- update css path -->
    <link rel="stylesheet" href="css/menu.css">
		<link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
	</head>

	<body>
			
			<nav class="sidebar">
      <a href="#" class="logo">	<?php
      
         ?>
         </a>
      <div class="menu-content">
        <ul class="menu-items">
          <div class="menu-title">Setup</div>

          <li class="item">
            <div class="submenu-item">
              <span>Region</span>
              <span class="fas fa-caret-down first"></span>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                 <span class="fas fa-caret-down first"></span>
                   Region
              </div>
              <li class="item">
                <a href="show_region.php">Show Region</a>
              </li>
              <li class="item">
                <a href="create_region.php">Add Region</a>
              </li>
              <li class="item">
                    <a href="edit_region.php">Edit Region</a>
            </li>
            </ul>
          </li>

          <li class="item">
            <div class="submenu-item">
              <span>District</span>
              <span class="fas fa-caret-down first"></span>
            </div>
            <ul class="menu-items submenu">
              <div class="menu-title">
                 <span class="fas fa-caret-down first"></span>
                   District
              </div>
              <li class="item">
                <a href="show_district.php">Show District</a>
              </li>
              <li class="item">
                <a href="create_district.php">Add District</a>
              </li>
              <li class="item">
                <a href="edit_district.php">Edit District</a>
              </li>
            </ul>
          </li>
        
          <li class="item">
            <div class="submenu-item">
              <span>School</span>
              <span class="fas fa-caret-down first"></span>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                 <span class="fas fa-caret-down first"></span>
                 School
              </div>
              <li class="item">
                <a href="show_school.php">Show School</a>
              </li>
              <li class="item">
                <a href="register.php">Add School</a>
              </li>
              <li class="item">
                <a href="edit_school.php">Edit School</a>
              </li> 
              <li class="item">
                <a href="add_user.php">Create School Users</a>
              </li>
              <li class="item">
                <a href="school_users.php">Show School Users</a>
              </li>
              <li class="item">
                <a href="select_school.php">Edit School Users</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

   
    <nav class="navbar">
      <span class="fas fa-bars" id="sidebar-close"></span>
    </nav>
    <!-- End of Sidebar -->

    <!-- Content -->
    <main class="main">
      <h1>Academix:School Management System</h1>
      <img src="img/logo.png" style="height: 100px;">  
    </main>

    <!-- update path -->
    <script src="js/script.js"></script>
	</body>
</html>
