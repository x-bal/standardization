@extends('faceid::layouts.default_layout')
@section('title', 'Logs Foto Karyawan')
@push('css')
@endpush
@section('content')
<table>
    <thead>
        <tr>
            <th colspan="9"></th>
            <th>Diambil dari compare capture suhu vs standard < 37,3 </th>
            <th>Diambil dengan kondisi jika salah satu kumis atau jenggot tidak NOK maka hasilnya NOK, untuk OK harus keduaya OK</th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
        </tr>
        <tr>
            <th>Tanggal Absen</th>
            <th>Jam Absen</th>
            <th>Nik</th>
            <th>Nama Karyawan</th>
            <th>Nama Dept</th>
            <th>Status Kumis</th>
            <th>Status Jenggot</th>
            <th>Suhu</th>
            <th>Komitmen</th>
            <th>Kondisi Sehat</th>
            <th>Kondisi GMP</th>
        </tr>
    </thead>
</table>
@endsection
@push('scripts')

@endpush