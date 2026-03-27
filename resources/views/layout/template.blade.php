<!DOCTYPE html>
<html lang="en">

<head>
    <title>KLHN 2026 &mdash; @yield('title')</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\icon\font-awesome\css\font-awesome.min.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\icon\icofont\css\icofont.css') }}">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\pages\data-table\css\buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('files\bower_components\select2\css\select2.min.css') }}">
    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\bower_components\bootstrap-multiselect\css\bootstrap-multiselect.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('files\bower_components\multiselect\css\multi-select.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\css\style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\css\jquery.mCustomScrollbar.css') }}">
    
    <!-- Custom CSS for responsive logout -->
    <style>
        /* Responsive logout styles */
        .desktop-logout {
            display: block;
        }
        .mobile-logout {
            display: none;
            margin-top: auto; /* Pushes to bottom */
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .mobile-logout .logout-btn {
            display: flex;
            align-items: center;
            color: #fff;
            width: 100%;
            background: none;
            border: none;
            text-align: left;
            padding: 8px 0;
        }
        .mobile-logout .logout-btn i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        @media (max-width: 992px) {
            .desktop-logout {
                display: none !important;
            }
            .mobile-logout {
                display: block;
            }
        }
        
        /* Adjust header for better mobile view */
        .navbar-logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        .navbar-logo .mobile-menu {
            order: 1;
        }
        .navbar-logo .logo-img {
            order: 2;
            margin: 0 auto;
        }
        .navbar-logo .spacer {
            order: 3;
            width: 40px;
        }
    </style>
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
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="fa fa-bars"></i>
                        </a>
                        <a href="index-1.htm" class="logo-img">
                            <img class="img-fluid" src="{{ asset('files/assets/images/Logo-100.png') }}" alt="Theme-Logo" style="max-height: 40px; width: auto;">
                        </a>
                        <div class="spacer"></div>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right desktop-logout">
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown" style="display: flex; align-items: center; gap: 8px;">
                                        <div style="
                                            width: 30px;
                                            height: 30px;
                                            border-radius: 6px;
                                            background-color: #6c757d;
                                            color: white;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-weight: bold;
                                            font-size: 15px; ">
                                            {{ Auth::user()->initials }}
                                        </div>
                                        <span>Hai, {{ Auth::user()->display_name }}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" style="background: none; border: none; width: 100%; text-align: left;">
                                                    <i class="feather icon-log-out"></i> Logout
                                                </button>
                                            </form>                            
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            @if (Auth::user()->role == 'Admin')
                                @include('layout.partials.menu-admin')
                            @elseif(Auth::user()->role == 'AdminMD')
                                @include('layout.partials.menu-adminmd')
                            @elseif(Auth::user()->role == 'Juri')
                                @include('layout.partials.menu-juri')
                            @elseif(Auth::user()->role == 'Peserta')
                                @include('layout.partials.menu-peserta')
                            @endif
                            
                            <!-- Mobile Logout Button -->
                            <div class="mobile-logout">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="logout-btn">
                                        <i class="feather icon-log-out"></i> 
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </nav>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tambahkan ini sebelum </body> -->
    <script type="text/javascript" src="{{ asset('files\assets\js\sweetalert2@11.js') }}"></script>
    <script>
        setInterval(() => {
            fetch("{{ route('check.session') }}", {
                method: "GET",
                headers: {
                    "X-User-ID": "{{ Auth::id() }}"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'expired') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sesi Anda Telah Habis',
                        text: 'Silakan login kembali.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        fetch("{{ route('logout') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({})
                        })
                        .then(() => {
                            window.location.href = "{{ route('login') }}";
                        });
                    });
                }
            });
        }, 60000);
        
        // Make sure mobile menu toggle works
        document.getElementById('mobile-collapse').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('pcoded').classList.toggle('mob-open');
        });
    </script>   

    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('files\bower_components\jquery\js\jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\jquery-ui\js\jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\popper.js\js\popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\bootstrap\js\bootstrap.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('files\bower_components\modernizr\js\modernizr.js') }}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset('files\bower_components\chart.js\js\Chart.js') }}"></script>
    <!-- amchart js -->
    <script src="{{ asset('files\assets\pages\widget\amchart\amcharts.js') }}"></script>
    <script src="{{ asset('files\assets\pages\widget\amchart\serial.js') }}"></script>
    <script src="{{ asset('files\assets\pages\widget\amchart\light.js') }}"></script>
    <script src="{{ asset('files\assets\js\jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\assets\js\SmoothScroll.js') }}"></script>
    <script src="{{ asset('files\assets\js\pcoded.min.js') }}"></script>
    <!-- data-table js -->
    <script src="{{ asset('files\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('files\assets\pages\data-table\js\jszip.min.js') }}"></script>
    <script src="{{ asset('files\assets\pages\data-table\js\pdfmake.min.js') }}"></script>
    <script src="{{ asset('files\assets\pages\data-table\js\vfs_fonts.js') }}"></script>
    <script src="{{ asset('files\bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
    <script src="{{ asset('files\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
    <script src="{{ asset('files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>
    <!-- custom js -->
    <script type="text/javascript" src="{{ asset('files\assets\pages\advance-elements\select2-custom.js') }}"></script>
    <script src="{{ asset('files\assets\pages\data-table\js\data-table-custom.js') }}"></script>
    <script src="{{ asset('files\assets\js\vartical-layout.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\assets\pages\dashboard\custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\assets\js\script.min.js') }}"></script>
    <!-- Select 2 js -->
    <script type="text/javascript" src="{{ asset('files\bower_components\select2\js\select2.full.min.js') }}"></script>
    <!-- Multiselect js -->
    <script type="text/javascript" src="{{ asset('files\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\multiselect\js\jquery.multi-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\assets\js\jquery.quicksearch.js') }}"></script>

    <script src="{{ asset('files\assets\pages\form-masking\inputmask.js') }}"></script>
    <script src="{{ asset('files\assets\pages\form-masking\jquery.inputmask.js') }}"></script>
    <script src="{{ asset('files\assets\pages\form-masking\autoNumeric.js') }}"></script>
    <script src="{{ asset('files\assets\pages\form-masking\form-mask.js') }}"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
</body>
</html>