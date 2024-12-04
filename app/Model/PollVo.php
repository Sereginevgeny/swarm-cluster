<?php
declare(strict_types=1);

namespace App\Model;

/**
 * Class PollVo
 *
 * @package App\Model
 */
class PollVo
{
    /**
     * @var string
     */
    private $question;

    /**
     * @var string[]
     */
    private $options = [];

    /**
     * PollVo constructor.
     *
     * @param string   $question
     * @param string[] $options
     */
    public function __construct(string $question, array $options)
    {
        $this->question = $question;
        $this->options  = $options;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
