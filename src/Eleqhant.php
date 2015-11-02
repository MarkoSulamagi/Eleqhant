<?php

namespace Rentmarket\Eleqhant;

use Auth;

abstract class Eleqhant extends \Eloquent {

    protected $primaryKey = null;

    protected $hasActorColumns = true;

    /**
     * The name of the "created by" column.
     *
     * @var string
     */
    const CREATED_BY = 'created_by';

    /**
     * The name of the "updated by" column.
     *
     * @var string
     */
    const UPDATED_BY = 'updated_by';

    /**
     * The name of the "deleted by" column.
     *
     * @var string
     */
    const DELETED_BY = 'deleted_by';

    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    const DELETED_AT = 'deleted_at';

    function __construct()
    {
        parent::__construct();
        $this->setKeyName($this->getKeyName());
    }

    public function hasActorColumns()
    {
        if ($this->hasActorColumns) {
            return true;
        }
        return false;
    }

    /**
     * Get the table associated with the model.
     * Override the Eloquent core function to use singular table names instead of plural.
     *
     * @return string
     */
    public function getTable()
    {
        if (isset($this->table)) return $this->table;

        return str_replace('\\', '', snake_case(str_plural(class_basename($this))));
    }

    /**
     * Get the primary key for the model.
     * Override the Eloquent core function to use table name as ID prefix.
     *
     * @return string
     */
    public function getKeyName()
    {
        if (isset($this->primaryKey)) return $this->primaryKey;

        return str_replace('\\', '', snake_case(class_basename($this))."_id");
    }

    /**
     * Update the creation/update timestamps and user id's.
     *
     * @return void
     */
    protected function updateTimestamps()
    {
        $time = $this->freshTimestamp();

        if ( ! $this->isDirty(static::UPDATED_AT))
        {
            $this->setUpdatedAt($time);
        }

        if ( ! $this->isDirty(static::UPDATED_BY) && $this->hasActorColumns() && Auth::check())
        {
            $this->setUpdatedBy(Auth::id());
        }

        if ( ! $this->exists && ! $this->isDirty(static::CREATED_AT))
        {
            $this->setCreatedAt($time);
        }

        if ( ! $this->exists && ! $this->isDirty(static::CREATED_BY) && $this->hasActorColumns() && Auth::check())
        {
            $this->setCreatedBy(Auth::id());
        }
    }

    /**
     * Set the value of the "created by" attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setCreatedBy($value)
    {
        $this->{static::CREATED_BY} = $value;
    }

    /**
     * Set the value of the "updated by" attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setUpdatedBy($value)
    {
        $this->{static::UPDATED_BY} = $value;
    }

    /**
     * Set the value of the "updated by" attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setDeletedBy($value)
    {
        $this->{static::DELETED_BY} = $value;
    }

    /**
     * Set the value of the "deleted at" attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setDeletedAt($value)
    {
        $this->{static::DELETED_AT} = $value;
    }

    /**
     * Get the name of the "created by" column.
     *
     * @return string
     */
    public function getCreatedByColumn()
    {
        return static::CREATED_BY;
    }

    /**
     * Get the name of the "updated by" column.
     *
     * @return string
     */
    public function getUpdatedByColumn()
    {
        return static::UPDATED_BY;
    }

    /**
     * Get the name of the "updated by" column.
     *
     * @return string
     */
    public function getDeletedByColumn()
    {
        return static::DELETED_BY;
    }

    public function softDelete()
    {
        if (\Auth::check()) {
            $this->setDeletedBy(\Auth::id());
        }

        $time = $this->freshTimestamp();
        $this->setDeletedAt($time);
        $this->save();
    }

    public static function saveMany($array)
    {
        $collection = new \Illuminate\Database\Eloquent\Collection;
        foreach ($array as $entity) {
            $collection->add(static::create($entity));
        }

        return $collection;
    }
}