@extends('layouts.app')

@section('css-header')
<style>
  .twitter-typeahead, .tt-hint, .tt-input, .tt-menu { width: 100%; }
  .tt-query, .tt-hint { outline: none;}
  .tt-query { box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);}
  .tt-hint {color: #999;}
  .tt-menu { 
      width: 100%;
      margin-top: 12px;
      padding: 8px 0;
      background-color: #fff;
      border: 1px solid #ccc;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      box-shadow: 0 5px 10px rgba(0,0,0,.2);
  }
  .tt-suggestion { padding: 3px 20px; }
  .tt-suggestion.tt-is-under-cursor { color: #fff; }
  .tt-suggestion p { margin: 0;}
</style>
@endsection

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('protocolos.index') }}">Lista de Protocolos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  @if(Session::has('edited_protocolo'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('edited_protocolo') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_protocolotramitacao'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_protocolotramitacao') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if ($errors->has('user_id_destino'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Erro!</strong>  {{ $errors->first('user_id_destino') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if ($errors->has('setor_id_destino'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Erro!</strong>  {{ $errors->first('setor_id_destino') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if ($errors->has('protocolo_id'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Erro!</strong>  {{ $errors->first('protocolo_id') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif


  <div class="container">
      


    @if ($protocolo->concluido === 'n')
    <form method="POST" action="{{ route('protocolos.update', $protocolo->id) }}">
      @csrf
      @method('PUT')
      <div class="form-row">
        <div class="form-group col-md-3">
          <div class="p-3 bg-primary text-white text-right h2">Nº {{ $protocolo->id }}</div>    
        </div>
        <div class="form-group col-md-2">
          <label for="dia">Data</label>
          <input type="text" class="form-control" name="dia" value="{{ $protocolo->created_at->format('d/m/Y') }}" readonly>
        </div>
        <div class="form-group col-md-2">
          <label for="hora">Hora</label>
          <input type="text" class="form-control" name="hora" value="{{ $protocolo->created_at->format('H:i') }}" readonly>
        </div>
        <div class="form-group col-md-5">
          <label for="protocolo_tipo_id">Tipo do Protocolo</label>
          <select class="form-control {{ $errors->has('protocolo_tipo_id') ? ' is-invalid' : '' }}" name="protocolo_tipo_id" id="protocolo_tipo_id">
            <option value="{{$protocolo->protocolo_tipo_id}}" selected="true">&rarr; {{ $protocolo->protocoloTipo->descricao }}</option>        
            @foreach($protocolotipos as $protocolotipo)
            <option value="{{$protocolotipo->id}}">{{ $protocolotipo->descricao }}</option>
            @endforeach
          </select>
          @if ($errors->has('protocolo_tipo_id'))
          <div class="invalid-feedback">
          {{ $errors->first('protocolo_tipo_id') }}
          </div>
          @endif
        </div>
      </div>
      <div class="form-group">
        <label for="conteudo">Conteúdo/Descrição</label>
        <textarea class="form-control" name="conteudo" rows="5">{{ $protocolo->conteudo }}</textarea>      
      </div>
      <div class="form-group">
        <label for="situacao">Situação</label>
        <input type="text" class="form-control" name="situacao" value="{{ $protocolo->protocoloSituacao->descricao }}" readonly style="font-weight: bold;">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Alterar</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirProtocolo">
          <i class="far fa-thumbs-up"></i> Concluir
        </button>
      </div>
    </form>
    @else
    <form>
      <div class="form-row">
        <div class="form-group col-md-3">
          <div class="p-3 bg-primary text-white text-right h2">Nº {{ $protocolo->id }}</div>    
        </div>
        <div class="form-group col-md-2">
          <label for="dia">Data</label>
          <input type="text" class="form-control" name="dia" value="{{ $protocolo->created_at->format('d/m/Y') }}" readonly>
        </div>
        <div class="form-group col-md-2">
          <label for="hora">Hora</label>
          <input type="text" class="form-control" name="hora" value="{{ $protocolo->created_at->format('H:i') }}" readonly>
        </div>
        <div class="form-group col-md-5">
          <label for="protocolo_tipo">Tipo do Protocolo</label>
          <input type="text" class="form-control" name="protocolo_tipo" value="{{ $protocolo->protocoloTipo->descricao }}" readonly>
        </div>
      </div>  
      <div class="form-group">
        <label for="conteudo">Conteúdo/Descrição</label>
        <textarea class="form-control" name="conteudo" rows="5" readonly>{{ $protocolo->conteudo }}</textarea>    
      </div>
      <div class="form-row">
        <div class="form-group col-sm-6">
          <label for="situacao">Situação</label>
          <input type="text" class="form-control" name="situacao" value="{{ $protocolo->protocoloSituacao->descricao }}" readonly style="font-weight: bold;">
        </div>
        <div class="form-group col-sm-3">
          <label for="protocolo_data_conclusao">Data(conclusão)</label>
          <input type="text" class="form-control" name="protocolo_data_conclusao" value="{{ $protocolo->concluido_em->format('d/m/Y') }} " readonly>
        </div>
        <div class="form-group col-sm-3">
          <label for="protocolo_hora_conclusao">Hora(conclusão)</label>
          <input type="text" class="form-control" name="protocolo_hora_conclusao" value="{{ $protocolo->concluido_em->format('H:i')  }}" readonly>
        </div>
      </div>
      <div class="form-group">
        <label for="conteudo">Notas de conclusão</label>
        <textarea class="form-control" name="conteudo" rows="3" readonly>{{ $protocolo->concluido_mensagem }}</textarea>    
      </div>   
    </form>
    @endif


    </div>
  </div>



  <div class="container">
    

    <div class="row">
      <div class="col-sm">

        <div class="container bg-primary text-light">
          <p class="text-center"><strong>Anexos</strong></p>
        </div>

        @if ($protocolo->concluido === 'n')
        <div class="container">
          <form method="POST" action="{{ route('protocoloanexos.store') }}" class="form-inline" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="protocolo_id" name="protocolo_id" value="{{ $protocolo->id }}">
            <div class="form-group p-2">
              <label for="arquivo">Escolha o arquivo</label>
              <input type="file" class="form-control-file  {{ $errors->has('arquivo') ? ' is-invalid' : '' }}" id="arquivo" name="arquivo">
              @if ($errors->has('arquivo'))
              <div class="invalid-feedback">
              {{ $errors->first('arquivo') }}
              </div>
              @endif
            </div>
            <div class="form-group py-2">
              <button type="submit" class="btn btn-primary"><i class="fas fa-paperclip"></i> Anexar Arquivo</button>
              <button type="button" class="btn btn-secondary" data-toggle="popover" title="Informações sobre o arquivo" data-placement="right" data-content="Somente são aceitos os seguintes formatos para o arquivo: pdf, doc, rtf, txt, jpg, jpeg, png, bmp, xls, xlsx, csv, xml. O arquivo não pode ter mais de 2Mb."><i class="fas fa-info-circle"></i> Info</button>
            </div>
          </form>  
        </div>
        @endif

        <div class="container">
          @if(Session::has('create_anexo'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Info!</strong>  {{ session('create_anexo') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          @if(Session::has('delete_anexo'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Info!</strong>  {{ session('delete_anexo') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          @if ( !$anexos->isEmpty() ) 
          <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Arquivo</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anexos as $anexo)
                    <tr>
                        <td>{{ $anexo->created_at->format('d/m/Y')  }}</td>
                        <td>{{ $anexo->created_at->format('H:i') }}</td>
                        <td><a href="{{ $anexo->arquivoUrl }}" target="_blank">{{ $anexo->arquivoNome }}</a></td>
                        <td>
                          @if ($protocolo->concluido === 'n')
                          <form method="post" action="{{route('protocoloanexos.destroy', $anexo->id)}}"  onsubmit="return confirm('Você tem certeza que quer excluir esse arquivo?');">
                            @csrf
                            @method('DELETE')  
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                          </form>
                          @endif
                        </td>
                    </tr>    
                    @endforeach                                                 
                </tbody>
            </table>
          </div>
          @else
            <p>Nenhuma anexo</p>
          @endif
        </div>

      </div>  

      <div class="col-sm">
        <div class="container bg-primary text-light">
          <p class="text-center"><strong>Notas</strong></p>
        </div>

        @if ($protocolo->concluido === 'n')
        <div class="container">
          <form method="POST" action="{{ route('protocolonotas.store') }}">
            @csrf
            <input type="hidden" id="protocolo_id" name="protocolo_id" value="{{ $protocolo->id }}">
            <div class="form-group">

              <label for="conteudo">Conteúdo</label>
              <textarea class="form-control {{ $errors->has('conteudo') ? ' is-invalid' : '' }}" name="conteudo" rows="2"></textarea> 
              @if ($errors->has('conteudo'))
              <div class="invalid-feedback">
              {{ $errors->first('conteudo') }}
              </div>
              @endif
              
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-sticky-note"></i> Adicionar Nota</button>  
            </div>
          </form>  
        </div>
        @endif

        <div class="container">
          @if(Session::has('create_nota'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Info!</strong>  {{ session('create_nota') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          @if(Session::has('delete_nota'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Info!</strong>  {{ session('delete_nota') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          @if ( !$notas->isEmpty() ) 
          <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Nota</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notas as $nota)
                    <tr>
                        <td>{{ $nota->created_at->format('d/m/Y')  }}</td>
                        <td>{{ $nota->created_at->format('H:i') }}</td>
                        <td>{{ $nota->conteudo }}</td>
                        <td>
                          @if ($protocolo->concluido === 'n')
                          <form method="post" action="{{route('protocolonotas.destroy', $nota->id)}}"  onsubmit="return confirm('Você tem certeza que quer excluir essa nota?');">
                            @csrf
                            @method('DELETE')  
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                          </form>
                          @endif
                        </td>
                    </tr>    
                    @endforeach                                                 
                </tbody>
            </table>
          </div>
          @else
            <p>Nenhuma nota</p>
          @endif 
        </div>
      </div>


    </div>
        
    
  </div>








  <div class="container">
    <div class="container bg-primary text-light">
      <p class="text-center"><strong>Tramitações</strong></p>
    </div>
  </div>


  @if ($protocolo->concluido === 'n')
  <div class="container">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTramitarProtocolo">
    <i class="fas fa-retweet"></i> Tramitar
  </button>    
  </div>
  @endif


<br>

  <div class="container">
    
    <div class="card">
    <div class="card-header">
     <strong><span><i class="fas fa-comment"></i></span> Tramitado em 10/10/2010 há 3 dias</strong> 
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <div class="container">
          <div class="row">
            
            <div class="col-sm">
              <strong>Origem:</strong> Abadia dos santos silva sauro azul
            </div>

            <div class="col-sm">
              <strong>Setor:</strong> Delegacia oficial dos Testes Malucos
            </div>

          </div>    
        </div>
      </li>
      <li class="list-group-item">
        
        <div class="container">
          <div class="row">
            
            <div class="col-sm">
              <strong>Destino:</strong> Abadia dos santos silva sauro azul
            </div>

            <div class="col-sm">
              <strong>Setor:</strong> Delegacia ofial dos Testes Malucos
            </div>

          </div>

        </div>
      </li>
      <li class="list-group-item">
        

        <div class="container">
          <div class="row">
            
            <div class="col-sm">
              <h5>Notas da Tramitação:</h5>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pharetra nibh commodo suscipit tristique. Aliquam pretium urna mi, in imperdiet augue fringilla non.</p>
            </div>

            <div class="col-sm">
              <h5>Notas do Recebimento:</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pharetra nibh commodo suscipit tristique. Aliquam pretium urna mi, in imperdiet augue fringilla non.</p>
            </div>

          </div>

        </div>

      </li>
      </ul>
    </div>


  </div>

  <br>

  <div class="container">
    <div class="float-right">
      <a href="{{ route('protocolos.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
    </div>
  </div>

  @if ($protocolo->concluido === 'n')
  <!-- Janela para concluir o protocolo -->
  <div class="modal fade" id="modalConcluirProtocolo" tabindex="-1" role="dialog" aria-labelledby="JanelaFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="far fa-thumbs-up"></i> Concluir Protocolo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atenção!</strong> Protocolos concluidos não podem ser reabertos.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="{{ route('protocolos.concluir', $protocolo->id) }}">
            @csrf
            <div class="form-group">
              <label for="concluido_mensagem">Mensagem de conclusão:</label>
              <textarea class="form-control" name="concluido_mensagem" rows="3"></textarea>      
            </div>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="protocolo_situacao_id" id="situacao_concluido" value="3" checked="true">
                <label class="form-check-label" for="situacao_concluido">Concluído</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="protocolo_situacao_id" id="situacao_cancelado" value="4">
                <label class="form-check-label" for="situacao_cancelado">Cancelado</label>
              </div>  
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="far fa-thumbs-up"></i> Concluir?</button>
            </div>
          </form>
        </div>     
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if ($protocolo->concluido === 'n')
  <!-- Janela para tramitar o protocolo -->
  <div class="modal fade" id="modalTramitarProtocolo" tabindex="-1" role="dialog" aria-labelledby="JanelaFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-retweet"></i> Tramitar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('protocolotramitacoes.store') }}">
            @csrf
            <input type="hidden" id="protocolo_id" name="protocolo_id" value="{{ $protocolo->id }}">

            <div class="form-group">
              <label for="funcionario_tramitacao">Funcionário</label>
              <input type="text" class="form-control typeahead" name="funcionario_tramitacao" id="funcionario_tramitacao" autocomplete="off">
              <input type="hidden" id="funcionario_tramitacao_id" name="funcionario_tramitacao_id">
              <input type="hidden" id="setor_tramitacao_id" name="setor_tramitacao_id">
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="funcionario_tramitacao_setor">Setor</label>
                <input type="text" class="form-control" name="funcionario_tramitacao_setor" id="funcionario_tramitacao_setor" readonly tabIndex="-1" placeholder="">
              </div>
              <div class="form-group col-md-6">
                <label for="funcionario_tramitacao_email">E-mail</label>
                <input type="text" class="form-control" name="funcionario_tramitacao_email" id="funcionario_tramitacao_email" readonly tabIndex="-1" placeholder="">
              </div>
            </div>

            <div class="form-group">
              <label for="mensagem">Mensagem</label>
              <textarea class="form-control" name="mensagem" rows="3"></textarea> 
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-retweet"></i> Tramitar</button>

          </form>  
        </div>     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Fechar</button>
        </div>
      </div>
    </div>
  </div>
  @endif







</div>

@endsection


@section('script-footer')
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script>
$(document).ready(function(){

var funcionarios = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "{{route('users.autocomplete')}}?query=%QUERY",
            wildcard: '%QUERY'
        },
        limit: 10
    });
    funcionarios.initialize();

    $("#funcionario_tramitacao").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: "funcionarios",
                displayKey: "text",
                source: funcionarios.ttAdapter(),
                templates: {
                  empty: [
                    '<div class="empty-message">',
                      '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhum funcionário com o texto digitado.</p>',
                    '</div>'
                  ].join('\n'),
                  suggestion: function(data) {
                      return '<div class="text-dark"><div>' + data.text + ' - <strong>Setor:</strong> ' + data.setor + '</div></div>';
                    }
                }
        }).on("typeahead:selected", function(obj, datum, name) {
            console.log(datum);
            $(this).data("seletectedId", datum.value);
            $('#funcionario_tramitacao_id').val(datum.value);
            $('#funcionario_tramitacao_setor').val(datum.setor);
            $('#funcionario_tramitacao_email').val(datum.email);
            $('#setor_tramitacao_id').val(datum.setor_id);
        }).on('typeahead:autocompleted', function (e, datum) {
            console.log(datum);
            $(this).data("seletectedId", datum.value);
            $('#funcionario_tramitacao_id').val(datum.value);
            $('#funcionario_tramitacao_setor').val(datum.setor);
            $('#funcionario_tramitacao_email').val(datum.email);
            $('#setor_tramitacao_id').val(datum.setor_id);
    });

    $(function () {
      $('[data-toggle="popover"]').popover()
    })   

});
</script>
@endsection