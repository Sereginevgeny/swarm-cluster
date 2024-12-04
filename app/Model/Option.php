<?php
declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Option
 *
 * @package App\Model
 *
 * @property string $question
 */
class Option extends Model
{
    protected $table = 'poll_options';

    protected $fillable = [
        'option',
    ];

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class, 'poll_id', 'id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'option_id', 'id');
    }
}
