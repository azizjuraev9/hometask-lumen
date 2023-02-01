<?php

namespace App\Providers;

use App\notification\repositories\INotificationRepository;
use App\notification\repositories\NotificationRepository;
use App\notification\services\INotificationService;
use App\notification\services\NotificationService;
use App\templates\repositories\ITemplateRepository;
use App\templates\repositories\TemplateRepository;
use App\templates\services\ITemplateService;
use App\templates\services\TemplateService;
use App\verification\repositories\IVerificationRepository;
use App\verification\repositories\VerificationRepository;
use App\verification\services\IVerificationService;
use App\verification\services\VerificationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IVerificationRepository::class, function () {
            return new VerificationRepository();
        });
        $this->app->singleton(IVerificationService::class, function () {
            return new VerificationService(new VerificationRepository());
        });
        $this->app->singleton(ITemplateRepository::class, function () {
            return new TemplateRepository();
        });
        $this->app->singleton(ITemplateService::class, function () {
            return new TemplateService(new TemplateRepository());
        });
        $this->app->singleton(INotificationRepository::class, function () {
            return new NotificationRepository();
        });
        $this->app->singleton(INotificationService::class, function () {
            return new NotificationService(new NotificationRepository());
        });
    }
}
