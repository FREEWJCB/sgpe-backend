<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('estudiante')
                    ->select('estudiante.*','persona.cedula','persona.nombre','persona.apellido','persona.sex','municipality.municipalitys','state.states')
                    ->join('persona', 'estudiante.persona', '=', 'persona.id')
                    ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('estudiante.status', '1')
                    ->orderBy('cedula','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $state = DB::table('state')->where('status', '1')->orderBy('states','asc');
        $state2 = $state->get();
        $num_state = $state->count();

        $ocupacion_laboral = DB::table('ocupacion_laboral')->where('status', '1')->orderBy('labor','asc');
        $ocupacion_laboral2 = $ocupacion_laboral->get();
        $num_ocupacion_laboral = $ocupacion_laboral->count();

        $tipoa = DB::table('tipo_alergia')->where('status', '1')->orderBy('tipo','asc');
        $tipoa2 = $tipoa->get();
        $num_tipoa = $tipoa->count();

        $tipod = DB::table('tipo_discapacidad')->where('status', '1')->orderBy('tipo','asc');
        $tipod2 = $tipod->get();
        $num_tipod = $tipod->count();

        return view('view.Estudiante',['cons' => $cons2, 'num' => $num, 'state' => $state2, 'num_state' => $num_state, 'ocupacion_laboral' => $ocupacion_laboral2, 'num_ocupacion_laboral' => $num_ocupacion_laboral,'tipoa' => $tipoa2, 'num_tipoa' => $num_tipoa,'tipod' => $tipod2, 'num_tipod' => $num_tipod, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //estudiante
        $cedula=$request->cedula;
        $nombre=$request->nombre;
        $apellido=$request->apellido;
        $sex=$request->sex;
        $telefono=$request->telefono;
        $direccion=$request->direccion;
        $municipality=$request->municipality;
        $fecha_nacimiento=$request->fecha_nacimiento;
        $lugar_nacimiento=$request->lugar_nacimiento;
        $descripcion=$request->descripcion;
        $persona=$request->persona;
        $representante=$request->representante;
        $cedula_r=$request->cedula_r;
        $nombre_r=$request->nombre_r;
        $apellido_r=$request->apellido_r;
        $sex_r=$request->sex_r;
        $telefono_r=$request->telefono_r;
        $direccion_r=$request->direccion_r;
        $municipality_r=$request->municipality_r;
        $ocupacion_laboral=$request->ocupacion_laboral;
        $parentesco=$request->parentesco;

        DB::table('persona')->insert([
            'cedula' => $cedula,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'sex' => $sex,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'municipality' => $municipality
            ]);

        $cons = DB::table('persona')->where('cedula', $cedula)->get();

        foreach ($cons as $cons2) {
            # code...
            $persona_es=$cons2->id;
        }
        DB::table('estudiante')->insert([
            'fecha_nacimiento' => $fecha_nacimiento,
            'lugar_nacimiento' => $lugar_nacimiento,
            'descripcion' => $descripcion,
            'persona' => $persona_es
            ]);

        $cons = DB::table('estudiante')->where('persona', $persona_es)->get();

        foreach ($cons as $cons2) {
            # code...
            $estudiante=$cons2->id;
        }

        $cons = DB::table('alergias');
        $cons1 = $cons->get();
        $num = $cons->count();

        if ($num>0) {
            # code...
            foreach ($cons1 as $cons2) {
                # code...
                $alergia=$cons2->alergia;
                DB::table('estudiante_alergia')->insert([
                    'estudiante' => $estudiante,
                    'alergia' => $alergia
                    ]);
            }
        }

        $cons = DB::table('discapacidades');
        $cons1 = $cons->get();
        $num = $cons->count();

        if ($num>0) {
            # code...
            foreach ($cons1 as $cons2) {
                # code...
                $discapacidad=$cons2->discapacidad;
                DB::table('estudiante_discapacidad')->insert([
                    'estudiante' => $estudiante,
                    'discapacidad' => $discapacidad
                    ]);
            }
        }
        if ($persona == null) {
            # code...
            DB::table('persona')->insert([
                'cedula' => $cedula_r,
                'nombre' => $nombre_r,
                'apellido' => $apellido_r,
                'sex' => $sex_r,
                'telefono' => $telefono_r,
                'direccion' => $direccion_r,
                'municipality' => $municipality_r
                ]);

            $cons = DB::table('persona')->where('cedula', $cedula_r)->get();

            foreach ($cons as $cons2) {
                # code...
                $persona=$cons2->id;
            }
        }

        if ($representante == null) {
            # code...
            DB::table('representante')->insert([
                'ocupacion_laboral' => $ocupacion_laboral,
                'persona' => $persona
                ]);

            $cons = DB::table('representante')->where('persona', $persona)->get();

            foreach ($cons as $cons2) {
                # code...
                $representante=$cons2->id;
            }
        }

        DB::table('estudiante_representante')->insert([
            'parentesco' => $parentesco,
            'estudiante' => $estudiante,
            'representante' => $representante
            ]);

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
        DB::table('persona')->where('id', $request->persona)->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'sex' => $request->sex,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'municipality' => $request->municipality
            ]);

        DB::table('estudiante')->where('id', $request->id)->update([
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'lugar_nacimiento' => $request->lugar_nacimiento,
            'descripcion' => $request->descripcion
            ]);
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
        DB::table('estudiante')->where('id', $id)->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $cedula=$request->bs_cedula;
        $nombre=$request->bs_nombre;
        $apellido=$request->bs_apellido;
        $sex=$request->bs_sex;
        $cons = DB::table('estudiante')
                    ->select('estudiante.*','persona.cedula','persona.nombre','persona.apellido','persona.sex','municipality.municipalitys','state.states')
                    ->join('persona', 'estudiante.persona', '=', 'persona.id')
                    ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('cedula','like', "%$cedula%")
                    ->where('nombre','like', "%$nombre%")
                    ->where('apellido','like', "%$apellido%")
                    ->where('sex','like', "%$sex%")
                    ->where('estudiante.status', '1')
                    ->orderBy('cedula','asc');

        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $cedula=$cons2->cedula;
                $nombre="$cons2->nombre $cons2->apellido";
                $sex=$cons2->sex;
                $fecha_nacimiento=$cons2->fecha_nacimiento;
                $lugar_nacimiento=$cons2->lugar_nacimiento;
                $states=$cons2->states;
                $municipalitys=$cons2->municipalitys;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$cedula</center></td>
                        <td><center>$nombre</center></td>
                        <td><center>$sex</center></td>
                        <td><center>$fecha_nacimiento</center></td>
                        <td><center>$lugar_nacimiento</center></td>
                        <td><center>$states</center></td>
                        <td><center>$municipalitys</center></td>
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
            $cat="<tr><td colspan='8'>No hay datos registrados</td></tr>";
        }
        return response()->json(['catalogo'=>$cat]);

    }

    public function mostrar(Request $request)
    {
        //
        $id=$request->id;

        $cons= DB::table('estudiante')
                 ->select('estudiante.*','persona.cedula','persona.nombre','persona.apellido','persona.sex','persona.telefono','persona.municipality','persona.direccion','municipality.state')
                 ->join('persona', 'estudiante.persona', '=', 'persona.id')
                 ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                 ->where('estudiante.id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $cedula=$cons2->cedula;
            $nombre=$cons2->nombre;
            $apellido=$cons2->apellido;
            $sex=$cons2->sex;
            $telefono=$cons2->telefono;
            $state=$cons2->state;
            $municipality=$cons2->municipality;
            $direccion=$cons2->direccion;
            $fecha_nacimiento=$cons2->fecha_nacimiento;
            $lugar_nacimiento=$cons2->lugar_nacimiento;
            $descripcion=$cons2->descripcion;
            $persona=$cons2->persona;

        }



        $cons= DB::table('estudiante_representante')
                 ->join('representante', 'estudiante_representante.representante', '=', 'representante.id')
                 ->join('persona', 'representante.persona', '=', 'persona.id')
                 ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                 ->where('estudiante_representante.status', 1)
                 ->where('estudiante', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $representante=$cons2->representante;
            $parentesco=$cons2->parentesco;
            $cedula_r=$cons2->cedula;
            $nombre_r=$cons2->nombre;
            $apellido_r=$cons2->apellido;
            $sex_r=$cons2->sex;
            $telefono_r=$cons2->telefono;
            $direccion_r=$cons2->direccion;
            $state_r=$cons2->state;
            $municipality_r=$cons2->municipality;
            $ocupacion_laboral=$cons2->ocupacion_laboral;

        }

        $list_a="";
        $list_d="";

        $cons= DB::table('estudiante_alergia')
                 ->select('estudiante_alergia.alergia','alergia.alergias','alergia.descripcion','tipo_alergia.tipo')
                 ->join('alergia', 'estudiante_alergia.alergia', '=', 'alergia.id')
                 ->join('tipo_alergia', 'alergia.tipo', '=', 'tipo_alergia.id')
                 ->where('estudiante', $id);

        $cons1 = $cons->get();
        $num = $cons->count();

        if ($num>0) {
            # code...
            DB::table('alergias')->delete();
            foreach ($cons1 as $cons2) {
                $alergia=$cons2->alergia;
                $tipo=$cons2->tipo;
                $alergias=$cons2->alergias;
                $descripcion=$cons2->descripcion;
                DB::table('alergias')->insert(['alergia' => $alergia]);
                $consu= DB::table('alergias')->where('alergia', $alergia)->get();
                foreach ($consu as $consu2) {
                    $ida=$consu2->id;
                }
                $list_a.="
                <div id='aler$ida' class='alert alert-primary alert-dismissible fade show' role='alert'>
                    <p> <strong>Tipo:</strong> $tipo.</p>
                    <p><strong>Alergia:</strong> $alergias.</p>
                    <p><strong>Descripcion:</strong> $descripcion.</p>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick ='return quitar_a($ida);'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }
        }

        $cons= DB::table('estudiante_discapacidad')
                 ->select('estudiante_discapacidad.discapacidad','discapacidad.discapacidades','discapacidad.descripcion','tipo_discapacidad.tipo')
                 ->join('discapacidad', 'estudiante_discapacidad.discapacidad', '=', 'discapacidad.id')
                 ->join('tipo_discapacidad', 'discapacidad.tipo', '=', 'tipo_discapacidad.id')
                 ->where('estudiante', $id);

        $cons1 = $cons->get();
        $num = $cons->count();

        if ($num>0) {
            # code...
            DB::table('discapacidades')->delete();
            foreach ($cons1 as $cons2) {
                $discapacidad=$cons2->discapacidad;
                $tipo=$cons2->tipo;
                $discapacidades=$cons2->discapacidades;
                $descripcion=$cons2->descripcion;
                DB::table('discapacidades')->insert(['discapacidad' => $discapacidad]);
                $consu= DB::table('discapacidades')->where('discapacidad', $discapacidad)->get();
                foreach ($consu as $consu2) {
                    $idd=$consu2->id;
                }
                $list_d.="
                <div id='dis$idd' class='alert alert-primary alert-dismissible fade show' role='alert'>
                    <p> <strong>Tipo:</strong> $tipo.</p>
                    <p><strong>Discapacidad:</strong> $discapacidades.</p>
                    <p><strong>Descripcion:</strong> $descripcion.</p>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick ='return quitar_d($idd);'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }
        }

        return response()->json([
            'cedula'=>$cedula,
            'nombre'=>$nombre,
            'apellido'=>$apellido,
            'sex'=>$sex,
            'telefono'=>$telefono,
            'direccion'=>$direccion,
            'fecha_nacimiento'=>$fecha_nacimiento,
            'lugar_nacimiento'=>$lugar_nacimiento,
            'descripcion'=>$descripcion,
            'state'=>$state,
            'municipality'=>$municipality,
            'representante'=>$representante,
            'parentesco'=>$parentesco,
            'cedula_r'=>$cedula_r,
            'nombre_r'=>$nombre_r,
            'apellido_r'=>$apellido_r,
            'sex_r'=>$sex_r,
            'telefono_r'=>$telefono_r,
            'direccion_r'=>$direccion_r,
            'state_r'=>$state_r,
            'municipality_r'=>$municipality_r,
            'ocupacion_laboral'=>$ocupacion_laboral,
            'list_a'=>$list_a,
            'list_d'=>$list_d,
            'persona'=>$persona
        ]);


    }

    public function clear_a()
    {
        //
        DB::table('alergias')->delete();

    }

    public function clear_d()
    {
        //
        DB::table('discapacidades')->delete();

    }

    public function quitar_a(Request $request)
    {
        //
        $id=$request->id;
        DB::table('alergias')->where('id', $id)->delete();

    }
    public function quitar_d(Request $request)
    {
        //
        $id=$request->id;
        DB::table('discapacidades')->where('id', $id)->delete();

    }

    public function alergias(Request $request)
    {
        //

        DB::table('alergias')->insert(['alergia' => $request->alergia]);

        $cons = DB::table('alergias')
                ->select('alergias.id as ida','alergias.alergia','alergia.alergias','alergia.descripcion','tipo_alergia.tipo')
                ->join('alergia', 'alergias.alergia', '=', 'alergia.id')
                ->join('tipo_alergia', 'alergia.tipo', '=', 'tipo_alergia.id')
                ->orderBy('ida','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        $i=0;
        $alergia="";
        $ocultar="";
        $id="";
        if ($num>0) {
            # code...
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->ida;
                $alergias=$cons2->alergias;
                $descripcion=$cons2->descripcion;
                $tipo=$cons2->tipo;
                if ($i==$num) {
                    # code...
                    $ocultar="style='display: none'";
                }
                $alergia.="
                <div id='aler$id' $ocultar class='alert alert-primary alert-dismissible fade show' role='alert'>
                    <p> <strong>Tipo:</strong> $tipo.</p>
                    <p><strong>Alergia:</strong> $alergias.</p>
                    <p><strong>Descripcion:</strong> $descripcion.</p>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick ='return quitar_a($id);'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }

        }

        return response()->json([
            'alergias'=>$alergia,
            'num'=>$num,
            'id'=>$id
        ]);


    }

    public function discapacidades(Request $request)
    {
        //

        DB::table('discapacidades')->insert(['discapacidad' => $request->discapacidad]);

        $cons = DB::table('discapacidades')
                ->select('discapacidades.id as ida','discapacidades.discapacidad','discapacidad.discapacidades','discapacidad.descripcion','tipo_discapacidad.tipo')
                ->join('discapacidad', 'discapacidades.discapacidad', '=', 'discapacidad.id')
                ->join('tipo_discapacidad', 'discapacidad.tipo', '=', 'tipo_discapacidad.id')
                ->orderBy('ida','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        $i=0;
        $discapacidad="";
        $ocultar="";
        $id="";
        if ($num>0) {
            # code...
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->ida;
                $discapacidades=$cons2->discapacidades;
                $descripcion=$cons2->descripcion;
                $tipo=$cons2->tipo;
                if ($i==$num) {
                    # code...
                    $ocultar="style='display: none'";
                }
                $discapacidad.="
                <div id='dis$id' $ocultar class='alert alert-primary alert-dismissible fade show' role='alert'>
                    <p> <strong>Tipo:</strong> $tipo.</p>
                    <p><strong>Discapacidad:</strong> $discapacidades.</p>
                    <p><strong>Descripcion:</strong> $descripcion.</p>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick ='return quitar_d($id);'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";

            }
        }


        return response()->json([
            'discapacidades'=>$discapacidad,
            'num'=>$num,
            'id'=>$id
        ]);


    }

    public function combobox(Request $request)
    {
        //
        $tabla=$request['tabla'];
        $atributo=$request['atributo'];
        $tipo=$request['tipo'];

        $cons = DB::table($atributo)->orderBy('id','asc');
        $cons1 = $cons->get();
        $num = $cons->count();

        $consu = DB::table($tabla)->where('tipo', $tipo)->orderBy('id','asc');
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->$tabla;
                $consu=$consu->where('id','!=', $id);
            }
        }
        $cons = $consu->get();
        $num = $consu->count();
        $select="<option disabled selected value='null'>Seleccione una $tabla</option>";
        if ($num>0) {
            # code...
            foreach ($cons as $cons2) {
                # code...
                $id=$cons2->id;
                $atri=$cons2->$atributo;
                $select.="<option value='$id'>$atri</option>";
            }
        }

        return response()->json([
            'select'=>$select
        ]);
    }

    public function representante(Request $request)
    {
        //
        $cedula=$request->cedula;
        $id="";
        $nombre="";
        $apellido="";
        $sex="";
        $telefono="";
        $ocupacion_laboral="";
        $state="";
        $municipality="";
        $direccion="";
        $persona="";
        $num_p="0";
        $num_r="0";
        $cons= DB::table('persona')
                ->select('persona.*', 'municipality.state')
                ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                ->where('cedula', $cedula);
        $cons1 = $cons->get();
        $num_p = $cons->count();

        if ($num_p>0) {

            foreach ($cons1 as $cons2) {
                # code...
                $persona=$cons2->id;
                $nombre=$cons2->nombre;
                $apellido=$cons2->apellido;
                $sex=$cons2->sex;
                $telefono=$cons2->telefono;
                $state=$cons2->state;
                $municipality=$cons2->municipality;
                $direccion=$cons2->direccion;
            }

            $cons= DB::table('representante')->where('persona', $persona);

            $cons1 = $cons->get();
            $num_r = $cons->count();

            if ($num_r>0) {
                # code...
                foreach ($cons1 as $cons2) {
                    # code...
                    $id=$cons2->id;
                    $ocupacion_laboral=$cons2->ocupacion_laboral;
                }
            }
        }




        return response()->json([
            'id'=>$id,
            'nombre'=>$nombre,
            'apellido'=>$apellido,
            'sex'=>$sex,
            'telefono'=>$telefono,
            'ocupacion_laboral'=>$ocupacion_laboral,
            'state'=>$state,
            'municipality'=>$municipality,
            'direccion'=>$direccion,
            'num_p'=>$num_p,
            'num_r'=>$num_r
        ]);


    }

}
