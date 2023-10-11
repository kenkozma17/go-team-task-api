<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Status;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ["title", "description", "due_date", "status_id"];
    protected $appends = ['formatted_date'];
    protected $casts = ['due_date' => 'datetime:Y-m-d'];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class);
    }

    public function getFormattedDateAttribute() {
      return Carbon::parse($this->due_date)->format("M d, Y");
    }
}
