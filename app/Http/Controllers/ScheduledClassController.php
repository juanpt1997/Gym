<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Events\ClassCanceled;
use App\Models\ScheduledClass;

class ScheduledClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduledClasses = auth()->user()->scheduledClasses()->upcoming()->oldest('date_time')->get(); /* Replaced by the scope query */
        return view('instructor.upcoming', compact('scheduledClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classTypes = ClassType::all();
        return view('instructor.schedule', compact('classTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $date_time = $request->input('date') . " " . $request->input('time');

        $request->merge([
            'date_time' => $date_time,
            'instructor_id' => auth()->id()
        ]);

        $validated = $request->validate([
            'class_type_id' => 'required',
            'instructor_id' => 'required',
            'date_time' => 'required|unique:scheduled_classes,date_time|after:now'
        ]);

        ScheduledClass::create($validated);

        return redirect()->route('schedule.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScheduledClass $schedule)
    {
        // if (auth()->user()->id !== $schedule->instructor_id) abort(403);

        if (auth()->user()->cannot('delete', $schedule)) {
            abort(403);
        }

        ClassCanceled::dispatch($schedule);

        $schedule->delete();
        $schedule->members()->detach();

        return redirect()->route('schedule.index');
    }
}
