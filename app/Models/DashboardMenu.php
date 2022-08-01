<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardMenu extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];

    public function dashboardroleaccess()
    {
        return $this->hasMany(DashboardRoleAccess::class);
    }
    public function DashboardSubmenu()
    {
        return $this->hasMany(DashboardSubmenu::class, 'slugmenu', 'slugmenu');
    }
    public function sluggable(): array
    {
        return [
            'slugmenu' => [
                'source' => 'nama'
            ]
        ];
    }
}
