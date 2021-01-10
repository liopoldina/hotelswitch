@section('head')
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>{{ env("APP_NAME") }}</title>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href={{asset('images/favicon_io/apple-touch-icon.png')}} >
<link rel="icon" type="image/png" sizes="32x32" href={{asset('images/favicon_io/favicon-32x32.png')}} >
<link rel="icon" type="image/png" sizes="16x16" href={{asset('images/favicon_io/favicon-16x16.png')}} >
<link rel="manifest" href={{asset('images/favicon_io/site.webmanifest')}} >

<!-- css -->
<link rel="stylesheet" href={{asset('css/main.css')}} />
<link rel="stylesheet" href={{asset('jquery-ui/jquery-ui.css')}} />
<link rel="stylesheet" href={{asset('jquery-ui/jquery-ui.structure.css')}} />
<link rel="stylesheet" href={{asset('jquery-ui/jquery-ui.theme.css')}} />
<link rel="stylesheet" href={{asset('css/daterangepicker.css')}} />

<!-- js -->
<script src={{asset('js/jquery.min.js')}}></script>
<script src={{asset('jquery-ui/jquery-ui.min.js')}}></script>
<script src={{asset('jquery-ui/jquery.ui.touch-punch.js')}}></script>
<script src={{asset('js/main.js')}}></script>
<script src='https://kit.fontawesome.com/93e6a1962d.js' crossorigin="anonymous"></script>
<script src={{asset('js/moment.min.js')}}></script>
<script src={{asset('js/daterangepicker.js')}}></script>

<script>
    @isset($h)
    h = @json($h);
    @endisset

    @isset($hotel)
    hotel = @json($hotel);
    @endisset

    @isset($m)
    m = @json($m);
    @endisset

    @isset($rate)
    rate = @json($rate);
    @endisset

</script>

@endsection
