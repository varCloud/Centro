<?php

session_start();
if(isset($_SESSION['usuario']) ||isset($_SESSION["Admin"]))
{

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="Laborator.co" />
    <link rel="icon" href="Imgs/icon.png">
    <title>AdminTrans | Dalton</title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
    <script src="assets/js/jquery-1.11.3.min.js"></script>

</head>
<body class="page-body page-fade" data-url="http://demo.neontheme.com">
   <?php echo "<input type='hidden' value='".$_SESSION['idSucursal']."' id='idSucursal' />";
      echo "<input type='hidden' value='".$_SESSION['idUsuario']."' id='idUsuario' />";
	  echo "<input type='hidden' value='".$_SESSION['idRol']."' id='idRol' />";
 ?>
    <div class="page-container">


        <!-- MENU -->
		  <?php include 'Menu/menu.php';?>


        <div class="main-content" >
          <?php include 'Footer/footer.php';?>
            <hr />

		 <?php 
		 if ( isset($_SESSION["Admin"] ))
		 {echo'
            <div class="row" id="citasPendientes">

            </div>
			';
		 }
		?>
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css" id="style-resource-2">
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
    <script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js" id="script-resource-8"></script>
    <script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js" id="script-resource-9"></script>
    <script src="assets/js/jquery.sparkline.min.js" id="script-resource-10"></script>
    <script src="assets/js/rickshaw/vendor/d3.v3.js" id="script-resource-11"></script>
    <script src="assets/js/rickshaw/rickshaw.min.js" id="script-resource-12"></script>
    <script src="assets/js/raphael-min.js" id="script-resource-13"></script>
    <script src="assets/js/morris.min.js" id="script-resource-14"></script>
    <script src="assets/js/toastr.js" id="script-resource-15"></script>
    <script src="assets/js/neon-chat.js" id="script-resource-16"></script>
    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js" id="script-resource-17"></script>
    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js" id="script-resource-18"></script>
    <script src="assets/js/neon-skins.js" id="script-resource-19"></script>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-28991003-7']);
        _gaq.push(['_setDomainName', 'demo.neontheme.com']);
        _gaq.push(['_trackPageview']);
        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <script src="js/index.js"></script>
</body>
<!-- Mirrored from demo.neontheme.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 May 2016 13:30:33 GMT -->
</html>
<?php
}else
    header("Location: Login.php");
    
?>