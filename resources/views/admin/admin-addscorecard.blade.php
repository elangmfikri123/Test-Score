@extends('layout.template')
@section('title', 'Manage Score Card')

@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <form method="POST" action="{{ url('/scorecard/store') }}">
                                @csrf

                                {{-- CARD: FORM HEADER + BUTTON --}}
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="feather icon-edit"></i> Form Score Card</h5>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="ion-checkmark"></i> Save
                                            </button>
                                    </div>
                                    <div class="card-block">

                                        {{-- NAMA FORM --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama Form *</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control requiredform" placeholder="Masukkan Nama" name="namaform">
                                                <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                            </div>
                                        </div>

                                        {{-- KATEGORI --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kategori *</label>
                                            <div class="col-sm-9">
                                                <select class="form-control requiredform select2-init" name="category_id" id="category_id">
                                                    <option value="" disabled selected>Pilih Kategori</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->namacategory }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                            </div>
                                        </div>

                                        {{-- MAKS SCORE --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Maksimal Score *</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control requiredform" placeholder="Maskimal Score" name="maxscore">
                                                <span class="messages text-danger" style="font-size: 0.7rem;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- CARD: PARAMETER --}}
                                <div class="card mt-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="ion-help-circled"></i> Tambah Parameter</h5>
                                        <label class="label label-warning label-lg" id="bobotTotalLabel">0%</label>
                                    </div>
                                    <div class="card-block">
                                        <table class="table table-bordered" id="parameterTable">
                                            <thead class="table-secondary text-center">
                                                <tr>
                                                    <th style="width: 50px;">No</th>
                                                    <th>Parameter</th>
                                                    <th>Keterangan</th>
                                                    <th style="width: 110px;">Bobot (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= 4; $i++)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $i }}</td>
                                                    <td class="text-center align-middle">
                                                        <input type="text" name="parameter[]" class="form-control" placeholder="Parameter" required>
                                                    </td>
                                                    <td>
                                                        <textarea name="deskripsi[]" class="form-control" placeholder="Keterangan..." required></textarea>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <input type="number" name="bobot[]" class="form-control bobot-input" min="0" max="100" step="0.01" placeholder="0.00%">
                                                    </td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>

                                        <button type="button" class="btn btn-primary btn-sm" id="addParameter">
                                            <i class="icofont icofont-plus"></i> Add New Parameter
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

{{-- SCRIPT --}}
<script>
    let parameterIndex = 5;

    function updateTotalBobot() {
        let total = 0;
        document.querySelectorAll('.bobot-input').forEach(input => {
            let val = parseFloat(input.value) || 0;
            total += val;
        });

        const label = document.getElementById('bobotTotalLabel');
        label.innerText = 'Total Bobot : ' + total + '%';
        const addButton = document.getElementById('addParameter');
        addButton.disabled = total >= 100;
    }

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('bobot-input')) {
            updateTotalBobot();
        }
    });

    document.getElementById('addParameter').addEventListener('click', function () {
        const table = document.getElementById('parameterTable').getElementsByTagName('tbody')[0];

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="text-center align-middle">${parameterIndex}</td>
            <td class="text-center align-middle">
                <input type="text" name="parameter[]" class="form-control" placeholder="Parameter" required>
            </td>
            <td>
                <textarea name="deskripsi[]" class="form-control" placeholder="Keterangan..." required></textarea>
            </td>
            <td class="text-center align-middle">
                <input type="number" name="bobot[]" class="form-control bobot-input" min="0" max="100" step="0.01" placeholder="0.00%">
            </td>
        `;
        table.appendChild(newRow);
        parameterIndex++;

        updateTotalBobot();
    });

    window.addEventListener('DOMContentLoaded', updateTotalBobot);
</script>
@endsection
