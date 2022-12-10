<?php
session_start();
unset($_SESSION['error']);
$servername = "127.0.0.1";
$username = "root";
$password = "";
$db = "AssessmentSecProg";
$connect = new PDO("mysql:host=$servername; dbname=$db", $username, $password);
$connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST['register'])) {
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_pwd = $_POST['password'];
    $user_Conpwd = $_POST['confirmpassword'];

    $error = false;
    $msg = [];

    //validate username
    if ($user_name === "") {
        $msg['username'] = "Your Username Is Empty!";
        $error = true;
    } else if (strlen($user_name) < 3 || strlen($user_name) > 10) {
        $msg['username'] = "Username length should be between 3 and 10
        character long";
        $error = true;
    }

    //validate email
    if ($user_email === "") {
        $msg['email'] = "Your Email Is Empty!";
        $error = true;
    } else if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $msg['email'] = "Email Not Valid";
        $error = true;
    }

    //filter password
    $number = preg_match('@[0-9]@', $user_pwd);
    $upper_case = preg_match('@[A-Z]@', $user_pwd);
    $special_Char = preg_match('@[^\w]@', $user_pwd);

    // if ($user_pwd === "") {
    //     $msg['password'] = "Your Password Is Empty!";
    //     $error = true;
    // } else if (strlen($user_pwd) < 10 || !$number || !$upper_case || !$special_Char) {
    //     $msg['password'] = "Password Must Be At Least 10 Characters And Contains Number,Uppercase, and Special Characters";
    //     $error = true;
    // } else {
    //     $confirm_pwd = $user_pwd;
    // }

    //filter confirm password
    if ($user_Conpwd === "") {
        $msg['confirm'] = "Confirm Password Is Empty!";
        $error = true;
    } else if ($user_Conpwd != $user_pwd) {
        $msg['confirm'] = "Wrong Confirm Password";
        $error = true;
    }

    if ($error == false) {
        $_POST["username"] = htmlspecialchars($_POST["username"]);
        $_POST["password"] = htmlspecialchars($_POST["password"]);
        $_POST["email"] = htmlspecialchars($_POST["email"]);
        $_POST["address"] = htmlspecialchars($_POST["address"]);
        $_POST["password"] = password_hash($_POST['password'], PASSWORD_BCRYPT, array("cost" => 11));
        $query = "INSERT INTO users (username, password, email, gender, address) VALUES (:username,:password,:email,:gender,:address)";
        $statement = $connect->prepare($query);
        $statement->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
        $statement->bindParam(':password', $_POST["password"], PDO::PARAM_STR);
        $statement->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
        $statement->bindParam(':gender', $_POST["gender"], PDO::PARAM_STR);
        $statement->bindParam(':address', $_POST["address"], PDO::PARAM_STR);
        $statement->execute();
    } else {
        $_SESSION['error'] = $msg;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Login</title>
</head>

<body>
    <!-- Navbar -->
    <!-- <div class="container">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark p-3 shadow-lg">
            <div class="container-md">
                <a class="navbar-brand" href="./index.html">
                    <h2>Apartment.Co</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.html">
                                <h5>Home</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">
                                <h5>Login</h5>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div> -->
    <!-- Navbar -->

    <!-- Login -->
    <section class="login vh-100" style="background-color: #eeede7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0 justify-content-center">
                            <!-- <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://th.bing.com/th/id/OIP.bwTTtN95_22_A8ZqjC8HxwHaNK?pid=ImgDet&rs=1" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div> -->
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="POST">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x"></i>
                                            <span class="h1 fw-bold">Create Account 😊</span>
                                        </div>

                                        <!-- <h5 class="fw-normal mb-2 pb-2" style="letter-spacing: 1px;">Create your
                                            account</h5> -->
                                        <?php if (isset($_SESSION["Error"])) { ?>
                                            ">
                                            <?= $_SESSION["Error"]; ?>
                                        <?php unset($_SESSION["Error"]);
                                        } ?>

                                        <div class="form-outline mb-1">
                                            <input type="text" class="form-control form-control-lg shadow-sm" name="username" />
                                            <label class="form-label">Username</label>
                                        </div>

                                        <div class="form-outline mb-1">
                                            <input type="email" class="form-control form-control-lg shadow-sm" name="email" />
                                            <label class="form-label">Email</label>
                                        </div>

                                        <div class="form-outline mb-1">
                                            <input type="password" class="form-control form-control-lg shadow-sm" name="password" />
                                            <label class="form-label">Password</label>
                                        </div>

                                        <div class="form-outline mb-1">
                                            <input type="password" class="form-control form-control-lg shadow-sm" name="confirmpassword" />
                                            <label class="form-label">Confirm Password</label>
                                        </div>

                                        <div class="form-outline mb-1">
                                            <input type="text" class="form-control form-control-lg shadow-sm" name="address" />
                                            <label class="form-label">Address</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="gender" name="gender" value="Male" checked>
                                            <label class="form-check-label" for="gender">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="gender" name="gender" value="female">
                                            <label class="form-check-label" for="gender">
                                                Female
                                            </label>
                                        </div>
                                        <br>

                                        <!-- <br> -->
                                        <?php
                                        if (isset($_SESSION['error'])) {
                                            foreach ($_SESSION['error'] as $msg) {
                                                echo "$msg";
                                                echo "<br>";
                                            }
                                            unset($_SESSION['error']);
                                        }
                                        ?>
                                        <br>
                                        <div class="pt-1 mb-4">
                                            <button class="register_btn btn-dark btn-lg btn-block" name="register" input type="submit">Register</button>
                                        </div>
                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Have account? <a href="./login.php" style="color: #393f81;">Login here</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login -->

    <!-- Footer -->
    <section class="footer">
        <div class="container">
            <footer class="py-5">
                <div class="row justify-content-between">
                    <div class="col-2">
                        <h5>Section</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="./index.html" class="nav-link p-0 text-muted">Home</a>
                            </li>
                            <li class="nav-item mb-2"><a href="./login.php" class="nav-link p-0 text-muted">Login</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4 offset-1">
                        <form>
                            <h5>Subscribe to our newsletter</h5>
                            <p>Monthly digest of whats new and exciting from us.</p>
                            <div class="d-flex w-100 gap-2">
                                <label for="newsletter1" class="visually-hidden">Email address</label>
                                <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                                <button class="btn btn-primary" type="button">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-between py-4 my-4 border-top">
                    <p>&copy; 2022 Apartment.Co. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </section>
    <!-- Footer -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>