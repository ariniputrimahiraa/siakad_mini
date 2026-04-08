<?php
session_start();

$data = json_decode(file_get_contents("../data/users.json"), true);

if (isset($_POST['login'])) {
    foreach ($data as $user) {
        if ($_POST['username'] == $user['username'] &&
            $_POST['password'] == $user['password']) {

            $_SESSION['login'] = true;
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['nim'] = isset($user['nim']) ? $user['nim'] : null;

            if ($user['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } elseif ($user['role'] == 'dosen') {
                header("Location: ../dosen/dashboard.php");
            } else {
                header("Location: ../mahasiswa/dashboard.php");
            }
            exit;
        }
    }
    $error = "Login gagal!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="icon" href="../assets/buk.png" type="image/png">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #e4e8ee, #0a3a7a);
}

.container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    width: 880px;
    max-width: 95%;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

/* LEFT */
.left {
    background: #052455;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 50px 30px;
    text-align: center;
    gap: 15px;
}

/* LOGO FIX BULAT */
.logo {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo img {
    width: 70%;
    height: 70%;
    object-fit: cover; /* bikin selalu penuh & rapi */
}

.left h1 {
    font-size: 20px;
    margin-bottom: 2px;
}

.left p {
    font-size: 14px;
    opacity: 0.85;
    margin-top: -10px;
}

/* RIGHT */
.right {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 50px 40px;
}

.form-box {
    width: 100%;
    max-width: 320px;
    margin: 0 auto; /* BIKIN SIMETRIS */
}

.right h2 {
    margin-bottom: 20px;
    color: #052455;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    transition: 0.3s;
}

input:focus {
    border-color: #052455;
    outline: none;
    box-shadow: 0 0 6px rgba(5,36,85,0.3);
}

button {
    width: 100%;
    padding: 12px;
    background: #052455;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #0a3a7a;
}

.error {
    background: #ffe5e5;
    color: red;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 14px;
    text-align: center;
}

@media(max-width: 768px) {
    .container {
        grid-template-columns: 1fr;
    }
    .left {
        display: none;
    }
}

</style>
</head>
<body>

<div class="container">

    <div class="left">
        <div class="logo">
           <img src="../assets/buk.png">
        </div>
        <h1>SIAKAD</h1>
        <p>Sistem Informasi Akademik</p>
    </div>

    <div class="right">
        <div class="form-box">
            <h2>Login</h2>

            <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">
                <div class="form-group">
                    <input name="username" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button name="login">Masuk</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>