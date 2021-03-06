<?php

	@require_once("../modul/session.php");
	require_once("../modul/class.user.php");
	$auth_user = new USER();

	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
    $tingkatan=$userRow['tingkatan'];
    $namapengguna=$userRow['user_name'];
    $kelas=$userRow['kelas'];
    $namapenuh=$userRow['real_name'];
    $kodsekolah=$userRow['kodsekolah'];
    $kodppd=$userRow['kodppd'];
    $kodnegeri=$userRow['kodnegeri'];
    $userlevel=$userRow['userlevel'];



    $sqln = $auth_user->runQuery("SELECT * FROM tkppd  WHERE KODPPD=:kodppd");
	$sqln->execute(array(":kodppd"=>$kodppd));
    $sqlnRow=$sqln->fetch(PDO::FETCH_ASSOC);
    $namappd=$sqlnRow['NAMAPPD'];



 @$id= $_GET['id'];

if($userlevel=="15"){

if(!empty($_POST["save_record"])) {

    
  
	//--------------------------- carian untuk nokp yg dah didaftarkan --------------	
	$admin =  $auth_user->runQuery("SELECT * FROM sisc_guru WHERE NOKP= :nokp ");
        
    $admin->bindParam(':nokp',$nokp);
    
    
    
	$admin->execute();
	$kira = $admin->rowCount();
	if($kira > 0){
		$userRow=$admin->fetch(PDO::FETCH_ASSOC);
        $namaguru=$userRow['NAMAGURU'];
		$nokp=$userRow['NOKP'];
         
  

        
		
     echo "<script>alert('Nama Guru $namaguru telah dihantar, sila buat semakan.');</script>";
	}else{		
          
    
    
    
$sql = $auth_user->runQuery("INSERT INTO sisc_guru
        (SISC,NOKP,NAMAGURU,KODSEKOLAH,KODPPD,TARIKHAKTIF) VALUES (:1,:2,:3,:4,:5,:6)"); 
    
        $namapengguna=$_POST['SISC'];
        $nokp=$_POST['NOKP'];
		$nama= $_POST['NAMAGURU'];
        $kodsekolah=$_POST['KODSEKOLAH'];
		$kodppd= $_POST['KODPPD'];
    
   

       // $dari=$_POST['TARIKHAKTIF'];
    
         $dari_hari = $_POST['dari_hari'];
         $dari_bulan = $_POST['dari_bulan'];
         $dari_tahun = $_POST['dari_tahun'];
         $dari_jam = "00";
         $dari_minit = "00";

           $dari = $dari_tahun."-".$dari_bulan."-".$dari_hari." ".$dari_jam.":".$dari_minit.":00";
    

          $nama = strtoupper($nama); 
         
        $sql->bindParam(':1',$namapengguna);
        $sql->bindParam(':2',$nokp);
		$sql->bindParam(':3',$nama);
        $sql->bindParam(':4',$kodsekolah);
		$sql->bindParam(':5',$kodppd);
        $sql->bindParam(':6',$dari);
       
    
		if($sql->execute()) {
			$success_message = "Added Successfully";
            
             header("Location: index.php?id=senaraiguru");
             
            
		} else {
			$error_message = "Problem in Adding New Record";
		}
    
}    
    
}
 

if(!empty($_POST["save_record2"])) {
	

$status=isset($_POST['STATUS']) ? $_POST['STATUS'] : null; 
$tarikhmula=isset($_POST['TARIKHSTATUS']) ? $_POST['TARIKHSTATUS'] : null; 
   
$nokp=isset($_GET['NOKP']) ? $_GET['NOKP'] :null;  
$tarikhmula=isset($_GET['TARIKHSTATUS']) ? $_GET['TARIKHSTATUS'] :null; 
    
           $dari_hari = $_POST['dari_hari'];
           $dari_bulan = $_POST['dari_bulan'];
           $dari_tahun = $_POST['dari_tahun'];
           

           $tarikhmula = $dari_tahun."-".$dari_bulan."-".$dari_hari;  
    
    
    
	$pdo_statement=$auth_user->runQuery("update sisc_guru set STATUS=:status,TARIKHSTATUS=:tarikhmula
    
    where NOKP=:nokp");
  
    $pdo_statement->bindParam(':status',$status); 
    $pdo_statement->bindParam(':tarikhmula',$tarikhmula); 
    
    $pdo_statement->bindParam(':nokp',$nokp);
	$result = $pdo_statement->execute();
    
	if($result) {
 header("Location: ../modulsisc/index.php?id=senaraiguru");
	}
}

    
    
    
    
    
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Sistem Pengurusan Maklumat Pencen Pegawai dan AKP PPD Kluang</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    
     <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="../plugins/bower_components/tablesaw-master/dist/tablesaw.css" rel="stylesheet">
    
    
    
    
    
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
    <!-- fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-gmail"></i>
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
                                   
                             
                                    
                                </div>
                            </li>
                            <li>
                                <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- .Task dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-check-circle"></i>
                            <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                        </a>
                        <ul class="dropdown-menu dropdown-tasks animated slideInUp">
                            <li>
                                <a href="#">
                                    <div>
                                        <p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p> <strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"> <span class="sr-only">20% Complete</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p> <strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> <span class="sr-only">60% Complete (warning)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p> <strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> <span class="sr-only">80% Complete (danger)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </li>
                    <!-- .Megamenu -->
                    <li class="mega-dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><span class="hidden-xs">Menu SISC+</span> <i class="icon-options-vertical"></i></a>
                        <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Perihal</li>
                                    <li><a href="#">SISC+ KPM</a></li>
                                  
                                </ul>
                            </li>
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Bantuan</li>
                                    <li><a href="#">mmazlanh@gmail.com</a><br>019-7771154</li>
                                  
                                </ul>
                            </li>
                         
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Manual</li>
                                    <li> <a href="#">SIP</a> </li>
                                    
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- /.Megamenu -->
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                            
                          
                         </form>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="../logo.png" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $namapengguna;?></b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="../logo.png" alt="user" /></div>
                                    <div class="u-text">
                                        <h4><?php echo $namapengguna;?></h4>
                                        <p class="text-muted">mmazlanh@gmail.com</p><a href="#" class="btn btn-rounded btn-danger btn-sm"><?php echo $namapenuh;?></a></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                       
                            <li><a href="logout.php?logout=true"><i class="fa fa-power-off"></i> Log Keluar</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation" style="background: linear-gradient(#FFFFF0, #FFF8DC);">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
                <div class="user-profile" style="margin-top:2rem;">
                    <div class="dropdown user-pro-body">
                        <div><img src="../logo.png" alt="user-img" class="img-circle"></div>
                        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $namapenuh;?><span class="caret"></span></a>
                        <ul class="dropdown-menu animated flipInY">
                            <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                            <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                            <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="login.html"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
                
                
                
                
<ul class="nav" id="side-menu">

    
  <!-- ============================= MULA MENU 1 ================================= -->   
    
    
<li><a href="index.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Muka Depan</span></a></li>     
    
    
    
    
    
    
                 
 <li> <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-plus fa-fw" data-icon="v"></i> 
                       
 <?php                     
$sql = "SELECT bar_menu.ID,
bar_menu.KOD,
bar_menu.MENU,
bar_menu.TAG
FROM
bar_menu

WHERE bar_menu.KOD ='1' AND bar_menu.TAG='SISCSIP'";
	
$result = $auth_user->runQuery($sql);
$result->bindParam(':namapengguna', $namapengguna);	
$result->execute();
         
   
if ($result->rowCount() > 0) {		
foreach ($result as $row) {
$menu=$row['MENU']; ?>                    
                      
                      
                      
                        <span class="hide-menu"> 
                            <?php echo $menu;?>
                            <span class="fa arrow"></span> </span></a>
                      
    <?php }
}
    ?>
      <!-- ========================== MULA SUB MENU 1 ==================================== -->
                        <ul class="nav nav-second-level">
                            
<?php                          

$sql = "SELECT bar_sub.ID,bar_sub.KOD,bar_sub.MENU AS SUBMENU,bar_sub.HTTP,bar_sub.TAG
FROM
bar_sub
WHERE bar_sub.KOD ='1' AND bar_sub.TAG='SISC'
ORDER BY bar_sub.KOD ASC";
	
$result = $auth_user->runQuery($sql);
$result->bindParam(':namapengguna', $namapengguna);	
$result->execute();
         
   
if ($result->rowCount() > 0) {		
foreach ($result as $row) {
$submenu=$row['SUBMENU'];
$http=$row['HTTP'];                           
                            ?>
    
                            <li>
                                
                                
                                <?php
                                echo "<a href=\"$http\">";?>
                                
                                
                                
                                <i class="mdi mdi-account-multiple-plus fa-fw"></i><span class="hide-menu"><?php echo "$submenu";?></span></a> </li>
                            
                            <?php } ?>
                        </ul>
                    </li>
                       
<?php } ?>
                    
 
   <!-- ============================ MULA MENU 2 ================================== -->  
    
 <li> <a href="javascript:void(0);" class="waves-effect">
     
    <i class="mdi mdi-format-color-fill fa-fw"></i> 
                       
 <?php                     
$sql = "SELECT bar_menu.ID,
bar_menu.KOD,
bar_menu.MENU,
bar_menu.TAG
FROM
bar_menu

WHERE bar_menu.KOD ='2' AND bar_menu.TAG='SISCSIP'";
	
$result = $auth_user->runQuery($sql);
$result->bindParam(':namapengguna', $namapengguna);	
$result->execute();
         
   
if ($result->rowCount() > 0) {		
foreach ($result as $row) {
$menu=$row['MENU']; 
  
     ?>                    
                      
                      
                      
                        <span class="hide-menu"> 
                            <?php echo $menu;?>
                            <span class="fa arrow"></span> </span></a>
                      
    <?php }
}
    ?>
     <!-- ========================== MULA SUB MENU 2 ==================================== -->
     
                        <ul class="nav nav-second-level">
                            
                           <?php                          
  

$sql = "SELECT bar_sub.ID,bar_sub.KOD,bar_sub.MENU AS SUBMENU,bar_sub.HTTP,bar_sub.TAG
FROM
bar_sub
WHERE bar_sub.KOD ='2' AND bar_sub.TAG='SISC'
ORDER BY bar_sub.KOD ASC";
	
$result = $auth_user->runQuery($sql);
$result->bindParam(':namapengguna', $namapengguna);	
$result->execute();
         
   
if ($result->rowCount() > 0) {		
foreach ($result as $row) {
$submenu=$row['SUBMENU']; 
$http=$row['HTTP'];                               
                            ?>
    
                            <li> 
                                
                              <?php
                                echo "<a href=\"$http\">";?>
                               <i class="fa fa-circle-o text-info"></i> <span class="hide-menu"><?php echo "$submenu";?></span></a> </li>
                            
                            <?php } ?>
                        </ul>
                    </li>
                       
<?php } ?>    
    
    
  <!-- ============================= MULA MENU 3 ================================= -->   

 <li> <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-cart-outline fa-fw" data-icon="v"></i> 
                       
 <?php                     
$sql = "SELECT bar_menu.ID,
bar_menu.KOD,
bar_menu.MENU,
bar_menu.TAG
FROM
bar_menu

WHERE bar_menu.KOD ='3' AND bar_menu.TAG='SISCSIP'";
	
$result = $auth_user->runQuery($sql);
$result->bindParam(':namapengguna', $namapengguna);	
$result->execute();
         
   
if ($result->rowCount() > 0) {		
foreach ($result as $row) {
$menu=$row['MENU']; ?>                    
                      
                      
                      
                        <span class="hide-menu"> 
                            <?php echo $menu;?>
                            <span class="fa arrow"></span> </span></a>
                      
    <?php }
}
    ?>
     <!-- ========================== MULA SUB MENU 3 ==================================== -->
                        <ul class="nav nav-second-level">
                            
                           <?php                          
  

$sql = "SELECT bar_sub.ID,bar_sub.KOD,bar_sub.MENU AS SUBMENU,bar_sub.HTTP,bar_sub.TAG
FROM
bar_sub
WHERE bar_sub.KOD ='3' AND bar_sub.TAG='SISC'
ORDER BY bar_sub.KOD ASC";
	
$result = $auth_user->runQuery($sql);
$result->bindParam(':namapengguna', $namapengguna);	
$result->execute();
         
   
if ($result->rowCount() > 0) {		
foreach ($result as $row3) {
$submenu3=$row3['SUBMENU']; 
$http3=$row3['HTTP'];
                            ?>
    
                            <li> 
                                
                             <?php
    
                                echo "<a href=\"$http3\">";?>
                                
                                
                                <i class="mdi mdi-cart-outline fa-fw" data-icon="v"></i><span class="hide-menu"><?php echo "$submenu3";?></span></a> </li>
                            
                            <?php } ?>
                        </ul>
                    </li>
                       
<?php } ?>    
    
    
                    
                    
    
          
                    
                    
          
                    
                
     
                        
                    <li class="devider"></li>
                  
                 <li><a href="logout.php?logout=true" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Log Keluar</span></a></li>           
                            
                </ul>

 <!-- ============================= MENU TAMAT ================================= -->




            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    
                    
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                         </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
                        <a href="#" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><?php echo $namapenuh;?></a>
                        <ol class="breadcrumb">
                        
                            <li><a href="#"><?php echo $namapengguna;?></a></li>
                            <li class="active"><?php echo "$kodppd $namappd";?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /row -->
                
                
                <div class="row">
<?php       
                     
                     
                     
    if($id=="daftar"){
        
        
         $hari = date('d');
         $bln = date('m');
         $tahunni = date("Y");
         $thnlps = $tahunni - 10;
         $thndpn = $tahunni + 10;   
        
        
        
        
        
     ?>                            
<table border="0" cellpadding="10" cellspacing="0" width="100%" align="center" class="tbl-qa">                           
<form name="frmAdd" action="" method="POST">
<tr class="table-row" >
                              
                              
                              
       <td>BORANG PENDAFTARAN GURU YANG DIBIMBING:</td><td>
            
 
 
  <?php 
        $jawatan='';$gred='';$jenissara='';$kodsekolah="";
    
    ?>      
 
         
         
 <tr class="table-row" >
    <td>No Kad Pengenalan <br>
        <input type="text"  maxlength="12" size="40" name="NOKP"  class="txtField" required > Contoh: 123456014321</td>
</tr>
 <tr class="table-row" >
    <td>Nama Penuh Guru:<br>
        <input type="text"  size="70" name="NAMAGURU"  class="txtField" required ></td>
</tr>
<tr class="table-row" >
    <td>Jawatan:<br>
        <input type="text"  size="40" name="JAWATAN"  class="txtField" required ></td>
</tr>

<tr class="table-row" >
       <td>Nama Sekolah:<br>
          
            <select name="KODSEKOLAH" id="KODSEKOLAH">
 <?php
 	$stmt = $auth_user->runQuery("SELECT KODSEKOLAH,NAMASEKOLAH FROM tssekolah WHERE KODPPD='$kodppd' ORDER BY KODSEKOLAH ASC");
	$stmt->execute();
	foreach ($stmt as $row) 
 {
 ?>
 
<?php print "<option value='";?><?php echo $row['KODSEKOLAH']; ?>'<?php if ($row['KODSEKOLAH']==$kodsekolah) { ?>selected<?php } ?>><?php
 echo $row['NAMASEKOLAH']; ?></option>

 <?php } ?>
 </select> </td></tr>	                             
                            
                

 <?php
 echo "<tr><td>Tarikh : <br>";
                echo "<select name=\"dari_hari\">";
                                              for ( $counter = 1; $counter <= 31; $counter += 1) {
                                                 echo "<option value=\"$counter\""; if($hari=="$counter") { echo "selected"; } echo ">$counter</option>";
                                              }
                       echo "</select>";
                       echo "<select name=\"dari_bulan\">";
                                              for ( $counter = 1; $counter <= 12; $counter += 1) {
                                                  if($counter=="1") { $bulan = "Jan"; }if($counter=="2") { $bulan = "Feb"; }if($counter=="3") { $bulan = "Mac"; }if($counter=="4") { $bulan = "Apr"; }
                                                  if($counter=="5") { $bulan = "Mei"; }if($counter=="6") { $bulan = "Jun"; }if($counter=="7") { $bulan = "Jul"; }if($counter=="8") { $bulan = "Aug"; }
                                                  if($counter=="9") { $bulan = "Sep"; }if($counter=="10") { $bulan = "Okt"; }if($counter=="11") { $bulan = "Nov"; }if($counter=="12") { $bulan = "Dis"; }
                                                  echo "<option value=\"$counter\"";if($bln==$counter) {echo " selected";} echo">$bulan</option>";
                                              }
                       echo "</select>";

                       echo "<select name=\"dari_tahun\">";
                                         for ( $counter = $thnlps; $counter <= $tahunni; $counter += 1) {
                                            echo "<option value=\"$counter\"";if($tahunni==$counter) {echo " selected";} echo">$counter</option>";
                                         }
                         echo "<option value=\"$thndpn\">$thndpn</option>";
                        echo " </select>";                    
                    
                    
                    
  ?>                  
                    
                    
                    
  <tr class="table-row" ><td><br>
<?php echo "<input type=\"hidden\" name=\"KODPPD\" value=\"$kodppd\" />";?>      
<?php echo "<input type=\"hidden\" name=\"SISC\" value=\"$namapengguna\" />";?>
<input name="save_record" type="submit" value="Simpan" class="demo-form-submit">
</td></tr>

</table>  
    
    </form>       
        
        
        
   <?php     
        
        
    }                 
                     
  
    
    if($id=="kemaskini"){
        
        
                       
 $nokp=isset($_GET['NOKP']) ? $_GET['NOKP'] : null; 

$sql = "SELECT

sisc_guru.ID,
sisc_guru.SISC,
sisc_guru.NOKP,
sisc_guru.NAMAGURU,
sisc_guru.KODSEKOLAH,
sisc_guru.JAWATAN,
sisc_guru.TARIKHSTATUS,
sisc_guru.`STATUS`
FROM
sisc_guru


WHERE sisc_guru.NOKP=:nokp";
	
$result = $auth_user->runQuery($sql);
$result->bindParam(':nokp', $nokp);	
$result->execute();
      

 $row=$result->fetch(PDO::FETCH_ASSOC);
    $id=$row['ID'];
    $nama=$row['NAMAGURU'];
    $status=$row['STATUS'];   
        
        
        $hari_ini = date('d');
            $bulan_ini = date('m');
            $tahun_ini = date('Y');
            $hari_esok = date('d');
            $bulan_esok = date('m');
            $tahun_esok = date('Y');   
    
    $tarikhmula = $row['TARIKHSTATUS'];
  
           if($tarikhmula!="") {
                 $mula_hari = date('d',strtotime($tarikhmula));
                 $mula_bulan = date('m',strtotime($tarikhmula));
                 $mula_tahun = date('Y',strtotime($tarikhmula));
                 $mula_jam = date('H',strtotime($tarikhmula));
                 $mula_minit = date('i',strtotime($tarikhmula));
                 $hari_ini = $mula_hari;
                 $bulan_ini = $mula_bulan;
                 $tahun_ini = $mula_tahun;
               }       
        
        
                 
   ?>             
                
<form name="frmAdd" action="" method="POST">
<table border="0" cellpadding="10" cellspacing="0" width="100%" align="center" class="tbl-qa">  
 PENGESAHAN STATUS
                
                

    
 <tr class="table-row" >
     <td>Nama Pegawai: </td><td><?php echo $nama;?></td>
  
</tr>                
<tr class="table-row" >
<td>Status: </td><td>
   
<select name="STATUS" id="STATUS">
    
 <?php
$stmt = $auth_user->runQuery("SELECT 

kodstatuspgb.ID,
kodstatuspgb.KOD,
kodstatuspgb.PERKARA,
kodstatuspgb.RANK
FROM
kodstatuspgb

ORDER BY kodstatuspgb.KOD ASC");
   
    
    
    
     echo "<option value=\"\"> - Sila Pilih -</option>";  
	$stmt->execute();
	foreach ($stmt as $row) 
 {
 ?>
<?php print "<option value='";?><?php echo $row['KOD']; ?>'<?php if ($row['KOD']==$status) { ?>selected<?php } ?>><?php
 echo $row['KOD'].'-'.$row['PERKARA']; ?></option>
 <?php } ?>
 </select> 

    </td>
</tr>       
                    
<?php                    
echo " <tr><td>Tarikh Status </td><td>";
         echo "        <select name=\"dari_hari\">";
                       for ( $counter = 1; $counter<= 31; $counter++) {
                       echo "<option value=\"$counter\"";if($counter==$hari_ini) { echo "selected"; }
                           echo ">$counter</option>";
                       }
         echo "          </select><select name=\"dari_bulan\">";
                           for ( $counter2 = 1; $counter2<= 12; $counter2++) {
                            if($counter2=="1") { $bulan="Januari"; }if($counter2=="2") { $bulan="Februari";
                                                                                       }if($counter2=="3") { $bulan="Mac"; }
                            if($counter2=="4") { $bulan="April"; }if($counter2=="5") { $bulan="Mei"; }if($counter2=="6") { $bulan="Jun"; }
                            if($counter2=="7") { $bulan="Julai"; }if($counter2=="8") { $bulan="Ogos"; }if($counter2=="9") { $bulan="September"; }
                            if($counter2=="10") { $bulan="Oktober"; }if($counter2=="11") { $bulan="November"; }if($counter2=="12") { $bulan="Disember"; }

         echo "<option value=\"$counter2\"";if($counter2==$bulan_ini) { echo "selected"; } echo ">$bulan</option>";
                        }

         echo "</select><select name=\"dari_tahun\">";
                         for ( $counter = $tahun_ini - 1; $counter<= $tahun_ini + 50; $counter++) {
         echo "<option value=\"$counter\"";if($counter==$tahun_ini) { echo "selected"; } echo ">$counter</option>";
                         }

        echo "</td></tr>";
    
       ?>                        
                    
                    
                    
                    
                    
                  
                    
                    
                    
                    
                
 <tr class="table-row" ><td>
     <?php //echo "<input type=\"hidden\" name=\"kodnegeri\" value=\"$kodnegeri\" />";?>
     <?php echo "<input type=\"hidden\" name=\"NOKP\" value=\"$nokp\" />";?>
     
          <input name="save_record2" type="submit" value="Simpan" class="demo-form-submit">
          </td><td>
          <a href="index.php?id=senaraiguru" class="demo-form-submit"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; Batal</a>
          </td>
                </tr>

  
     </table>      
    
    </form>                  
                
                    
        
   <?php     
        
        
    }
    
    
    
    
    
    
              
  if($id=="senaraiguru"){
      
     
       ?>                    
<div class="col-sm-12">
                        <div class="white-box">
  
<?php                          
 

$sql = "SELECT
users.user_name,users.real_name,sisc_guru.SISC,sisc_guru.NOKP,sisc_guru.ID,
sisc_guru.NAMAGURU,sisc_guru.KODSEKOLAH,sisc_guru.JAWATAN,sisc_guru.KODPPD,
sisc_guru.TAHUN,sisc_guru.TARIKHAKTIF,tssekolah.NAMASEKOLAH,sisc_guru.TARIKHSTATUS,
sisc_guru.STATUS
FROM
users
JOIN sisc_guru
ON users.user_name = sisc_guru.SISC 
JOIN tssekolah
ON sisc_guru.kodsekolah = tssekolah.KODSEKOLAH


WHERE sisc_guru.SISC=:namapengguna  ORDER BY sisc_guru.NAMAGURU ASC";
	
$result = $auth_user->runQuery($sql);
$result->bindParam(':namapengguna', $namapengguna);	
$result->execute();
      
    
      
      
    ?>                          
                            

                            <h3 class="box-title m-b-0">Senarai Nama Guru Yang Dibimbing</h3>
                            <p class="text-muted m-b-30">Eksport data Ke Salin, CSV, Excel, PDF & Print</p>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nokp</th>
                                            <th>Nama Guru Dibimbing</th>
                                            <th>Nama Sekolah</th>
                                            <th>Tarikh Aktif</th>
                                            <th>Status <br>Tarikh</th>
                                            
                                            <th> ARAHAN</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                              
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
 <?php
            
$bil=0;
if ($result->rowCount() > 0) {		
foreach ($result as $row) {
                        $kod=$row['ID'];
                        $id=$row['ID'];
                        $nama=$row['NAMAGURU'];
                        $nokp=$row['NOKP'];
                        $namasekolah=$row['NAMASEKOLAH'];
                        $status=$row['STATUS'];
                        $pp1=$row['TARIKHAKTIF'];
                       if($pp1=="0000-00-00") { $pp1= ""; }
                       if($pp1!="") { $pp1 = date('d/m/Y',strtotime($pp1)); }
    
           
                       $tarikhstatus=$row['TARIKHSTATUS'];
                       if($tarikhstatus=="0000-00-00") { $tarikhstatus= ""; }
                       if($tarikhstatus!="") { $tarikhstatus = date('d/m/Y',strtotime($tarikhstatus)); }
                        $bil++;
    
    
    $sqln = $auth_user->runQuery("SELECT * FROM kodstatuspgb  WHERE KOD=:status");
	$sqln->execute(array(":status"=>$status));
    $sqlnRow=$sqln->fetch(PDO::FETCH_ASSOC);
    $perkara=$sqlnRow['PERKARA'];  
    
    
                        
			?>                                       
                                        
                                        
                                        
                                        <tr>
                                            <td><?php echo $nokp;?></td>
                                            <td><?php echo $nama;?></td>
                                            <td><?php echo $namasekolah;?></td>
                                            <td><?php echo $pp1;?></td>
                                            <td><?php 
    
    if($status=="1"){
   
           
        
        
        
     echo "$perkara<br><a href=\"./index.php?id=kemaskini&NOKP=$nokp\" title=\"Kemaskini Maklumat: $nama \" > 
     
     <span class=\"label label-success\">$tarikhstatus </span></a>  <td>";  
        
    }
     if($status=="2"){
        
     echo "$perkara<br><a href=\"./index.php?id=kemaskini&NOKP=$nokp\" title=\"Kemaskini Maklumat: $nama \" > 
     <span class=\"label label-success\">$tarikhstatus </span></a><td>";  
        
    }
     if($status=="3"){
        
     echo "$perkara<br><a href=\"./index.php?id=kemaskini&NOKP=$nokp\" title=\"Kemaskini Maklumat: $nama \" > 
     <span class=\"label label-success\">$tarikhstatus </span></a><td>";  
        
    }
    
    
   if($status==""){
        
     echo " $perkara<br> <a href=\"./index.php?id=kemaskini&NOKP=$nokp\" title=\"Kemaskini Maklumat: $nama \" > 
     
     <span class=\"label label-success\">$tarikhstatus</span>Tidak Berkenaan</a> <td>";  
        
    }

      echo"
   <a href=\"../modulsisc/pelaporan.php?id=$kod\" title=\"Pepaloran[ $id ]$nama \"> 
   Lapor</a></td>";?>
   
                                                
   <td><a href="../modulsisc/padam.php?ID=<?php echo $row["ID"]; ?>" class="link"><img name="delete" id="delete" title="Padam" onclick="return confirm('Anda Pasti Hendak Padam Rekod Ini?')" src="../icon/delete.png"/></a></td>
                                            
                                            
                                            </td>
                                            
                                        </tr>
                         <?php
}
}
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
         
                    
                    
     <?php     
      
      
      
      
      
  }                   
                     
    
           
 
                     

                     ?>
                                    
                    
                    
                    
                    
                </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Manual<span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>1. Manual 1</b></li>
                                <li>1.1 Manual 1</li>
                               
                            </ul>
                            <ul class="m-t-20 all-demos">
                                <li><b>2. Manual 2</b></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>3. Manual 3</b></li>
                               
                               
                            </ul>
                        </div>
                    </div>
                </div>
                
                
     <?php }
                
                
         else
     {
         
     header("Location: ../modulppd/logout.php?logout=true");     
         
     }         
                
                
                
                ?>           
                
                
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2018 &copy; Bahagian Sekolah Harian Kementerian Pendidikan Malaysia</footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    
   <!-- jQuery peity -->
    <script src="../plugins/bower_components/tablesaw-master/dist/tablesaw.js"></script>
    <script src="../plugins/bower_components/tablesaw-master/dist/tablesaw-init.js"></script>
    <!--Style Switcher --> 
    
    
    
    
    
    
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="../plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
    <!--Style Switcher -->
    <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
