<?php

namespace Binafy\LaravelUserMonitoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VisitMonitoring extends Model
{
    /**
     * Set table name.
     *
     * @var string
     */
    protected $table = 'visits_monitoring';

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
