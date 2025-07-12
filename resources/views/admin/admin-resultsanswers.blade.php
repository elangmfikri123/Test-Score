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

                            <div class="card mb-3">
                                <div class="card-block">
                                     <form id="exportForm" action="{{ route('admin.results.download') }}" method="GET">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-8">
                                                <label>Nama Quiz</label>
                                                <select name="course_id" id="course_id" class="form-control" required>
                                                    <option value="">-- Pilih Quiz --</option>
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->namacourse }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end" style="gap: 5px">
                                                <button type="button" id="filterBtn" class="btn btn-secondary btn-sm px-3 mb-1">
                                                    <i class="ion-funnel"></i> Filter
                                                </button>
                                                <button type="button" id="resetBtn" class="btn btn-warning btn-sm px-3 mb-1">
                                                    <i class="ion-refresh"></i> Reset
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-sm px-3 mb-1">
                                                    <i class="ion-archive"></i> Download
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
            $('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
        });
    });
</script>
@endsection