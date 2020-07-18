<?php
namespace App\Audit\Traits;

use App\Models\Activity;
use Auth;

trait RecordsActivity
{
    /**
     * boot function for trigger events
     */
    protected static function boot()
    {
        parent::boot();

        foreach (static::getModelEvents() as $event) {
            static::$event(function($model) use ($event) {
                $model->addActivity($event);
            });
        }
    }

    /**
     * @param $event
     */
    protected function addActivity($event)
    {
        Activity::create([
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
            'name' => $this->getActivityName($this, $event),
            'user_id' => Auth::id() ?: 'Can not found!',
        ]);
    }

    /**
     * @param $model
     * @param $action
     * @return string
     */
    protected function getActivityName($model, $action)
    {
        $name = strtolower((new \ReflectionClass($model))->getShortName());

        return "{$action}_{$name}";
    }

    /**
     * @return array
     */
    protected static function getModelEvents()
    {
        if (isset(static::$recordEvents)) {

            return static::$recordEvents;
        }

        return ['created', 'deleted', 'updated'];
    }
}

