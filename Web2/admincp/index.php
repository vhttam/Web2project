<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <title>Web bán đồng hồ</title>
</head>
<body>
    <div class="container-fluid">

     <?php 
    session_start();
    include("admincp/config/config.php");
     include("pages/header.php");
     include("pages/menu.php");     
        include("pages/main.php");
        include("pages/footer.php");
     ?>

    
       
       
    </div>
            
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
// Tab chi tiết sản phẩm
$('#tabs-nav li:first-child').addClass('active');
$('.tab-content').hide();
$('.tab-content:first').show();

$('#tabs-nav li').click(function(e){
    e.preventDefault();
    $('#tabs-nav li').removeClass('active');
    $(this).addClass('active');
    $('.tab-content').hide();
    var activeTab = $(this).find('a').attr('href');
    $(activeTab).fadeIn();
    return false;
});
</script>

</body>
<script type="text/javascript">
    $(document).ready(function() {

        var back = $(".prev");
        var next = $(".next");
        var steps = $(".step");

        next.bind("click", function(e) {
            e.preventDefault(); // Ngăn chặn sự kiện cuộn/nhảy mặc định cổ trình duyệt
            $.each(steps, function(i) {
                if (!$(steps[i]).hasClass('current') && !$(steps[i]).hasClass('done')) {
                    $(steps[i]).addClass('current');
                    $(steps[i - 1]).removeClass('current').addClass('done');
                    return false;
                }
            })
        });

        back.bind("click", function(e) {
            e.preventDefault(); // Ngăn chặn sự kiện cuộn/nhảy mặc định cổ trình duyệt
            $.each(steps, function(i) {
                if ($(steps[i]).hasClass('done') && $(steps[i + 1]).hasClass('current')) {
                    $(steps[i + 1]).removeClass('current');
                    $(steps[i]).removeClass('done').addClass('current');
                    return false;
                }
            })
        });

    });
</script>
<script type="text/javascript" src="js/validate.js?v=<?php echo time(); ?>"></script>

</html>