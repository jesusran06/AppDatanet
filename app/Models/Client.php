<?php

namespace App\Models;
use App\Models\ServiceRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['id', 
                            'names', 
                            'document', 
                            'address', 
                            'state_id', 
                            'municipio_id', 
                            'parroquia_id', 
                            'sector_id', 
                            'subsector_id', 
                            'celphone', 
                            'whatsapp', 
                            'email',
                            'last_names', 
                            'type_client',
                            'birthdate'
                        ];

    public function state(){
        return $this->belongsTo('states', 'state_id', 'id');
    }

    public function municipio(){
        return $this->belongsTo('municipios', 'municipio_id', 'id');
    }

    public function parroquia(){
        return $this->belongsTo('parroquias', 'parroquia_id', 'id');
    }

    public function existeCorreoElectronico($email)
    {
        $cliente = $this->where('email', $email)->first();
        return $cliente;
    }

    public function existeDocument($document)
    {
        $cliente = $this->where('document', $document)->first();
        return $cliente;
    }

}
