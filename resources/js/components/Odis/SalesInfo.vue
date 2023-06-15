<template>
    <div
    class="modal fade"
    id="showInfo"
    tabindex="-1"
    role="dialog"
    aria-labelledby="showInfoLabel"
    aria-hidden="true"
  >
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content"> 
                <div class="modal-header justify-content-between">
                <!--h5 class="modal-title">
                    <strong>Información de Venta N°</strong> {{  request.id }}
                </h5-->
                <h5 class="modal-title">
                    <!--<strong>Contrato N°</strong> {{  (request.nro_contrato) }}-->
                </h5>
                
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="container-fluid">
                    <div class="row my-4">
                        <div class="col-md-4">
                            <span class="h5"><strong>Cliente:</strong> {{  request.social_razon }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>Documento: </strong> {{ (request.service_request.type_client == 'N' || request.service_request.type_client == 'n') ? request.service_request.document2 : request.service_request.document}}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>Email:</strong> {{  request.service_request.email }}</span>
                        </div>

                    </div>
                    <div class="row my-4">
                        <div class="col-md-4">
                            <span class="h5"><strong>Tel/Wsp</strong> {{  request.service_request.celphone+'/'+request.service_request.whatsapp }}</span>
                            
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>Dirección:</strong> {{  request.service_request.address }}</span>
                            
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>NAP:</strong> {{  (request.nap) ? request.nap.name : 'No seleccionada' }}</span>
                            
                        </div>
                        

                    </div>
                    <!--div class="row my-4">
                        <div class="col-md-4">
                            <span class="h5"><strong>Parroquia:</strong> {{  request.parroquia.parroquia }}</span>
                            
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>Sector:</strong> {{  request.sector.name }}</span>
                            
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>Subsector:</strong> {{  (request.subsector ) ? request.subsector.name : 'Desconocido' }}</span>
                            
                        </div>
                        

                    </div>
                    <div class="row my-4">
                        
                        <div class="col-md-4">
                            <span class="h5"><strong>Plan Solicitado:</strong> {{  request.plan.name }}</span>
                            
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>Instalación:</strong> {{  request.instalation.name }}</span>
                            
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>Fecha de Venta:</strong> {{  request.created_date }}</span>
                            
                        </div>
                    </div>    
                    <div class="row my-4">
                        <div class="col-md-4">
                            <span class="h5"><strong>Vendedor:</strong> {{  request.seller.name }}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="h5"><strong>Fecha de Aprobación:</strong> {{  request.approved_date }}</span>
                        </div>
                    </div>
                    <div-- class="row my-4">
                        <div class="col-md-12">
                            <span class="h5"><strong>Observaciones:</strong> {{  request.observations }}</span>
                        </div>
                    </div-->
                    <hr>
                    <div class="row justify-content-center">
                      <div class="col-sm-4 text-center">
                        <h4 class="mb-0">Facturación</h4>
                        <!--span class="" style="font-size: 0.7rem"
                          ><strong
                            >BCV: {{ bcv.exchange.toFixed(3) }}</strong
                          ></span
                        -->
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-8">
                        <table class="table table-hover table-sm table-striped">
                          <thead>
                            <tr class="table-info">
                              <th style="width: 60%">Item</th>
                              <th style="width: 40%" class="text-center">
                                Monto Divisas
                              </th>
                              <!--th style="width: 20%" class="text-center">
                                Monto Bs.
                              </th-->
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td>Instalación {{ request.service_request.instalation.name }}</td>
                                <td class="text-center">{{  parseFloat(request.service_request.instalation.total_cost).toFixed(2) }}<strong></strong></td>
                            </tr>
                            <tr>
                                <td>Plan {{ request.plan.name }}</td>
                                <td class="text-center">{{  parseFloat(request.plan.price).toFixed(2) }}<strong></strong></td>
                            </tr>
                            <tr v-if="request.cable == 1">
                                <td>Abono Cable</td>
                                <td class="text-center">{{  parseFloat(request.service_request.mount_cable).toFixed(2) }}<strong></strong></td>
                            </tr>
                            <tr v-if="request.prorateo == 1">
                                <td>Abono Cable</td>
                                <td class="text-center">{{  parseFloat(request.service_request.mount_prorateo).toFixed(2) }}<strong></strong></td>
                            </tr>
                             <tr v-if="request.router == 1">
                                <td>{{ request.router_model.name }}</td>
                                <td class="text-center">{{ parseFloat(request.service_request.router_model.price).toFixed(2)  }}<strong></strong></td>
                            </tr>
                         </tbody>
                         <tfoot>
                            <td class="text-capitalize">
                              <p class="h4"><strong>Total</strong></p>
                            </td>
                            <td class="text-capitalize text-center">
                              <p class="h4"><strong>{{ parseFloat(request.service_request.invoice_total).toFixed(2) }}</strong></p>
                            </td>

                         </tfoot>
                         </table>
                        </div>
                    </div>
                    <br>
                    <div class="row justify-content-center">
                      <div class="col-sm-4 text-center">
                        <h4 class="mb-0">Pago Realizado</h4>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-8">
                        <table class="table table-hover table-sm table-striped">
                          <thead>
                            <tr class="table-info">
                              <th style="width: 40%">Método</th>
                              <th style="width: 30%" class="text-center">
                                Monto
                              </th>
                              <th style="width: 30%" class="text-center">
                                Descripción
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="it in request.service_request.paid_forms" :key="it.id">
                                <td>{{ it.name }}</td>
                                <td class="text-center">{{  parseFloat(it.mount).toFixed(2) }}<strong></strong></td>
                                <td class="text-center">{{  it.description }}<strong></strong></td>
                            </tr>
    
                         </tbody>
                         
                         </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Observación</label>
                            <p class="red">{{  request.service_request.observations }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            >
                            Cerrar
                            </button>
                    </div>
                </div>        
                

            </div>
        </div>
  </div>
</template>
<script>
export default {
    props:{
        request:{
            type: Object,
            default: null
        }
    },
    data() {
        return {
            //request: []
        }
    },
}
</script>
