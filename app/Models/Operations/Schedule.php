<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'sched_id';

    protected $fillable = [
        'departure_time',
        'vessel',
        'port_a_id',
        'port_b_id',
    ];

    public $timestamps = true;

    // Relationship for Port A
    public function portA()
    {
        return $this->belongsTo(Port::class, 'port_a_id', 'port_id');
    }

    // Relationship for Port B
    public function portB()
    {
        return $this->belongsTo(Port::class, 'port_b_id', 'port_id');
    }
}
