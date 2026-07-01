<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;

class PublishAllCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:publish-all {--instructor= : Only publish courses for this instructor ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all Draft courses (optionally filtered by instructor ID)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = Course::where('status', 'Draft');

        if ($instructorId = $this->option('instructor')) {
            $query->where('instructor_id', $instructorId);
        }

        $count = $query->update(['status' => 'Published']);

        $this->info("✓ Published {$count} course(s) successfully.");

        return Command::SUCCESS;
    }
}
