<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mantenimiento;
use Auth;


class WorkflowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function solicitud(Request $request)
    {
    	$step = 1;
        if(isset($request['step']) && !is_null($step)) $step = $request['step'];
        
        $registro = Mantenimiento::where('uuid',$request->uuid)->first();
        if (is_null($registro)) {
            $registro = new Mantenimiento;
        };

        $status_id = 1;

        return view('workflow.solicitud.forma',compact('step','registro','status_id'));
    }

    public function store(Request $request){
        $input = $request->all();        
        $input['user_id'] = Auth::id();

        $step = 0;
        if(isset($request['step']) && !is_null($step)) $step = $input['step'];
        // $solicitud = Auth::user()->solicitud;

        // switch ( __("workflow.$step") ) {
        //      case __("workflow.1") : 
                
        //         if (is_null($solicitud)){
        //             $solicitud = new Solicitud($input); 
        //             $solicitud->step = 2;
        //             $solicitud->save();
        //         } else {
        //             if ($solicitud->step <= $step) $input['step'] = 2;
        //             $solicitud->update($input);
        //             $step = $solicitud->step;
        //         }
        //         $step = 2;
        //         break;
        //      case __("workflow.2") : 
        //         $academico = Auth::user()->academico;
        //         if (is_null($academico)){
        //             $academico = new Academico($input); 
        //             $academico->save();
        //         } else {                    
        //             $academico->update($input);
        //         }
        //         if (!is_null($solicitud) && $solicitud->step <= $step) {
        //             $solicitud->step = 3;
        //             $solicitud->save();
        //         }
        //         $step = 3;
        //         break;
        //      case __("workflow.3") : 
                
        //         break;
        //      case __("workflow.4") : 
        //         $encuesta = Auth::user()->encuesta;
        //         if (is_null($encuesta)){
        //             $encuesta = new Encuesta($input); 
        //             $encuesta->save();
        //         } else {                    
        //             $encuesta->update($input);
        //         }
        //         if (!is_null($solicitud) && $solicitud->step <= $step) {
        //             $solicitud->step = 5;
        //             $solicitud->save();
        //         }
        //         $step = 5;
        //         break;                                  
        //      case __("workflow.5") : 
        //          if (!is_null($solicitud) && $solicitud->step == $step) {
        //             $solicitud->step = 6;
        //             $solicitud->save();
        //         }
        //          break;
        //      default:
        //          return back()->withErros('ocurrio un error, favor de volver a intentarlo');
        //  }


         return redirect()->route('solicitud', ['step'=>$step]);
    }

    public function close(Request $request) {

    }

}
