@extends('layout.template')
@section('title', 'Peserta List - Admin')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5><i class="feather icon-edit"></i> Submission KLHR</h5>
                                </div>
                                <hr class="m-0">
                                <div class="card-block">
                                    <form action="{{ url('/admin/course/store') }}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Main Dealer *</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-init" name="main_dealer_id" >
                                                    <option value="" disabled selected>Pilih Main Dealer</option>
                                                    @foreach($mainDealers as $dealer)
                                                        <option value="{{ $dealer->id }}">{{ $dealer->kodemd }} - {{ $dealer->nama_md }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>    
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Link Publikasi KLHR 1 *</label>
                                            <div class="col-sm-9">
                                                <input type="url" class="form-control" placeholder="Link publikasi KLHR" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Link Publikasi KLHR 2 *</label>
                                            <div class="col-sm-9">
                                                <input type="ulr" class="form-control" placeholder="Link publikasi KLHR" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Link Publikasi KLHR 3 *</label>
                                            <div class="col-sm-9">
                                                <input type="ulr" class="form-control" placeholder="Link publikasi KLHR" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">File Submission New Format *</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" placeholder="Masukkan Honda ID" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">File Submission TTD KANWIL *</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" placeholder="Masukkan Honda ID" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">File Submission Dokumentasi Pelaksaan (.pdf) *</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" placeholder="Masukkan Honda ID" >
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success">
                                                <i class="ion-checkmark"></i> Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        
        $('.select2-init').select2({
            minimumResultsForSearch: 1 
        });
    });
</script>
@endsection