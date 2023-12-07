<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meeting\StoreRequest;
use App\Models\CompanyType;
use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RESOURCES
    |--------------------------------------------------------------------------
    */

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = [];
 
        $meetings = Meeting::where('user_id', auth()->id())->get();
 
        foreach ($meetings as $meeting) {
            $events[] = [
                'title' => $meeting->contact->name,
                'start' => $meeting->date . ' ' . $meeting->start_time,
                'end'   => $meeting->date . ' ' . $meeting->end_time,
            ];
        }
 
        return view('models.meeting.index', compact('events'));
    }

    public function store(StoreRequest $request)
    {
        $meeting                         = new Meeting();
        $meeting->date                   = $request->get('date');
        $meeting->start_time             = $request->get('start_time');
        $meeting->end_time               = $request->get('end_time');
        $meeting->objective              = $request->get('objective');
        $meeting->marketing_requirements = $request->get('marketing_requirements');
        $meeting->contact_id             = $request->get('contact_id');
        $meeting->company_id             = $request->get('company_id');
        $meeting->company_type_id        = $request->get('company_type_id');
        $meeting->user_id                = $request->get('user_id');
        $meeting->save();

        return redirect()->route('meeting.index')->with([
            'status' => 'Meeting created successfully',
        ]);
    }
}
