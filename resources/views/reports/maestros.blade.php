@extends('reports.reporte')

@section('title', 'Estados')

@section('encabezado', $titulo)

@section('encabezados')
    <tr>
      @foreach($headers as $header)
        <th scope="col">{{$header}}</td>
      @endforeach
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
  @foreach($field as $campo)
    |@if($campo === "created_at" || $campo === "updated_at")
                <td>{{date("d-m-Y", strtotime($row[$campo]))}}</td>
                @else
                <td>{{$row[$campo]}}</td>
    @endif
  @endforeach
            </tr>
         @endforeach
    @endif
@endsection
