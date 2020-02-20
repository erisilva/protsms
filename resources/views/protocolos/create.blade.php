@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('protocolos.index') }}">Lista de Protocolos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('protocolos.store') }}">
    @csrf
    <div class="form-group">
      <label for="protocolo_tipo_id">Tipo do Protocolo</label>
      <select class="form-control {{ $errors->has('protocolo_tipo_id') ? ' is-invalid' : '' }}" name="protocolo_tipo_id" id="protocolo_tipo_id">
        <option value="" selected="true">Selecione ...</option>        
        @foreach($protocolotipos as $protocolotipo)
        <option value="{{$protocolotipo->id}}">{{$protocolotipo->descricao}}</option>
        @endforeach
      </select>
      @if ($errors->has('protocolo_tipo_id'))
      <div class="invalid-feedback">
      {{ $errors->first('protocolo_tipo_id') }}
      </div>
      @endif
    </div>
    <div class="form-group">
      <label for="conteudo">Conteúdo/Descrição</label>
      <textarea class="form-control {{ $errors->has('conteudo') ? ' is-invalid' : '' }}" name="conteudo" id="conteudo" rows="5">{{ old('conteudo') ?? '' }}</textarea>
      @if ($errors->has('conteudo'))
      <div class="invalid-feedback">
      {{ $errors->first('conteudo') }}
      </div>
      @endif
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Novo Protocolo</button>
  </form>
  <div class="float-right">
    <a href="{{ route('protocolos.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection
