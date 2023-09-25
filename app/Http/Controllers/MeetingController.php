<?php

namespace App\Http\Controllers;

use App\Models\Contact;

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
    public function index()
    {
        return view('models.meeting.index');
    }
}
