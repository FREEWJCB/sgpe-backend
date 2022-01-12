@extends('reports.pdf')
@section('contenido')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <div class="text-center">
                    <h2>Asistencia</h2>
                </div>
                {{--<div class="text-left">{{ $inscripcion->created_at->format('d/m/Y') }}
            </div>--}}
        </div>
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
                <col width="120px">
                <col width="120px">
                <col width="120px">
                <col width="120px">
                <tbody>
                    <tr class="divide-x divide-gray-200">
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                        </td>
                        @foreach($label as $lab)
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            {{ $lab }}
                        </td>
                        @endforeach
                    </tr>
                    <tr class="divide-x divide-gray-200">
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            Asistencias
                        </td>
                        @foreach($dataAsistencia as $Asistencia)
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            {{ $Asistencia }}
                        </td>
                        @endforeach
                    </tr>
                    <tr class="divide-x divide-gray-200">
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            Inacsistencias
                        </td>
                        @foreach($dataInasistencia as $Asistencia)
                        <td colspan="2" class="px-3 py-2 fw-bold text-xs bg-gray-50">
                            {{ $Asistencia }}
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    {{--<pre>@json($label, JSON_PRETTY_PRINT)</pre>--}}
    {{--<pre>@json($dataAsistencia, JSON_PRETTY_PRINT)</pre>--}}
    {{--<pre>@json($dataInasistencia, JSON_PRETTY_PRINT)</pre>--}}
</div>
@endsection
