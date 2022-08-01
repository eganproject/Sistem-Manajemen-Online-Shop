<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardRole extends Model
{
    use HasFactory;
    protected $primarykey = 'id';
    protected $guarded = ['id'];
    // protected $with = ['dashboardroleaccess'];

    // nama function harus sama dengan model untuk lakukan eloquent
    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function dashboardroleaccess()
    {
        return $this->hasMany(DashboardRoleAccess::class);
    }
}
