<?php

namespace App\Http\Controllers;

use App\Protocolo;
use App\Anexo;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon; // tratamento de datas
use Illuminate\Support\Facades\Redirect; // para poder usar o redirect

use Illuminate\Support\Facades\Storage;

use Auth; // receber o id do operador logado no sistema

class ProtocoloAnexoController extends Controller
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
        // if (Gate::denies('protocolo.anexo.create')) {
        //     abort(403, 'Acesso negado.');
        // }

        // validação
        $this->validate($request, [
          'arquivo' => 'required|file|mimes:pdf,doc,rtf,txt,jpg,jpeg,png,bmp,xls,xlsx,csv,xml|max:2000',
        ],
        [
            'arquivo.required' => 'Selecione o arquivo a ser anexado',
            'arquivo.max' => 'O tamanho máximo do anexo deve ser 2Mb',
            'arquivo.mimes' => 'Somente são aceitos os seguintes formatos: pdf, doc, rtf, txt, jpg, jpeg, png, bmp, xls, xlsx, csv, xml',
        ]);

        // geração de uma string aleatória de tamanho configurável
        function generateRandomString($length = 10) {
            return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
        }

        $local = generateRandomString(8);

        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {

            $nome_arquivo = $request->arquivo->getClientOriginalName();

            $path = $request->file('arquivo')->storeAs($local, $request->arquivo->getClientOriginalName(), 'public');

            // full url
            $url = asset('storage/' . $local . '/' . $request->arquivo->getClientOriginalName());
        }   

        // recebi o usuário logado no sistema
        // cria o anexo
        $anexo = new Anexo;

        $user = Auth::user();

        $anexo->user_id = $user->id;

        // salva as informações do arquivo
        $anexo->arquivoNome = $nome_arquivo;
        $anexo->arquivoLocal = $local;
        $anexo->arquivoUrl = $url;


        // salva o anexo no banco de dados
        $protocolo = Protocolo::find($request['protocolo_id']);

        $protocolo->anexos()->save($anexo);

        Session::flash('create_anexo', 'Anexo salvo com sucesso!');

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
        // if (Gate::denies('protocolo.anexo.delete')) {
        //     abort(403, 'Acesso negado.');
        // }

        $anexo = Anexo::findOrFail($id);

        $num_protocolo = $anexo->anexoable_id;

        // paga o arquivo, mas mantém a pasta
        Storage::delete('public/' . $anexo->arquivoLocal . '/' . $anexo->arquivoNome);

        // apaga o registro do banco de dados
        $anexo->delete();

        Session::flash('delete_anexo', 'Anexo excluído com sucesso!');

        return Redirect::route('protocolos.edit', $num_protocolo);        
    }
}
