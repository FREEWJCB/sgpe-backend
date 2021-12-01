@extends('reports.reporte')

@section('title', 'Seccion')

@section('encabezado', 'Reporte de las Secciones')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Seccion</th>
        <th>Creado</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->secciones}}</td>
                <td>{{date("d-m-Y", strtotime($row->created_at))}}</td>
            </tr>
         @endforeach
    @endif
@endsection
