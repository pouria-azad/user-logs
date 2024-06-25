<?php

namespace Binafy\LaravelUserMonitoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuthenticationMonitoring extends Model
{
    /**
     * Set table name.
     *
     * @var string
     */
    protected $table = 'authentications_monitoring';

    /**
     * Guarded columns.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    # Relations

    public function consumer(): MorphTo
    {
        return $this->morphTo();
    }
}
