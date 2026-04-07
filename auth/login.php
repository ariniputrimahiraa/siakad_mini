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
<html>
<head>
<title>Login</title>
<style>
body { font-family: Arial; background:#eef2f7; }
.card { width:300px; margin:100px auto; background:white; padding:20px; border-radius:10px; }
input, button { width:100%; padding:10px; margin:5px 0; }
button { background:#3498db; color:white; border:none; }
</style>
</head>
<body>

<div class="card">
<h2>Login</h2>

<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
<input name="username" placeholder="Username" required>
<input name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>
</div>

</body>
</html>