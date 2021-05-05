

<?php

	require('config.php');
	require('CSRFgeneratetoken.php');
	require('CSRFvalidatetoken.php');

	//filters post variables from special chacarters and html tags
	require('filter.php');

	//if user not logged in or user_type=employee go to sign in page
	if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email']) || !isset($_SESSION['user_email']) || !($_SESSION['user_type'] == 'Supervisor')  ) {
		header('Location: index.php');
		exit();
	}

  $predifined_firstname='';
	$predifined_lastname='';
	$predifined_myuseremail='';
	$predifined_myusertype='';
  if ( isset($_POST['myuserfirstname']) && isset($_POST['myuserlastname']) && isset($_POST['myuseremail']) && isset($_POST['myusertype']) )
	{
	$predifined_firstname=$_POST['myuserfirstname'];
	$predifined_lastname=$_POST['myuserlastname'];
	$predifined_myuseremail=$_POST['myuseremail'];
	$predifined_myusertype=$_POST['myusertype'];
  }

	$e_msg='';
	if (isset($_POST['myid']))
	{
		$_SESSION['property']=intval($_POST['myid']);
	}
	if ( isset($_POST['update_lastname']) && isset($_POST['update_firstname']) && isset($_POST['update_email']) && isset($_POST['update_usertype']) )
	{

	$update_lastname=$_POST['update_lastname'];
	$update_firstname=$_POST['update_firstname'];
	$update_email=$_POST['update_email'];
	$update_usertype=$_POST['update_usertype'];


		if (isset($_POST['update_password']) && isset($_POST['update_confirmpassword']) && !empty($_POST['update_password']) && !empty($_POST['update_confirmpassword']))
		{
			$update_password=$_POST['update_password'];
			$update_confirmpassword=$_POST['update_confirmpassword'];

			if ($update_password == $update_confirmpassword)
			{
				try {
						$hashed_password = password_hash($update_password, PASSWORD_DEFAULT);
						$stmt = $DB->prepare(" UPDATE users SET firstname=?, lastname=?, email=? , password=? , user_type=?  WHERE id=? ");
 				    $stmt->execute([$update_firstname, $update_lastname, $update_email,$hashed_password,$update_usertype,$_SESSION['property']]);
 		        $e_msg = '<div class="alert alert-success" role="alert">
   Your user properties Has been successfully updated !
 </div>' ;

 		     }catch (Exception $ex) {
					 $e_msg = '<div class="alert alert-danger" role="alert">
	 This email is already registered
	</div>';
 		   }
			}
			else if ($update_password != $update_confirmpassword)
			{
				$e_msg='<div class="alert alert-danger" role="alert">
		Passwords are not identical . Please try again !
 </div>';
			}
		}
		else
		{
			try {

					$stmt = $DB->prepare("UPDATE users SET firstname=?, lastname=?, email=?,user_type=?  WHERE id=?");
					$stmt->execute([$update_firstname, $update_lastname, $update_email,$update_usertype,$_SESSION['property']]);
				 $e_msg = '<div class="alert alert-success" role="alert">
 Your user properties Has been successfully updated !
</div>' ;

			 } catch (Exception $ex) {
				 $e_msg = '<div class="alert alert-danger" role="alert">
 This email is already registered
</div>';
		 }
		}
		//initialize predefined input fields with new user properties
		$predifined_firstname=$update_firstname;
		$predifined_lastname=$update_lastname;
		$predifined_myuseremail=$update_email;
		$predifined_myusertype=$update_usertype;

		}
?>



<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Time off Application</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" type="text/css">
      <link
         href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
         rel="stylesheet">
      <link href="assets/css/dashboard.css" rel="stylesheet">
   </head>
   <body id="page-top">
      <!-- Page Wrapper -->
      <div id="wrapper">
         <!-- Sidebar -->
         <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="adminstratordashboard.php">
               <div class="sidebar-brand-icon rotate-n-15">
                  <i class="fas fa-graduation-cap"></i>
               </div>
               <div class="sidebar-brand-text mx-3">Time <sup>off</sup></div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
               <a class="nav-link" href="adminstratordashboard.php">
               <i class="fas fa-fw fa-tachometer-alt"></i>
               <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
               Menu
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
               <a class="nav-link " href="adminstratordashboard.php"
                  aria-expanded="true" aria-controls="collapsePages">
               <i class="fas fa-fw fa-folder"></i>
               <span>Users</span>
               </a>
            </li>
            <!-- Nav Item - Charts -->
            <li class="nav-item">
               <a class="nav-link" href="createuserform.php">
               <i class="fas fa-fw fa-chart-area"></i>
               <span>Create User</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Heading -->
            <div class="sidebar-heading">
               Δείτε επίσης
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
               <a class="nav-link " href="https://thanoskipriadis.eu"
                  aria-expanded="true" aria-controls="collapsePages">
               <i class="fas fa-fw fa-folder"></i>
               <span>Portfolio</span>
               </a>
            </li>
            <!-- Nav Item - Charts -->
            <li class="nav-item">
               <a class="nav-link" href="https://www.linkedin.com/in/athanasios-kipriadis-9904611b8/">
               <i class="fas fa-fw fa-chart-area"></i>
               <span>Linkedin</span></a>
            </li>
            <!-- Nav Item - Tables -->
            <li class="nav-item">
               <a class="nav-link" href="https://github.com/iKipris">
               <i class="fas fa-fw fa-table"></i>
               <span>GitHub</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
               <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
         </ul>
         <!-- End of Sidebar -->
         <!-- Content Wrapper -->
         <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
               <!-- Topbar -->
               <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                  <!-- Sidebar Toggle (Topbar) -->
                  <button id="sidebarToggleTop" class="btn btn-link d-md-none colorbar rounded-circle mr-3">
                  <i class="fa fa-bars"></i>
                  </button>
                  <!-- Topbar Search -->
                  <div id="mysearchbar" class="d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                     <div class="input-group">
                        <button onclick="window.location.href='adminstratordashboard.php'" class="btn d-inline btn-primary search-icon" type="button">
                           <h6 class="d-inline">Go back</h6>
                           <i class="fas fa-sign-out-alt fa-sm d-inline"></i>
                        </button>
                     </div>
                  </div>
                  <!-- Topbar Navbar -->
                  <div>
                     <ul class="navbar-nav ml-left">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                           <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <span style="font-weight:400; color:#202020;" class="mr-2 d-none d-lg-inline small"><?php echo ($_SESSION['user_name']);  ?></span>
                           <img src= 'assets/img/avatar7.png' class='img-profile rounded-circle'>
                           </a>
                           <!-- Dropdown - User Information -->
                           <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                              aria-labelledby="userDropdown">
                              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                              <i  class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                              Logout
                              </a>
                           </div>
                        </li>
                     </ul>
                  </div>
               </nav>
               <!-- End of Topbar -->
               <!-- Begin Page Content -->
               <div  id="formContent" class="">
                  <div class="container-fluid mb-5">
                     <!-- Page Heading -->
                     <div id="pageheading" class="d-sm-flex align-items-center text-center justify-content-between mb-4">
                        <div  class="m-auto">
                           <h3 class="text-dark">Update User</h3>
                           <?php echo $e_msg ?>
                        </div>
                     </div>
                     <!-- /.container-fluid -->
                  </div>
                  <div class="container pt-5">
                     <div class="row">
                        <div class="col-xl-8 col-lg-7">
                           <div class="card shadow mb-4">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                 <h6 class="card-heading m-0 font-weight-bold text-primary">Update Form</h6>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body mobile-height overflow-auto ">
                                 <div class="chart-area ">
                                    <div class="col-lg-12">
                                       <form method="POST">
                                          <div class="form-group">
                                             <label > User Name</label>
                                             <input value="<?php echo $predifined_firstname ; ?>"  type="text" required class="form-control" name="update_firstname" placeholder="">
                                          </div>
                                          <div class="form-group">
                                             <label > Last name</label>
                                             <input value="<?php echo $predifined_lastname ; ?>" type="text" required class="form-control" name="update_lastname" placeholder="">
                                          </div>
                                          <div class="form-group">
                                             <label> Email</label>
                                             <input value="<?php echo $predifined_myuseremail ; ?>" type="text" required class="form-control" name="update_email" placeholder="">
                                          </div>
                                          <div class="form-group">
                                             <label > User Type</label>
                                             <select required class="custom-select" name="update_usertype">
                                                <option hidden id="populateselect" value="<?php echo $predifined_myusertype ; ?>" ></option>
                                                <option id="selectSuper" value="Supervisor">Supervisor</option>
                                                <option id="selectEmploy" value="Employee">Employee</option>
                                             </select>
                                          </div>
                                          <div class="form-group">
                                             <label > Password</label>
                                             <input value=""  type="password"  class="form-control" name="update_password" placeholder="">
                                          </div>
                                          <div class="form-group">
                                             <label > Confirm Password</label>
                                             <input value="" type="password"  class="form-control" name="update_confirmpassword" placeholder="">
                                          </div>
                                          <input type="hidden" name="csrf_token" value="<?php echo generate_token();?>" />
                                          <button type="submit" class="btn r btn-primary">Update</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                           <div class="  mb-4">
                              <!-- Card Header - Dropdown -->
                              <!-- Card Body -->
                              <div class="card-body mobile-height overflow-auto">
                                 <div class="chart-area ">
                                    <div class="col-md-12">
                                       <div class="panel ">
                                          <div class="panel-body text-center  ">
                                             <div>
                                                <img src= 'assets/img/palm-tree-exotic-vacation-49975.png' style="max-width:100%; height:600px;" >
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Area Chart -->
                     </div>
                  </div>
               </div>
               <!-- End of Main Content -->
               <!-- Footer -->
               <footer id="myfooter" class="sticky-footer bg-white">
                  <div class="container my-auto">
                     <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Thanos Kipriadis </span>
                     </div>
                  </div>
               </footer>
               <!-- End of Footer -->
               <!-- End of Content Wrapper -->
            </div>
            <!-- End of Page Wrapper -->
         </div>
         <!-- Logout Modal-->
         <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                  <div class="modal-footer">
                     <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                     <a  class="btn btn-primary" href="logout.php">Logout</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script>
         document.getElementById("sidebarToggleTop").addEventListener("click", function() {
            console.log(document.getElementById("accordionSidebar").classList);

            if (document.getElementById("accordionSidebar").classList.contains("toggled")) {

               document.getElementById("pageheading").hidden = true;
               document.getElementById("myfooter").hidden = true;
               document.getElementById("formContent").hidden = true;
               $('#content-wrapper').addClass('myoverlay');
               document.getElementById("mysearchbar").hidden = true;
            } else {
               document.getElementById("pageheading").hidden = false;
               document.getElementById("myfooter").hidden = false;
               document.getElementById("formContent").hidden = false;
               $('#content-wrapper').removeClass('myoverlay');
               document.getElementById("mysearchbar").hidden = false;
            }
         });

         //assign select to php post variable user type
         check=document.getElementById("populateselect").value;
         if (check === 'Employee')
         {
         	document.getElementById('selectEmploy').setAttribute('selected','selected');
         }
         else if (check === 'Supervisor')
         {
         document.getElementById('selectSuper').setAttribute('selected','selected');
         }

      </script>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <!-- Custom scripts for all pages-->
      <script src="assets/js/custom.js"></script>
   </body>
</html>
