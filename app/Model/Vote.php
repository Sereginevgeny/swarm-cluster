<?php
declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Vote
 *
 * @package App\Model
 *
 * @property int    $id
 * @property string $username
 */
class Vote extends Model
{
    protected $table = 'votes';

    protected $fillable = [
        'username',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class, 'poll_id', 'id');
    }
}
