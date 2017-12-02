<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Skill;
use App\Project;
use App\Challenge;

class Freelancer extends Model {

    protected $table = 'freelancers';
    public $timestamps = false;
    protected $primaryKey = 'freelancer_id';
    protected $hidden = ['pivot'];
    protected $fillable = array('freelancer_id', 'phone',
        'image', 'premium', 'coins', 'first_name', 'last_name', 'freelancer_curriculum_vitae', 'freelancer_id', 'description', 'profession',
        'address', 'pseudonym', 'badge');

    public function challenges() {
        return $this->belongsToMany('App\Challenge', 'challenge_freelancer_participation', 'freelancer_id', 'challenge_id')->withPivot(['freelancer_participation_id', 'message', 'document', 'viewed'])->withTimestamps();
    }

    public function challengesWithoutPivot() {
        return $this->belongsToMany('App\Challenge', 'challenge_freelancer_participation', 'freelancer_id', 'challenge_id')->withPivot(['paritcipation_url', 'message']);
    }

    public function skills() {
        return $this->belongsToMany('App\Skill', 'freelancer_skill', 'freelancer_id', 'skill_id'
        );
    }

    public function projects() {
        return $this->belongsToMany('App\Project', 'freelancer_project_interest', 'freelancer_id', 'project_id')->withTimestamps();
    }

    public function enterprises() {
        return $this->belongsToMany('App\Enterprise', 'freelancer_profile_unblocked', 'freelancer_id', 'enterprise_id');
    }

    public function criterions() {
        return $this->belongsToMany('App\Criterion', 'freelancer_criterion_evaluation', 'freelancer_id', 'criterion_id')->withPivot('mark');
    }

    public function participationNumber() {
        return $this->challenges()->count();
    }

    public function WinningNumber() {
        // to change after with the real winning number
        return $this->challenges()->count();
    }

    public function deblocked_number() {
        $deblocked_number_by_enterprises = $this->belongsToMany('App\Enterprise', 'freelancer_profile_unblocked', 'freelancer_id', 'enterprise_id')->count();

        $deblocked_number_by_freelancers = $this->belongsToMany('App\Freelancer', 'freelancer_profile_unblocked', 'freelancer_id', 'freelancer_unlocker_id')->count();

        return $deblocked_number_by_enterprises + $deblocked_number_by_freelancers;
    }

    public function is_freelancer_Unlocked($freelancer_id) {

        if ($this->freelancers()->wherePivot('freelancer_id', $freelancer_id)->first() != null) {
            return true;
        }
        return false;
    }

    public function freelancers() {
        return $this->belongsToMany('App\Freelancer', 'freelancer_profile_unblocked', 'freelancer_unlocker_id', 'freelancer_id')->withTimestamps();
    }

    public function unlockFreelancer($freelancer_id) {

        $this->freelancers()->attach(['freelancer_id' => $freelancer_id]);
    }

    /**
     * @return Object User
     */
    public function get_average_marks($challenge_id) {
        $marks = $this->criterions()->where('challenge_id', '=', $challenge_id)->get();
        $average = 0;
        foreach ($marks as $mark) {
            $average = $average + $mark->pivot->mark;
        }
        return count($marks) == 0 ? -1 : $average / count($marks);
        return $average;
    }

    
}
