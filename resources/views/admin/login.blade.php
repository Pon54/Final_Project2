<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/legacy/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/legacy/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/legacy/admin/css/style.css">
    <style>body{background:#333}</style>
</head>
<body>
    <div class="login-page bk-img" style="background-image: url('/legacy/admin/img/login-bg.jpg');">
        <div class="form-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <h1 class="text-center text-bold mt-4x" style="color:#fff">Admin | Sign in</h1>
                        <div class="well row pt-2x pb-3x bk-light">
                            <div class="col-md-8 col-md-offset-2">
                                @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
                                <form method="post" action="{{ url('/admin/login') }}">
                                    @csrf
                                    <label class="text-uppercase text-sm">Your Username </label>
                                    <input type="text" placeholder="Username" name="username" class="form-control mb">
                                    <label class="text-uppercase text-sm">Password</label>
                                    <input type="password" placeholder="Password" name="password" class="form-control mb">
                                    <button class="btn btn-primary btn-block" name="login" type="submit">LOGIN</button>
                                </form>
                                <p style="margin-top: 4%" align="center"><a href="/">Back to Home</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/legacy/admin/js/jquery.min.js"></script>
    <script src="/legacy/admin/js/bootstrap.min.js"></script>
</body>
</html>
