@extends('layout.template')
@section('title', 'Scorecard Juri')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-body" style="margin-top: -20px;">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('scorecard.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peserta_id" value="{{ $peserta->id }}">
                        <input type="hidden" name="formpenilaian_id" value="{{ $formId }}">

                        <div class="card mb-3">
                            <div class="card-block">
                                <div class="row align-items-end justify-content-between">
                                    <div class="col-md-9"></div>
                                    <div class="col-md-3 text-end">
                                        <button type="submit" name="action" value="draft" class="btn btn-warning btn-sm px-3 mb-1">
                                            <i class="icofont icofont-copy-black"></i> Draft
                                        </button>
                                        <button type="submit" name="action" value="submit" class="btn btn-success btn-sm px-3 mb-1">
                                            <i class="ion-checkmark"></i> Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                        <table class="table table-styling">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th class="text-center" style="width: 10%;">#</th>
                                                    <th style="width: 75%;">Parameter</th>
                                                    <th class="text-center" style="width: 15%;">Weight (%)</th>
                                                    <th class="text-center" style="width: 15%;">Score</th>
                                                </tr>
                                            </thead>
                                            <tbody id="parameter-body">
                                                <!-- AJAX akan isi ini -->
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-6">
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-styling">
                                                <thead>
                                                    <tr class="table-primary">
                                                        <th class="text-center" style="width: 50px;">Catatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center" style="width: 50px;">
                                                            <textarea name="notes" rows="6" class="form-control" placeholder="Masukkan catatan..."></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                {{-- Card Informasi --}}
                                <div class="card mb-2">
                                    <div class="card-body text-center">
                                        <img src="{{ asset('files/assets/images/Logo-100.png') }}" 
                                             alt="Theme-Logo" 
                                             style="max-height: 100px; width: auto;">
                                    </div>
                                </div>

                                {{-- Card Informasi --}}
                                <div class="card mb-2">
                                    <div class="card-body p-3">
                                        <h6 class="mb-3">Information</h6>
                                        <div>
                                            <p class="mb-2"><strong>Participant</strong><br>{{ $peserta->nama }}</p>
                                            <p class="mb-2"><strong>Main Dealer</strong><br>{{ $peserta->maindealer->nama_md ?? '-' }}</p>
                                            <p class="mb-0"><strong>Kategori</strong><br>{{ $peserta->category->namacategory ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Card Final Score --}}
                                <div class="card mb-2">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center" 
                                             style="width: 45px; height: 45px; background-color: #cdcdcd; border-radius: 5px; margin-right: 1rem;">
                                            <i class="fa fa-trophy" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0" id="totalScore">0%</h5>
                                            <span>Total Score</span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pesertaId = {{ $peserta->id }};
    const formId = {{ $formId ?? 'null' }};
    const parameterBody = document.getElementById('parameter-body');
    const totalScoreEl = document.getElementById('totalScore');
    let maxScore = 1;

    // Tampilkan pesan "Processing..." saat proses load dimulai
    parameterBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Processing...</td></tr>';

    if (!formId) {
        parameterBody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Form ID tidak tersedia.</td></tr>';
        return;
    }

    fetch(`/api/formpenilaian/${formId}/parameters`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data parameter');
            }
            return response.json();
        })
        .then(data => {
            maxScore = data.maxscore;
            parameterBody.innerHTML = '';

            if (!data.parameters || data.parameters.length === 0) {
                parameterBody.innerHTML = '<tr><td colspan="4" class="text-center text-warning">Tidak ada parameter ditemukan.</td></tr>';
                return;
            }

            data.parameters.forEach((param, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <th class="text-center" style="width: 10%;">${index + 1}</th>
                    <td style="width: 75%;">
                        <strong>${param.nama}</strong><br>
                        ${param.deskripsi}
                        <input type="hidden" name="parameter_id[]" value="${param.id}">
                    </td>
                    <td class="text-center" style="width: 15%;">${param.bobot}%</td>
                    <td class="text-center" style="width: 15%;">
                        <select name="score[]" data-bobot="${param.bobot}" class="form-control form-control-sm score-select" style="width: 60px; margin: auto;">
                            ${[...Array(maxScore + 1).keys()].map(i => `<option value="${i}">${i}</option>`).join('')}
                        </select>
                    </td>
                `;
                parameterBody.appendChild(row);
            });

            document.querySelectorAll('.score-select').forEach(select => {
                select.addEventListener('change', calculateTotal);
            });
        })
        .catch(error => {
            console.error(error);
            parameterBody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Gagal memuat parameter.</td></tr>';
        });

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.score-select').forEach(select => {
            const score = parseFloat(select.value);
            const bobot = parseFloat(select.getAttribute('data-bobot'));
            total += (score / maxScore) * bobot;
        });
        totalScoreEl.textContent = total.toFixed(2) + '%';
    }
});
</script>
@endsection
