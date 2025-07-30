<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Matua Community</title>
      <link rel="shortcut icon" type="image/png" href="images/fav.png">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/themify-icons.css">
      <link rel="stylesheet" href="css/animate.css">
      <link rel="stylesheet" href="css/styles.css">
      <link rel="stylesheet" href="css/green.css" id="style_theme">
      <link rel="stylesheet" href="css/responsive.css">
      <link rel="stylesheet" href="css/jquery-jvectormap.css">
      <link rel="stylesheet" href="datatable/dataTables.bootstrap4.min.css">
   </head>
   <style>
      .navbar-nav li:hover > ul.dropdown-menu {
      display: block;
      }
      .dropdown-submenu {
      position:relative;
      }
      .dropdown-submenu>.dropdown-menu {
      top:0;
      left:94%;
      margin-top:0px;
      }
      /* rotate caret on hover */
      .dropdown-menu > li > a:hover:after {
      text-decoration: underline;
      transform: rotate(-90deg);
      } 
      ul.dropdown-menu li a { background: transparent; }
   </style>
   <body>
      <div class="header">
         <div class="top-brand">
            <nav class="navbar navbar-default">
               <div class="navbar-header">
                  <div class="sidebar-header">
                     <div class="row">
                        <div class="col-lg-3"><a href="index.php"><img src="images/logo.png" class="logo" alt="logo"></a></div>
                        <div class="col-lg-9 mt-4"><span class="logo_name" style="padding-top:80px;">Matua Community</span></div>
                     </div>
                  </div>
               </div>
               <ul class="nav justify-content-end">
                  <li class="nav-item">
                     <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                     <span class="ti-user"></span>
                     </a>
                     <div class="dropdown-menu proclinic-box-shadow2 profile animated flipInY">
                        <h5>Debalina Chatterjee</h5>
                        <a class="dropdown-item" href="#">
                        <span class="ti-settings"></span> Settings</a>
                        <a class="dropdown-item" href="#">
                        <span class="ti-help-alt"></span> Help</a>
                        <a class="dropdown-item" href="#">
                        <span class="ti-power-off"></span> Logout</a>
                     </div>
                  </li>
               </ul>
            </nav>
         </div>
         <div class="menu-nav">
            <nav class="navbar navbar-expand-lg proclinic-bg text-white">
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="ti-menu text-white"></span>
               </button>				
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav">
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="ti-id-badge"></span> Master Data</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                           <li class="dropdown-submenu">
                              <a class="dropdown-item dropdown-toggle" href="#">DM Office</a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="DM_office.php">DM Office Creation</a></li>
                                 <li><a class="dropdown-item" href="DM_List.php">List</a></li>
                              </ul>
                           </li>
                           <li class="dropdown-submenu">
                              <a class="dropdown-item dropdown-toggle" href="#">Executive Agency</a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="vendor.php">Executive Agency Creation</a></li>
                                 <li><a class="dropdown-item" href="vendor_list.php">Executive Agency Creation List</a></li>
                              </ul>
                           </li>
                           <li class="dropdown-submenu">
                              <a class="dropdown-item dropdown-toggle" href="#">Scheme</a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="Scheme.php">Scheme Creation</a></li>
                                 <li><a class="dropdown-item" href="Scheme_List.php">Scheme Creation List</a></li>
                              </ul>
                           </li>
                        </ul>
                     </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><span class="ti-write"></span> Requisition Creation</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                           <li class="dropdown-submenu">
                              <a class="nav-link" href="requsition.php">Requisition</a>
                              <a class="nav-link" href="req_List.php">List</a>
                           </li>
                        </ul>                        
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="DM_office_req_approval_List.php"><span class="ti-files"></span>D.M. Requisition Approval List</a>
                     </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><span class="ti-credit-card"></span>Installment</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                           <li class="dropdown-submenu">
                              <a class="nav-link" href="installment_list.php">Payment Installment</a>
                              <a class="nav-link" href="payment_list.php">Payment List</a>
                           </li>
                        </ul>
                     </li>
                  </ul>
               </div>
            </nav>
         </div>
      </div>
   </body>
</html>