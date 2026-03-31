<?php
    $sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
    $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);

    if(isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1){
        unset($_SESSION['dangnhap1']); 
        unset($_SESSION['id_dangky']); 
        unset($_SESSION['dangky']);    
        header("Location:index.php");
        exit();
    }
?>
<nav class="menu">
  <div class="nav-container">
    <div style="font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; letter-spacing: 3px; color: #D4AF37;">
      <a href="index.php">LUXWATCH</a>
    </div>

    <ul class="list_menu">
        <li><a href="index.php">Trang chủ</a></li>
        <li><a href="index.php?quanly=giohang">Giỏ hàng</a></li>
        <li><a href="index.php?quanly=lichsudonhang">Lịch sử</a></li>
        <?php if(isset($_SESSION['dangnhap1'])){ ?>
           <li><a href="index.php?dangxuat=1" style="color:#D4AF37;">Đăng xuất (<?php echo $_SESSION['dangnhap1']; ?>)</a></li>
        <?php } else { ?>
            <li><a style="cursor:pointer;" onclick="openAuthModal('register')">Đăng ký</a></li>
            <li><a style="cursor:pointer;" onclick="openAuthModal('login')">Đăng nhập</a></li>
        <?php } ?>
        <li><a href="index.php?quanly=timkiemnangcao">Tìm kiếm nâng cao</a></li>
        <li><a href="index.php?quanly=lienhe">Liên hệ</a></li>
    </ul>
    
    <div class="nav-search">
        <form action="index.php" method="GET">
            <input type="hidden" name="quanly" value="timkiem">
            <input type="text" placeholder="Tìm kiếm đồng hồ..." name="tukhoa">
            <input type="submit" name="timkiem" value="Tìm">
        </form>
    </div>
  </div>
</nav>

<?php
if(isset($_POST['dangnhap1_modal'])){
    $email = $_POST['email'];
    $matkhau = md5($_POST['matkhau']); 
    $stmt = $mysqli->prepare("SELECT * FROM tbl_dangky WHERE email=? AND matkhau=? LIMIT 1");
    if($stmt) {
        $stmt->bind_param("ss", $email, $matkhau);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row_data = $result->fetch_assoc();
            if($row_data['tinhtrang'] == 0){
                echo '<script>alert("Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản lý.");</script>';
            } else {
                $_SESSION['dangnhap1'] = $row_data['email']; 
                $_SESSION['id_dangky'] = $row_data['id_dangky']; 
                session_write_close(); 
                echo '<script>window.location.href="index.php";</script>';
            }
        } else {
            echo '<script>alert("Email hoặc Mật khẩu không đúng.");</script>';
        }
    }
}

if(isset($_POST['dangky_modal'])){
    $tenkhachhang = $_POST['hovaten'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $dienthoai = $_POST['dienthoai'];
    $matkhau = md5($_POST['matkhau']); 
    $sql_dangky = mysqli_query($mysqli,"INSERT INTO tbl_dangky(tenkhachhang,email,diachi,dienthoai,matkhau) 
    VALUES ('".$tenkhachhang."','".$email."','".$diachi."','".$dienthoai."','".$matkhau."')");
    if($sql_dangky){
        $_SESSION['dangky'] = $email;
        $_SESSION['id_dangky'] = mysqli_insert_id($mysqli);
        echo '<script>alert("Bạn đã đăng ký thành công!"); window.location.href="index.php";</script>';
    } else {
        echo '<script>alert("Đăng ký thất bại! Email có thể đã tồn tại.");</script>';
    }
}
?>

<style>
.auth-modal-backdrop {
    display: none;
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}
.auth-modal-contain {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    width: 400px;
    max-width: 90%;
    position: relative;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.auth-close-btn {
    position: absolute;
    top: 15px; right: 15px;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    color: #333;
    background: none; border: none; padding: 0; line-height: 1;
}
.auth-close-btn:hover { color: #f00; }
.auth-form-group {
    margin-bottom: 15px;
}
.auth-form-group input {
    width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
}
.auth-submit-btn {
    width: 100%; padding: 12px; background: #111; color: #D4AF37; border: none; font-weight: 600; cursor: pointer; border-radius: 4px; letter-spacing: 1px; text-transform: uppercase;
}
.auth-submit-btn:hover { background: #333; }
.auth-switch {
    text-align: center; margin-top: 15px; font-size: 14px;
}
.auth-switch span {
    color: #D4AF37; cursor: pointer; font-weight: bold;
}
.auth-switch span:hover { text-decoration: underline; }
</style>

<div id="authModal" class="auth-modal-backdrop" onclick="closeAuthModal(event)">
    <div class="auth-modal-contain" onclick="event.stopPropagation()">
        <button class="auth-close-btn" onclick="closeAuthModalX()">×</button>
        
        <div id="loginFormContainer">
            <h3 style="text-align:center; margin-bottom:20px; color:#D4AF37; text-transform: uppercase;">Đăng Nhập</h3>
            <form action="" method="POST" autocomplete="off">
                <div class="auth-form-group">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:13px; color:#333;">Tài khoản / Email</label>
                    <input type="text" name="email" placeholder="Tên tài khoản hoặc Email..." required>
                </div>
                <div class="auth-form-group">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:13px; color:#333;">Mật khẩu</label>
                    <input type="password" name="matkhau" placeholder="Mật khẩu..." required>
                </div>
                <button type="submit" name="dangnhap1_modal" class="auth-submit-btn">Đăng nhập</button>
            </form>
            <div class="auth-switch">Chưa có tài khoản? <span onclick="switchAuthForm('register')">Đăng ký ngay</span></div>
        </div>

        <div id="registerFormContainer" style="display:none;">
            <h3 style="text-align:center; margin-bottom:20px; color:#D4AF37; text-transform: uppercase;">Đăng Ký</h3>
            <form action="" method="POST" autocomplete="off">
                <div class="auth-form-group">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:13px; color:#333;">Họ và tên</label>
                    <input type="text" name="hovaten" id="hovaten" placeholder="Nhập họ và tên..." required>
                    <small id="name-error" style="color: red; display: none; margin-top: 5px; font-size: 12px;">Họ tên không hợp lệ.</small>
                </div>
                <div class="auth-form-group">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:13px; color:#333;">Tên tài khoản / Email</label>
                    <input type="text" name="email" placeholder="Nhập email hoặc tên tài khoản..." required>
                </div>
                <div class="auth-form-group">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:13px; color:#333;">Địa chỉ</label>
                    <input type="text" name="diachi" id="diachi" placeholder="Nhập địa chỉ của bạn..." required>
                    <small id="address-error" style="color: red; display: none; margin-top: 5px; font-size: 12px;">Địa chỉ không hợp lệ.</small>
                </div>
                <div class="auth-form-group">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:13px; color:#333;">Số điện thoại</label>
                    <input type="text" name="dienthoai" id="dienthoai" placeholder="Nhập số điện thoại..." required>
                    <small id="phone-error" style="color: red; display: none; margin-top: 5px; font-size: 12px;">SĐT không hợp lệ.</small>
                </div>
                <div class="auth-form-group">
                    <label style="display:block; margin-bottom:5px; font-weight:600; font-size:13px; color:#333;">Mật khẩu</label>
                    <input type="password" name="matkhau" placeholder="Nhập mật khẩu..." required>
                </div>
                <button type="submit" name="dangky_modal" class="auth-submit-btn">Đăng ký</button>
            </form>
            <div class="auth-switch">Đã có tài khoản? <span onclick="switchAuthForm('login')">Đăng nhập ngay</span></div>
        </div>
    </div>
</div>

<script>
function openAuthModal(type) {
    document.getElementById('authModal').style.display = 'flex';
    switchAuthForm(type);
}
function closeAuthModal(e) {
    if(e.target.id === 'authModal') {
        document.getElementById('authModal').style.display = 'none';
    }
}
function closeAuthModalX() {
    document.getElementById('authModal').style.display = 'none';
}
function switchAuthForm(type) {
    if(type === 'login') {
        document.getElementById('loginFormContainer').style.display = 'block';
        document.getElementById('registerFormContainer').style.display = 'none';
    } else {
        document.getElementById('loginFormContainer').style.display = 'none';
        document.getElementById('registerFormContainer').style.display = 'block';
    }
}
</script>