<?php
namespace App\Observers;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;
class AuditObserver
{
    public function updated($model)
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model' => class_basename($model),
            'model_id' => $model->id,
            'old_values' => json_encode($model->getOriginal()),
            'new_values' => json_encode($model->getChanges()),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
