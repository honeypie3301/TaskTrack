<!DOCTYPE html>
<html>
<head>
    <title>TaskTrack</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background-color: #121212; color: #e0e0e0; padding: 30px 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .box { background: #1e1e1e; padding: 25px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #2d2d2d; }
        h2, h3 { margin-bottom: 15px; color: #ffffff; }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], textarea, select { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #3d3d3d; border-radius: 4px; background: #2a2a2a; color: #ffffff; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #3498db; }
        button, .btn { display: inline-block; width: 100%; padding: 12px; background-color: #3498db; color: #fff; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; text-decoration: none; text-align: center; }
        button:hover, .btn:hover { background-color: #2980b9; }
        .btn-secondary { background-color: #555; }
        .btn-secondary:hover { background-color: #666; }
    </style>
</head>
<body>

<div class="container">

<div class="box">
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>
</div>

<div class="box">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>
</div>

</div>

</body>
</html>