<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ServiceRequestExport implements FromQuery, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'N° de Venta',
            'Contrato',
            'Cliente',
            'Documento',
            'Telefono',
            'Email',
            'Dirección',
            'Parroquia',
            'Sector',
            'Subsector',
            'Vendedor',
            'Fecha de Venta',
            'Plan',
            'Instalación',
            'Dolares',
            'Seriales',
            'Bolivares',
            'Transferencia Bancaria',
            'Nro de Referencia',
            'Zelle',
            'Email Zelle',
            'Titular Zelle',
            'Pago Móvil',
            'Referencia Pago Móvil',
            'Pago por Punto',
            'Nro de Referencia',
            'Router',
            'Modelo de Router',
            'Serial',
            'Pago Cable?',
            'Monto abonado',
            'Prorateo',
            'Monto abonado prorateo',
            'Monto Total recibido',
            'Observaciones'
            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function query()
    {
        $sales = ServiceRequest::select(
            'service_requests.id as num_venta',
            'service_requests.nro_contract',
            'service_requests.social_razon',  
            DB::raw(" 
                CASE
                    WHEN type_client = 'J' THEN document
                    WHEN type_client = 'N' THEN document2
                END"), 
            'service_requests.celphone',
            'service_requests.email',
            'service_requests.address',
            'parroquias.parroquia',
            'sectors.name as secotr',
            'subsectors.name as subsector',
            'users.name as vendedor',
            'service_requests.created_at',
            'plans.name as plan',
            'instalations.name',
            'service_requests.mount_cash_dl',
            'service_requests.serials_cash_dl',
            'service_requests.mount_cash_bs',
            'service_requests.mount_bank_transfer',
            'service_requests.serial_bank_transfer',
            'service_requests.mount_zelle',
            'service_requests.serial_zelle',
            'service_requests.titular_zelle',
            'service_requests.mount_movil_paid',
            'service_requests.serial_movil_paid',
            'service_requests.mount_point',
            'service_requests.serial_point',
            DB::raw(" 
                CASE
                    WHEN router = 1 THEN 'SI'
                    ELSE  'NO'
            END"), 
            'service_requests.router_model',
            'service_requests.router_serial',
            DB::raw(" 
                CASE
                    WHEN cable = 1 THEN 'SI'
                    ELSE  'NO'
            END"),
            'service_requests.mount_cable',
            DB::raw(" 
                CASE
                    WHEN prorateo = 1 THEN 'SI'
                    ELSE  'NO'
            END"),
            'service_requests.mount_prorateo',
            'service_requests.total_dls_received',
            'service_requests.observations'
        );
        
        $sales->where('approved', true)
            ->join('parroquias', 'service_requests.parroquia_id', '=', 'parroquias.id')
            ->join('sectors', 'service_requests.sector_id', '=', 'sectors.id')
            ->join('subsectors', 'service_requests.subsector_id', '=', 'subsectors.id')
            ->join('users', 'service_requests.seller_id', '=', 'users.id')
            ->join('plans', 'service_requests.plan_id', '=', 'plans.id')
            ->join('instalations', 'service_requests.instalation_id', '=', 'instalations.id');
       
            
            $now = Carbon::now()->format('Y-m-d');
            $hasta = ($this->request->hasta == '') ? $now : $this->request->hasta;

            if (($this->request->desde != null) && ($hasta != null)) {
                $sales = $sales->whereRaw("DATE(service_requests.created_at) BETWEEN '" . $this->request->desde . "'" . " AND " . "'" . $hasta . "'");
                
            }
            if(!is_null($this->request->seller) ){
                $sales = $sales->whereIn('seller_id', $this->request->seller);
            }
            
            if($this->request->parroquia != ""){
                $sales = $sales->where('service_requests.parroquia_id', $this->request->parroquia);
            }
            if($this->request->sector != ""){
                $sales = $sales->where('service_requests.sector_id', $this->request->sector);
                
            }
            if($this->request->subsector != "" ){
                $sales = $sales->where('service_requests.subsector_id', $this->request->subsector);
            }
            
            
            
        
        $sales->orderBy('service_requests.nro_contract');
        return $sales;
                        

    }
}
