@extends('reports.reporte')

@section('title', 'Empleados')

@section('encabezado', 'Reporte de los Empleados')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Cedula</th>
        <th scope="col">Nombres y Apellidos</th>
        <th scope="col">Sexo</th>
        <th scope="col">Estado</th>
        <th scope="col">Municipio</th>
        <th scope="col">Email</th>
        <th scope="col">Cargo</th>
        <th scope="col">Telefono</th>
        <th>Creado</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->cedula}}</td>
                <td>{{$row->nombre}} {{$row->apellido}}</td>
                <td>{{$row->sex}}</td>
                <td>{{$row->states}}</td>
                <td>{{$row->municipalitys}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->cargos}}</td>
                <td>{{$row->telefono}}</td>
            </tr>
         @endforeach
    @endif
@endsection
