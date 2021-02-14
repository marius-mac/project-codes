<html>
  <head>
    <title>{{ $meta_title or 'Krepšinio aikštelės' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
  <body>
    <div id="wrapper">
      <div id="header">
        <a id="logo" href="{{ url('/') }}">KREPŠINIO AIKŠTELĖS</a>
      </div>
      <div id="main_menu">
        <ul>
          <li><a href="{{ url('/') }}">Pagrindinis</a></li>
          <li><a href="{{ url('apie') }}">Apie projektą</a></li>
          <li><a href="{{ url('kontaktai') }}">Kontaktai</a></li>

@if (Auth::check())
  <li><a href="{{ url('admin/aiksteles') }}">Aikštelės</a></li>
  <li><a href="{{ url('admin/aiksteliu_tipai') }}">Aikštelių tipai</a></li>
  <li><a href="{{ url('admin/miestai') }}">Miestai</a></li>
  <li><a href="{{ url('auth/logout') }}">Atsijungti</a></li>
@else
  <li><a href="{{ url('auth/login') }}">Prisijungti</a></li>
@endif
        </ul>
        <div class="clear"></div>
      </div>
      <div id="content">
      @if (!Auth::check())
        {!! Form::open(array('url' => 'aiksteles')) !!}
        Miestas: {!! Form::select('city_id', \App\City::lists('title', 'id'), \Input::get('city_id')) !!}
        Aikštelės tipas: {!! Form::select('type_id', \App\Type::lists('title', 'id'), \Input::get('type_id')) !!}
        Pavadinimas: {!! Form::text('search', \Input::get('search')) !!}
        {!! Form::submit('Ieškoti') !!}
        {!! Form::close() !!}
      @endif

        @yield('content')
      </div>
      <div id="footer">
        © {{ date('Y') }} PHPPamokos.lt. Visos teisės saugomos.
      </div>
    </div>
  </body>
</html>