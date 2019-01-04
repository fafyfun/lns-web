<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Installation;
use SnappyPDF;

class JobCard extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        $installation = Installation::with(
//            'insatllaionlead',
//            'job.quotation.inquiry.saleslead.customer',
//            'job.quotation.rooms',
//            'job.quotation.rooms.walls',
//            'job.quotation.rooms.walls.product')
//            ->where('id',$this->installationId)
//            ->first();
//
//        $pdf = SnappyPDF::loadView('pdf.jobcard',array('installation' => $installation));

        return $this->view('emails.sample')
            ->subject('Job Card')
            ->attachData($this->pdf->output(), 'quotation.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
