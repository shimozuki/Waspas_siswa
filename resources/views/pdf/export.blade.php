<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Perankingan - {{ config('app.name') }}</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }

        .kop-surat img {
            width: 60px;
        }

        .kop-surat .info {
            margin-top: -60px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table th {
            background: #eee;
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <table width="100%">
            <tr>
                <td width="60">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo1.png'))) }}" alt="Logo 1">
                </td>
                <td class="info" align="center">
                    <div style="font-size: 14px; font-weight: bold;">PEMERINTAH PROVINSI NUSA TENGGARA BARAT</div>
                    <div style="font-size: 13px;">DINAS PENDIDIKAN DAN KEBUDAYAAN</div>
                    <div style="font-size: 13px;">SMK NEGERI 1 TARANO</div>
                    <div style="font-size: 10px;">Jln. Lintas Sumbawa Besar Tarano</div>
                    <div style="font-size: 10px;">Email: smkntarano@gmail.com | Web: smkntarano.sch.id</div>
                </td>
                <td width="60" align="right">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.jpg'))) }}" alt="Logo 2">
                </td>
            </tr>
        </table>
    </div>

    <div class="judul">HASIL PERANGKINGAN TAHUN AJARAN {{$data[0]->tahun_ajaran}}</div>

    <table width="100%" cellspacing="0" cellpadding="6" border="1">
        <thead>
            <tr>
                <th>Ranking</th>
                <th>No Reg</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Hasil Qi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->rank }}</td>
                <td>{{ $row->mahasiswa->no_reg }}</td>
                <td>{{ $row->mahasiswa->nama }}</td>
                <td>{{ $row->mahasiswa->jenis_kelamin }}</td>
                <td>{{ number_format($row->qi, 4) }}</td>
                <td>{{ $row->status_diterima }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>