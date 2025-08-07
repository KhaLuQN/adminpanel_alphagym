<?php

// app/Http/Controllers/Api/Auth/MemberMagicLinkController.php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\MagicLink;
use App\Models\Member;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MemberMagicLinkController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (! $member) {
            return response()->json(['message' => 'Email không tồn tại trong hệ thống.'], 404);
        }

        // Tìm magic link còn hiệu lực
        $magicLink = MagicLink::where('member_id', $member->member_id)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        // Nếu chưa có thì tạo mới
        if (! $magicLink) {
            $magicLink = MagicLink::create([
                'member_id'  => $member->member_id,
                'token'      => Str::uuid(),
                'expires_at' => now()->addMinutes(15),
            ]);
        }

        $url = config('app.frontend_url') . '/thong-tin-hoi-vien?token=' . $magicLink->token;

        Mail::to($member->email)->send(new \App\Mail\MemberMagicLinkMail($member, $url));

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi liên kết đăng nhập tới email.',
        ]);
    }

    public function verify(Request $request)
    {
        $token = $request->input('token');

        if (! $token) {
            return response()->json(['message' => 'Token không được để trống'], 422);
        }

        $magicLink = MagicLink::where('token', $token)

            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (! $magicLink) {
            return response()->json(['message' => 'Token không hợp lệ hoặc đã hết hạn'], 401);
        }

        $member = $magicLink->member;

        if (! $member) {
            return response()->json(['message' => 'Không tìm thấy hội viên'], 404);
        }
        $memberService = new MemberService();
        $profileData   = $memberService->getMemberProfileData($member);

        return response()->json([
            'member'  => $profileData,
            'message' => 'Đăng nhập thành công',
        ]);

    }
}
