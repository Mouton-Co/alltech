<?php

namespace App\Http\Controllers;

use App\Models\CompanyType;
use App\Models\Meeting;
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
        $companyTypes = CompanyType::all();
        $date         = $request->get('date') ?? now()->format('Y-m-d');
        $meetings     = Meeting::where('date', $date)->where(
            'user_id', auth()->user()->id
        )->orderBy('start_time')->get();

        return view('models.meeting.index')->with([
            'meetings'     => $meetings,
            'date'         => $date,
            'companyTypes' => $companyTypes,
        ]);
    }
}
