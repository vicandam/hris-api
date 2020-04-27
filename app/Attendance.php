<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $appends = array(
        'human_readable_date' ,
    );

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function getHumanReadableDateAttribute()
    {
        return  $this->created_at->format('M d, Y h:i A');
    }

    public function getStatusAttribute($value)
    {
        return strtoupper($value);
    }
}
