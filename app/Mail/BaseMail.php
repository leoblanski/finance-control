<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $body;

    /**
     * Set the subject of the email.
     *
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject($subject);

        return $this;
    }

    /**
     * Set the body of the email.
     *
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Set the attachments of the email.
     *
     * @param array|null $attachments
     * @return $this
     */
    public function setAttachments($attachments)
    {
        $this->attachMany($attachments);

        return $this;
    }

    /**
     * Set the "from" address of the email.
     *
     * @param mixed $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from($from);

        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mail')
            ->with(['body' => $this->body, 'subject' => $this->subject]);
    }
}
