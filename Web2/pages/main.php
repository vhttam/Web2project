 <div id="main">
           <?php
            include("sidebar/sidebar.php");
           ?>
            <div class="maincontent">
             <?php
                if(isset($_GET['quanly'])){
                    $tam = $_GET['quanly'];
                }else{
                    $tam = '';
                }
                if($tam=='danhmucsanpham'){
                    include("main/danhmuc.php");
                }elseif($tam=='giohang'){
                    include("main/giohang.php");
                }elseif($tam=='lienhe'){
                    include("main/lienhe.php");
                
                }
                elseif($tam=='sanpham'){
                    include("main/chitietsp.php");
                     }
                     
                elseif($tam=='dangky'){
                    include("main/dangky.php");
                     }
                elseif($tam=='dangnhap1'){
                    include("main/dangnhap.php");
                     }
                      elseif($tam=='thanhtoan'){
                    include("main/thanhtoan.php");
                     }
                     
                elseif($tam=='timkiem'){
                    include("main/timkiem.php");
                 }
               
                    elseif($tam=='timkiemnangcao'){
                        include("main/timkiemnangcao.php");
                    }
                 elseif($tam=='camon'){
                    include("main/camon.php");
                 }
                 elseif($tam=='vanchuyen'){
                    include("main/vanchuyen.php");
                 }
                   elseif($tam=='vanchuyen'){
                    include("main/vanchuyen.php");
                 }
                   elseif($tam=='thongtinthanhtoan'){
                    include("main/thongtinthanhtoan.php");
                 }
                   elseif($tam=='donhangdadat'){
                    include("main/donhangdadat.php");
                     }
                   elseif($tam=='lichsudonhang'){
                    include("main/lichsudonhang.php");
                         }
                   elseif($tam=='xemdonhang'){
                    include("main/xemdonhang.php");

                 }else{
                    include("main/index.php");}
                ?>

            </div>
        </div>