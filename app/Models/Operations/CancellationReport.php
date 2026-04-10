<?php

namespace App\Models\Operations;

use App\Models\Accounts\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancellationReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cancellation_reports';

    protected $fillable = [
        'control_number',
        'port_id',
        'vessel_id',
        'schedule_id',
        'vessel_master_id',
        'num_passengers_affected',
        'num_rcs_affected',
        'est_revenue_loss',
        'cancellation_category',
        'cancellation_type',
        'consulted_dept',
        'reason_of_cancel',
        'recommendation',
        'documents',
    ];

    protected $casts = [
        'num_passengers_affected' => 'integer',
        'num_rcs_affected'        => 'integer',
        'est_revenue_loss'        => 'decimal:2',
        'documents'               => 'array',
    ];

    public function port()
    {
        return $this->belongsTo(Port::class, 'port_id', 'port_id');
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class, 'vessel_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'sched_id');
    }

    public function vesselMaster()
    {
        return $this->belongsTo(User::class, 'vessel_master_id');
    }
}
