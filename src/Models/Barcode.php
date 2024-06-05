<?php

namespace JobMetric\Barcode\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property mixed barcodeable_id
 * @property mixed barcodeable_type
 * @property mixed type
 * @property mixed value
 * @property mixed created_at
 */
class Barcode extends Pivot
{
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'barcodeable_id',
        'barcodeable_type',
        'type',
        'value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'barcodeable_id' => 'integer',
        'barcodeable_type' => 'string',
        'type' => 'string',
        'value' => 'string',
    ];

    public function getTable()
    {
        return config('barcode.tables.barcode', parent::getTable());
    }

    /**
     * barcodeable relationship
     *
     * @return MorphTo
     */
    public function barcodeable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope type.
     *
     * @param Builder $query
     * @param string $type
     *
     * @return Builder
     */
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope value like.
     *
     * @param Builder $query
     * @param string $value
     *
     * @return Builder
     */
    public function scopeValue(Builder $query, string $value): Builder
    {
        $words = explode(' ', $value);

        foreach ($words as $word) {
            $query->where('value', 'like', "%$word%");
        }

        return $query;
    }
}
