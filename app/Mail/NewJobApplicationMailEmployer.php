<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\JobPosting;

class NewJobApplicationMailEmployer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $application,
        public JobPosting $job,
        public $portal_name = null
    ){
        $this->portal_name = $portal_name ?? config('app.name', 'Emprega Paulínia');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "{$this->portal_name} - Nova Candidatura de Emprego",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-job-application-employer',
            with: [
                'application' => $this->application,
                'job' => $this->job,
                'portal_name' => $this->portal_name,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (
            $this->job->apply_method === 'email' && 
            $this->application->resume_path
        ) {
            return [
                Attachment::fromPath(storage_path('app/public/' . $this->application->resume_path))
                    ->as('Resume_' . $this->application->user->name . '.' . pathinfo($this->application->resume_path, PATHINFO_EXTENSION))
            ];
        }
        
        return [];
    }
}
