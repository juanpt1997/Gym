<?php

namespace App\Console\Commands;

use App\Models\ScheduledClass;
use Illuminate\Console\Command;

class IncrementDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:increment-date {--days=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increment all the scheduled classes date.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get scheduled classes
        $scheduledClasses = ScheduledClass::latest('date_time')->get(); // all() scheduledClasses can not be retrieved in a random order since we have the restriction that classes can not have same date and time, which could cause a conflict
        $scheduledClasses->each(function ($class){
            $class->date_time = $class->date_time->addDays(intval($this->option('days')));
            $class->save();
        });
    }
}
