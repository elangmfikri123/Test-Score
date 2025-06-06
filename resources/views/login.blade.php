<!DOCTYPE html>
<html lang="en">

<head>
    <title>KLHN 2025 | Login</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords"
        content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('files\assets\images\Logo-100.png') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\bower_components\bootstrap\css\bootstrap.min.css') }}">
    <!-- ion icon css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\icon\ion-icon\css\ionicons.min.css') }}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\icon\feather\css\feather.css') }}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\icon\themify-icons\themify-icons.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\icon\icofont\css\icofont.css') }}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\icon\feather\css\feather.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\css\style.css') }}">
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded load-height">
        <!-- Menu header end -->
        <section class="login-block with-header">
            <!-- Container-fluid starts -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Authentication card start -->
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center mb-3">
                                            <img class="img-fluid" src="{{ asset('files/assets/images/Logo-100.png') }}" alt="Theme-Logo" style="max-height: 120px; width: auto;">
                                        </div>
                                        <h3 class="text-center txt-primary">Selamat Datang !</h3>
                                        <p class="text-muted text-center p-b-5">Silakan masukan username, password
                                            untuk masuk ke halaman.</p>
                                            @if ($errors->any())
                                            <div class="alert alert-warning background-warning" style="position: relative;">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <i class="ion-close-circled text-white"></i>
                                                </button>
                                                <strong>Gagal Login !</strong> {{ $errors->first() }}
                                            </div>
                                            @endif
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('login.submit') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i
                                                        class="ion-person icon-black"></i></span>
                                                <input type="text" name="username" class="form-control" required
                                                    placeholder="Username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i
                                                    class="ion-locked icon-black"></i></span>
                                            <input type="password" id="password" name="password" class="form-control" autocomplete="off" inputmode="text"
                                                required placeholder="Password">
                                            <span class="input-group-addon" onclick="togglePassword()"
                                                style="cursor: pointer;">
                                                <i class="ion-eye-disabled" id="eye-icon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row m-t-25 text-left">
                                        <div class="col-12">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="checkbox" value="">
                                                    <span class="cr"><i
                                                            class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span class="text-inverse">Remember me</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit"
                                                class="btn btn-grd-info btn-block waves-effect text-center m-b-20"><i class="feather icon-log-in"></i> Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container-fluid -->

        </section>
        <style>
            .icon-black {
                color: #444 !important;
                font-size: 16px;
            }

            #eye-icon {
                font-size: 16px;
                color: #444;
            }
            input::-ms-reveal {
                display: none;
            }
        </style>
        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('ion-eye-disabled');
                    eyeIcon.classList.add('ion-eye');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('ion-eye');
                    eyeIcon.classList.add('ion-eye-disabled');
                }
            }
        </script>
        
        <!-- Required Jquery -->
        <script type="text/javascript" src="{{ asset('files\bower_components\jquery\js\jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('files\bower_components\jquery-ui\js\jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('files\bower_components\popper.js\js\popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('files\bower_components\bootstrap\js\bootstrap.min.js') }}"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="{{ asset('files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js') }}">
        </script>
        <!-- modernizr js -->
        <script type="text/javascript" src="{{ asset('files\bower_components\modernizr\js\modernizr.js') }}"></script>
        <script type="text/javascript" src="{{ asset('files\bower_components\modernizr\js\css-scrollbars.js') }}"></script>
        <!-- i18next.min.js -->
        <script type="text/javascript" src="{{ asset('files\bower_components\i18next\js\i18next.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ asset('files\bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ asset('files\bower_components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('files\bower_components\jquery-i18next\js\jquery-i18next.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('files\assets\js\common-pages.js') }}"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-23581568-13');
        </script>
</body>

</html>
