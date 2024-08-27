<!DOCTYPE html>
<html>

<head>
	<title>Landing Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/styling.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
</head>

<body>

	<?php
	include 'connect.php';
	ob_start();
	session_start();
	?>
	<div class="container">
		<div class="img">
			<img src="img/splash.svg">
		</div>
		<div class="login-content">
			<form action="login.php" method="post">

				<h2 class="title" style="text-align: center; color: #1D5B79; font-size: 20px;">
					WELCOME
					<p style="white-space: nowrap;">TO</p>
					<span style="white-space: nowrap; text-align:center; margin: right 10px;">NIFTY ACADEMIX STUDENT MANAGEMENT SYSTEM</span>
				</h2>


				<?php
				$stmt = oci_parse($conn, "select * from school where school = :name");
				oci_bind_by_name($stmt, ':name', $school);
				oci_execute($stmt);
				if ($rowS = oci_fetch_array($stmt)) {
					$imageData = $rowS['LOGO']->load(); // Load OCILob data

					// Encode the image data as base64
					$base64Image = base64_encode($imageData);
				?> <td style=" padding: 5px 8px; font-size: 10px; margin: 5px;"><?php

																				echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 100px; height: 100px;">'; ?></td> <?php
																																																	}
																																																		?>
				<h3 class="title">Login</h3>
				<div class="input-div one">
					<div class="i">
						<i class="fa fa-graduation-cap" aria-hidden="true"></i>
					</div>

					<div class="div">
						<select class="input" name="school" style="width: 400px;">
							<option selected>KOTU SENIOR SECONDARY SCHOOL</option>
							<?php
							/*	$get_hos = "select * from school order by school";
							$get = oci_parse($conn, $get_hos);
							oci_execute($get);
							while ($row = oci_fetch_array($get)) {
							?><option>
									<?php echo $row["SCHOOL"]; ?>
								</option> <?php
										} */
							?>
						</select>
					</div>
				</div>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" class="input" name="username">
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" class="input" name="password">
					</div>
				</div>
				<a href="#">Password Reset</a>
				<input type="submit" class="btn" value="Login" name="login">
				<?php
				if (isset($_POST['login'])) {
					$user = $_POST['username'];
					$pass = $_POST['password'];
					$school = $_POST['school'];

					include 'connect.php';
					$sql = oci_parse($conn, "select * from school where school = '$school'");
					oci_execute($sql);
					while ($r = oci_fetch_array($sql)) {
						$sid = $r['S_ID'];
					}
					$_SESSION['sid'] = $sid;
					$_SESSION['school'] = $school;

					$get_hos = "select * from school_users where username = '$user' and password = '$pass' and password = 'ChangePassword' and s_id=$sid";
					$get = oci_parse($conn, $get_hos);
					oci_execute($get);
					if (oci_fetch_all($get, $a) > 0) {
				?><div style="font-size:13px;
						color: green;
						position: relative;
						display:flex;
						margin-left:10px;
						text-align: center;
						justify-content:center;
						animation:button .3s linear;text-align: center;">
							<?php
							echo '<script>
Swal.fire({
	position: "center",
	icon: "info",
	title: "LOGIN SUCCESSFUL AND SET YOUR NEW PASSWORD",
	showConfirmButton: false,
	timer: 1500
  });
</script>';
							$_SESSION['username'] = $user;
							header("refresh:3;url=forgot.php");
							?>
						</div> <?php
							} else {
								$get_hos = "select * from school s join school_users u on (s.s_id=u.s_id) where u.username = '$user' and s.status = 'ACTIVE' and u.status='ACTIVE' or u.status ='ENROLLED' OR u.STATUS = 'SEMI-ENROLLED' and u.s_id = $sid ";
								//	echo $get_hos;
								$get = oci_parse($conn, $get_hos);
								oci_execute($get);
								while ($r = oci_fetch_array($get)) {
									$type = $r['TYPE'];
								}
								oci_execute($get);
								if (oci_fetch_all($get, $a) > 0) {
									$get_hos = "select * from school_users where username = '$user' and s_id=$sid ";
									$get = oci_parse($conn, $get_hos);
									oci_execute($get);
									while ($r = oci_fetch_array($get)) {
										$word = $r['PASSWORD'];
									}
									//	$pass = password_hash($pass, PASSWORD_DEFAULT);
								?><h3><?php	//echo $pass; 
										?> </h3><?php
												if (password_verify($pass, $word) == 1) {
													$get_hos = "select * from school_users where username = '$user' ";
													$get = oci_parse($conn, $get_hos);
													oci_execute($get);
													while ($r = oci_fetch_array($get)) {
														$rights = $r['RIGHTS'];
													}
													if ($rights == 'SYSADMIN') {
												?><div style="font-size:13px;
											color: green;
											position: relative;
											display:flex;
											margin-left:10px;
											text-align: center;
											justify-content:center;
											animation:button .3s linear;text-align: center;">
										<?php
														echo '<script>
														Swal.fire({
															position: "center",
															icon: "success",
															title: "LOGIN SUCCESSFUL",
															showConfirmButton: false,
															timer: 1500
														  });
														</script>';
														header("refresh:3;");
														$targetPage = '../Sys_Admin/sysadmin.php';
														//header("Location: $targetPage");
														header("refresh:3;url=$targetPage");
										?>
									</div> <?php
													} else 		if ($rights == 'REGISTRA') {

														if ($type == 'DAYCARE') {
														} else if ($type == 'PRIAMRY') {
											?><div style="font-size:13px;
															color: green;
															position: relative;
															display:flex;
															margin-left:10px;
															text-align: center;
															justify-content:center;
															animation:button .3s linear;text-align: center;">
											<?php

															echo '<script>
Swal.fire({
position: "center",
icon: "success",
title: "LOGIN SUCCESSFUL",
showConfirmButton: false,
timer: 1500
});
</script>';
															header("refresh:3;");
															$targetPage = '../Registra/registra.php';
															//header("Location: $targetPage");
															header("refresh:3;url=$targetPage");
											?>
										</div> <?php
														} else if ($type == 'JUNIOR') {
															echo 1;
												?><div style="font-size:13px;
																			color: green;
																			position: relative;
																			display:flex;
																			margin-left:10px;
																			text-align: center;
																			justify-content:center;
																			animation:button .3s linear;text-align: center;">
											<?php

															echo '<script>
Swal.fire({
	position: "center",
	icon: "success",
	title: "LOGIN SUCCESSFUL",
	showConfirmButton: false,
	timer: 1500
  });
</script>';
															header("refresh:3;");
															$targetPage = '../Jun_Registra/registra.php';
															//header("Location: $targetPage");
															header("refresh:3;url=$targetPage");
											?>
										</div> <?php
														} else if ($type == 'SECONDARY') {
												?><div style="font-size:13px;
																			color: green; 
																			position: relative;
																			display:flex;
																			margin-left:10px;
																			text-align: center;
																			justify-content:center;
																			animation:button .3s linear;text-align: center;">
											<?php
															$_SESSION['username'] = $user;
															echo '<script>
															Swal.fire({
																position: "center",
																icon: "success",
																title: "LOGIN SUCCESSFUL",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
															header("refresh:3;");
															$targetPage = '../Registra/registra.php';
															//header("Location: $targetPage");
															header("refresh:3;url=$targetPage");
											?>
										</div> <?php
														}
													} else if ($rights == 'FINANCE') {
												?><div style="font-size:13px;
															color: green;
															position: relative;
															display:flex;
															margin-left:10px;
															text-align: center;
															justify-content:center;
															animation:button .3s linear;text-align: center;">
										<?php
														echo '<script>
															Swal.fire({
																position: "center",
																icon: "success",
																title: "LOGIN SUCCESSFUL",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
														header("refresh:3;");
														$targetPage = '../Finance/finance.php';
														//header("Location: $targetPage");
														header("refresh:3;url=$targetPage");
										?>
									</div> <?php
													} else if ($rights == 'PRINCIPAL') {
											?><div style="font-size:13px;
																	color: green;
																	position: relative;
																	display:flex;
																	margin-left:10px;
																	text-align: center;
																	justify-content:center;
																	animation:button .3s linear;text-align: center;">
										<?php
														echo '<script>
															Swal.fire({
																position: "center",
																icon: "success",
																title: "LOGIN SUCCESSFUL",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
														header("refresh:3;");
														$targetPage = '../Principal/principal.php';
														//header("Location: $targetPage");
														header("refresh:3;url=$targetPage");
										?>
									</div> <?php
													} else if ($rights == 'TEACHER') {
											?><div style="font-size:13px;
																				color: green;
																				position: relative;
																				display:flex;
																				margin-left:10px;
																				text-align: center;
																				justify-content:center;
																				animation:button .3s linear;text-align: center;">
										<?php
														echo '<script>
															Swal.fire({
																position: "center",
																icon: "success",
																title: "LOGIN SUCCESSFUL",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
														header("refresh:3;");
														$targetPage = '../Teacher/teacher.php';
														//header("Location: $targetPage");
														$sql = oci_parse($conn, "select * from employee where username = '$user' ");
														oci_execute($sql);
														while ($r = oci_fetch_array($sql)) {
															$emp_id = $r['EMP_ID'];
														}
														$_SESSION['emp_id'] = $emp_id;
														header("refresh:3;url=$targetPage");
										?>
									</div> <?php
													} else if ($rights == 'STUDENT') {
											?><div style="font-size:13px;
																	color: green;
																	position: relative;
																	display:flex;
																	margin-left:10px;
																	text-align: center;
																	justify-content:center;
																	animation:button .3s linear;text-align: center;">
										<?php
														//		echo "SELECT STUD_ID FROM STUDENT WHERE STDNUMBER = '$user'";
														$sql = oci_parse($conn, "SELECT STUD_ID FROM STUDENT WHERE STDNUMBER = '$user' OR STUD_ID ='$user' ");
														oci_execute($sql);
														while ($row = oci_fetch_array($sql)) {
															$stud_id = $row['STUD_ID'];
															//	echo $stud_id;
														}
														$_SESSION['username'] = $stud_id;
														echo '<script>
														Swal.fire({
															position: "center",
															icon: "success",
															title: "LOGIN SUCCESSFUL",
															showConfirmButton: false,
															timer: 1500
														  });
														</script>';
														header("refresh:3;");
														$targetPage = '../Student/student.php';
														//header("Location: $targetPage");
														header("refresh:3;url=$targetPage");
										?>
									</div> <?php
													}
												} else {
											?><div style="font-size:13px;
										color: red;
										position: relative;
										display:flex;
										margin-left:10px;
										text-align: center;
										justify-content:center;
										animation:button .3s linear;text-align: center;">
									<?php

													echo '<script>
Swal.fire({
	position: "center",
	icon: "error",
	title: "WRONG USERNAME OR WRONG PASSWORD",
	showConfirmButton: false,
	timer: 1500
  });
</script>';

													header("refresh:3;");
									?>
								</div> <?php
												}
											} else {
										?><div style="font-size:13px;
						color: red;
						position: relative;
						display:flex;
						margin-left:10px;
						text-align: center;
						justify-content:center;
						animation:button .3s linear;text-align: center;">
								<?php
												echo '<script>
								Swal.fire({
									position: "center",
									icon: "error",
									title: "SCHOOL OR USER IS INACTIVE",
									showConfirmButton: false,
									timer: 1500
								  });
								</script>';

												header("refresh:3;");
								?>
							</div> <?php
											}
										}
									}
									?>
			</form>
		</div>
		<footer style=" color: #1D5B79; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; font-size: 16px;">
			<p style="margin: 0;">Developed and Powered By Nifty ICT Solutions Ltd</p>
			<p style="margin: 0;">Phone: +2209067411 | Website: www.niftyict.com | Email: enquiries@niftyict.com</p>

		</footer>
	</div>

	<script type="text/javascript" src="js/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<?php //header("refresh:300;url=Academix.php");
	?>
</body>

</html>