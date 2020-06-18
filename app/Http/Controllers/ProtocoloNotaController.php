<?php

namespace App\Http\Controllers;

use App\Protocolo;
use App\Nota;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon; // tratamento de datas
use Illuminate\Support\Facades\Redirect; // para poder usar o redirect

use Illuminate\Support\Facades\Storage;

use Auth; // receber o id do operador logado no sistema

class ProtocoloNotaController extends Controller
{

    /**
     * Construtor.
     *
     * precisa estar logado ao sistema
     * precisa ter a conta ativa (access)
     *
     * @return 
     */
    public function __construct()
    {
        $this->middleware(['middleware' => 'auth']);
        $this->middleware(['middleware' => 'hasaccess']);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validação
        $this->validate($request, [
          'conteudo' => 'required',
        ],
        [
            'conteudo.required' => 'Escreva algum conteúdo para se criar a nota',
        ]);

        $nota = new Nota;

        $user = Auth::user();

        $nota->user_id = $user->id;

        $nota->conteudo = $request['conteudo'];

        // salva o nota no banco de dados
        $protocolo = Protocolo::find($request['protocolo_id']);

        $protocolo->notas()->save($nota);

        Session::flash('create_nota', 'Nota salva com sucesso!');

        return Redirect::route('protocolos.edit', $request['protocolo_id']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nota = Nota::findOrFail($id);

        $num_protocolo = $nota->notaable_id;

        // apaga o registro do banco de dados
        $nota->delete();

        Session::flash('delete_nota', 'Nota excluída com sucesso!');

        return Redirect::route('protocolos.edit', $num_protocolo);  
    }
}
