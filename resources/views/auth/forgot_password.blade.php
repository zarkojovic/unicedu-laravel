<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Forgot password</h1>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <form action="/forgot-password" method="POST" id="form-reset-password">
                    @csrf
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email"/>
                    <input type="submit" value="Submit"/>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
