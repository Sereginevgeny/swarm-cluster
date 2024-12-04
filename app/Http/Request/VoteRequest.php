<?php
declare(strict_types=1);

namespace App\Http\Request;

use App\Model\VoteVo;
use App\Rules\DuplicateVote;
use App\Service\PollManageService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Class VoteRequest
 *
 * @package App\Http\Request
 */
class VoteRequest extends FormRequest
{

    public function validator(Factory $factory, PollManageService $manageService)
    {
        $validator = $factory->make($this->validationData(), [], $this->messages(), $this->attributes());

        try {
            $poll = $manageService->find($this->route('id'));
        } catch (\Throwable $exception) {
            throw new ValidationException($validator, new JsonResponse(['message' => 'Poll does not exist', 404]));
        }

        $rules = [
            'option'   => [
                'required',
                Rule::exists('poll_options', 'id'),
            ],
            'username' => [
                'required',
                new DuplicateVote($poll),
            ],
        ];

        $validator->addRules($rules);

        return $validator;
    }

    public function values(): VoteVo
    {
        return new VoteVo(
            (int) $this->input('option'),
            $this->input('username')
        );
    }
}
