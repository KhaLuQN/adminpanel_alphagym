<?php

namespace App\Services;

use App\Mail\CustomCampaignMail;
use App\Models\CommunicationLog;
use App\Models\EmailTemplate;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MemberEngagementService
{
    public function getMembersForEngagementIndex(array $filters)
    {
        $query = Member::query();

        if (isset($filters['months'])) {
            $months = (int) $filters['months'];
            if ($months > 0) {
                $targetDate = Carbon::now()->subMonths($months);
                $query->whereMonth('join_date', $targetDate->month)
                    ->whereYear('join_date', $targetDate->year);
            }
        }

        if (isset($filters['campaign_name'])) {
            $campaignName = $filters['campaign_name'];
            $sentMemberIds = CommunicationLog::where('campaign_name', $campaignName)->pluck('member_id');
            $query->whereNotIn('member_id', $sentMemberIds);
        }

        $members   = $query->with('subscriptions')->paginate(20)->withQueryString();
        $templates = EmailTemplate::all();

        return [
            'members'   => $members,
            'templates' => $templates,
            'filters'   => $filters,
        ];
    }

    public function sendCampaignEmail(array $memberIds, string $campaignName, string $subject, string $body, int $senderId): int
    {
        $members   = Member::whereIn('member_id', $memberIds)->get();
        $sentCount = 0;

        foreach ($members as $member) {
            try {
                $personalizedBody = str_replace('[TEN_HOI_VIEN]', $member->full_name, $body);
                $personalizedBody = str_replace(
                    '[NGAY_THAM_GIA]',
                    Carbon::parse($member->join_date)->format('d/m/Y'),
                    $personalizedBody
                );

                Mail::to($member->email)->send(new CustomCampaignMail($subject, $personalizedBody));

                CommunicationLog::create([
                    'member_id'     => $member->member_id,
                    'user_id'       => $senderId,
                    'campaign_name' => $campaignName,
                    'subject'       => $subject,
                    'body'          => $personalizedBody,
                    'status'        => 'sent',
                    'sent_at'       => now(),
                ]);

                $sentCount++;
            } catch (\Exception $e) {
                Log::error("Gửi email chiến dịch '{$campaignName}' thất bại đến {$member->email}: " . $e->getMessage());
            }
        }

        return $sentCount;
    }
}
