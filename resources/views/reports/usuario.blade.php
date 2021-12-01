@extends('reports.reporte')

@section('title', 'Usuario')

@section('encabezado', 'Reporte de los Usuarios')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Cedula</th>
        <th scope="col">Nombres y Apellidos</th>
        <th scope="col">Nombre de Usuario</th>
        <th scope="col">Tipo</th>
        <th scope="col">Email</th>
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
                <td>{{$row->username}}</td>
                <td>{{$row->tipo}}</td>
                <td>{{$row->email}}</td>
                <td>{{date("d-m-Y", strtotime($row->created_at))}}</td>
            </tr>
         @endforeach
    @endif
@endsection
