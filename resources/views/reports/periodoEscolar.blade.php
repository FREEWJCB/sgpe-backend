@extends('reports.reporte')

@section('title', 'Periodo Escolar')

@section('encabezado', 'Reporte de los Periodos Escolares')

@section('encabezados')
    <tr>
        <th>#</th>
        <th scope="col">Profesor - Nombres y Apellidos</th>
        <th scope="col">Grado</th>
        <th scope="col">Seccion</th>
        <th scope="col">Salon</th>
        <th scope="col">Creado</th>
    </tr>
@endsection
@section('contenido')
    @if(count($data) > 0)
         @foreach($data as $row)
            <tr>
                <td scope="row">{{$row->id}}</td>
                <td>{{$row->nombre}} {{$row->apellido}}</td>
                <td>{{$row->grados}}</td>
                <td>{{$row->secciones}}</td>
                <td>{{$row->salones}}</td>
                <td>{{date("d-m-Y", strtotime($row->created_at))}}</td>
            </tr>
         @endforeach
    @endif
@endsection
