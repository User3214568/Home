<?php

namespace App\Console\Commands;

use App\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class BackOffice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backoffice:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Création de l'utilisateur admin";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = [];
        try{
            $inputs = [

                ['field' => 'first_name' , 'label'=> 'Nom', 'validator' => 'required' ],
                ['field' => 'last_name' , 'label'=> 'Prénom', 'validator' => 'required' ],
                ['field' => 'cin' , 'label'=> 'CIN', 'validator' => 'required|unique:users,cin' ],
                ['field' => 'email' , 'label'=> 'Email', 'validator' => 'required|email|unique:users,email' ],
                ['field' => 'password' , 'label'=> 'Mot de Passe', 'validator' => 'required'  , 'hashed'=>true ],
                ['field' => 'phone' , 'label'=> 'Téléphone', 'validator' => '' ],
                
            ];
            $this->makeFormulaire($user,$inputs);
            $user['type'] = 0;
            User::create($user);
            $this->info("Utilisateur à ete bien crée");
        }catch(Exception $e){
            $this->error("On a pas pu crée l'utilisateur");
        }
    }
   
    function makeFormulaire(array &$user ,  array $inputs){
        foreach($inputs as $input){
            do{
                echo "\n".$input['label']." : ";
                $user[$input['field']] = readline();
                $validation = Validator::make($user,[$input['field'] => $input['validator']]);
                if(isset($input['hashed'])){
                    $user[$input['field']] = bcrypt($user[$input['field']]);
                }
                if($validation->fails()){
                    echo "\n données invalides!\n";
                }
            }while($validation->fails());
            
        }
    }
}
