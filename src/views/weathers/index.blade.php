<form action="{{url('weathers/create')}}" method="post">
    <a href="{{url('email')}}">ivesti email</a>
    <p>Vejo greitis: {{ $res['wind']['speed'] }}</p>
    <p>Oro temperatura: {{ $res['main']['temp'] }}</p>
    <p>Vejo kryptis: {{ $res['wind']['deg'] }}</p>
    <div>
        <label for="city">miestas</label>
        <input type="text" name="city">
    </div>
    <button type="submit">Submit</button>
</form>