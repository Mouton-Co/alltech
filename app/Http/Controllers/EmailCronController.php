<?php

namespace App\Http\Controllers;

use App\Models\EmailCron;
use Illuminate\Http\Request;
use PharIo\Manifest\Email;

class EmailCronController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $emailCrons = EmailCron::query();

        if ($request->has('search')) {
            $emailCrons->where('to', 'like', "%{$request->search}%")
                ->orWhere('subject', 'like', "%{$request->search}%")
                ->orWhere('hour', 'like', "%{$request->search}%")
                ->orWhere('day', 'like', "%{$request->search}%");
        }

        return view('models.email-cron.index', [
            'emailCrons' => $emailCrons->paginate(10),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        EmailCron::create($request->all());

        return redirect()->back()->with('success', 'Email task created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailCron $emailCron)
    {
        EmailCron::where('id', $emailCron->id)->update($request->except([
            '_token',
            '_method',
        ]));

        return redirect()->back()->with('success', 'Email task updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailCron $emailCron)
    {
        $emailCron->delete();

        return redirect()->back()->with('success', 'Email task deleted');
    }
}
