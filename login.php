<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$db = "AssessmentSecProg";
try {
    $connect = new PDO("mysql:host=$servername; dbname=$db", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_SESSION["Lock"])) {
        $diff = time() - $_SESSION["Lock"];
        if ($diff > 10) {
            unset($_SESSION["Lock"]);
            unset($_SESSION["attempt"]);
        }
    }
    if (!isset($_SESSION['attempt'])) {
        $_SESSION['attempt'] = 0;
    }
    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<label>All fields are required</label>';
        } else {
            $query = "SELECT * FROM users WHERE username = :username AND password = :password";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'username'     =>     $_POST["username"],
                    'password'     =>     $_POST["password"]
                )
            );
            $count = $statement->rowCount();
            if ($count > 0) {
                $_SESSION["username"] = $_POST["username"];
                echo "Berhasil";
            } else {
                $_SESSION["attempt"] += 1;
                // $_SESSION['Error'] = "Wrong CredentialS";
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage();
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

    <title>Login</title>
</head>

<body>
    <!-- Navbar -->
    <div class="container">
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
    </div>
    <!-- Navbar -->

    <!-- Login -->
    <section class="login vh-100" style="background-color: #eeede7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://th.bing.com/th/id/OIP.bwTTtN95_22_A8ZqjC8HxwHaNK?pid=ImgDet&rs=1" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="POST">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3"></i>
                                            <span class="h1 fw-bold mb-0">Welcome Back!👋</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your
                                            account</h5>
                                        <?php if (isset($_SESSION["Error"])) { ?>
                                            ">
                                            <?= $_SESSION["Error"]; ?>
                                        <?php unset($_SESSION["Error"]);
                                        } ?>

                                        <div class="form-outline mb-4">
                                            <input type="text" class="form-control form-control-lg" name="username" />
                                            <label class="form-label">Username</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" class="form-control form-control-lg" name="password" />
                                            <label class="form-label">Password</label>
                                        </div>

                                        <?php
                                        if ($_SESSION["attempt"] >= 2) {
                                            $_SESSION["Lock"] = time();
                                            echo "<p>Please wait for 10 seconds</p>";
                                        } else {
                                        }
                                        ?>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" name="login">Login</button>
                                        </div>
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
    <!-- Optional JavaScript; choose one of the two! -->
    <!--
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="./assets/particles.js/particles.js-master/"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<sc
</body>

sc</html>ript src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->

</body>

</html>