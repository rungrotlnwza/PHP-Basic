<?php
// สร้างตัวแปร message เพื่อใช้แสดงข้อความ
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // รับค่าจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $name = $_POST['name'];

    
    if ($password === $confirmPassword) {
        
        $conn = mysqli_connect("localhost", "root", "", "carshop");

        if (!$conn) {
            $message = "การเชื่อมต่อฐานข้อมูลไม่สำเร็จ";
        } else {
            
            $check = "SELECT * FROM user WHERE username = '$username'";
            $result = mysqli_query($conn, $check);

            if (mysqli_num_rows($result) > 0) {
                $message = "มีชื่อผู้ไช้นี้แล้ว";
            } else {
                
                $insert = "INSERT INTO user (username, password, name, status) VALUES ('$username', '$password', '$name', 'user')";
                if (mysqli_query($conn, $insert)) {
                    $message = "ลงทะเบียนสำเร็จ";
                } else {
                    $message = "เกิดข้อผิดพลาดในการลงทะเบียน";
                }
            }
            mysqli_close($conn);
        }
    } else {
        $message = "รหัสผ่านไม่ตรงกัน";
    }
}
// 1. ตรวจสอบว่ามีการส่งค่ามาจากฟอร์มหรือไม่ และเป็นการส่งค่าด้วยการ login หรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // 1.1 ไปแก้ ช่องรับ username ให้มีชื่อเป็น username
    // 1.2ไปแก้ button input ให้มีชื่อเป็น login เพื่อให้โปรแกรมรู้ว่าจะส่งข้อมูลจากฟรอมชุดไหน
    // 2. ดึงค่าจากฟอร์มมาเก็บในตัวแปร
    $name = $_POST['username'];
    $password = $_POST['password'];

    // 3. สร้างการเชื่อมต่อกับฐานข้อมูล
    $conn = mysqli_connect('localhost', 'root', '', 'doc');

    // 4. คำสั่ง SQL
    $sql = "SELECT * FROM `users` WHERE `username` = '$name'";
    $result = mysqli_query($conn, $sql);

    // 5. ตรวจสอบว่าพบผู้ใช้ในฐานข้อมูลหรือไม่
    // 5.1 ให้ num_rows เป็นตัวนับว่าชื่อนั้นมีเท่าไหร่ โดยให้ query เป็นตัวค้นหา 
    if (mysqli_num_rows($result) > 0) {
        //5.2 ไช้ mysqli_fetch_assoc เพื่อแปลงข้อมูล ให้อยู่ในรูปแบบที่ php อ่านได้จากข้อมูล sql ซึ่งเราไช้ไม่ได้
        $user = mysqli_fetch_assoc($result);

        // ถ้าเข้าเงื่อไขว่ามียูสเซอร์เนมนี้ให้ตรวจสอบหรัสผ่านตรวจสอบรหัสผ่าน
        if ($password === $user['password']) {
            header("Location: index.php");

        } else {
           $message = "รัหสผ่านหรือยูสเซอร์เนมผิดรึปล่าว";
        }
    } else {
        $message = "ไม่มียูสเซอร์เนมนี้";
    }

    // 6. ปิดการเชื่อมต่อฐานข้อมูล เพื่อให้ปรแกรมรู้ว่าต้องหยุดการทำงาน
    mysqli_close($conn);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Bootstrap Login | Ludiflex</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background: #ececec;
    }

    .box-area {
        width: 930px;
    }

    .right-box {
        padding: 40px 30px 40px 40px;
    }

    ::placeholder {
        font-size: 16px;
    }

    .rounded-4 {
        border-radius: 20px;
    }

    .rounded-5 {
        border-radius: 30px;
    }

    @media only screen and (max-width: 768px) {
        .box-area {
            margin: 0 10px;
        }

        .left-box {
            height: 100px;
            overflow: hidden;
        }

        .right-box {
            padding: 20px;
        }
    }
    </style>
</head>

<body>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login/Register Container -------------------------->

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <!--------------------------- Left Box ----------------------------->

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="image/01.jpg" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be
                    Verified</p>
                <small class="text-white text-wrap text-center"
                    style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join experienced Designers on
                    this platform.</small>
            </div>

            <!-------------------- ------ Right Box ---------------------------->

            <div class="col-md-6 right-box">

                <!-- Login Form -->
                <form method="post" id="loginForm">
                    <div class="row align-items-center">
                        <div class="header-text mb-4">
                            <h2>Hello, Again</h2>
                            <p><?php echo $message ?></p>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Email address" required>
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Password" required>
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck" name="remember">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember
                                        Me</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="#">Forgot Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="login" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                        <div class="input-group mb-3">
                            
                            <button type="button" name="login" class="btn btn-lg btn-light w-100 fs-6"><img src="image/google.jpg"
                                    style="width:20px" class="me-2"><small>Sign In with Google</small></button>
                        </div>
                        <div class="row">
                            <small>Don't have an account? <a href="#" onclick="showRegister()">Sign Up</a></small>
                        </div>
                    </div>
                </form>

                <!-- Register Form (hidden by default) -->
                <form method="POST" id="registerForm" style="display: none;">
                    <div class="row align-items-center">
                        <div class="header-text mb-4">
                            <h2>Create Account</h2>
                            <p>Join us today for an amazing experience.</p>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Username" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Your Name" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Password" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="confirmPassword"
                                class="form-control form-control-lg bg-light fs-6" placeholder="Confirm Password"
                                required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="submit" name='register' class="btn btn-lg btn-primary w-100 fs-6">Sign Up</input>
                        </div>
                        <div class="row">
                            <small>Already have an account? <a href="#" onclick="showLogin()">Login</a></small>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
    // Function to show the Register form and hide the Login form
    function showRegister() {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
    }

    // Function to show the Login form and hide the Register form
    function showLogin() {
        document.getElementById('loginForm').style.display = 'block';
        document.getElementById('registerForm').style.display = 'none';
    }
    </script>

</body>

</html>
