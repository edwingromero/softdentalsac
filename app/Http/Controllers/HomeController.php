<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Distrito;
use App\Models\Paciente;
use App\Models\Provincia;
use App\Models\Informacion;
use App\Models\Departamento;
use App\Models\TipoPaciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function index()
    {
        
        return Inertia::render('Index');
    }

    public function registrar()
    {
        $departamento = Departamento::select('departamento_id as value','departamento_nombre as text')->get();
        $informacion = Informacion::all();
        $tipo = TipoPaciente::where('est_tipac',1)->get();
        return Inertia::render('Registrar',compact('departamento','informacion','tipo'));
    }

    public function getProvincias(Request $request)
    {
        $provincias = Provincia::select('provincia_id as value','provincia_nombre as text')
        ->where('departamento_id',$request->departamento)
        ->get();
        return response($provincias);
    }

    public function getDistritos(Request $request)
    {
        $distritos = Distrito::select('distrito_id as value','distrito_nombre as text')
        ->where('provincia_id',$request->provincia)
        ->get();
        return response($distritos);
    }

    public function verificarDNI(Request $request)
    {
        $res = Paciente::where('dni_pac',$request->numero_documento)->first();
        if(!is_null($res)){
            return response(['success' => false, 'type' => 1, 'data' => $res]);
        }
        $data = file_get_contents("https://api.persona.bfacturas.com/persona/".$request->numero_documento);

        if($this->isJson($data)){
            return response(['success' => true, 'data' => json_decode($data)]);
        }else{
            return response(['success' => false, 'type' => 2]);
        }
        
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function guardar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_documento' => ['required'],
            'numero_documento' => ['required'],
            'apellidos' => ['required'],
            'nombres' => ['required'],
            'departamento' => ['required'],
            'provincia' => ['required'],
            'distrito' => ['required'],
            'direccion' => ['required'],
            'telefono' => ['required'],
            'fec_nac' => ['required'],
            'edad' => ['required'],
            'estado_civil' => ['required'],

        ])->validate();

        $paciente = new Paciente;
        $paciente->tipo_paciente = $request->tipo_documento;
        $paciente->dni_pac = $request->numero_documento;
        $paciente->nomb_pac = $request->nombres;
        $paciente->apel_pac = $request->apellidos;
        $paciente->departamento_id = $request->departamento;
        $paciente->provincia_id = $request->provincia;
        $paciente->distrito_id = $request->distrito;
        $paciente->dire_pac = $request->direccion;
        $paciente->telf_pac = $request->telefono;
        $paciente->fena_pac = $request->fec_nac;
        $paciente->edad_pac = $request->edad;
        $paciente->civi_pac = $request->estado_civil;
        $paciente->cod_infor = $request->informacion;
        $paciente->cod_tipac = $request->tipo;
        $paciente->sexo_pac = $request->sexo;

        $paciente->cod_infor = 5;
        $paciente->cod_tipac = 2;

        $paciente->save();
        
        return redirect()->back();

    }

}
