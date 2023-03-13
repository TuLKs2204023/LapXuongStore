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
        <div class="container b-container is-txl is-z200" id="b-container">
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
                <a class="form__span" href="{{ Route('password.request') }}">Forgot your password?</a>
                <button class="form__button button  type=" submit">SIGN IN</button>



            </form>
        </div>
        <div class="container a-container is-txl" id="a-container">
            <form class="form" id="a-form" method="post" action="{{ Route('register') }}">
                @csrf
                <h2 class="form_title title">Create Account</h2>

                <span class="form__span">use email for registration</span>
                <input class="form__input" type="text" placeholder="FullName" name="name" required>
                <input class="form__input" type="email" placeholder="Email" name="email" required>
                <input class="form__input" type="password" placeholder="Password" name="password" required>
                <input class="form__input" type="password" placeholder="Retype password" name="password_confirmation" required>
                <button class="form__button button " type="submit" style="background-color:#4154f1">SIGN UP</button>
            </form>
        </div>
        <div class="switch is-txr" id="switch-cnt">
            <div class="switch__circle is-txr"></div>
            <div class="switch__circle switch__circle--t is-txr"></div>
            <div class="switch__container is-hidden" id="switch-c1">
                <h2 class="switch__title title">Welcome Back !</h2>
                <p class="switch__description description">To keep connected with us please login with your personal info</p>


                <button class="switch__button button switch-btn" style="background-color:#4154f1">SIGN IN</button>
                    <h3 style="margin-top: 30px">Or sign in with</h3>
                <p style="margin-top: 20px ;">
                        <a href="{{ route('auth.google') }} " title="Sign in with your Google account">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16"
                            onMouseOver="this.style.color='#4154f1'" onMouseOut="this.style.color='currentColor'"
                            >
                                <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                            </svg>
                        </a>
                        <a href="{{ route('auth.facebook') }}" title="Sign in with your Facebook account" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16" style="margin-left: 20px"
                            onMouseOver="this.style.color='#4154f1'" onMouseOut="this.style.color='currentColor'"

                            >
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                              </svg>
                        </a>

                    </p>
            </div>
            <div class="switch__container" id="switch-c2">

                <h2 class="switch__title title">Hello Friend !</h2>
                <p class="switch__description description">Enter your personal details and start journey with us</p>
                <button class="switch__button button switch-btn">SIGN UP</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/dist/js/login.js') }}"></script>
</body>
