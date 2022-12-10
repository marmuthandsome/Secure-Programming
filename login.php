<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$db = "assessmentSecProg";
$connect = new PDO("mysql:host=$servername; dbname=$db", $username, $password);
$connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST["login"])) {
    $_POST["username"] = htmlspecialchars($_POST["username"]);
    $_POST["password"] = htmlspecialchars($_POST["password"]);
    $time = time() - 30;
    $ip = '127.0.0.1';
    $query = "SELECT count(*) FROM log WHERE ip = :ip AND time > :time";
    $limitquery = $connect->prepare($query);
    $limitquery->bindValue(':ip', $ip);
    $limitquery->bindValue(':time', $time);
    $limitquery->execute();
    $totalfailedloginattempts = $limitquery->fetchColumn();
    if ($totalfailedloginattempts == 3) {
        $_SESSION['Message'] = "Too many failed login attempts";
    } else {
        if (isset($_POST['g-recaptcha-response'])) {
            $secret = "6LfkzGMjAAAAAFR6Npy2bSFkBwDYff9DQL0609Xf";
            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
            $data = json_decode($response);
            if ($data->success) {
                $query = "SELECT * FROM users WHERE username = :username";
                $statement = $connect->prepare($query);
                $statement->bindParam(':username', $_POST["username"]);
                $statement->execute();
                $output = $statement->fetch(PDO::FETCH_ASSOC);
                if (password_verify($_POST["password"], $output['password'])) {
                    $_SESSION["username"] = $_POST["username"];
                    $sql = "DELETE FROM log WHERE ip=?";
                    $stmt = $connect->prepare($sql);
                    $stmt->execute(["127.0.0.1"]);
                    header("Location: ./dashboard.php");
                    unset($_SESSION['Message']);
                } else {
                    $ip_address = '127.0.0.1';
                    $logtime = time();
                    $query = "INSERT INTO log (ip, time) VALUES (:ip,:time)";
                    $stmt = $connect->prepare($query);
                    $stmt->bindParam(':ip', $ip_address);
                    $stmt->bindParam(':time', $logtime);
                    $stmt->execute();
                    $totalfailedloginattempts++;
                    $_SESSION['Message'] = "Invalid Username or Password";
                }
            }
        }
        if (empty($_POST['g-recaptcha-response'])) {
            $_SESSION['Message'] = "Please insert your Username or Password";
        }
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
                                            <span class="h1 fw-bold">Welcome Back!👋</span>
                                        </div>

                                        <h5 class="fw-normal mb-2 pb-2" style="letter-spacing: 1px;">Sign into your
                                            account</h5>
                                        <?php if (isset($_SESSION["Error"])) { ?>
                                            ">
                                            <?= $_SESSION["Error"]; ?>
                                        <?php unset($_SESSION["Error"]);
                                        } ?>

                                        <div class="form-outline mb-1">
                                            <input type="text" class="form-control form-control-lg shadow-sm" name="username" />
                                            <label class="form-label ">Username</label>
                                        </div>

                                        <div class="form-outline mb-1">
                                            <input type="password" class="form-control form-control-lg shadow-sm" name="password" />
                                            <label class="form-label">Password</label>
                                        </div>
                                        <div class="g-recaptcha" data-sitekey="6LfkzGMjAAAAAIIgY1A0BNyDpDokKU2OiTBAJze-"></div>
                                        <br>
                                        <?php
                                        if (isset($_SESSION['Message'])) {
                                            echo $_SESSION['Message'];
                                        }
                                        unset($_SESSION['Message']);
                                        ?>
                                        <br><br>
                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block shadow-lg" name="login" input type="submit">Login</button>
                                        </div>
                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="./register.php" style="color: #393f81;">Register here</a></p>
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