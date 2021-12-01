@extends('reports.reporte')

@section('title', 'Grados')

@section('encabezado', 'Reporte de los Grados')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Grados</th>
        <th>Creado</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->grados}}</td>
                <td>{{date("d-m-Y", strtotime($row->created_at))}}</td>
            </tr>
         @endforeach
    @endif
@endsection
