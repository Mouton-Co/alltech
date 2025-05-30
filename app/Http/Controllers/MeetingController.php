<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\CompanyType;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Meeting\StoreRequest;
use App\Http\Requests\Meeting\UpdateRequest;

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

        // grabbing company type query
        $companyTypes = CompanyType::all();
        $companyTypesQuery = [];
        if ($request->has('company_types')) {
            $companyTypesQuery = array_merge($companyTypesQuery, $request->get('company_types'));
        }
        $companyTypesQuery = array_unique($companyTypesQuery);

        // grabbing pill display query
        $format = $request->has('display') ? $request->get('display') : 'title';

        // grabbing all meetings for the selected users
        $eventSources = [];
        $counter = 0;
        foreach ($usersQuery as $user) {
            $events = [];
            $meetings = Meeting::where('user_id', $user)->whereIn('company_type_id', $companyTypesQuery)->get();
            foreach ($meetings as $meeting) {

                // if all day, set end date to start date
                if ($meeting->all_day ?? false) {
                    // create a new date object for the end date
                    $endDate = new \DateTime($meeting->end_date);
                    // add 1 day to the end date
                    $endDate->add(new \DateInterval('P1D'));
                    $end = $endDate->format('Y-m-d') . ' ' . $meeting->end_time;
                } else {
                    $end = $meeting->date . ' ' . $meeting->end_time;
                }

                $events[] = [
                    'id' => $meeting->id,
                    'title' => $meeting->getPillText($format),
                    'allDay' => $meeting->all_day ?? false,
                    'start' => $meeting->date . ' ' . $meeting->start_time,
                    'end' => $end,
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

        return view('models.meeting.index', compact('eventSources', 'contacts', 'users', 'usersQuery', 'companyTypes', 'companyTypesQuery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id): View|RedirectResponse
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

        if ($request->get('all_day')) {
            $request->merge([
                'start_time' => '00:00',
                'end_time' => '23:59',
            ]);
        }

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

        if ($request->get('all_day')) {
            $request->merge([
                'start_time' => '00:00',
                'end_time' => '23:59',
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
