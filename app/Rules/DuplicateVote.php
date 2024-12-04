<?php

namespace App\Rules;

use App\Model\Poll;
use Illuminate\Contracts\Validation\Rule;

class DuplicateVote implements Rule
{
    /**
     * @var Poll
     */
    private $poll;

    /**
     * Create a new rule instance.
     *
     * @param Poll $poll
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->poll->votes()->where('username', $value)->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This user already voted in this poll';
    }
}
