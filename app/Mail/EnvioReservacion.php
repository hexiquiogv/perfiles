<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Mail\Mailables\Attachment;
use Carbon\Carbon;

use Illuminate\Support\Facades\Request;
use App\Models\Reservacion;
use Log;

class EnvioReservacion extends Mailable 
// implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected Reservacion $reservacion;

    public function __construct(Reservacion $reservacion)
    {
        $this->reservacion = $reservacion;
    }

    public function build()
    {
        setlocale(LC_ALL, 'es_MX');
        
        $date = Carbon::today();
        $fecha = $date->translatedFormat('l j \\d\\e F \\d\\e Y');  
        // $url = storage_path("app/public/".$this->reservacion->uuid.".pdf");    
        $url = config('app.url') . "/download/" . $this->reservacion->uuid;
        Log::debug($url);

        return $this->view('mails.envio_reservacion',compact('fecha','url'));

        // return $this->view('mails.envio_reservacion',compact('fecha'))
        //     ->attach($url, [
        //         'as' => 'newsletter',
        //         'mime' => 'application/pdf',
        //      ]);

    }

    // public function attachments(): array
    // {
    //     $url = storage_path("app/public/".$this->reservacion->uuid.".pdf");
    //     Log::debug($url);
    //     return [
    //         Attachment::fromPath($url)
    //             ->as('reservacion.pdf')
    //             ->withMime('application/pdf'),
    //     ];
    // }
}
