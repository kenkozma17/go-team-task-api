<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Status;


class Task extends Model
{
    use HasFactory;

    protected $fillable = ["title", "description", "due_date", "status_id"];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class);
    }
}
