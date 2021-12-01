@extends('reports.reporte')

@section('title', 'Usuario')

@section('encabezado', 'Reporte de los Usuarios')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Nombres y Apellidos</th>
        <th scope="col">Sexo</th>
        <th scope="col">Estado</th>
        <th scope="col">Municipio</th>
        <th scope="col">Labor</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->nombre}} {{$row->apellido}}</td>
                <td>{{$row->sex}}</td>
                <td>{{$row->states}}</td>
                <td>{{$row->municipalitys}}</td>
                <td>{{$row->labor}}</td>
            </tr>
         @endforeach
    @endif
@endsection
