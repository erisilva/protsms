<?php

namespace App\Http\Controllers;

use App\ProtocoloTramitacao;

use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect; // para poder usar o redirect

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Builder; // para poder usar o whereHas nos filtros

use Auth; // receber o id do operador logado no sistema

use Carbon\Carbon; // tratamento de datas

class ProtocoloTramitacaoController extends Controller
{
    protected $pdf;

    /**
     * Construtor.
     *
     * precisa estar logado ao sistema
     * precisa ter a conta ativa (access)
     *
     * @return 
     */
    public function __construct(\App\Reports\ProtocoloTramitacaoReport $pdf)
    {
        $this->middleware(['middleware' => 'auth']);
        $this->middleware(['middleware' => 'hasaccess']);

        $this->pdf = $pdf;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'funcionario_tramitacao_id' => 'required',
          'setor_tramitacao_id' => 'required',
          'protocolo_id' => 'required',
        ],
        [
            'funcionario_tramitacao_id.required' => 'Escolha o funcionário para tramitação',
            'setor_tramitacao_id.required' => 'Escolha o funcionário e o setor para tramitação',
            'protocolo_id.required' => 'Erro no sistema, protocolo não selecionado para tramitação',
        ]);


        $input_tramitacao = $request->all();

        // recebi o usuário logado no sistema
        $user = Auth::user();


        $input_tramitacao['user_id_origem'] = $user->id;
        $input_tramitacao['setor_id_origem'] = $user->setor->id;
        $input_tramitacao['user_id_destino'] = $input_tramitacao['funcionario_tramitacao_id'];
        $input_tramitacao['setor_id_destino'] = $input_tramitacao['setor_tramitacao_id'];
        $input_tramitacao['recebido'] = 'n';
        $input_tramitacao['tramitado'] = 'n';

        ProtocoloTramitacao::create($input_tramitacao); //salva

        Session::flash('create_protocolotramitacao', 'Tramitação inserida com sucesso!');

        return Redirect::route('protocolos.edit', $input_tramitacao['protocolo_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
