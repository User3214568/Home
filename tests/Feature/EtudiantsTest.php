<?php

namespace Tests\Feature;

use App\Etudiant;
use App\Evaluation;
use App\Formation;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EtudiantsTest extends TestCase
{
    use AuthTrait,DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $faker = Factory::create();
        $this->actingUser();

        $formation = Formation::first();
        if(!$formation) return;
        $formation->save();
        $first_name = $faker->name();
        $last_name = $faker->name();
        $born_date = $faker->date();
        $born_place = $faker->city();
        $cin = $faker->unique()->word();
        $email = $faker->unique()->safeEmail();

        $phone = $faker->phoneNumber();
        $response = $this->call('POST',route('etudiant.store'),array(
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'cin'=>$cin,
            'email'=>$email,
            'born_date'=>$born_date,
            'phone'=>$phone,
            'born_place'=>$born_place,
            'formation_id'=>$formation->id,
            '_token'=>csrf_token(),
        ));

        $response->assertStatus(302);
        $response->assertRedirect(route('etudiant.index'));
        $e = Etudiant::get()->sortBy('created_at')->last();

        $this->assertTrue($e->user->first_name === $first_name,'FIRST NAME');
        $this->assertTrue($e->user->last_name === $last_name,'LAST NAME');
        $this->assertTrue($e->user->cin === $cin,'CIN ');
        $this->assertTrue($e->user->email === $email,'EMAIL');
        $this->assertTrue($e->born_date === $born_date,'BORN DATE');
        $this->assertTrue($e->born_place === $born_place,'BORN PLACE');
        $this->assertTrue($e->promotion->numero === 1,'NUMERO PROMO');
        $this->assertTrue($e->formation->id === $formation->id,'FORMATION');
        foreach($e->promotion->semestres as $sem){
            foreach($sem->modules as $mod){
                foreach($mod->devoirs as $dev){
                    if($dev->session === 1 ){
                        $ev = $dev->evaluations->where('etudiant_cin',$e->cin)->first();
                        $this->assertTrue($ev !== null , 'ETUDIANT DOESNT HAVE EVALUATION');
                    }
                }
            }
        }
    }
    public function testUpdate(){
        $faker = Factory::create();
        $e = Etudiant::get()->sortBy('created_at')->last();
        $this->actingUser();
        $formation = Formation::first();
        if(!$formation) return;
        $first_name = $faker->name();
        $last_name = $faker->name();
        $born_date = $faker->date();
        $born_place = $faker->city();
        $email = $faker->unique()->safeEmail();
        $phone = $faker->phoneNumber();
        $promo = $e->promotion_id + 1;
        $response = $this->call('PUT',route('etudiant.update',['etudiant'=>$e->cin]),array(
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'email'=>$email,
            'born_date'=>$born_date,
            'phone'=>$phone,
            'born_place'=>$born_place,
            'formation_id'=>$formation->id,
            'promotion_id'=>$promo,
            '_token'=>csrf_token(),
        ));
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('etudiant.index'));
        $e = Etudiant::find($e->cin);

        $this->assertTrue($e->user->first_name == $first_name,'FIRST NAME');
        $this->assertTrue($e->user->last_name == $last_name,'LAST NAME');
        $this->assertTrue($e->user->email == $email,'EMAIL');
        $this->assertTrue($e->born_date == $born_date,'BORN DATE');
        $this->assertTrue($e->born_place == $born_place,'BORN PLACE');
        $this->assertTrue($e->promotion->id == $promo,'NUMERO PROMO');
        $this->assertTrue($e->formation->id == $formation->id,'FORMATION');
        foreach($e->promotion->semestres as $sem){
            foreach($sem->modules as $mod){
                foreach($mod->devoirs as $dev){
                    if($dev->session === 1 ){
                        $ev = $dev->evaluations->where('etudiant_cin',$e->cin)->first();
                        $this->assertTrue($ev !== null , 'ETUDIANT DOESNT HAVE EVALUATION');
                    }
                }
            }
        }
    }
    public function testDelete(){
        $e = Etudiant::first();
        $evaluations = $e->evaluations->pluck('id')->toArray();
        $this->actingUser();
        $response = $this->call('DELETE',route('etudiant.destroy',['etudiant'=>$e->cin]),array(
            '_token'=>csrf_token(),
        ));

        $response->assertRedirect(route('etudiant.index'));
        foreach ($evaluations as  $evaluation) {
            $this->assertTrue(Evaluation::find($evaluation) === null  , 'Evaluation Deleted');
        }
    }

}
