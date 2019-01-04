<?php
namespace App;
use ReflectionClass;
use Auth;
//use Activity;

trait RecordsActivity
{
    /**
     * Register the necessary event listeners.
     *
     * @return void
     */
    protected static function bootRecordsActivity()
    {
        foreach (static::getModelEvents() as $event) {
           // dd($event);
            static::$event(function ($model) use ($event) {
                //dd($model->recordActivity($event));
                $model->recordActivity($event);
            });
        }
    }
    /**
     * Record activity for the model.
     *
     * @param  string $event
     * @return void
     */
    public  function recordActivity($event)
    {

        Activity::create([
                'subject_id' => $this->id,
                'subject_type' => get_class($this),
                'name' => $this->getActivityName($this, $event),
                'key_name' =>'',
                'auth_id' => Auth::user()->id,
                'auth_type' => Auth::getProvider()->getModel(),
            ]);

    }
    /**
     * Prepare the appropriate activity name.
     *
     * @param  mixed  $model
     * @param  string $action
     * @return string
     */
    protected function getActivityName($model, $action)
    {
        $name = strtolower((new ReflectionClass($model))->getShortName());
        return "{$action}_{$name}";
    }
    /**
     * Get the model events to record activity for.
     *
     * @return array
     */
    protected static function getModelEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }
        return [
            'created', 'deleted', 'updated'
        ];
    }
}

