<?php
session_start();
if (isset($_POST['sifre'])) {
    if ($_POST['sifre'] == '123') { // Şifren şimdilik 123
        $_SESSION['giris'] = true;
        header("Location: index.php");
    } else {
        $hata = "Hatalı şifre!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Giriş Yap</title>
    <style>
        body { background: #121212; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: sans-serif; }
        .login-box { background: #1e1e1e; padding: 40px; border-radius: 10px; text-align: center; }
        input { padding: 10px; width: 200px; border-radius: 5px; border: none; }
        button { padding: 10px 20px; background: #4caf50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-box">
        <h3>Trading Journal Giriş</h3>
        <form method="POST">
            <input type="password" name="sifre" placeholder="Şifreniz" required><br><br>
            <button type="submit">Giriş Yap</button>
        </form>
        <?php if(isset($hata)) echo $hata; ?>
    </div>
</body>
</html>