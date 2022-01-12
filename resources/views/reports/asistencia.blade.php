@extends('reports.pdf')
@section('contenido')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <div class="text-center">
                    <h2>Notas</h2>
                </div>
                {{--<div class="text-left">{{ $inscripcion->created_at->format('d/m/Y') }}
            </div>--}}
        </div>
        @foreach($grupos as $key => $grupo)
        <div style="margin-bottom: 20px;">
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
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            Grado
                        </td>
                        <td colspan="2" class="px-3 py-2 text-xs">
                            {{ $grupo->grado }}
                        </td>
                        <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            Sección
                        </td>
                        <td colspan="1" class="px-3 py-2 text-xs">
                            {{ $grupo->seccion }}
                        </td>
                        <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            Periodo Escolar
                        </td>
                        <td colspan="1" class="px-3 py-2 text-xs">
                            {{ $grupo->periodo_escolar }}
                        </td>
                    </tr>
                    <tr class="divide-x divide-gray-200">
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            Profesor
                        </td>
                        <td colspan="3" class="px-3 py-2 text-xs">
                            {{ $grupo->empleado }}
                        </td>
                        <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            Materia
                        </td>
                        <td colspan="2" class="px-3 py-2 text-xs">
                            {{ $grupo->materia }}
                        </td>
                    </tr>
                    <tr class="divide-x divide-gray-200">
                        <td colspan="3" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            Estudiante
                        </td>
                        <td colspan="4" class="px-3 py-2 fw-bold text-xs bg-gray-50 text-center">
                            Lapsos
                        </td>
                        <td colspan="1" class="px-3 py-2 fw-bold text-xs bg-gray-50 text-center" style="padding-left: 20px;">
                            Total
                        </td>
                    </tr>
                    <tr class="divide-x divide-gray-200">
                        @php
                        $total = 0;
                        @endphp
                        <td colspan="3" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            {{ $estudiantes[$key]->nombre }} {{ $estudiantes[$key]->apellido }}
                        </td>
                        <td colspan="1" class="px-3 py-2 text-xs" style="padding: 0 70px;">
                            {{ $estudiantes[$key]->primerLapso }}
                            @php
                            $total += $estudiantes[$key]->primerLapso;
                            @endphp
                        </td>
                        <td colspan="1" class="px-3 py-2 text-xs" style="padding: 0 70px;">
                            {{ $estudiantes[$key]->segundoLapso }}
                            @php
                            $total += $estudiantes[$key]->segundoLapso;
                            @endphp
                        </td>
                        <td colspan="1" class="px-3 py-2 text-xs" style="padding: 0 70px;">
                            {{ $estudiantes[$key]->tercerLapso }}
                            @php
                            $total += $estudiantes[$key]->tercerLapso;
                            @endphp
                        </td>
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            {{ $total }}
                        </td>
                        @php
                        $total = 0;
                        @endphp
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
    {{--<pre>@json($grupos, JSON_PRETTY_PRINT)</pre>--}}
    {{--<pre>@json($estudiantes, JSON_PRETTY_PRINT)</pre>--}}
</div>
@endsection
