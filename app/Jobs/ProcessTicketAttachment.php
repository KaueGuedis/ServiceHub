<?php

namespace App\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketProcessedNotification;
use Illuminate\Support\Facades\Storage;

class ProcessTicketAttachment implements ShouldQueue
{
    use Queueable;

    protected $ticket;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1. Processar o anexo (se existir)
        $attachmentPath = $this->ticket->attachment_path;
        $details = [];
        if ($attachmentPath && Storage::exists($attachmentPath)) {
            $content = Storage::get($attachmentPath);
            // Tenta decodificar como JSON, senão salva como texto
            $json = json_decode($content, true);
            $details = $json ?? ['text' => $content];
        }

        // 2. Atualizar ou criar TicketDetail
        TicketDetail::updateOrCreate(
            ['ticket_id' => $this->ticket->id],
            ['technical_details' => $details]
        );

        // 3. Notificar o responsável
        if ($this->ticket->user) {
            Notification::send($this->ticket->user, new TicketProcessedNotification($this->ticket));
        }
    }
}
