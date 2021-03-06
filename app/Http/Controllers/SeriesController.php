<?php

namespace App\Http\Controllers;

use App\Events\NovaSerie as EventsNovaSerie;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\NovaSerie;
use App\Serie;
use App\Services\SeriesCreator;
use App\Services\SeriesDelete;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::query()->orderBy('nome')->get();
        $mensagem = $request->session()->get('mensagem');
        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, SeriesCreator $serieCreator)
    {
        $capa = null;
        if ($request->hasFile('capa')) {
            $capa = $request->file('capa')->store('serie');
        }
        $serie = $serieCreator->createSerie(
            $request->nome,
            $capa ,
            $request->qtd_temporadas, 
            $request->qtd_episodios
        );

        $eventoNovaSerie = new EventsNovaSerie(
            $request->nome, 
            $request->qtd_temporadas, 
            $request->qtd_episodios
        );
        event($eventoNovaSerie);

        $request
            ->session()
            ->flash('mensagem', "Série {$serie->nome} adicionada com sucesso "); //Metodo que insere mensagem na sessão que permanece por apenas um requisição
        return redirect()->route('series.index');
    }

    public function destroy(Request $request, SeriesDelete $serie)
    {
        $nome = $serie->deleteSerie($request->id);
        $request
            ->session()
            ->flash('mensagem', "Série $nome removida");
        return redirect()->route('series.index');
    }

    public function editarSerie(int $id, Request $request)
    {
        $serie = new Serie();

        $serie = Serie::find($id);
        $serie->nome = $request->nome;
        $serie->save();
    }
}
