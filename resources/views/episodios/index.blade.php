@extends('layout')

@section('cabecalho')
@endsection

@section('conteudo')
@include('mensagem')
<form action="/temporadas/{{$temporadaId}}/episodios/assistir" method="post">
    @csrf
    <ul class="list-group">
        @foreach ($episodios as $episodio)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="/temporadas/{{$episodio->id}}/episodios">
                Episodio {{$episodio->numero}}
            </a>
            <input type="checkbox" name="episodios[]" value="{{$episodio->id}}"
                {{ $episodio->assistido ? 'checked': '' }}>
        </li>
        @endforeach
    </ul>
    @auth
        <button class="btn btn-primary mt-2 mb-2">Salvar</button>
    @endauth
</form>
@endsection
