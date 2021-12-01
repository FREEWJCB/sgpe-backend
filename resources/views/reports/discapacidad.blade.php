@extends('reports.reporte')

@section('title', 'Discapacidad')

@section('encabezado', 'Reporte de Discapacidades')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Tipo</th>
        <th scope="col">Discapacidades</th>
        <th scope="col">Descripción</th>
        <th>Creado</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->tipo}}</td>
                <td>{{$row->discapacidades}}</td>
                <td>{{$row->descripcion}}</td>
                <td>{{date("d-m-Y", strtotime($row->created_at))}}</td>
            </tr>
         @endforeach
    @endif
@endsection
