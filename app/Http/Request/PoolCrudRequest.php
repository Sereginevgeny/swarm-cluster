<?php
declare(strict_types=1);

namespace App\Http\Request;

use App\Model\PollVo;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PoolCrudRequest
 *
 * @package App\Http\Request
 */
class PoolCrudRequest extends FormRequest
{
    public function rules()
    {
        return [
            'question'  => 'required|max:255',
            'options'   => 'required|array',
            'options.*' => 'max:255',
        ];
    }

    public function values(): PollVo
    {
        return new PollVo(
            $this->input('question'),
            $this->input('options')
        );
    }
}
