@extends('layout.template')
@section('title', 'Dashboard')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <h5>Lampiran</h5>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="table table-styling">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center" style="width: 100px;">No</th>
                                            <th class="text-center">Nama File</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <th class="text-center" style="width: 100px;">1</th>
                                                <td class="text-center">Lampiran Peserta</td>
                                                <td class="text-center">
                                                    <a href="https://drive.google.com/file/d/1VvKSFafYz0lXl2EQAD5XVQwaYgOO2jUV" 
                                                        target="_blank" 
                                                        class="btn btn-sm btn-info">
                                                        <i class="feather icon-download"></i> Download
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-center" style="width: 100px;">2</th>
                                                <td class="text-center">Lampiran KLHR</td>
                                                <td class="text-center">
                                                    <a href="https://drive.google.com/file/d/1UTp1J-W_7AUzZZMXFria_AYCoANa9Gwx" 
                                                        target="_blank" 
                                                        class="btn btn-sm btn-info">
                                                        <i class="feather icon-download"></i> Download
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-center" style="width: 100px;">3</th>
                                                <td class="text-center">Panduan Presentasi Team Leader</td>
                                                <td class="text-center">
                                                    <a href="https://drive.google.com/file/d/1bEE5-KU7jp_H5x3E2uMUpBX425-lcpTX/view?usp=drivesdk" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-info ">
                                                       <i class="feather icon-download"></i> Download
                                                    </a>
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
@endsection