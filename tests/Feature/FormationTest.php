<?php

namespace Tests\Feature;

use App\Critere;
use App\Etudiant;
use App\Formation;
use App\Module;
use App\Promotion;
use App\Semestre;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class FormationTest extends TestCase
{
    use AuthTrait;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $faker = Factory::create();
        $semestres = [];
        $modules = factory(\App\Module::class,50)->make()->pluck('id')->toArray();
        $random = $faker->numberBetween(0,8);
        for($i = 1 ; $i <= $random ; $i++){
            $semestres["".$i]= $this->randomFromArray($modules,$faker->numberBetween(0,8));
        }

        $this->actingUser();
        $response = $this->call('POST',route('formation.store'),array(
            'name' => $faker->name,
            'description' => $faker->text(),
            'note_validation'=> rand(10,12) ,
            'note_aj'=> rand(7,10),
            'number_aj'=> $faker->numberBetween(0,1),
            'number_nv'=> $faker->numberBetween(0,2),
            'prix' =>  $faker->randomNumber(5),
            'semestres'=> json_encode($semestres),
            '_token'=>csrf_token()
        ));
        $response->assertStatus(302);
        $response->assertRedirect(route('formation.index'));
        $formation = Formation::get()[0];
        $this->assertTrue(sizeof($formation->promotions) === (int)($random === 0 ? 0 : (1+$random)/2),"Nombre de promotion n'est pas proportionnel au nombre des semestres");
    }
    public function testUpdate(){
        $this->actingUser();
        $semestres = [];
        $modules_registrated = [];
        $count = 1 ;
        $faker = Factory::create();
        $formation  = Formation::get()->last();
        $modules = Module::get()->pluck('id')->toArray();
        $random = $faker->numberBetween(0,8);
        for($i = 1 ; $i <= $random ; $i++){
            $m_selected = $this->randomFromArray($modules,$faker->numberBetween(0,8));
            $semestres["".$i] = $m_selected;
            array_push($modules_registrated,$m_selected);
        }

        $n_aj = $faker->numberBetween(0,1);
        $n_nv = $faker->numberBetween(0,2);
        $price = $faker->randomNumber(5);
        $note_aj = rand(7,10);
        $note_v  = rand(10,12);
        $name = $faker->name;
        $desc = $faker->text();
        $response = $this->call('PUT',route('formation.update',['formation'=>$formation->id]),array(
            'name' => $name,
            'description' => $desc,
            'note_validation'=> $note_v,
            'note_aj'=> $note_aj,
            'number_aj'=> $n_aj,
            'number_nv'=> $n_nv,
            'prix' =>  $price,
            'semestres'=> json_encode($semestres),
            '_token'=>csrf_token()
        ));
        $response->assertStatus(302);
        $response->assertRedirect(route('formation.index'));
        $formation = Formation::get()->last();

        $this->assertTrue($formation->name === $name , "Name has been updated");
        $this->assertTrue($formation->description === $desc , "Description has been updated");
        $this->assertTrue($formation->critere->note_validation == $note_v , "Note has been updated");
        $this->assertTrue($formation->critere->note_aj == $note_aj , "Note Aj has been updated");
        $this->assertTrue($formation->critere->number_aj == $n_aj, "Number of Aj has been updated");
        $this->assertTrue($formation->critere->number_nv == $n_nv , "Number of Nv has been updated");
        $this->assertTrue($formation->prix == $price , "Price has been updated");
        $this->assertTrue(sizeof($formation->promotions) === (int)($random === 0 ? 0 : (1+$random)/2),"Nombre de promotion n'est pas proportionnel au nombre des semestres");
        foreach ($formation->modules() as $m) {
            $this->assertTrue($this->inArray($modules_registrated,$m['id']),'MODULE NOT REGISTRATED FOR FORMATION');
        }
    }
    private function inArray(array $array, $search){
        foreach ($array as  $value) {
            if(in_array($search,$value)){
                return true;
            }
        }
        return false;
    }
    public function testDelete(){
        $this->actingUser();
        $formation = Formation::last();
        $promos = $formation->promotions->pluck('id');
        $semestres = $formation->semestres->pluck('id');
        $etudiants = $formation->etudiants->pluck('cin');
        $critere = $formation->critere_id;
        $response = $this->call('DELETE',route('formation.destroy',['formation'=>$formation->id]),array(
            '_token'=>csrf_token()
        ));
        $response->assertStatus(302);
        foreach ($promos as $promo_id) {
            $this->assertTrue(Promotion::find($promo_id) === null,'PROMOTION OF FORMATION HAS BEEN DELETED');
        }
        foreach ($semestres as $semestre) {
            $this->assertTrue( Semestre::find($semestre) === null, 'Semestre OF FORMATION HAS BEEN DELETED');
        }
        foreach ($etudiants as $etudiant) {
            $this->assertTrue(Etudiant::find($etudiant) === null,'Etduant OF FORMATION HAS BEEN DELETED');
        }
        $this->assertTrue(Critere::find($critere) === null,'CRITERE OF FORMATION HAS BEEN DELETED');

    }

    private function randomFromArray(array $array, $size){
        $result = [];
        if($size === 0 || sizeof($array) === 0) return $result;
        $keys = array_rand($array,$size > sizeof($array) ? sizeof($array) : $size);

        if(is_array($keys)){
            foreach($keys as $key){
                array_push($result,$array[$key]);
            }
        }
        return $result;
    }
}
