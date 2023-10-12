<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Task;

class Status extends Model
{
    use HasFactory;

    public function tasks(): HasMany {
      return $this->hasMany(Task::class)->orderBy("due_date", "asc");
    }
}
