<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Odi;
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


class OdiExport implements FromQuery, WithHeadings, WithStyles, ShouldAutoSize
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
            'Contrato',
            'Cliente',
            'Documento',
            'Parroquia',
            'Sector',
            'Subsector',
            'Instalado',
            'Fecha de Instalación',
            'Carrete',
            'Medida Inicial de Carrete',
            'Medida Final de Carrete',
            'Mts de Fibra',
            'Nap',
            'Puerto en Nap',
            'Potencia en Nap',
            'Conector Rápido',
            'Pigtail',
            'Flejes',
            'Aros',
            'Termoencogible',
            'Rosetas',
            'Grapas',
            'Potencia en Cliente',
            'Retorno',
            'Onu (Serial)',
            'Instalador',
            'Fecha de Asignación',
            'Monto Recibido Divisas',
            'Seriales',
            'Monto Recibido en Bs',
            'Monto recibido por Transfrencia',
            'Referencia',
            'Monto Recibido por Zelle',
            'Correo',
            'Monto Recibido por Pago Movil',
            'Referencia',
            'Monto Recibido por Punto',
            'Referencia',
            'Total Recibido en Divisas',
            'Total Recibido en Bs',
            'Fecha de Aprobación',
            'Observaciones ODI',
            'Fecha de Venta',
            'Plan contratado',
            'Instalación',
            'Adelanto de Cable',
            'Monto por Cable',
            'Prorateo',
            'Monto por Prorateo',
            'Router',
            'Modelo',
            'Monto Recibido Divisas',
            'Seriales Divisas',
            'Monto recibido Bs',
            'Monto recibido por Zelle',
            'Correo',
            'Titular',
            'Monto por transferencia',
            'Referencia',
            'Monto Pago móvil',
            'Referencia',
            'Monto Punto de Venta',
            'Referencia',
            'Total recibido en Divisas',
            'Total recibido Bs',
            'Observaciones en Ventas'

            
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
        $odis =  Odi::select(
            'contracts.nro', 
            'contracts.social_razon', 
            'contracts.document' ,
            'parroquias.parroquia' ,
            'sectors.name as Sector' ,
            'subsectors.name as Subsector' ,
            DB::raw(" 
            CASE
                WHEN odis.instalated = 1 THEN 'SI'
                ELSE  'NO'
            END"),
            'odis.instalation_date',
            'odis.reel',
            'odis.reel_start_mts',
            'odis.reel_end_mts',
            'odis.total_distance',
            'naps.name as Nap',
            'odis.nap_port',
            'odis.nap_potency',
            'odis.fast_conector',
            'odis.pgtail',
            'odis.strapping',
            'odis.hoops',
            'odis.heat_shrinkable',
            'odis.rosettes',
            'odis.staples',
            'odis.client_potency',
            'odis.return_potency',
            'odis.onu_serial',
            'users.name as Instalador',
            'odis.asignated_date',
            'odis.mount_cash_dl',
            'odis.serials_cash_dl',
            'odis.mount_cash_bs',
            'odis.mount_bank_transfer',
            'odis.serial_bank_transfer',
            'odis.mount_zelle',
            'odis.serial_zelle',
            'odis.mount_movil_paid',
            'odis.serial_movil_paid',
            'odis.mount_point',
            'odis.serial_point',
            'odis.total_dls_received',
            'odis.total_bs_received',
            'odis.approved_date',
            'odis.observations as Obs',
            'service_requests.created_at',
            'plans.name as Plan_contratado',
            'instalations.name as Instalación',
            DB::raw(" 
            CASE
                WHEN service_requests.cable = 1 THEN 'SI'
                ELSE  'NO'
            END"), 
            'service_requests.mount_cable',
            DB::raw(" 
            CASE
                WHEN service_requests.prorateo = 1 THEN 'SI'
                ELSE  'NO'
            END"), 
            'service_requests.mount_prorateo',
            DB::raw(" 
            CASE
                WHEN service_requests.router = 1 THEN 'SI'
                ELSE  'NO'
            END"), 
            'service_requests.router_model',
            'service_requests.mount_cash_dl as cash_dls',
            'service_requests.serials_cash_dl as serials_dls',
            'service_requests.mount_cash_bs as cash_bs',
            'service_requests.mount_zelle as cash_zelle',
            'service_requests.serial_zelle as serias_zelle',
            'service_requests.titular_zelle as titular_zelle',
            'service_requests.mount_bank_transfer as cash_transfer',
            'service_requests.serial_bank_transfer as serials_transfer',
            'service_requests.mount_movil_paid as cash_movil_paid',
            'service_requests.serial_movil_paid as serials_movil_paid',
            'service_requests.mount_point as cash_point',
            'service_requests.serial_point as serials_point',
            'service_requests.total_dls_received as cash_received_dl',
            'service_requests.total_bs_received as cash_received_bs',
            'service_requests.observations as obs2'
        )
        ->join('contracts', 'odis.contract_id', '=', 'contracts.id')
        ->join('users', 'odis.instalator_id', '=', 'users.id')
        ->join('naps', 'contracts.nap_id', '=', 'naps.id')
        ->join('parroquias', 'contracts.parroquia_id', '=', 'parroquias.id')
        ->join('sectors', 'contracts.sector_id', '=', 'sectors.id')
        ->join('subsectors', 'contracts.subsector_id', '=', 'subsectors.id')
        ->join('service_requests', 'contracts.nro_contract', '=', 'service_requests.nro_contract')
        ->join('plans', 'contracts.plan_id', '=', 'plans.id')
        ->join('instalations', 'service_requests.instalation_id', '=', 'instalations.id');
        //->join('clients', 'contracts.client_id', '=', 'clients.id');




        /*->with([
            'contract',
            'contract.client',
            'contract.sector',
            'contract.subsector',
            'contract.nap',
            'contract.plan',
            'instalator',
            'contract.service_request',
            'contract.parroquia',
        ]);*/
        
       
       
            
            $now = Carbon::now()->format('Y-m-d');
            $hasta = ( $this->request->hasta == '') ? $now :  $this->request->hasta;

            if (( $this->request->desde != null) && ($hasta != null)) {
                $odis = $odis->whereRaw("DATE(instalation_date) BETWEEN '" .  $this->request->desde . "'" . " AND " . "'" . $hasta . "'");
                
            }
            if(!is_null( $this->request->instalator) ){
                $odis = $odis->whereIn('instalator_id',  $this->request->instalator);
            }
            
           
                if ( $this->request->subsector != "" &&  $this->request->subsector == "") {
                    $odis->where('contracts.subsector_id', '=',  $this->request->subsector);
                }
           
           
                if ( $this->request->sector != "" &&  $this->request->subsector == "") {
                    $odis->where('contracts.sector_id', '=',  $this->request->sector);
                }
           
           
                if ($this->request->parroquia != "" &&  $this->request->parroquia == "") {
                    $odis->where('contracts.parroquia_id', '=',  $this->request->parroquia);
                }
           
           
            //$odis->orderBy('contracts.nro_contract');
            
            
            
            
        return $odis;
                        

    }
}
