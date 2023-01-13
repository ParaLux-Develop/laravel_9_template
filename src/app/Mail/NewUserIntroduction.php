<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserIntroduction extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $toUser;
    public User $newUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $toUser, User $newUser)
    {
        $this->toUser  = $toUser;
        $this->newUser = $newUser;
    }

    public function build()
    {
        return $this
        ->subject('新しいユーザーが追加されました！')
        ->view('email.new_user_introduction');
    }
}
