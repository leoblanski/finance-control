<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\BaseMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class DispatchEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->onQueue('emails');
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $to = $this->data['to'];
        $body = $this->data['body'];
        $subject = $this->data['subject'];
        $attachments = $this->data['attachments'] ?? [];
        $from = $this->data['from'] ?? config('mail.from.address');
        Log::error('Dispatching email to: ' . $to);

        try {
            $mailer = Mail::to($to);

            if (isset($this->data['cc'])) {
                $mailer->cc($this->data['cc']);
            }

            if (isset($this->data['bcc'])) {
                $mailer->bcc($this->data['bcc']);
            }

            $mailable = (new BaseMail())
                ->setFrom($from)
                ->setSubject($subject)
                ->setBody($body);

            if (!empty($attachments)) {
                $mailable->setAttachments($this->buildAttachments($attachments));
            }

            $this->beforeSend($mailable);

            $mailer->send($mailable->build());
        } catch (\Exception $e) {
            dd($e);
            Notification::make()
                ->title('Error')
                ->danger()
                ->body('There was an error sending the email. Please try again.')
                ->send();

            $this->fail($e);

            Log::error('Error sending email: ' . $e->getMessage());

            throw $e;
        }
    }

    private function beforeSend($mailable)
    {
        $operation = $this->data['operation'] ?? null;
        $previewPdf = isset($this->data['previewPdf']) ? base64_decode($this->data['previewPdf']) : null;

        switch ($operation) {
            case 'trip_email_action':
                if (!$previewPdf) {
                    break;
                }
                $mailable->attachData($previewPdf, 'proposal.pdf', ['mime' => 'application/pdf']);
                break;
            default:
                break;
        }
    }

    private function buildAttachments(array $attachments): array
    {
        $attachmentsFormated = [];

        foreach ($attachments as $attachment) {
            $attachmentsFormated[] = Attachment::fromPath($attachment);
        }

        return $attachmentsFormated;
    }
}
