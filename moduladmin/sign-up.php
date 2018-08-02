<?php
session_start();
require_once('class.user.php');
$user = new USER();



if(isset($_POST['btn-signup']))
{
	$uname = strip_tags($_POST['txt_uname']);
	$umail = strip_tags($_POST['txt_umail']);
	$upass = strip_tags($_POST['txt_upass']);	
	$uaras = strip_tags($_POST['txt_aras']);
    $ukodppd = strip_tags($_POST['txt_kodppd']);
    $ukodnegeri= strip_tags($_POST['txt_kodnegeri']);
    $ukodsekolah= strip_tags($_POST['txt_kodsekolah']);
    
	if($uname=="")	{
		$error[] = "Taipkan Nama Pengguna!";	
	}
    
	else if($umail=="")	{
		$error[] = "Taipkan Nama Penuh Pengguna !";	
	}
	else if($uaras=="")	{
		$error[] = "Aras Pengguna !";	
	}
    else if($ukodppd=="")	{
		$error[] = "Taipkan Kod PPD !";	
	}
     else if($ukodnegeri=="")	{
		$error[] = "Taipkan Kod Negeri !";	
	}
	else if($upass=="")	{
		$error[] = "Taipkan Kata Laluan !";
	}
	else if(strlen($upass) < 6){
		$error[] = "Sekurang-kurangnya 6 perkataan";	
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT user_name, user_email FROM users WHERE user_name=:uname OR user_email=:umail");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($row['user_name']==$uname) {
				$error[] = "sorry username already taken !";
			}
			else if($row['user_email']==$umail) {
				$error[] = "sorry email id already taken !";
			}
			else
			{
				if($user->register($uname,$umail,$upass,$uaras,$ukodppd,$ukodnegeri,$ukodsekolah)){	
					$user->redirect('sign-up.php?joined');
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Selamat Datang Pengguna Admin SIP+ Dan SISC+ </title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

    
    
    
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home.php?id=senarai">Senarai Nama</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
    
            <li><a href="../moduladmin/sign-up.php">Daftar Pengguna</a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php //echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;Profil</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Log Keluar</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="clearfix"></div>
    
<div class="signin-form">

<div class="container">
    	
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Daftar Pengguna Admin</h2><hr />
            <?php
			if(isset($error))
			{
			 	foreach($error as $error)
			 	{
					 ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
				}
			}
			else if(isset($_GET['joined']))
			{
				 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Pendaftaran Pengguna Telah Berjaya didaftarkan <a href='../'>login Masuk</a> Klik
                 </div>
                 <?php
			}
			?>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_uname" placeholder="Masukkan Nama Pengguna" value="<?php if(isset($error)){echo $uname;}?>" />
            </div>
            
            <div class="form-group">
            <input type="text" class="form-control" name="txt_umail" placeholder="Nama Penuh Pengguna" value="<?php if(isset($error)){echo $umail;}?>" />
            </div>
            <div class="form-group">
            	<input type="password" class="form-control" name="txt_upass" placeholder="Taipkan Kata laluan" />
            </div>
             <div class="form-group">
            	<input type="userlevel" class="form-control" name="txt_aras" placeholder="Aras Pengguna" />
            </div>
             <div class="form-group">
            	<input type="kodsekolah" class="form-control" name="txt_kodsekolah" placeholder="Kod Sekolah untuk pengguna PGYB" />
            </div>
             <div class="form-group">
            	<input type="kodppd" class="form-control" name="txt_kodppd" placeholder="Kod PPD" />
            </div>
             <div class="form-group">
            	<input type="kodnegeri" class="form-control" name="txt_kodnegeri" placeholder="Kod Negeri" />
            </div>
            
            
            
            
            
            
            
            <div class="clearfix"></div><hr />
            <div class="form-group">
            	<button type="submit" class="btn btn-primary" name="btn-signup">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;DAFTAR
                </button>
            </div>
            <br />
            <label>Gunakan Nama Pengguna! <a href="../">Log Masuk</a></label>
        </form>
       </div>
</div>

</div>

</body>
</html>