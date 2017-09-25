<?php

use Illuminate\Database\Seeder;

class SampleSeeder extends Seeder {
    private $config;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->getConfig();
        $this->addUsers();
        $this->addClients();
    }

    private function getConfig()
    {
        $this->config = config('dashboardx');
    }

    private function addUsers()
    {
        $users = $this->config['users'];
        foreach ($users as $user) {
            $check = DB::table('users')->where('email', $user['email'])->first();
            if ($check) {
                continue;
            }
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password'])
            ]);
        }
    }

    private function addClients()
    {
        $clients = $this->config['clients'];
        foreach ($clients as $client) {
            $clientId = DB::table('clients')->insertGetId([
                'name' => $client['name']
            ]);

            $this->addClientUsers($clientId, $client['users']);
            $this->addClientRepos($clientId, $client['repositories']);
        }
    }

    private function addClientUsers($clientId, $users)
    {
        foreach ($users as $user) {
            $model = DB::table('users')->where('email', $user['email'])->first();
            if (!$model) {
                continue;
            }
            DB::table('client_users')->insert([
                'client_id' => $clientId,
                'user_id' => $model->id,
                'role' => $user['role']
            ]);
        }
    }

    private function addClientRepos($clientId, $repos)
    {
        foreach ($repos as $repo) {
            DB::table('client_repositories')->insert([
                'client_id' => $clientId,
                'name' => $repo
            ]);
        }
    }
}
