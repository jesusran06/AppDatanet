<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Client;
//use Your Model

/**
 * Class ClientsRepository.
 */
class ClientsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Client::class;
    }

    public function getClients(){
        
            $clients = $this->paginate(10);
    
            return $clients;
    }

    public function createClient($data){
        $cliente = $this->model->existeCorreoElectronico($data['email']);
        if($cliente){
            return $cliente;
        }
        $cliente = $this->model->existeDocument($data['document']);
        if($cliente){
            return $cliente;
        }
        $client = $this->create([
            'names' => $data["names"],
            'document' => $data["document"],
            'birthdate' => $data["birthdate"],
            'address' => $data["address"],
            'parroquia_id' => $data["parroquia_id"],
            'sector_id' => $data["sector_id"],
            'subsector_id' => $data["subsector_id"],
            'celphone' => $data["celphone"],
            'whatsapp' => $data["whatsapp"],
            'email' => $data["email"],
            'last_names' => $data["last_names"],
            'type_client' => $data["type_client"],
            
        ]);
        return $client;
    }
}
