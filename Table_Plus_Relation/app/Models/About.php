<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = ['title','content','experience_id','skill_id','project_id'];

    public function experience()
    {
        return $this->belongsTo(Experience::class, 'experience_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
