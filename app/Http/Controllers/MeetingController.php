<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meeting\StoreRequest;
use App\Http\Requests\Meeting\UpdateRequest;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
use Faker\Core\Color;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $eventSources = [];
        $users = User::all();

        $usersQuery = [auth()->id()];
        if ($request->has('users')) {
            $usersQuery = array_merge($usersQuery, $request->get('users'));
        }
        $usersQuery = array_unique($usersQuery);
        foreach ($usersQuery as $user) {
            $events = [];
            $meetings = Meeting::where('user_id', $user)->get();
            foreach ($meetings as $meeting) {
                $events[] = [
                    'id' => $meeting->id,
                    'title' => $meeting->contact->name,
                    'start' => $meeting->date.' '.$meeting->start_time,
                    'end' => $meeting->date.' '.$meeting->end_time,
                    'model' => $meeting,
                ];
            }
            $eventSources[] = [
                'events' => $events,
                'color' => (new Color())->colorName(),
                'user' => $user,
            ];
        }

        $contacts = Contact::where('name', '<>', '')->where('email', '<>', '')->orderBy('name')->get();

        $request->merge([
            'users' => $usersQuery,
        ]);

        return view('models.meeting.index', compact('eventSources', 'contacts', 'users', 'usersQuery'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $contact = Contact::find($request->input('contact_id'));

        $meeting = new Meeting();
        $meeting->date = $request->input('date');
        $meeting->start_time = $request->input('start_time');
        $meeting->end_time = $request->input('end_time');
        $meeting->objective = $request->input('objective');
        $meeting->marketing_requirements = $request->input('marketing_requirements');
        $meeting->contact_id = $request->input('contact_id');
        $meeting->company_id = strval($contact->company_id);
        $meeting->company_type_id = strval($contact->company->company_type_id);
        $meeting->user_id = auth()->id();
        $meeting->save();

        if ($meeting) {
            return redirect()->route('meeting.index')->with([
                'status' => 'Meeting created successfully',
            ]);
        }

        return redirect()->route('meeting.index')->with([
            'error' => 'Meeting creation failed',
        ]);
    }

    public function update(UpdateRequest $request): RedirectResponse
    {
        $contact = Contact::find($request->input('contact_id'));

        $meeting = Meeting::find($request->input('meeting_id'));
        $meeting->date = $request->input('date');
        $meeting->start_time = $request->input('start_time');
        $meeting->end_time = $request->input('end_time');
        $meeting->objective = $request->input('objective');
        $meeting->marketing_requirements = $request->input('marketing_requirements');
        $meeting->contact_id = $request->input('contact_id');
        $meeting->company_id = strval($contact->company_id);
        $meeting->company_type_id = strval($contact->company->company_type_id);
        $meeting->user_id = auth()->id();
        $meeting->save();

        if ($meeting) {
            return redirect()->route('meeting.index')->with([
                'status' => 'Meeting updated successfully',
            ]);
        }

        return redirect()->route('meeting.index')->with([
            'error' => 'Meeting update failed',
        ]);
    }
}
