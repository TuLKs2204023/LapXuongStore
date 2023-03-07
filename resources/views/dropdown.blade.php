<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel AJAX Dependent Country State City Dropdown Example - ItSolutionStuff.com</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-4" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-primary mb-4 text-center">
                   <h4 >Laravel AJAX Dependent Country State City Dropdown Example  ItSolutionStuff.com</h4>
                </div>
                <form >

                    <div class="form-group mb-3">
                        <select id="City-dropdown" class="form-control">
                            <option value="">-- Select City --</option>
                            @foreach ($city as $data)
                            <option value="{{$data->id}}">
                                {{$data->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select id="district-dropdown" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="ward-dropdown" class="form-control">
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        jQuery(document).ready(function ($) {

            /*------------------------------------------
            --------------------------------------------
            City Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#City-dropdown').on('change', function () {
                let idCity = this.value;
                $("#district-dropdown").html('');
                $.ajax({
                    url: "{{url('api/fetch-district')}}",
                    type: "POST",
                    data: {
                        id: idCity,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',

                    success: function (result) {

                        $('#district-dropdown').html('<option value="">-- Select District --</option>');
                        $.each(result.districts, function (key, value) {
                            $("#district-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#ward-dropdown').html('<option value="">-- Select Ward --</option>');
                    }
                });
            });

            /*------------------------------------------
            --------------------------------------------
            District Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#district-dropdown').on('change', function () {
                var idDistrict = this.value;
                console.log(idDistrict);
                $("#ward-dropdown").html('');
                $.ajax({
                    url: "{{url('api/fetch-ward')}}",
                    type: "POST",
                    data: {
                        district_id: idDistrict,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#ward-dropdown').html('<option value="">-- Select Ward --</option>');
                        $.each(res.wards, function (key, value) {
                            $("#ward-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });

        });
    </script>
</body>
</html>
