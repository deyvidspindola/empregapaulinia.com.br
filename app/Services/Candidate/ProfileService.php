<?php

namespace App\Services\Candidate;

use App\Models\User;
use App\Models\Candidate;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;

class ProfileService
{

    private string $fileSystem;
    public function __construct()
    {
        $this->fileSystem = env('APP_FILE_SYSTEM', 'local');;
    }

    public function store(array $data, $user): Candidate
    {
        try {
            return DB::transaction(function () use ($data, $user): Candidate {               
                if (isset($data['logo'])) {
                    $data['logo_path'] = $data['logo']->store('candidates/profile', $this->fileSystem);
                }

                unset($data['logo']);
                
                $candidate = Candidate::create([
                    ...$data,
                    'user_id' => $user->id,
                ]);

                User::whereKey($user->id)
                    ->update([
                        'name' => $data['full_name'],
                        'email_verified_at' => now()
                    ]);                

                return $candidate;
            });
                
        } catch (\Exception $e) {
            throw new BusinessException('Erro ao criar perfil', previous: $e);
        }    
    }

    public function update(Candidate $candidate, array $data): Candidate
    {
        try {
            return DB::transaction(function () use ($candidate, $data): Candidate {
                if (isset($data['logo'])) {
                    // Remove logo antiga se existir
                    if ($candidate->logo_path && \Storage::disk($this->fileSystem)->exists($candidate->logo_path)) {
                        \Storage::disk($this->fileSystem)->delete($candidate->logo_path);
                    }

                    $data['logo_path'] = $data['logo']->store('candidates/profile', $this->fileSystem);
                }

                unset($data['logo']);

                $candidate->update($data);

                return $candidate;
            });

        } catch (\Exception $e) {
            throw new BusinessException('Erro ao atualizar perfil', previous: $e);
        }
    }

}