<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 19/01/17
 * Time: 11:28
 */

namespace istheweb\iscorporate\behaviors;

use Illuminate\Support\Facades\Lang;
use Istheweb\IsCorporate\Models\Variant;
use System\Classes\ModelBehavior;
use Backend\Facades\Backend;
use Backend\Facades\BackendAuth;
use Carbon\Carbon;

class ProjectModel extends ModelBehavior
{
    /**
     * @param \System\Classes\October\Rain\Database\Model $model
     * @throws \ApplicationException
     */
    public function __construct($model)
    {
        parent::__construct($model);
    }

    /**
     * @return mixed
     */
    public function getOpenedCount()
    {
        return $this->model->opened()->count();
    }

    /**
     * @return mixed
     */
    public function getClosedCount()
    {
        return $this->model->closed()->count();
    }

    /**
     * @return mixed
     */
    public function getCompletedCount()
    {
        return $this->model->completed()->count();
    }

    /**
     * @param $var
     * @return int
     */
    public function getProjectTime($var)
    {
        $from = Carbon::parse($this->model->available_on);
        $to = Carbon::parse($this->model->available_until);
        if($var == 'hours'){
            $diff = $to->diffInHours($from);
        }else if($var == 'days'){
            $diff = $to->diffInDays($from);
        }

        return $diff;
    }

    /**
     * @return mixed
     */
    public function getSelectedStatusName()
    {
        foreach($this->model->getStatusOptions() as $key => $value)
        {
            if($this->model->status == $key){
                return Lang::get($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getSelectedNowName()
    {
        foreach($this->model->getNowOptions() as $key => $value){
            if($this->model->now == $key){
                return Lang::get($value);
            }
        }
    }

    public function getSelectedColumn($k, $column){

        //$project = new Project();
        if($column == 'status'){
            $array = $this->model->getStatusOptions();
        } else {
            $array = $this->model->getNowOptions();
        }

        foreach($array as $key => $value){
            if($k == $key) {
                return Lang::get($value);
            }
        }
    }

    /**
     * @param $budget
     * @return mixed
     */
    public function generateProjectFromBudget($budget)
    {
        $client = $budget->client;
        $c = $client->company->name."_".$budget->motivo;
        $code = strtolower(str_replace(" ", "_",$c));
        $slug = str_replace("_", '-', $code);

        $project = $this->model->firstOrNew(['slug' => $slug]);
        $project->name = $budget->motivo;
        $project->client = $budget->client;
        $project->code = $code;
        $project->slug = $slug;
        $project->available_on = Carbon::now();
        $project->available_until = $budget->fecha_entrega;
        $project->enabled = 0;

        $project->project_types = $budget->project_types;
        $project->options = $budget->options;

        $project->save();
        if(!$budget->variants->isEmpty()){
            foreach($budget->variants as $variant){
                $p_variant = Variant::createVariant($project, $variant);
                $project->variants()->add($p_variant);
            }
        }
        return $project;
    }

    /**
     * @param $date
     * @return string
     */
    public function formatDate($date){
        setlocale(LC_TIME, 'Spanish');
        $d = Carbon::parse($date);
        return $d->formatLocalized('%d-%m-%Y');
    }

    /**
     * @return int
     */
    public function getAssignedDaysCount()
    {
        $total = 0;
        foreach($this->model->variants as $variant){
            $total += $variant->plazo;
        }
        return $total;
    }

    /**
     * @return int
     */
    public function getAssignedHoursCount()
    {
        $total = 0;
        foreach($this->model->variants as $variant){
            $total += $variant->horas;
        }
        return $total;
    }

    /**
     * @return array
     */
    public function getTotalWorkingTime()
    {
        $hours = 0;
        $minutes = 0;
        foreach($this->model->reports as $report){
            $hours += $report->hours;
            $minutes += $report->minutes;
        }

        $time = $this->calculateTime($hours, $minutes);

        return $time;
    }

    /**
     * @param $hours
     * @param $minutes
     * @return array
     */
    protected function calculateTime($hours, $minutes){
        if($minutes > 60){
            $hours += 1;
            $minutes = $minutes - 60;
            if($minutes > 60){
                $this->calculateTime($hours, $minutes);
            }
        }
        return [
            $hours, $minutes
        ];
    }

    /**
     * @param $context
     * @return bool
     */
    public function isAllowedToUpdate($context)
    {
        //dd($this->model->variants->count());
        $isbackend = false;
        foreach($this->model->variants as $variant){
            if($variant->isBackendUser()){
                return true;
            }
        }
        return $isbackend;
    }


}