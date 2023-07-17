<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking Details - {{ $data['book_no'] }}</title>
</head>
<body style="font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
    <div class="container" style="text-align: center;
                                  margin-top: 50px;
                                  max-width: 30rem;
                                  align-item: center;
                                  margin-left: auto;
                                  margin-right: auto;">

        {{-- <div style="font-size: 16pt; font-weight: bold;">Detail Booking</div> --}}

        <br> 

        <div style="font-size: 12pt;
                    margin-bottom: 4px;
                    font-weight: bold;">Hai, {{ $data['name'] }}, berikut detail booking kamu: </div>

        <div class="card"
            style="border: 1px black solid;
                   padding-top: 5px;
                   padding-bottom: 5px;
                   font-size: 16pt;
                   font-weight: bold;
                   background-color: #0d1a39;
                   color: white;">Booking Details #{{ $data['book_no'] }}</div>

        <div class="card"
            style="border: 1px black solid;
                   padding-top: 7px;
                   padding-bottom: 7px;
                   font-size: 12pt;
                   padding-left: 5px;
                   padding-right: 5px;">
            <table>
                <tr>
                    <th style="text-align: left; width: 40%;">Tanggal</th>
                    <td style="40%;">:</td>
                    <td style="text-align: left; width: 45%;">{{ date('d', strtotime($data['book_date'])) . ' ' . $data['month'][date('m', strtotime($data['book_date']))] . ' ' . date('Y', strtotime($data['book_date'])) }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; width: 40%;">Jam</th>
                    <td style="40%;">:</td>
                    <td style="text-align: left; width: 45%;">{{ $data['book_time'] }} WIB</td>
                </tr>
                <tr>
                    <th style="text-align: left; width: 40%;">Hair Artist</th>
                    <td style="40%;">:</td>
                    <td style="text-align: left; width: 45%;">{{ $data['ha_name'] }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; width: 40%;">Customer</th>
                    <td style="40%;">:</td>
                    <td style="text-align: left; width: 45%;">{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; width: 40%;">Gender</th>
                    <td style="40%;">:</td>
                    <td style="text-align: left; width: 45%;">{{ $data['gender'] == 1 ? 'Man' : 'Woman' }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; width: 40%;">Whatsapp</th>
                    <td style="40%;">:</td>
                    <td style="text-align: left; width: 45%;">{{ $data['phone'] }}</td>
                </tr>
            </table>

            <br>

            <table style="padding: 10px; border: 1px solid; border-collapse: collapse; margin-left: auto; margin-right: auto;">
                <thead>
                    <tr>
                        <th style="background-color:#0d1a39; color:#f0f2f5; padding-top: 7px; padding-bottom: 7px;">Service</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['transaction_detail'] as $td)
                        <tr>
                            <td width="40%">{{ $td->service_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="font-weight: bold;
                    font-size: 10pt;
                    font-style: italic;
                    color: #767676;
                    margin-top: 5px;
                    text-align: left;">Email ini bersifat otomatis, tidak perlu di reply.</div>
    </div>
</body>
</html>
