@extends('reports.reporte')

@section('title', 'Tipos de Usuarios')

@section('encabezado', 'Reporte de los Tipos de Usuarios')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Tipo</th>
        <th>Creado</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->tipo}}</td>
                <td>{{date("d-m-Y", strtotime($row->created_at))}}</td>
            </tr>
         @endforeach
    @endif
@endsection
