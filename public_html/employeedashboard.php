<?php
require ('config.php');
require ('CSRFgeneratetoken.php');
require ('CSRFvalidatetoken.php');
$e_msg = '';

//filter removes html tags
foreach ($_POST as $key => $value)
{
   $value = filter_var($value, FILTER_SANITIZE_STRING);
   $value = clean($value);
   $_POST[$key] = $value;
}
//filter removes html tags
foreach ($_GET as $key => $value)
{
   $value = filter_var($value, FILTER_SANITIZE_STRING);
   $value = clean($value);
   $_POST[$key] = $value;
}
//remove special characters but allow spaces
function clean($string)
{
   return preg_replace('/[^A-Za-z0-9\-@.\s]/', '', $string); // Removes special chars .
}

//if user not logged in or user_type=supervisor go to sign in page
if (!(isset($_SESSION['user_name'])) || !(isset($_SESSION['user_email'])) || !($_SESSION['user_type'] == 'Employee'))
{
   header('Location: index.php');
   exit();
}

//send email to supervisor for application + insert application
if (isset($_POST['dateto']) && isset($_POST['datefrom']) && isset($_POST['reason']))
{
   $bytes = random_bytes(16);
   $email_id_handler = bin2hex($bytes);
   $acceptlink = "http://{$_SERVER['SERVER_NAME']}/public_html/requesthandler.php?application_string={$email_id_handler}&answer=yes";
   $rejectlink = "http://{$_SERVER['SERVER_NAME']}/public_html/requesthandler.php?application_string={$email_id_handler}&answer=no";
   $status = 'Pending';
   $dateto = $_POST['dateto'];
   $datefrom = $_POST['datefrom'];
   $reason = $_POST['reason'];
   //connect to database and insert
   try
   {
      $stmt = $DB->prepare(' INSERT INTO applications (user_email,status,date_from,date_to,reason,email_handler) VALUES (?,?,?,?,?,?) ');
      $stmt->execute([$_SESSION['user_email'], $status, $datefrom, $dateto, $reason, $email_id_handler]);
      $supervisorsemails = array();
      $supervisorname = array();

      // find a random supervisor email
      $stmt = $DB->prepare("SELECT * FROM users WHERE user_type='Supervisor'");
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      //search in database for user
      foreach ($results as $result)
      {
         array_push($supervisorsemails, $result['email']);
         array_push($supervisorname, $result['firstname'] . ' ' . $result['lastname']);
      }

      $random = mt_rand(0, count($supervisorsemails) - 1);

      $subject = 'Time off request';
      $body = "Dear supervisor, employee <strong>{$_SESSION['user_name']}</strong> requested  some time off" . "<br>" . "Starting on
			 <strong>{$datefrom}</strong> and ending on <strong>{$dateto}</strong>" . "<br>" . "Stating the reason: <strong>{$reason}</strong>" . "<br>" . "Click on one of the below links to approve or reject the application:" . "<br>" . "{$acceptlink}    -    {$rejectlink}";
      //var_dump($supervisorsemails[$random], $supervisorname[$random]);
      // Mail Headers
      $headers = array();
      $headers[] = "MIME-Version: 1.0";
      $headers[] = "Content-type: text/html; charset=iso-8859-1";
      $headers[] = "From: {$_SESSION['user_email']} <no.reply.application.timeoff@gmail.com>";
      $headers[] = "Reply-To: {$_SESSION['user_name']} <{$_SESSION['user_email']}>";
      $headers[] = "Subject: ";
      $headers[] = "X-Mailer: PHP/" . phpversion();

      //email to a random supervisor email for production
      //$toMail= "{$supervisorname[$random]} <{$supervisorsemails[$random]}>";
      $toMail = "<{$supervisorsemails[$random]}>";

      //email to an existing supervisor email for testing
      //$toMail= "<t.kipriadis@gmail.com}>";
      mail($toMail, $subject, $body, implode("\r\n", $headers));
      $e_msg = '<div class="alert d-inline-block alert-success" role="alert">
Your application Has been successfully created !
</div>';

   }
   catch(Exception $ex)
   {
      $e_msg = '<div class="alert d-inline-block alert-danger" role="alert">
	Something seems be wrong about your application!
	Please try again !
</div>';
   }

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="employeedashboard.php">
               <div class="sidebar-brand-icon rotate-n-15">
                  <i class="fas fa-graduation-cap"></i>
               </div>
               <div class="sidebar-brand-text mx-3">Time <sup>off</sup></div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
               <a class="nav-link" href="employeedashboard.php">
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
               <a class="nav-link " href="employeedashboard.php"
                  aria-expanded="true" aria-controls="collapsePages">
               <i class="fas fa-fw fa-folder"></i>
               <span>Applications</span>
               </a>
            </li>
            <!-- Nav Item - Charts -->
            <li class="nav-item">
               <a class="nav-link" href="createapplicationform.php">
               <i class="fas fa-fw fa-chart-area"></i>
               <span>Create Application</span></a>
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
                     <button  onclick="window.location.href='createapplicationform.php'" id="pageheading" type="button" class="btn m-auto btn-primary">
                        Create  Application
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                           <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                           <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                     </button>
                  </div>
                  <div  class="m-auto w-auto text-center">
                     <?php echo ($e_msg); ?>
                  </div>
                  <div  id="myItems">
                     <div id="disp" class="">
                        <?php
                           $email=$_SESSION['user_email'];
                           try {
                               $stmt = $DB->prepare('SELECT * FROM applications WHERE user_email =? ORDER BY date_submitted DESC LIMIT 40');
                               $stmt->execute([$email]);
                               $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                               //search in database for user
                               foreach ($results as $result) {
                                    //calculate date_diff bettween date_from and date_to
                                    $date1= $result['date_from'];
                                    $date2= $result['date_to'];
                                    $diff = strtotime($date2) - strtotime($date1);
                                    $datediff= abs(round($diff / 86400));

                                //User Not found condition
                                $myitems = '<div class="card shadow mb-4">
                                   <!-- Card Header - Dropdown -->
                                   <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                      <h6 class="card-heading m-0 font-weight-bold text-primary">Application ID: ' . $result['application_id'] . '</h6>
                                   </div>
                                   <!-- Card Body -->
                                   <div class="card-body">
                                      <div class="container">


                                         <div class="row">
                                            <div class="col-12 col-md-6 text-xs-center">
                                               <h5 class="card-title text-dark">Dates: '  . $result['date_from'] . ' to ' . $result['date_to'] .  ' </h5>
                                               <h6 class="card-subtitle mb-2 text-muted">Submitted: ' . $result['date_submitted'] . '</h6>
                                               <h6 class="card-subtitle mb-2 text-muted">Days requested : '  . $datediff . ' </h6>

                                            </div>
                                            <div class="col-12 col-md-6 text-xs-center margin-top-xs">
                                               <div class="class-card">
                                                  <div class="alert alert-success" role="alert">
                                                     ' . $result['status'] . '
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
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

         					 if (check.includes("Rejected") )
         					 {
         						  elements[i].classList.add("alert-danger");
         							elements[i].classList.remove("alert-sucess");

         					 }
                   else if (check.includes("Pending"))
                   {
                     elements[i].classList.add("alert-warning");
                     elements[i].classList.remove("alert-sucess");
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


      </script>
   </body>
</html>
