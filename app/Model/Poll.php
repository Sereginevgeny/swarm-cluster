<?php
declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Poll
 *
 * @package App
 *
 * @property string $question
 */
class Poll extends Model
{
    protected $table = 'polls';

    protected $fillable = [
        'question',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class, 'poll_id', 'id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'poll_id', 'id');
    }
}
