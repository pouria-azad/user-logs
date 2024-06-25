<?php

namespace Binafy\LaravelUserMonitoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActionMonitoring extends Model
{
    /**
     * Set table name.
     *
     * @var string
     */
    protected $table = 'actions_monitoring';

    /**
     * Guarded columns.
     *
     * @var array
     */
    protected $guarded = ['id'];

    # Relations

    public function consumer(): MorphTo
    {
        return $this->morphTo();
    }
}
