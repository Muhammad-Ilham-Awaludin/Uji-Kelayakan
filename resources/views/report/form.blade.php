@extends('layouts.layout')

@section('content')
    <div class="col-md-8 form-container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="mb-4">Form Keluhan</h1>

        <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="province" class="form-label">Provinsi*</label>
                <select class="form-select" id="province" name="province" required>
                    <option value="">Pilih</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="regency" class="form-label">Kota/Kabupaten*</label>
                <select class="form-select" id="regency" name="regency" required>
                    <option value="">Pilih</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="subdistrict" class="form-label">Kecamatan*</label>
                <select class="form-select" id="subdistrict" name="subdistrict" required>
                    <option value="">Pilih</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="village" class="form-label">Kelurahan*</label>
                <select class="form-select" id="village" name="village" required>
                    <option value="">Pilih</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Jenis Laporan*</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="KEJAHATAN">Kejahatan</option>
                    <option value="PEMBANGUNAN">Pembangunan</option>
                    <option value="SOSIAL">Sosial</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Detail Keluhan*</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Gambar Pendukung</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="statement" name="statement" required>
                <label class="form-check-label" for="statement">Laporan yang disampaikan sesuai dengan kebenaran.</label>
            </div>

            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Load provinces
                $.ajax({
                    url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
                    method: 'GET',
                    success: function(data) {
                        let provinceSelect = $('#province');
                        provinceSelect.empty().append('<option value="">Pilih</option>');
                        data.forEach(function(province) {
                            provinceSelect.append(
                                `<option value="${province.name}" data-id="${province.id}">${province.name}</option>`
                            );
                        });
                    },
                    error: function() {
                        alert('Gagal memuat data provinsi.');
                    }
                });

                // Load regencies when a province is selected
                $('#province').on('change', function() {
                    let provinceId = $(this).find(':selected').data('id');
                    if (provinceId) {
                        $.ajax({
                            url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`,
                            method: 'GET',
                            success: function(data) {
                                let regencySelect = $('#regency');
                                regencySelect.empty().append('<option value="">Pilih</option>');
                                data.forEach(function(regency) {
                                    regencySelect.append(
                                        `<option value="${regency.name}" data-id="${regency.id}">${regency.name}</option>`
                                    );
                                });
                            },
                            error: function() {
                                alert('Gagal memuat data kabupaten/kota.');
                            }
                        });
                    } else {
                        $('#regency').empty().append('<option value="">Pilih</option>');
                    }
                });

                // Load subdistricts when a regency is selected
                $('#regency').on('change', function() {
                    let regencyId = $(this).find(':selected').data('id');
                    if (regencyId) {
                        $.ajax({
                            url: `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`,
                            method: 'GET',
                            success: function(data) {
                                let subdistrictSelect = $('#subdistrict');
                                subdistrictSelect.empty().append('<option value="">Pilih</option>');
                                data.forEach(function(subdistrict) {
                                    subdistrictSelect.append(
                                        `<option value="${subdistrict.name}" data-id="${subdistrict.id}">${subdistrict.name}</option>`
                                    );
                                });
                            },
                            error: function() {
                                alert('Gagal memuat data kecamatan.');
                            }
                        });
                    } else {
                        $('#subdistrict').empty().append('<option value="">Pilih</option>');
                    }
                });

                // Load villages when a subdistrict is selected
                $('#subdistrict').on('change', function() {
                    let subdistrictId = $(this).find(':selected').data('id');
                    if (subdistrictId) {
                        $.ajax({
                            url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${subdistrictId}.json`,
                            method: 'GET',
                            success: function(data) {
                                let villageSelect = $('#village');
                                villageSelect.empty().append('<option value="">Pilih</option>');
                                data.forEach(function(village) {
                                    villageSelect.append(
                                        `<option value="${village.name}">${village.name}</option>`
                                    );
                                });
                            },
                            error: function() {
                                alert('Gagal memuat data kelurahan.');
                            }
                        });
                    } else {
                        $('#village').empty().append('<option value="">Pilih</option>');
                    }
                });
            });
        </script>
    </div>
@endsection
