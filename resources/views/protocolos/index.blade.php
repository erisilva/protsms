@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('protocolos.index') }}">Lista de Protocolos</a></li>
    </ol>
  </nav>
  @if(Session::has('deleted_protocolo'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('deleted_protocolo') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_protocolo'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_protocolo') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="btn-group py-1" role="group" aria-label="Opções">
    <a href="{{ route('protocolos.create') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-plus-square"></i> Novo Registro</a>
    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalFilter"><i class="fas fa-filter"></i> Filtrar</button>
    <div class="btn-group" role="group">
      <button id="btnGroupDropOptions" type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Opções
      </button>
      <div class="dropdown-menu" aria-labelledby="btnGroupDropOptions">
        <a class="dropdown-item" href="#" id="btnExportarCSV"><i class="fas fa-file-download"></i> Exportar Planilha</a>
        <a class="dropdown-item" href="#" id="btnExportarPDF"><i class="fas fa-file-download"></i> Exportar PDF</a>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Nº</th>
                <th scope="col">Data</th>
                <th scope="col">Hora</th>
                <th scope="col"></th>
                <th scope="col">Tipo</th>
                <th scope="col">Setor</th>
                <th scope="col">Aberto por</th>
                <th scope="col">Situação</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($protocolos as $protocolo)
            <tr>
                <td><strong>{{$protocolo->id}}</strong></td>
                <td>{{$protocolo->created_at->format('d/m/Y')}}</td>
                <td>{{$protocolo->created_at->format('H:i')}}</td>
                <td>{{$protocolo->created_at->diffForHumans()}}</td>
                <td>{{$protocolo->protocoloTipo->descricao}}</td>
                <td>{{$protocolo->setor->descricao}}</td>
                <td>{{$protocolo->user->name}}</td>
                <td><strong>{{$protocolo->protocoloSituacao->descricao}}</strong></td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('protocolos.edit', $protocolo->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-edit"></i></a>
                    <a href="{{route('protocolos.show', $protocolo->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-trash-alt"></i></a>
                  </div>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $protocolos->currentPage() }} de {{ $protocolos->lastPage() }}. Total de registros: {{ $protocolos->total() }}.</p>
  <div class="container-fluid">
      {{ $protocolos->links() }}
  </div>
  <!-- Janela de filtragem da consulta -->
  <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="JanelaFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-filter"></i> Filtro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Filtragem dos dados -->
          <!-- Seleção de número de resultados por página -->
          <div class="form-group">
            <select class="form-control" name="perpage" id="perpage">
              @foreach($perpages as $perpage)
              <option value="{{$perpage->valor}}"  {{($perpage->valor == session('perPage')) ? 'selected' : ''}}>{{$perpage->nome}}</option>
              @endforeach
            </select>
          </div>
        </div>     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Fechar</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script-footer')
<script>
$(document).ready(function(){
    $('#perpage').on('change', function() {
        perpage = $(this).find(":selected").val(); 
        
        window.open("{{ route('protocolos.index') }}" + "?perpage=" + perpage,"_self");
    });

    $('#btnExportarCSV').on('click', function(){
        window.open("{{ route('protocolos.export.csv') }}","_self");
    });

    $('#btnExportarPDF').on('click', function(){
        window.open("{{ route('protocolos.export.pdf') }}","_self");
    });
}); 
</script>
@endsection