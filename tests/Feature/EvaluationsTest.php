<?php

namespace Tests\Feature;

use App\Evaluation;
use App\Formation;
use App\Promotion;
use App\User;
use App\Utilities\Validation;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EvaluationsTest extends TestCase
{
    use AuthTrait;
    /**
     * A basic feature test example.
     *
     * @return void
    */



    public function testUpdateNote(){
        $etudiants = Formation::first()->etudiants;
        $evals = [];
        $this->actingUser();
        foreach ($etudiants as  $etudiant) {
            foreach ($etudiant->evaluations as $evaluation) {
                $note = ['note'=>rand(0,20)];
                $evals[$evaluation->id] = $note;
            }
        }
        $response = $this->call('POST',route('etudiant.note.update'),array(
            'evaluations' => json_encode($evals),
            '_token' => csrf_token()
        ));
        $response->assertStatus(200);
        $etudiants = Formation::first()->etudiants;
        foreach ($etudiants as  $etudiant) {
            foreach ($etudiant->evaluations as $evaluation) {

                $this->assertTrue($evaluation->note == $evals[$evaluation->id]['note'],"NOTE HAS NOT BEEN UPDATED");
            }
        }
    }
    public function testCommit(){
        $this->actingUser();
        $d ="admin/Module/commit/{promotion_id}-{sem_id}-{module_id}";
        $promo = Promotion::premier(Formation::first()->id);
        foreach($promo->semestres as $sem){
            foreach($sem->modules as $mod){
                $response = $this->call('GET',route('module.commit.notes',['module_id'=>$mod->id,'promotion_id'=>$promo->id,'sem_id'=>$sem->id]));
                $response->assertStatus(302);
                $response->assertRedirect(route('etudiant.evaluation'));
            }
        }
    }


}
