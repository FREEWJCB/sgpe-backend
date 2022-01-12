@extends('reports.pdf')
@section('contenido')

<div class="card">
    <div class="card-body">
        @foreach($inscripciones as $inscripcion)
        <div class="table-responsive">
            <div>
                <div class="text-center">
                    <h2>Inscripción</h2>
                </div>
                <div class="text-left">{{ $inscripcion->created_at->format('d/m/Y') }}</div>
            </div>
            <div>
                <table class="table table-borderles">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <tbody>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="8" class="px-3 py-2 fw-bold bg-gray-50">
                                Estudiante
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Nombre
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->nombre }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Apellido
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->apellido }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                cedula
                            </td>
                            <td colspan="1" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->cedula }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Sexo
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->sex }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Telefono
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->telefono }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200 text-xs">
                            <td colspan="1" class="px-3 py-2 fw-bold bg-gray-50">
                                Fecha de Nacimiento
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->fecha_nacimiento }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Lugar de Nacimiento
                            </td>
                            <td colspan="4" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->lugar_nacimiento }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200 text-xs">
                            <td colspan="1" class="px-3 py-2 fw-bold bg-gray-50">
                                Descripción
                            </td>
                            <td colspan="7" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->descripcion }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200 text-xs">
                            <td colspan="1" class="px-3 py-2 fw-bold bg-gray-50">
                                Tipo de Sangre
                            </td>
                            <td colspan="1" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->t_sangre }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Estatura
                            </td>
                            <td colspan="1" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->estatura }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Peso
                            </td>
                            <td colspan="1" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->peso }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Talla
                            </td>
                            <td colspan="1" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->talla }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Estado
                            </td>
                            <td colspan="3" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->states }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Municipio
                            </td>
                            <td colspan="3" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->municipality }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Dirección
                            </td>
                            <td colspan="7" class="px-3 py-2 text-xs">
                                {{ $inscripcion->estudiante->direccion }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px; width: 1000px;">
                <table class="table table-borderles">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <tbody>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="8" class="px-3 py-2 fw-bold bg-gray-50">
                                Representante
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                nombre
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->nombre }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                apellido
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->apellido }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                cedula
                            </td>
                            <td colspan="1" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->cedula }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                sexo
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->sex }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                telefono
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->telefono }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                labor
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->ocupacion_laboral }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                estado
                            </td>
                            <td colspan="3" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->states }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                municipio
                            </td>
                            <td colspan="3" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->municipality }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200 bg-gray-50">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs">
                                dirección
                            </td>
                            <td colspan="7" class="px-3 py-2 text-xs">
                                {{ $inscripcion->representante->direccion }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px; width: 1000px;">
                <table class="table table-borderles">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <tbody>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="8" class="px-3 py-2 fw-bold bg-gray-50">
                                Profesor
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                nombre
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->empleado->nombre }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                apellido
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->empleado->apellido }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                cedula
                            </td>
                            <td colspan="1" class="px-3 py-2 text-xs">
                                {{ $inscripcion->empleado->cedula }}
                            </td>
                        </tr>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Cargo
                            </td>
                            <td colspan="7" class="px-3 py-2 text-xs">
                                {{ $inscripcion->empleado->cargo }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px; width: 1000px;">
                <table class="table table-borderles">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <col width="120px">
                    <tbody>
                        <tr class="divide-x divide-gray-200">
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Grado
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->grado }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Sección
                            </td>
                            <td colspan="2" class="px-3 py-2 text-xs">
                                {{ $inscripcion->seccion }}
                            </td>
                            <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                                Periodo Escolar
                            </td>
                            <td colspan="1" class="px-3 py-2 text-xs">
                                {{ $inscripcion->periodoescolar->anio_ini }} - {{ $inscripcion->periodoescolar->anio_fin }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{--<pre>@json($inscripcion, JSON_PRETTY_PRINT)</pre>--}}
        @endforeach
    </div>
</div>

@endsection
