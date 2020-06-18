<?php

namespace App\Http\Controllers;

use App\Protocolo;
use App\ProtocoloSituacao;
use App\ProtocoloTipo;

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

class ProtocoloController extends Controller
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
    public function __construct(\App\Reports\ProtocoloReport $pdf)
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
        $protocolos = new Protocolo;

        // ordena
        $protocolos = $protocolos->orderBy('id', 'desc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $protocolos = $protocolos->paginate(session('perPage', '5'));

        return view('protocolos.index', compact('protocolos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $protocolotipos = ProtocoloTipo::orderBy('descricao', 'asc')->get();

        return view('protocolos.create', compact('protocolotipos'));
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
          'conteudo' => 'required',
          'protocolo_tipo_id' => 'required',
        ],
        [
            'conteudo.required' => 'Preencha o conteúdo ou descrição do protocolo',
            'protocolo_tipo_id.required' => 'Selecione o tipo do protocolo na lista',
        ]);

        $protocolo_input = $request->all();

        $user = Auth::user();

        $protocolo_input['user_id'] = $user->id;

        $protocolo_input['setor_id'] = $user->setor->id;

        $protocolo_input['protocolo_situacao_id'] = 1 ; //aberto
        
        $protocolo_input['concluido'] = 'n' ; // não concluido

        Protocolo::create($protocolo_input); //salva

        Session::flash('create_protocolo', 'Protocolo cadastrado com sucesso!');

        return redirect(route('protocolos.index'));  
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
        $protocolo = Protocolo::findOrFail($id);

        $protocolotipos = ProtocoloTipo::orderBy('descricao', 'asc')->get();

        $anexos = $protocolo->anexos()->orderBy('id', 'desc')->get();

        $notas = $protocolo->notas()->orderBy('id', 'desc')->get();

        return view('protocolos.edit', compact('protocolo', 'protocolotipos', 'anexos', 'notas'));
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
        $this->validate($request, [
          'conteudo' => 'required',
        ]);

        $protocolo = Protocolo::findOrFail($id);
            
        $protocolo->update($request->all());
        
        Session::flash('edited_protocolo', 'Protocolo alterado com sucesso!');

        return redirect(route('protocolos.edit', $id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function concluir(Request $request, $id)
    {

        $protocolo = Protocolo::findOrFail($id);

        $input = $request->all();

        $protocolo->concluido = 's';
        $protocolo->protocolo_situacao_id = $input['protocolo_situacao_id'];; // concluido e 4 cancelado
        $protocolo->concluido_mensagem = $input['concluido_mensagem'];
        $protocolo->concluido_em = Carbon::now()->toDateTimeString();
            
        $protocolo->save();
        
        Session::flash('concluir_protocolo', 'Protocolo finalizado!!');

        //dd($protocolo);

        return redirect(route('protocolos.edit', $id));
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
