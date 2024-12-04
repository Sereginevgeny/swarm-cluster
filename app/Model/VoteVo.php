<?php
declare(strict_types=1);

namespace App\Model;

/**
 * Class VoteVo
 *
 * @package App\Model
 */
class VoteVo
{
    /**
     * @var int
     */
    private $option;

    /**
     * @var string
     */
    private $username;

    /**
     * VoteVo constructor.
     *
     * @param int    $option
     * @param string $username
     */
    public function __construct(int $option, string $username)
    {
        $this->option   = $option;
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getOption(): int
    {
        return $this->option;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}
