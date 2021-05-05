<?php
require ('config.php');
require ('CSRFgeneratetoken.php');
require ('CSRFvalidatetoken.php');
require ('filter.php');

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email']) || !isset($_SESSION['user_email']) || !($_SESSION['user_type'] == 'Supervisor'))
{
   header('Location: index.php');
   exit();
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
               <span>Create user</span></a>
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
                        <input type="text" id="myFilter" onkeyup="myFunction()" class="form-control bg-light border-0 small" placeholder="Search for..."
                           aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                           <button class="btn btn-primary search-icon" type="button">
                           <i class="fas fa-search fa-sm"></i>
                           </button>
                        </div>
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
               <div class="container-fluid">
                  <!-- Page Heading -->
                  <div  class="d-sm-flex align-items-center text-center justify-content-between mb-4">
                     <button onclick="window.location.href='createuserform.php'" id="pageheading" type="button" class="btn m-auto btn-primary">
                        Create  User
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                           <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                           <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                     </button>
                  </div>
                  <div  id="myItems">
                     <div >
                        <form hidden id="propertiesform" action="propertiespage.php" method="POST">
                           <input  type="text" id="myuseremail"  name="myuseremail" readonly="readonly" >
                           <input  type="text" id="myuserlastname"  name="myuserlastname" readonly="readonly" >
                           <input  type="text" id="myuserfirstname"  name="myuserfirstname" readonly="readonly" >
                           <input  type="text" id="myusertype"  name="myusertype" readonly="readonly" >
                           <input  type="text" id="myid"  name="myid" readonly="readonly" >
                           <input type="hidden" name="csrf_token" value="<?php echo generate_token();?>" />
                           <input  type="submit" value="Send Request">
                        </form>
                     </div>
                     <div id="disp" class="">
                        <?php
                           try {
                           		$stmt = $DB->prepare('SELECT * FROM users');
                           		$stmt->execute();
                           		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                           		$counter=0;
                           		//search in database for user
                           		foreach ($results as $result) {
                           			$counter = $counter +1;
                           		 //User Not found condition
                           		 $myitems = '<div class="card shadow mb-4"  style="cursor: pointer;">
                           				<!-- Card Header - Dropdown -->
                           				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                           					 <h6 class="card-heading m-0 font-weight-bold text-primary">' . $result['firstname'] . ' ' . $result['lastname'] .  '</h6>
                           				</div>
                           				<!-- Card Body -->
                           				<div class="card-body">
                           					 <div class="container">
                           							<div class="row">
                           								 <div class="col-12 col-md-6 text-xs-center">
                           										<h5 class="card-title text-dark">First name : ' . $result['firstname'] . ' </h5>
                           										<h6 class="card-subtitle mb-2 text-muted pseudoclass2">Last name : ' . $result['lastname'] . ' </h6>
                           										<h6 class="card-subtitle mb-2 text-muted pseudoclass">Email : '. $result['email'] . '</h6>
                           										<h6 hidden class="card-subtitle mb-2 text-muted pseudoclass3">'. $result['id'] . '</h6>

                           								 </div>
                           								 <div class="col-12 col-md-6 text-xs-center">
                           										<div class="class-card">

                           											 <div class="alert alert-success" role="alert">
                           													'. $result['user_type'] . '
                           													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                           <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                           </svg>
                           											 </div>
                           										</div>
                           								 </div>
                           							</div>
                           					 </div>
                           				</div>
                           		 </div>' ;

                           echo $myitems;
                           		}



                           	}catch (Exception $ex) {
                           	$e_msg = $ex->getMessage();
                           }
                            ?>
                     </div>
                  </div>
                  <!-- /.container-fluid -->
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
            </div>
            <!-- End of Content Wrapper -->
         </div>
         <!-- End of Page Wrapper -->
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

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <!-- Custom scripts for all pages-->
      <script src="assets/js/custom.js"></script>
      <script>
			function myFunction() {
						var input, filter, myItems, cards, i, current, h5, text,h6;
						input = document.getElementById("myFilter");
						filter = input.value.toUpperCase();
						myItems = document.getElementById("myItems");
						cards = myItems.getElementsByClassName("card");
						var counter=0;
						for (i = 0; i < cards.length; i++) {

									current = cards[i];
									h5 = current.getElementsByClassName('card-title')[0];
									h6 = current.getElementsByClassName('card-subtitle')[0];
									h7 = current.getElementsByClassName('card-heading')[0];
									h9 = current.getElementsByClassName('alert')[0];
									text = h5.innerText.toUpperCase().replace(/\s/g, "");
									text1=h6.innerText.toUpperCase().replace(/\s/g, "");
									text2=text + text1;
									text3=text1+text;
									text4=h7.innerText.toUpperCase().replace(/\s/g, "");
									text5=h9.innerText.toUpperCase().replace(/\s/g, "");

									filter=filter.replace(/\s/g, "");



									if  ((text.includes(filter)) || (text1.includes(filter))  || (text2.includes(filter)) ||  (text3.includes(filter)) || (text4.includes(filter)) || (text5.includes(filter)) ) {
												current.style.display = "";
												++counter;
									} else {
												current.style.display = "none";
									}

									}

									var layoutdisp=document.getElementById('disp');
									if (window.innerWidth>1196)
									{
									if (counter == 1)
									{
											layoutdisp.classList.remove("grid-container");
											layoutdisp.classList.add("col-lg-12");
									}
									else
									{

											layoutdisp.classList.remove("col-lg-12");
											layoutdisp.classList.add("grid-container");
									}
									}
									counter=0;


			}
				 var elements = document.getElementsByClassName("alert");

				 for (var i=0 ; i < elements.length ; i++)
				 {
					 var check = elements[i].innerText;

					 if (check.includes("Supervisor") )
					 {
						  elements[i].classList.add("alert-info");
							elements[i].classList.remove("alert-success");

					 }
				 }

		  $(window).bind("resize", function() {

      if ($(this).width() < 1179) {
         $('#disp').removeClass('grid-container').addClass('col-lg-12')
      } else {
         $('#disp').removeClass('col-lg-12').addClass('grid-container')
      }
	  })

	  if ($(this).width() < 1179) {
         $('#disp').removeClass('grid-container').addClass('col-lg-12')
      } else {
         $('#disp').removeClass('col-lg-12').addClass('grid-container')
      }

   document.getElementById("sidebarToggleTop").addEventListener("click", function() {
      console.log(document.getElementById("accordionSidebar").classList);

      if (document.getElementById("accordionSidebar").classList.contains("toggled")) {

         document.getElementById("pageheading").hidden = false;
         document.getElementById("myfooter").hidden = false;
         document.getElementById("disp").hidden = false;
         $('#content-wrapper').removeClass('myoverlay');
         document.getElementById("mysearchbar").hidden = false;
      } else {
         document.getElementById("pageheading").hidden = true;
         document.getElementById("myfooter").hidden = true;
         document.getElementById("disp").hidden = true;
         $('#content-wrapper').addClass('myoverlay');
         document.getElementById("mysearchbar").hidden = true;
      }
   });

	 $(".card").click(function(event){

   event.preventDefault();
   var myemail=$(this).closest('.card').find('.pseudoclass').text().replace('Email : ','').trim();
	 var myfirstname=$(this).closest('.card').find('.card-title').text().replace('First name : ','').trim();
	 var mylastname=$(this).closest('.card').find('.pseudoclass2').text().replace('Last name : ','').trim();
	 var myusertype=$(this).closest('.card').find('.alert').text().trim();
	 var myid=$(this).closest('.card').find('.pseudoclass3').text().trim();
   document.getElementById("myuseremail").value=myemail;
	 document.getElementById("myuserfirstname").value=myfirstname;
	 document.getElementById("myuserlastname").value=mylastname;
	 document.getElementById("myusertype").value=myusertype;
	 document.getElementById("myid").value=myid;
	 if(myemail && myfirstname && mylastname && myusertype && myid)
	{
	document.getElementById("propertiesform").submit();
	}

});


      </script>
   </body>
</html>
