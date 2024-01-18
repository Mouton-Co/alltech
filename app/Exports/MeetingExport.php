<?php

namespace App\Exports;

use App\Models\Meeting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MeetingExport implements FromView
{
    protected Meeting $meetings;

    public function __construct(Meeting $meetings)
    {
        $this->meetings = $meetings;
    }

    public function view(): View
    {
        return view('models.meeting.export', [
            'meetings' => $this->meetings,
        ]);
    }
}
