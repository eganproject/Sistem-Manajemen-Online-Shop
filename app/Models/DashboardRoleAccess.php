<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DashboardRoleAccess extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function dashboardrole()
    {
        return $this->belongsTo(DashboardRole::class);
    }

    public function dashboardmenu()
    {
        return $this->belongsTo(DashboardMenu::class);
    }
}
