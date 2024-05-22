<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meeting\StoreRequest;
use App\Http\Requests\Meeting\UpdateRequest;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
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
        // grabbing user query
        $users = User::all();
        $usersQuery = [auth()->id()];
        if ($request->has('users')) {
            $usersQuery = array_merge($usersQuery, $request->get('users'));
        }
        $usersQuery = array_unique($usersQuery);

        // grabbing all meetings for the selected users
        $eventSources = [];
        $counter = 0;
        foreach ($usersQuery as $user) {
            $events = [];
            $meetings = Meeting::where('user_id', $user)->get();
            foreach ($meetings as $meeting) {
                $events[] = [
                    'id' => $meeting->id,
                    'title' => $meeting->title,
                    'start' => $meeting->date.' '.$meeting->start_time,
                    'end' => $meeting->date.' '.$meeting->end_time,
                    'className' => ! empty($meeting->cancelled_at) ? 'cancelled-meeting' : '',
                ];
            }
            $eventSources[] = [
                'events'      => $events,
                'color'       => config('pill-colors')[$counter]['background'],
                'textColor'   => config('pill-colors')[$counter]['text'],
                'user'        => $user,
                'borderColor' => config('pill-colors')[$counter]['text'],
            ];
            $counter++;
        }

        // grabbing contacts
        $contacts = Contact::where('name', '<>', '')->orWhere('email', '<>', '')->get();

        // merging request with users
        $request->merge([
            'users' => $usersQuery,
        ]);
        
        return view('models.meeting.index', compact('eventSources', 'contacts', 'users', 'usersQuery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id): View
    {
        if (empty($meeting = Meeting::find($id))) {
            return redirect()->back()->with([
                'error' => 'Meeting not found',
            ]);
        }

        $contacts = Contact::where('name', '<>', '')->orWhere('email', '<>', '')->get();

        return view('models.meeting.edit', [
            'meeting' => $meeting,
            'contacts' => $contacts,
            'grid' => $request->input('grid') ?? '',
            'start_date' => $request->input('start_date') ?? '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $contact = Contact::find($request->input('contact_id'));

        $meeting = Meeting::create(array_merge($request->all(), [
            'company_id' => $contact->company_id,
            'company_type_id' => $contact->company->company_type_id,
            'user_id' => auth()->id(),
        ]));

        if ($meeting) {
            return redirect()->route('meeting.index', [
                'grid' => $request->input('grid'),
                'start_date' => $request->input('start_date') ?? '',
            ])->with([
                'status' => 'Meeting created successfully',
            ]);
        }

        return redirect()->back()->with([
            'error' => 'Meeting creation failed',
        ]);
    }

    public function update(UpdateRequest $request): RedirectResponse
    {
        $contact = Contact::find($request->input('contact_id'));

        $meeting = Meeting::find($request->input('meeting_id'));

        if (! $meeting) {
            return redirect()->back()->with([
                'error' => 'Meeting not found',
            ]);
        }

        $meeting->update(array_merge($request->all(), [
            'company_id' => $contact->company_id,
            'company_type_id' => $contact->company->company_type_id,
            'user_id' => auth()->id(),
        ]));

        if ($meeting) {
            return redirect()->back()->with([
                'success' => 'Meeting updated',
            ]);
        }

        return redirect()->back()->with([
            'error' => 'Meeting update failed',
        ]);
    }

    public function cancel(Request $request): RedirectResponse
    {
        $meeting = Meeting::find($request->input('meeting_id'));

        if (! $meeting) {
            return redirect()->back()->with([
                'error' => 'Meeting not found',
            ]);
        }

        $meeting->update([
            'cancelled_at' => now(),
            'cancelled_reason' => $request->input('cancelled_reason'),
        ]);

        return redirect()->back()->with([
            'success' => 'Meeting cancelled',
        ]);
    }
}
