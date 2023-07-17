@extends('customer.layout')
@section('content')
    <main id="content">
        <!-- Section 1 -->
        <div class="container-fluid pt-5 mt-5">
            <div class="text-white text-center fs-3 fw-bold mb-3 mt-2" id="text-form">HI
                {{ strtoupper(Auth::user()->name) }}
            </div>
            <div class="text-center">
                <div class="badge mb-2" style="background-color:steelblue" id="step-form">Choose your gender</div>
            </div>

            {{-- Gender --}}
            <div class="row justify-content-center mt-3" id="gender-section">
                <div class="col-md-2 col-6 mb-3">
                    <div class="card card-gender card-picker">
                        <div class="card-body text-center">
                            <img src="/assets/image/man.png" alt="Man" style="width: 70px; height: 70px;"> <br>
                            <input type="text" readonly class="btn btn-sm btn-gender mt-3" value="Man">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="card card-gender card-picker">
                        <div class="card-body text-center">
                            <img src="/assets/image/woman.png" alt="Woman" style="width: 70px; height: 70px;"> <br>
                            <input type="text" readonly class="btn btn-sm btn-gender mt-3" value="Woman">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Artist --}}
            <div class="row justify-content-center mt-3" id="artist-section" style="display: none;"></div>

            {{-- Schedules --}}
            <div class="row justify-content-center mt-3" id="schedule-section" style="display: none;">
                <div class="col-md-6 col-sm-8 col-12 mb-3">
                    <div class="card text-center">
                        <div class="row justify-content-center">
                            <div class="col-auto my-2">
                                <div class="fs-5 fw-bold">Set a Schedule:</div>
                                <div id="schedule_date" class="mb-3"></div>
                                <div class="fs-5 fw-bold">Available at:</div>
                                <div class="schedule-list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Is your choice appropiate?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Gender</th>
                                    <th>Hair Artist</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span id="gender_row"></span><input type="hidden" class="form-control" readonly id="gender_input"></td>
                                    <td><span id="ha_row"></span><input type="hidden" class="form-control" readonly id="ha_input"></td>
                                    <td><span id="date_row"></span><input type="hidden" class="form-control" readonly id="date_input"></td>
                                    <td><span id="time_row"></span><input type="hidden" class="form-control" readonly id="time_input"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                    <a href="/book" class="btn btn-sm btn-secondary">Re-choose</a>
                    <button type="button" class="btn btn-sm btn-primary btn-confirm">Next</button>
                    </div>
                </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        $('.btn-gender').on('click', function() {
            let gender_val = $(this).val();
            $('#gender-section').hide();
            $('#artist-section').show();
            $('#step-form').text('Pick your hair artist');
            $('#gender_row').text(gender_val);
            if(gender_val == 'Man'){
                $('#gender_input').val(1);
            }else{
                $('#gender_input').val(2);
            }

            $.ajax({
                url: '/book/hair-artist',
                type: 'GET',
                cache: false,
                dataType: 'JSON',
                success: function(response){
                    let data = response.data;

                    for(let i = 0; i < data.length; i++){
                        let ha_id = data[i].id;
                        let ha_name = data[i].ha_name;
                        let phone = data[i].phone;
                        let instagram = data[i].instagram;
                        let profile_picture = data[i].profile_picture;

                        let startCol = '<div class="col-sm-4 col-md-3 col-6 col-lg-3 col-xxl-2 mb-3">';
                        let endCol = '</div>';
                        let startCard = '<div class="card card-gender card-picker">';
                        let endCard = '</div>';
                        let startCardBody = '<div class="card-body text-center">';
                        let endCardBody = '</div>';
                        let haImg = '<img src="/storage/' + profile_picture +'" alt="Hair Artist" style="width: 120px; height: 120px;" class="ha-avatar">';
                        let haContact = '<div class="mt-2 mb-2">Consult me: <br> <a href="' + instagram +'" target="_blank" class="btn-contact"><i class="fab fa-instagram"></i></a></div>';
                        let btnPick = '<div><button type="button" class="btn btn-sm btn-pick" id="btn' + ha_id +'">' + ha_name +'</button><input type="hidden" readonly id="ha' + ha_id + '" value="' + ha_name +'"></div>';

                        $('#artist-section').append(startCol + startCard + startCardBody + haImg + haContact + btnPick + endCardBody + endCard + endCol);
                    }

                    $('.btn-pick').on('click', function() {
                        $('#artist-section').hide();
                        $('#schedule-section').show();
                        $('#step-form').text('Set your time');

                        let btnID = $(this).attr('id');
                        let ha_id = btnID.slice(3);
                        let ha_name = $('#ha' + ha_id).val();

                        $('#ha_row').text(ha_name);
                        $('#ha_input').val(ha_id);

                        $('#schedule_date').datepicker({
                            todayHighlight: false,
                            dateFormat: 'yy-mm-dd',
                            minDate: '0',
                            maxDate: '+2',
                            onSelect: function pickedDate(dateText){
                                let picked_date = dateText;
                                let date = picked_date.split('-').reverse().join('-');
                                $('#date_row').text(date);
                                $('#date_input').val(picked_date);

                                $.ajax({
                                    url: '/book/ha-schedule',
                                    type: 'GET',
                                    cache: false,
                                    data: {
                                        picked_date: picked_date,
                                        ha_id: ha_id,
                                    },
                                    dataType: 'JSON',
                                    success: function(response){
                                        $('.schedule-list').empty();
                                        let data = response.data;
                                        for(let i = 0; i < data.length; i++){
                                            let time = data[i].time;
                                            let today = new Date();
                                            let date_now = today.toISOString().slice(0, 10);
                                            let now = today.getHours()+ "." + today.getMinutes();

                                            if(picked_date == date_now){
                                                if(now < time){
                                                    let btnTime = '<input type="submit" readonly class="btn-time mb-3" value="' + time +'" data-bs-toggle="modal" id="' + time +'" data-bs-target="#confirmModal"> ';
                                                    $('.schedule-list').append(btnTime);
                                                }else{
                                                    let btnTime = '';
                                                    $('.schedule-list').append(btnTime);
                                                }
                                            }else{
                                                let btnTime = '<input type="submit" readonly class="btn-time mb-3" value="' + time +'" data-bs-toggle="modal" id="' + time +'" data-bs-target="#confirmModal"> ';
                                                $('.schedule-list').append(btnTime);
                                            }
                                        }

                                        $('.btn-time').on('click', function() {
                                            let time = $(this).attr('id');
                                            $('#time_row').text(time + ' WIB');
                                            $('#time_input').val(time);
                                        });
                                    }
                                });
                            }
                        });
                    });
                }
            });
        });

        $('.btn-confirm').on('click', function() {
            let gender = $('#gender_input').val();
            let ha_id = $('#ha_input').val();
            let book_date = $('#date_input').val();
            let book_time = $('#time_input').val();
            let arrData = {
                'gender': gender,
                'ha_id': ha_id,
                'book_date': book_date,
                'book_time': book_time,
            };
            let jsonData = JSON.stringify(arrData);
            let params = btoa(jsonData);

            window.location.href = '/book/service/' + params;
        });
    </script>
@endsection
