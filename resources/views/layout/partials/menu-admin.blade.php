<div class="pcoded-navigatio-lavel">Admin</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu active pcoded-trigger">
                                    <a href="{{ url('/admin') }}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                        <span class="pcoded-mtext">Data User</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="{{ url('/listuser') }}">
                                                <span class="pcoded-mtext">Data User</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('/listpeserta') }}">
                                                <span class="pcoded-mtext">Data Peserta</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ url('/listjuri') }}">
                                                <span class="pcoded-mtext">Data Juri</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="ion-android-settings"></i></span>
                                        <span class="pcoded-mtext">Other</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <li class=" ">
                                                <a href="{{ url('/categorylist') }}">
                                                    <span class="pcoded-mtext">Category</span>
                                                </a>
                                            </li>
                                            <li class=" ">
                                                <a href="{{ url('/maindealerlist') }}">
                                                    <span class="pcoded-mtext">Main Dealer</span>
                                                </a>
                                            </li>
                                        </li>
                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-edit-1"></i></span>
                                        <span class="pcoded-mtext">Course</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <a href="{{ url('/admin/exams') }}">
                                                <span class="pcoded-mtext">Manage Course</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="{{ url('/admin/manage-participants') }}">
                                                <span class="pcoded-mtext">Manage Participants</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                                        <span class="pcoded-mtext">Score Card</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <a href="{{ url('/admin/scorecardlist') }}">
                                                <span class="pcoded-mtext">Manage Score Card</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="form-elements-add-on.htm">
                                                <span class="pcoded-mtext">Manage Juri & Peserta</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="editable-table.htm">
                                        <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                        <span class="pcoded-mtext">Editable Table</span>
                                    </a>
                                </li>
                            </ul>