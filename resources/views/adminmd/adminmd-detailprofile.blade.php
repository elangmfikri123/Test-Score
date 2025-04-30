@extends('layout.template')
@section('title', 'Detail Peserta')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-header start -->
                    <div class="page-header">
                        <div class="row align-items-end">
                            <div class="col-lg-8">
                                <div class="page-header-title">
                                    <div class="d-inline">
                                        <h4>User Profile</h4>
                                        <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="page-header-breadcrumb">
                                    <ul class="breadcrumb-title">
                                        <li class="breadcrumb-item">
                                            <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">User Profile</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="#!">User Profile</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page-header end -->

                    <!-- Page-body start -->
                    <div class="page-body">
                        <!--profile cover start-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cover-profile">
                                    <div class="profile-bg-img">
                                        <img class="profile-bg-img img-fluid"
                                            src="{{ asset('files\assets\images\user-profile\bg-img1.jpg') }}"
                                            alt="bg-img">
                                        <div class="card-block user-info">
                                            <div class="col-md-12">
                                                <div class="media-left">
                                                    <div class="profile-image">
                                                        <img class="user-img img-radius"
                                                            src="{{ asset('files\assets\images\user-profile\user-img.jpg') }}"
                                                            alt="user-img">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--profile cover end-->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- tab header start -->
                                <div class="tab-header card">
                                    <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#bpeserta"
                                                role="tab">Data Peserta</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#batasan" role="tab">Data Atasan</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#bdealer" role="tab">Data Dealer</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#bfiles" role="tab">Files</a>
                                            <div class="slide"></div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    <!-- tab panel personal start -->
                                    
                                    <div class="tab-pane active" id="bpeserta" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Identitas Peserta</h5>
                                                <button id="edit-btn" type="button"
                                                    class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                    <i class="icofont icofont-edit"></i>
                                                </button>
                                            </div>
                                            <div class="card-block">
                                                <div class="view-info">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="general-info">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table m-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Full Name</th>
                                                                                        <td>Josephine Villa</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Gender</th>
                                                                                        <td>Female</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Birth Date</th>
                                                                                        <td>October 25th, 1990</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Marital Status
                                                                                        </th>
                                                                                        <td>Single</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Location</th>
                                                                                        <td>New York, USA</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end of table col-lg-6 -->
                                                                    <div class="col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Email</th>
                                                                                        <td><a href="#!"><span
                                                                                                    class="__cf_email__"
                                                                                                    data-cfemail="4206272f2d02273a232f322e276c212d2f">[email&#160;protected]</span></a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Mobile Number
                                                                                        </th>
                                                                                        <td>(0123) - 4567891</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Twitter</th>
                                                                                        <td>@xyz</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Skype</th>
                                                                                        <td>demo.skype</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Website</th>
                                                                                        <td><a
                                                                                                href="#!">www.demo.com</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="batasan" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Data Atasan Peserta</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="view-info">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table m-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Full Name</th>
                                                                                        <td>Josephine Villa</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Gender</th>
                                                                                        <td>Female</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Birth Date</th>
                                                                                        <td>October 25th, 1990</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Marital Status
                                                                                        </th>
                                                                                        <td>Single</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Location</th>
                                                                                        <td>New York, USA</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end of table col-lg-6 -->
                                                                    <div class="col-lg-12 col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Email</th>
                                                                                        <td><a href="#!"><span
                                                                                                    class="__cf_email__"
                                                                                                    data-cfemail="4206272f2d02273a232f322e276c212d2f">[email&#160;protected]</span></a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Mobile Number
                                                                                        </th>
                                                                                        <td>(0123) - 4567891</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Twitter</th>
                                                                                        <td>@xyz</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Skype</th>
                                                                                        <td>demo.skype</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Website</th>
                                                                                        <td><a
                                                                                                href="#!">www.demo.com</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end of table col-lg-6 -->
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="bdealer" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Review</h5>
                                            </div>
                                            <div class="card-block">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="bfiles" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">Files</h5>
                                            </div>
                                            <div class="card-block">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
