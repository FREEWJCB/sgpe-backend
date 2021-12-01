@extends('reports.reporte')

@section('title', 'Ocupacion Laboral')

@section('encabezado', 'Reporte de las Ocupaciónes Laborales')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">labor</th>
        <th>Creado</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->labor}}</td>
                <td>{{date("d-m-Y", strtotime($row->created_at))}}</td>
            </tr>
         @endforeach
    @endif
@endsection
