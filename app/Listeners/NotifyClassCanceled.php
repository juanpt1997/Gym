<?php

namespace App\Listeners;

use App\Events\ClassCanceled;
use App\Jobs\NotifyClassCanceledJob;
use App\Mail\ClassCanceledMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ClassCanceledNotification;
use Illuminate\Support\Facades\Notification;

class NotifyClassCanceled
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassCanceled $event): void
    {
        // $scheduledClass = $event->scheduledClass;
        // Log::info($scheduledClass);

        $members = $event->scheduledClass->members()->get();

        $className = $event->scheduledClass->classType->name;
        $classDateTime = $event->scheduledClass->date_time;

        $details = compact('className', 'classDateTime');

        /* ===================================================
           MAIL
        ===================================================*/
        // $members->each(function($user) use ($details) {
        //     //send a mail
        //     Mail::to($user)->send(new ClassCanceledMail($details, $user));
        // });

        /* ===================================================
           NOTIFICATION
        ===================================================*/
        // Notification::send($members, new ClassCanceledNotification($details));

        /* ===================================================
           JOBS
        ===================================================*/
        NotifyClassCanceledJob::dispatch($members, $details);
    }
}
