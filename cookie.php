<?php

$user_name = $user_pw = '';
$user_name_err = $user_pw_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['username'])) {
        $user_name_err = 'Khong dc de trong cot';
    } else {
        if ($_POST['username'] === 'admin') {
            $user_name = htmlspecialchars($_POST['username']);
            $user_name_err = "";
        } else {
            $user_name_err = "Ten dang nhap khong dung , Vui long nhap lai";
        }
    }
    if (empty($_POST['userpw'])) {
        $user_pw_err = 'Khong dc de trong cot';
    } else {
        if ($_POST['userpw'] === '123456') {
            $user_pw = htmlspecialchars($_POST['userpw']);
            $user_pw_err = "";
        } else {
            $user_pw_err = "Mat khau khong dung , Vui long nhap lai";
        }
    }

    if ($user_name !== '' && $user_pw !== '') {
        setcookie("username", $user_name, time() + 60, '/');
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }

        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .container input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .container input:focus {
            border-color: #4facfe;
            box-shadow: 0 0 6px rgba(79, 172, 254, 0.5);
        }

        .container button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .container button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        .welcome {
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (isset($_COOKIE["username"])): ?>
            <p class="welcome">Xin chào <?= $_COOKIE["username"] ?></p>
            <form action="deleteCk.php" method="POST">
                <button type="submit">Đăng xuất</button>
            </form>
        <?php else: ?>
            <h2>Đăng nhập</h2>
            <form action="" method="POST">
                <input type="text" name="username" placeholder="Nhập tên đăng nhập">
                <span class="error"><?= $user_name_err ?></span>

                <input type="password" name="userpw" placeholder="Nhập mật khẩu">
                <span class="error"><?= $user_pw_err ?></span>

                <button type="submit">Login</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>