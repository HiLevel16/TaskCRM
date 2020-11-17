<?php


namespace App\Traits;


use App\PaymentSystem;
use App\Project;
use App\TaskCategory;

trait ProjectAndPaymentSystem
{

    public function project()
    {
        return $this->belongsTo(Project::class, 'projectId');
    }

    public function paymentSystem()
    {
        return $this->belongsTo(PaymentSystem::class, 'paymentSystemId');
    }

    public function linkedCategory()
    {
        return $this->belongsTo(TaskCategory::class, 'category');
    }
}