@extends('reports.reporte')

@section('title', 'Estudiante')

@section('encabezado', 'Reporte de los Estudiantes')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Nombres y Apellidos</th>
        <th scope="col">Sexo</th>
        <th scope="col">Fecha de Nacimiento</th>
        <th scope="col">Lugar de Nacimiento</th>
        <th scope="col">Estado</th>
        <th scope="col">Municipio</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->nombre}} {{$row->apellido}}</td>
                <td>{{$row->sex}}</td>
                <td>{{$row->fecha_nacimiento}}</td>
                <td>{{$row->lugar_nacimiento}}</td>
                <td>{{$row->states}}</td>
                <td>{{$row->municipalitys}}</td>
            </tr>
         @endforeach
    @endif
@endsection
