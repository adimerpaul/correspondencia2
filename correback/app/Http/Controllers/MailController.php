<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
//use Barryvdh\DomPDF\Facade as PDF;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Mail::where('unit_id',$request->user()->unit_id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Mail::select('remitente','cargo','institucion')->groupBy('remitente','cargo','institucion')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Mail::max("codinterno")==''){
            $codigointerno=1;
        }else{
            $codigointerno=Mail::max("codinterno")+1;
        }
//        return Mail::max("codinterno")+1;
        $user=User::where('id',$request->user()->id)->with('unit')->get();
//        return $user[0]->unit->codigo;
//        return $request;
        $mail=new Mail();
        $mail->codigo=$user[0]->unit->codigo.str_pad($codigointerno, 4, '0', STR_PAD_LEFT);
        $mail->tipo=$request->tipo;
//        $mail->tipo2=$request->tipo2;
        $mail->remitente=$request->remitente;
        $mail->cargo=$request->cargo;
        $mail->institucion=$request->institucion;
        $mail->ref=$request->ref;
        $mail->fecha=date('Y-m-d');
        $mail->fechacarta=$request->fecha;
//        $mail->estado=$request->estado;
        $mail->folio=$request->folio;
//        $mail->archivo=$request->archivo;
        $mail->codinterno=$codigointerno;
        $mail->codexterno=$request->codexterno;
        $mail->user_id=$request->user()->id;
        $mail->unit_id=$request->user()->unit_id;
//        $mail->mail_id=$request->mail_id;
        $mail->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function show(Mail $mail)
    {
//        return $mail;
        $pdf = App::make('dompdf.wrapper');
//        $customPaper = array(0,0,360,360);
        $pdf->setPaper('letter','landscape');

        $pdf->loadHTML('
                <style>
.tablex , th , .tdx  {
  border: 0.2px solid black;
  border-collapse: collapse;
}
*{
padding: 0px;
margin: 0px;
border: 0px;
font-size: 13px;
    font-family: Elegance, sans-serif;
}
</style>
<table style="width: 100%">
<tr>
    <td style="width: 50%"></td>
    <td>
        <table style="width: 100%;padding-top: 20px;border: 1px solid black">
        <tr><td align="center" style="font-weight: bold;font-size: 17px">GOBIERNO AUTÓNOMO MUNICIPAL DE ORURO</td></tr>
        </table>
        <table style="width: 100%;padding-top: 20px;border: 1px solid black">
        <tr>
            <td style="width: 33%" align="center;font">HOJA DE TRAMITE</td>
            <td style="width: 33%" align="right">Registro No.:</td>
            <td style="width: 33%" align="center">______________________</td>
        </tr>
        </table>
    </td>
</tr>
</table>
','UTF-8');
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(Mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mail $mail)
    {
        $mail->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mail $mail)
    {
        $mail->delete();
    }
}
