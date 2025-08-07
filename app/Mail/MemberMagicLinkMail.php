<?php
namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberMagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $magicLinkUrl;
    public $expireMinutes;

    /**
     * Create a new message instance.
     */
    public function __construct(Member $member, string $magicLinkUrl, int $expireMinutes = 15)
    {
        $this->member        = $member;
        $this->magicLinkUrl  = $magicLinkUrl;
        $this->expireMinutes = $expireMinutes;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Liên kết đăng nhập hệ thống GymTech')
            ->view('emails.member_magic_link')
            ->with([
                'member'        => $this->member,
                'magicLink'     => $this->magicLinkUrl,
                'expireMinutes' => $this->expireMinutes,
            ]);
    }
}
