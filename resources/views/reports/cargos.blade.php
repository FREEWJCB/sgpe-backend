@extends('reports.reporte')

@section('title', 'Cargos')

@section('encabezado', 'Reporte de los Cargos')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Cargo</th>
        <th>Creado</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->cargos}}</td>
                <td>{{date("d-m-Y", strtotime($row->created_at))}}</td>
            </tr>
         @endforeach
    @endif
@endsection
