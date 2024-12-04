<?php

use App\Model;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class PollsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker     = FakerFactory::create();
        $usernames = array_map(static function () use ($faker) {
            return $faker->unique()->userName;
        }, range(1, 250));

        factory(Model\Poll::class, 100)->create()->each(function (Model\Poll $poll) use ($usernames, $faker) {
            $votingUsers = $usernames;

            array_map(function () use (&$votingUsers, $faker, $poll) {
                if (empty($votingUsers)) {
                    return;
                }

                $option = new Model\Option(['option' => $faker->sentence(3, true)]);
                $option->poll()->associate($poll);
                $option->save();

                $maxVotes = floor(count($votingUsers) / 2);

                array_map(function () use (&$votingUsers, $poll, $option) {
                    if (empty($votingUsers)) {
                        return;
                    }

                    shuffle($votingUsers);
                    $vote = new Model\Vote(['username' => array_pop($votingUsers)]);
                    $vote->option()->associate($option);
                    $vote->poll()->associate($poll);
                    $vote->save();
                }, range(1, random_int(0, ($maxVotes < 0 ? 0 : $maxVotes))));
            }, range(1, random_int(2, 5)));
        });
    }
}
