<!DOCTYPE html>
<html lang="es" dir="ltr">

</html>

<head>
    <title>LapXuongStore Welcome</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend\dist\css\login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
</head>


<body>
    <div class="main">
        <div class="container b-container" id="b-container">
            <form class="form" id="b-form" method="post" action="{{ Route('login') }}">
                @csrf
                <h2 class="form_title title">Sign in to LapXuong</h2>
                <span class="form__span">use your email account</span>
                <input class="form__input" type="text" placeholder="Email" name="email" required @error('email') is-invalid @enderror autofocus autocomplete="email" value="{{ old('email') }}">
                @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ "Wrong email or password !" }}</strong>
                                        </span>
                @enderror
                <input class="form__input" type="password" placeholder="Password" name="password" required>
                <a class="form__span" href="{{ Route('password.request') }}" >Forgot your password?</a>
                <button class="form__button button  type="submit">SIGN IN</button>
            </form>
        </div>
        <div class="container a-container" id="a-container">
            <form class="form" id="a-form" method="post" action="{{ Route('register') }}">
               @csrf
                <h2 class="form_title title">Create Account</h2>

                <span class="form__span">use email for registration</span>
                <input class="form__input" type="text" placeholder="FullName" name="name" required>
                    <input class="form__input" type="email" placeholder="Email" name="email" required>
                    <input class="form__input" type="password" placeholder="Password" name="password" required>
                    <input class="form__input" type="password" placeholder="Retype password" name= "password_confirmation" required>
                    <button class="form__button button " type="submit" style="background-color:#4154f1">SIGN UP</button>
            </form>
        </div>
        <div class="switch" id="switch-cnt">
            <div class="switch__circle"></div>
            <div class="switch__circle switch__circle--t"></div>
            <div class="switch__container" id="switch-c1">
                <h2 class="switch__title title">Welcome Back !</h2>
                <p class="switch__description description">To keep connected with us please login with your personal info</p>
                    <button class="switch__button button switch-btn" style="background-color:#4154f1">SIGN IN</button>
            </div>
            <div class="switch__container is-hidden" id="switch-c2">

                <h2 class="switch__title title">Hello Friend !</h2>
                <p class="switch__description description">Enter your personal details and start journey with us</p>
                <button class="switch__button button switch-btn" >SIGN UP</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/dist/js/login.js') }}"></script>
</body>
