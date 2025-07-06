@extends('layout.template')
@section('title', 'Result Course')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Export Hasil Ujian</h5>
                                </div>
                                <div class="card-block">
                                    <form id="exportForm" action="{{ route('admin.results.download') }}" method="GET">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Pilih Quiz</label>
                                            <div class="col-sm-8">
                                                <select name="course_id" id="course_id" class="form-control" required>
                                                    <option value="">-- Pilih Quiz --</option>
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->namacourse }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="fa fa-file-excel-o"></i> Export Excel
                                                </button>
                                            </div>
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
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#exportForm').on('submit', function(e) {
            const courseId = $('#course_id').val();
            if (!courseId) {
                e.preventDefault();
                alert('Silakan pilih quiz terlebih dahulu');
                return false;
            }
            // Show loading indicator
            $('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
        });
    });
</script>
@endsection