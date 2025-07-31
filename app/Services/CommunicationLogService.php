<?php

namespace App\Services;

use App\Models\CommunicationLog;

class CommunicationLogService
{
    public function getCommunicationLogsForIndex(array $filters)
    {
        $query = CommunicationLog::query()->with(['member', 'sender']);

        // Add any filtering logic here if needed in the future

        return $query->latest('sent_at')->paginate(15)->withQueryString();
    }
}
