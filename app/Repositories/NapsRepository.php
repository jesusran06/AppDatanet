<?php

namespace App\Repositories;
use App\Models\Nap;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Exception;

//use Your Model

/**
 * Class NapsRepository.
 */
class NapsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Nap::class;
    }

    public function getNaps(){
        $naps = $this->with('Subsector')->with('Sector')->with('Sector.parroquia')->with('Sector.subsectors')->paginate(20);
        foreach($naps as $key=>$nap){
            $naps[$key]->parroquia = $nap->sector->parroquia;
            $naps[$key]->subsectors = $nap->sector->subsectors;
        }
        return $naps;
    }

    public function createNap($data){
        try {
            $nap = $this->create($data);
            return $nap;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function updateNap($data, $id){
        $nap = $this->updateById($id, $data);
        return $nap;
    }

    public function deleteNap($id){
        try {
            $nap = $this->deleteById($id);    
            return $nap;
        } catch (\Throwable $th) {
            return  $th;
        }
    }

    public function getAll(){
        return $this->all();
    }
    public function filter($search){
        $result= Nap::join('sectors', 'naps.sector_id', 'sectors.id')
                ->join('parroquias', 'sectors.parroquia_id', 'parroquias.id')
                ->Where('sectors.name','LIKE',"%$search%")
                ->orWhere('parroquias.parroquia','LIKE',"%$search%")
                ->orWhere('naps.name','LIKE',"%$search%")
                ->orWhere('naps.nro','LIKE',"%$search%")
                ->select('naps.*', 'sectors.name as sectorName')
                ->with('Sector')
                ->with('Sector.Parroquia')
                ->orderBy('naps.created_at','asc')->paginate(5);
        foreach($result as $key=>$nap){
            $result[$key]->parroquia = $nap->sector->parroquia;
        }
        return $result;
    }
}
