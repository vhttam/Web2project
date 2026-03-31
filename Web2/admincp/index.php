
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styleadmincp.css?v=<?php echo time(); ?>">
    <title>Admincp</title>
</head>
<?php
session_start();
if(!isset($_SESSION['dangnhap'])){
    header("Location:login.php");
}
 ?>
<body>
    <h3 class="title_admin">Chào mừng đến trang Admincp</h3>
    <div class="wrapper">
      <?php 
      include("config/config.php");
     include("modules/header.php");
     include("modules/menu.php");     
        include("modules/main.php");
        include("modules/footer.php");
     ?>
</body>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="../js/validate.js?v=<?php echo time(); ?>"></script>
<script type="text/javascript" src="js/validate_admin.js?v=<?php echo time(); ?>"></script>
<script>
    function imagePreview(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (event) {
                $('#preview').html('<img src="'+event.target.result+'" width="300" height="auto"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }
    $("#image").change(function () {
        imagePreview(this);
    });
</script>
</html>