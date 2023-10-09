<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Adrolli\FilamentJobManager\Models\FailedJob;
use Adrolli\FilamentJobManager\Models\Job;
use Adrolli\FilamentJobManager\Models\JobBatch;
use Adrolli\FilamentJobManager\Models\JobManager;
use App\Policies\FailedJobPolicy;
use App\Policies\JobBatchPolicy;
use App\Policies\JobManagerPolicy;
use App\Policies\JobPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Job::class => JobPolicy::class,
        JobManager::class => JobManagerPolicy::class,
        FailedJob::class => FailedJobPolicy::class,
        JobBatch::class => JobBatchPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
