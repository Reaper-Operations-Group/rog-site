<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\OperationUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use PHPUnit\Exception;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Create users
        $users = User::factory(40)->create();
        $users->push(User::factory()->create([
            'username'=>'Kieran',
           'email'=>'kieranjag@hotmail.com',
           'password'=> bcrypt('password'),
            'isAdmin'=>'1',
            'isMissionMaker'=>'1'
        ]));
        $users->push(User::factory()->create([
            'username'=>'Kieran2',
            'email'=>'kieranjag2@hotmail.com',
            'password'=> bcrypt('password'),
        ]));

        //Create Types
        $types = collect();
        $types->push(OperationType::factory()->create([
            'name'=>'Standard'
        ]));
        $types->push(OperationType::factory()->create([
            'name'=>'Special'
        ]));

        //Create Operations
        $ops = collect();
        for ($i = 0; $i < 100; $i++) {
            if($i<5){
                $ops->push(Operation::factory()->create([
                    'operation_type_id'=>$types->random(),
                    'isCompleted'=>0
                ]));
            } else {
                $ops->push(Operation::factory()->create([
                    'operation_type_id'=>$types->random(),
                    'isCompleted'=>1
                ]));
            }
        }

        //Assign Players to operations
        foreach ($ops as $op){
            for($i = 0; $i < random_int(5,30); $i++)
            {
                $user = $users->random();
                if(!OperationUser::query()->where('operation_id','=',$op->id)->where('user_id','=',$user->id)->exists())
                {
                    OperationUser::factory()->create([
                        'operation_id'=>$op->id,
                        'user_id'=>$user->id
                    ]);
                }

            }

        }
        //dd($types);

    }
}
