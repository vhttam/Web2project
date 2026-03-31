<div class="clear"></div>
<div class="main">
            
             <?php
                if(isset($_GET['action']) && $_GET['query']){
                    $tam = $_GET['action'];
                    $query = $_GET['query'];
                }else{
                    $tam = '';
                    $query = '';
                }
                if($tam=='quanlydanhmucsanpham' && $query=='them'){
                    include("modules/quanlydanhmucsp/them.php");
                    include("modules/quanlydanhmucsp/lietke.php");
                }else if($tam=='quanlydanhmucsanpham' && $query=='sua'){
                    include("modules/quanlydanhmucsp/sua.php");
                

                }
                //sp
                    else if($tam=='quanlysanpham' && $query=='them'){
                    include("modules/quanlysp/them.php");
                    include("modules/quanlysp/lietke.php");
                    } else if($tam=='quanlysanpham' && $query=='sua'){
                    include("modules/quanlysp/sua.php");
                   
                   } 
                   //Nguoi dung
                    else if($tam=='quanlynguoidung' && $query=='them'){
                        include("modules/quanlynguoidung/them.php");
                        include("modules/quanlynguoidung/lietke.php");
                    } else if($tam=='quanlynguoidung' && $query=='sua'){
                        include("modules/quanlynguoidung/sua.php");

                    //donhang
                    } else if($tam=='quanlydonhang' && $query=='lietke'){
                    include("modules/quanlydonhang/lietke.php");
                     } else if($tam=='donhang' && $query=='xemdonhang'){
                    include("modules/quanlydonhang/xemdonhang.php");

                     //kho
                    }else if($tam=='quanlykho' && $query=='lietke'){
                    include("modules/quanlykho/lietke.php");
                    //nhap hang
                    } else if($tam=='quanlynhaphang' && $query=='them'){
                        include("modules/quanlynhaphang/them.php");
                        include("modules/quanlynhaphang/lietke.php"); // Hiển thị danh sách phiếu bên dưới form thêm
                    } else if($tam=='quanlynhaphang' && $query=='sua'){
                        include("modules/quanlynhaphang/sua.php"); // Đây là trang để thêm sản phẩm vào phiếu
                    //giaban
                        } else if($tam=='quanlygiaban' && $query=='lietke'){
                        include("modules/quanlygiaban/lietke.php");
                
                  }else{
                    include("modules/dashboard.php");}
                ?>
</div>
