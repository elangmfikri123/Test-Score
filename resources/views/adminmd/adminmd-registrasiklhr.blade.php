@extends('layout.template')
@section('title', 'Registrasi KLHR')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3><strong>Submission KLHR</strong></h3>
                                </div>
                                <hr class="m-0">
                                <div class="card-block">
                                    <form action="{{ route('submission.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Main Dealer *</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-init" name="maindealer_id" required>
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
                                                <input type="url" class="form-control" name="link_klhr1" placeholder="Link publikasi KLHR" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Link Publikasi KLHR 2</label>
                                            <div class="col-sm-9">
                                                <input type="url" class="form-control" name="link_klhr2" placeholder="Link publikasi KLHR">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Link Publikasi KLHR 3</label>
                                            <div class="col-sm-9">
                                                <input type="url" class="form-control" name="link_klhr3" placeholder="Link publikasi KLHR">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <i class="feather icon-file" style="italic"></i><em><a href="{{ asset('templates/template_submission.xlsx') }}">Download Template File Submission</a></em>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">File Submission (.xlsx) *</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="file_submission" accept=".xlsx,.xls" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">File Submission Tanda Tangan (.pdf) *</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="file_ttdkanwil" accept=".pdf" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <i class="feather icon-file" style="italic"></i><em><a href="{{ asset('templates/template_evidence.pdf') }}">Download Template File Submission Evidence</a></em>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">File Submission Evidence Pelaksaan (.pdf) *</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="file_dokumpelaksanaan" accept=".pdf" required>
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