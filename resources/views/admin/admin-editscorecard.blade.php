@extends('layout.template')
@section('title', 'Edit Scorecard')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form method="POST" action="{{ route('scorecard.update', $scorecard->id) }}">
                                @csrf
                                @method('PUT')

                                {{-- FORM UTAMA --}}
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="feather icon-edit"></i> Edit Scorecard</h5>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        {{-- Nama Form --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Nama Form *</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="namaform" class="form-control requiredform" value="{{ old('namaform', $scorecard->namaform) }}" required>
                                            </div>
                                        </div>

                                        {{-- Kategori --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Kategori *</label>
                                            <div class="col-sm-9">
                                                <select class="form-control requiredform select2-init" name="category_id" id="category_id" required>
                                                    <option value="" disabled>Pilih Kategori</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ $scorecard->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->namacategory }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Maksimal Score --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Maksimal Score *</label>
                                            <div class="col-sm-9">
                                                <input type="number" name="maxscore" class="form-control requiredform" value="{{ old('maxscore', $scorecard->maxscore) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- PARAMETER --}}
                                <div class="card mt-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5><i class="ion-help-circled"></i> Edit Parameter</h5>
                                        <label class="label label-warning label-lg" id="bobotTotalLabel">Total Bobot : 0%</label>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-block">
                                        <table class="table table-bordered" id="parameterTable">
                                            <thead class="table-secondary text-center">
                                                <tr>
                                                    <th style="width: 50px;">No</th>
                                                    <th>Parameter</th>
                                                    <th>Keterangan</th>
                                                    <th style="width: 110px;">Bobot (%)</th>
                                                    <th style="width: 50px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($scorecard->parameters as $index => $param)
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                                                        <td>
                                                            <input type="text" name="parameter[]" class="form-control" value="{{ $param->parameter }}" required>
                                                        </td>
                                                        <td>
                                                            <textarea name="deskripsi[]" class="form-control" required>{{ $param->deskripsi }}</textarea>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="bobot[]" class="form-control bobot-input" value="{{ $param->bobot }}" min="0" max="100" step="0.01" required>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <button type="button" class="btn btn-danger btn-sm deleteRow">
                                                                <i class="icofont icofont-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <button type="button" class="btn btn-primary btn-sm" id="addParameter">
                                            <i class="icofont icofont-plus"></i> Add New Parameter
                                        </button>

                                        <div class="text-right mt-3">
                                            <button type="submit" class="btn btn-success">
                                                <i class="ion-checkmark"></i> Update
                                            </button>
                                        </div>
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

{{-- Script --}}
<script>
    function updateTotalBobot() {
        let total = 0;
        document.querySelectorAll('.bobot-input').forEach(input => {
            let val = parseFloat(input.value) || 0;
            total += val;
        });
        document.getElementById('bobotTotalLabel').innerText = 'Total Bobot : ' + total.toFixed(2) + '%';
        document.getElementById('addParameter').disabled = total >= 100;
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('#parameterTable tbody tr');
        rows.forEach((row, index) => {
            row.querySelector('td:first-child').innerText = index + 1;
        });
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
            <td class="text-center align-middle"></td>
            <td><input type="text" name="parameter[]" class="form-control" placeholder="Parameter" required></td>
            <td><textarea name="deskripsi[]" class="form-control" placeholder="Keterangan..." required></textarea></td>
            <td><input type="number" name="bobot[]" class="form-control bobot-input" min="0" max="100" step="0.01" placeholder="0.00%" required></td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-danger btn-sm deleteRow">
                    <i class="icofont icofont-trash"></i>
                </button>
            </td>
        `;
        table.appendChild(newRow);
        updateRowNumbers();
        updateTotalBobot();
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.deleteRow')) {
            const row = e.target.closest('tr');
            row.remove();
            updateRowNumbers();
            updateTotalBobot();
        }
    });

    window.addEventListener('DOMContentLoaded', function () {
        updateRowNumbers();
        updateTotalBobot();
    });
</script>
@endsection
