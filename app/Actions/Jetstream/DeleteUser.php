<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;
use App\Models\Animal;
use App\Models\Food;
use App\Models\Note;
use App\Models\Weight;
use App\Models\Thedate;

class DeleteUser implements DeletesUsers
{
    /**
     * The team deleter implementation.
     *
     * @var \Laravel\Jetstream\Contracts\DeletesTeams
     */
    protected $deletesTeams;

    /**
     * Create a new action instance.
     *
     * @param  \Laravel\Jetstream\Contracts\DeletesTeams  $deletesTeams
     * @return void
     */
    public function __construct(DeletesTeams $deletesTeams)
    {
        $this->deletesTeams = $deletesTeams;
    }

    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {

        $use_animal = Animal::where('user_id', $user->id)->get();
        foreach ($use_animal as $row) {

            $user_thedate = Thedate::where('animal_id', $row->id)->get();
            foreach ($user_thedate as $each) {
                DB::table('thedate_thedatetitle')->where('thedate_id', $each->id)->delete();
            }
            Weight::where('animal_id', $row->id)->delete();
            Note::where('animal_id', $row->id)->delete();
            Thedate::where('animal_id', $row->id)->delete();
        }
        Animal::where('user_id', $user->id)->delete();
        Food::where('user_id', $user->id)->delete();
        DB::transaction(function () use ($user) {
            $this->deleteTeams($user);
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
        });
    }

    /**
     * Delete the teams and team associations attached to the user.
     *
     * @param  mixed  $user
     * @return void
     */
    protected function deleteTeams($user)
    {
        $user->teams()->detach();

        $user->ownedTeams->each(function ($team) {
            $this->deletesTeams->delete($team);
        });
    }
}
