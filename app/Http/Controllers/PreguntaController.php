<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('pregunta')
                    ->select('pregunta.*', 'cursos.curso as curs')
                    ->join('cursos', 'pregunta.cursos', '=', 'cursos.id')
                    ->where('pregunta.status', '1')
                    ->orderBy('preguntas','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $cursos = DB::table('cursos')->where('status', '1')->orderBy('curso','asc');
        $cursos2 = $cursos->get();
        $num_curso = $cursos->count();
        return view('view.Pregunta',['cons' => $cons2, 'num' => $num,'cursos' => $cursos2, 'num_curso' => $num_curso, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        DB::table('pregunta')->insert([
            'preguntas' => $request->preguntas,
            'cursos' => $request->curso
            ]);
        $cons = DB::table('pregunta')->where('preguntas', $request->preguntas)->get();

        foreach ($cons as $cons2) {
            # code...
            $pregunta=$cons2->id;
        }

        $cons = DB::table('respuestas')->orderBy('id','asc')->get();

        foreach ($cons as $cons2) {
            # code...
            $id=$cons2->id;
            $respuestas=$cons2->respuesta;
            $puntos=$request['puntos'.$id];
            DB::table('respuesta')->insert([
                'pregunta' => $pregunta,
                'puntos' => $puntos,
                'respuestas' => $respuestas
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $id=$request['id'];
        $preguntas=$request['preguntas'];
        DB::table('pregunta')->where('id', $id)->update(['preguntas' => $preguntas]);
        DB::table('respuesta')->where('pregunta', $id)->delete();

        $cons = DB::table('respuestas')->orderBy('id','asc')->get();

        foreach ($cons as $cons2) {
            # code...
            $ids=$cons2->id;
            $respuestas=$cons2->respuesta;
            $puntos=$request['puntos'.$ids];
            DB::table('respuesta')->insert([
                'pregunta' => $id,
                'puntos' => $puntos,
                'respuestas' => $respuestas
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::table('respuesta')->where('pregunta', $id)->delete();
        DB::table('pregunta')->where('id', $id)->delete();
    }

    public function cargar(Request $request)
    {
        $cat="";
        $preguntas=$request->bs_pregunta;
        $curs=$request->bs_curso;
        $cons = DB::table('pregunta')
                    ->select('pregunta.*', 'cursos.curso as curs')
                    ->join('cursos', 'pregunta.cursos', '=', 'cursos.id')
                    ->where([
                        ['pregunta.status', '1'],
                        ['preguntas','like', "%$preguntas%"],
                        ['cursos.curso','like', "%$curs%"]
                    ])
                    ->orderBy('preguntas','asc');

        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $preguntas=$cons2->preguntas;
                $curs=$cons2->curs;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$curs</center></td>
                        <td><center>$preguntas</center></td>
                        <td>
                            <center data-turbolinks='false' class='navbar navbar-light'>
                                <a onclick = \"return mostrar($id,'Mostrar');\" class='btn btn-info btncolorblanco' href='#' >
                                    <i class='fa fa-list-alt'></i>
                                </a>
                                <a onclick = \"return mostrar($id,'Edicion');\" class='btn btn-success btncolorblanco' href='#' >
                                    <i class='fa fa-edit'></i>
                                </a>
                                <a onclick ='return desactivar($id)' class='btn btn-danger btncolorblanco' href='#' >
                                    <i class='fa fa-trash-alt'></i>
                                </a>
                            </center>
                        </td>
                    </tr>";

            }
        }else{
            $cat="<tr><td colspan='6'>No hay datos registrados</td></tr>";
        }
        return response()->json([
            'catalogo'=>$cat
        ]);

    }

    public function mostrar(Request $request)
    {
        //
        $id=$request->id;
        $cons= DB::table('pregunta')->where('id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $preguntas=$cons2->preguntas;
            $cursos=$cons2->cursos;
            $consu= DB::table('respuesta')->where('pregunta', $id)->orderBy('id','asc')->get();
            foreach ($consu as $consu2) {
                # code...
                $respuestas=$consu2->respuestas;
                $puntos=$consu2->puntos;
                DB::table('respuestas')->insert([
                    'respuesta' => $respuestas,
                    'puntos' => $puntos
                    ]);
            }
        }
        $cons = DB::table('respuestas')->orderBy('id','asc')->get();
        $respuestas="";
        $i=0;
        foreach ($cons as $cons2) {
            $i++;
            $id=$cons2->id;
            $respuesta=$cons2->respuesta;
            $puntos=$cons2->puntos;
            $respuestas.="
            <div id='resp$id' class='alert alert-primary alert-dismissible fade show form-row' role='alert'>
                <div class='col-7'>$respuesta</div>
                <div class='col'><label for='puntos$id'><strong>Puntos:</strong></label></div>
                <div class='col'><input type='number' class='my-1 mr-sm-2' value='$puntos' min='1' max='99' name='puntos$id' id='puntos$id'></div>
                <button type='button' id='respu$i' class='close' data-dismiss='alert' aria-label='Close' onclick='return quitar($id);'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
        }

        return response()->json([
            'preguntas'=>$preguntas,
            'respuestas'=>$respuestas,
            'curso'=>$cursos,
            'i'=>$i
        ]);


    }

    public function clear()
    {
        //
        DB::table('respuestas')->delete();

    }

    public function quitar(Request $request)
    {
        //
        $id=$request->id;
        DB::table('respuestas')->where('id', $id)->delete();
        $num = DB::table('respuestas')->count();
        return response()->json([
            'num'=>$num
        ]);
    }

    public function respuestas(Request $request)
    {
        //
        DB::table('respuestas')->insert(['respuesta' => $request->respuestas]);

        $cons = DB::table('respuestas')->orderBy('id','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        $i=0;
        $respuestas="";
        $ocultar="";
        foreach ($cons1 as $cons2) {
            # code...
            $i++;
            $id=$cons2->id;
            $respuesta=$cons2->respuesta;
            $puntos=$cons2->puntos;
            $request['puntos'.$id];
            if ($i==$num) {
                # code...
                $ocultar="style='display: none'";
            }else{

                $puntos=$request['puntos'.$id];
                DB::table('respuestas')->where('id', $id)->update(['puntos' => $puntos]);

            }

            $respuestas.="
            <div id='resp$id' $ocultar class='alert alert-primary alert-dismissible fade show form-row' role='alert'>
                <div class='col-7'>$respuesta</div>
                <div class='col'><label for='puntos$id'><strong>Puntos:</strong></label></div>
                <div class='col'><input type='number' class='my-1 mr-sm-2' value='$puntos' min='1' max='99' name='puntos$id' id='puntos$id'></div>
                <button type='button' class='close' id='respu$i' data-dismiss='alert' aria-label='Close' onclick='return quitar($id);'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>";



        }

        return response()->json([
            'respuestas'=>$respuestas,
            'num'=>$num,
            'id'=>$id
        ]);


    }

    public function prueba()
    {
        //

        $cons = DB::table('cursos')->where('status', '1')->orderBy('curso','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        return view('view.Prueba',['cons' => $cons2, 'num' => $num]);
    }


    public function exam(Request $request)
    {
        //
        $cursos=$request['curso'];
        $cons = DB::table('pregunta')->where('cursos', $cursos)->orderBy('preguntas','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        $exam="";
        if ($num>0) {
            # code...
            $i=0;
            $exam.="<h2>Preguntas</h2>";
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $preguntas=$cons2->preguntas;

                $exam.="<div class='form-group'>

                            <br><br> <label>$preguntas</label> <br><br>";
                $consu = DB::table('respuesta')->where('pregunta', $id)->orderBy('respuestas','asc')->get();
                $u=0;
                foreach ($consu as $consu2) {
                    $u++;
                    $respuestas=$consu2->respuestas;
                    $puntos=$consu2->puntos;
                    $exam.="
                        <div class='form-check form-check-inline'>
                            <input class='form-check-input' type='radio' name='respuestas$i' id='respuestas$u$i' value='$puntos'>
                            <label class='form-check-label' for='respuestas$u$i'>$respuestas</label>
                        </div>";
                }

            }
            $exam.="</div>
                        <br><br><input type='submit' class='btn btn-primary' id='reg' value='Examinar' />
                        <div id='resp'></div>";
        }else{
            $exam.="<div class='alert alert-danger' role='alert'>
                        No hay preguntas registradas!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href='{{route('Pregunta.index')}}' class='btn btn-danger btncolorblanco' rel='noopener noreferrer'><i class='fa fa-user-plus'></i> Registrar</a>
                    </div>";
        }

        return response()->json([
            'exam'=>$exam,
            'num'=>$num
        ]);

    }


    public function calcular(Request $request)
    {
        //
        $curso=$request['curso'];
        $num=$request['num'];
        $puntos=0;
        $resp="";
        if ($num>0) {
            # code...
            for ($i=1; $i <= $num; $i++) {
                # code...
                $respuestas=$request['respuestas'.$i];
                $puntos=$puntos+$respuestas;

            }
            $cons = DB::table('nivel')->where('cursos', $curso)->orderBy('id','asc')->get();
            foreach($cons as $cons2){
                $inicial = $cons2->inicial;
                $final = $cons2->final;
                if($puntos >= $inicial && $puntos <= $final){
                    $niveles = $cons2->niveles;
                }
            }

            $resp .="<div class='alert alert-success' role='alert'>
                        La encuesta ha dado un total de <strong>$puntos</strong> puntos.
                        Nivel <strong>$niveles</strong>.
                    </div>";
        }else{
            $resp .="<div class='alert alert-danger' role='alert'>
                        error.
                    </div>";
        }


        return response()->json([
            'resp'=>$resp
        ]);


    }
}
