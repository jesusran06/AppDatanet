<template>
  <div
    class="modal fade"
    id="addNew"
    tabindex="-1"
    role="dialog"
    aria-labelledby="addNewLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" v-show="!editmode">
            Nueva Orden de Instalación
          </h5>
          <h5 class="modal-title" v-show="editmode">
            Actualizar Orden de Instalación
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            @click="clearForm"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- <form @submit.prevent="createUser"> -->

        <form @submit.prevent="editmode ? update() : create()">
          <div class="modal-body">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a
                  class="nav-item nav-link active"
                  id="nav-client-tab"
                  data-toggle="tab"
                  href="#nav-client"
                  role="tab"
                  aria-controls="nav-client"
                  aria-selected="true"
                  @click="nextTab(1)"
                  >Datos de Cliente</a
                >
                <a
                  class="nav-item nav-link"
                  id="nav-ubication-tab"
                  data-toggle="tab"
                  href="#nav-ubication"
                  role="tab"
                  aria-controls="nav-ubication"
                  aria-selected="true"
                  @click="nextTab(2)"
                  >Información de Cableado</a
                >
                <a
                  class="nav-item nav-link"
                  id="nav-service-tab"
                  data-toggle="tab"
                  href="#nav-service"
                  role="tab"
                  aria-controls="nav-service"
                  aria-selected="false"
                  @click="nextTab(3)"
                  >Información de Instalación</a
                >
                <a
                  class="nav-item nav-link"
                  id="nav-questionnarie-tab"
                  data-toggle="tab"
                  href="#nav-questionnarie"
                  role="tab"
                  aria-controls="nav-questionnarie"
                  aria-selected="false"
                  @click="nextTab(4)"
                  >Servicios Adicionales</a
                >
                <a
                  class="nav-item nav-link"
                  id="nav-gps-tab"
                  data-toggle="tab"
                  href="#nav-gps"
                  role="tab"
                  aria-controls="nav-gps"
                  aria-selected="false"
                  @click="nextTab(5)"
                  >Mapa</a
                >
              </div>
            </nav>
            <div class="tab-content mt-4" id="nav-tabContent">
              <div
                class="tab-pane fade show active"
                id="nav-client"
                role="tabpanel"
                aria-labelledby="nav-client-tab"
              >
                <div
                  class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                >
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Orden N°</label>
                        <div class="form-group">
                          <input
                            class="form-control"
                            type="text"
                            v-model="form.id"
                            disabled
                          />
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <label for="">N° Solicitud</label>
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.contract.service_request.num_form"
                          placeholder="N° de Planilla"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Contrato N°</label>
                        <input
                          v-model="form.contract.nro"
                          type="text"
                          name="name"
                          class="form-control"
                          disabled
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Cliente</label>
                        <input
                          type="text"
                          class="form-control"
                          name="client"
                          v-model="form.contract.social_razon"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">CI/Rif</label>
                        <input
                          type="text"
                          v-model="form.contract.document"
                          class="form-control"
                          disabled
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Teléfono</label>
                        <input
                          type="text"
                          v-model="form.contract.client.celphone"
                          name="celphone"
                          class="form-control"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Email</label>
                        <input
                          type="email"
                          v-model="form.contract.client.email"
                          name="email"
                          class="form-control"
                          disabled
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="">Dirección</label>
                        <textarea 
                          class="form-control" 
                          name="direccion" 
                          id="direccion" 
                          cols="30" 
                          rows="3"  
                          v-model="form.contract.client.address" 
                          disabled
                          style="resize: none;"
                          >
                        </textarea>
                      </div>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Sector</label>
                        <input
                          type="text"
                          v-model="form.contract.sector.name"
                          name="sector"
                          class="form-control"
                          disabled
                        />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Subsector</label>
                        <input
                          type="text"
                          v-model="form.contract.subsector.name"
                          name="subsector"
                          class="form-control"
                          disabled
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm">
                      <div class="form-group">
                        <label>Nap</label>
                        <v-select
                          :options="naps"
                          label="name"
                          v-model="form.contract.nap"
                          placeholder="Naps"
                        >
                        </v-select>
                        <!--input
                          v-model="form.contract.nap.name"
                          type="text"
                          name="plan"
                          class="form-control"
                          disabled
                        /-->
                      </div>
                    </div>
                    <div class="col-sm">
                      <div class="form-group">
                        <label>Plan Contratado</label>
                        <input
                          v-model="form.contract.plan.name"
                          type="text"
                          name="plan"
                          class="form-control"
                          disabled
                        />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Tipo de Instalación</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.contract.service_request.instalation.name"
                          disabled
                        />
                      </div>
                    </div>
                    
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Vendedor</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.contract.service_request.seller.name"
                          disabled
                        />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Dist.Aprox (Mts)</label>
                        <input
                          type="number"
                          class="form-control"
                          v-model="form.contract.service_request.distance"
                          disabled
                          inputmode="numeric"
                        />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Observaciones</label>
                        <textarea
                          name="observations"
                          id=""
                          cols="30"
                          rows="3"
                          v-model="form.contract.service_request.observations"
                          disabled
                          style="resize: none"
                        >
                        </textarea>
                      </div>
                    </div>
                    
                  </div>
                  <div class="row" v-if="user.role_id == 1">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Instalador Asignado</label>
                        <v-select
                          :options="instalators"
                          label="name"
                          v-model="form.instalator"
                          :clearable="clearable"
                          placeholder="Instaladores"
                          :class="{
                            'is-invalid': form.errors.has('instalator'),
                          }"
                        >
                        </v-select>
                        <has-error :form="form" field="instalator"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center" v-if="form.contract.service_request.cable == 1 || form.contract.service_request.prorateo == 1 || form.contract.service_request.mount_prorateo > 0">
                      <div class="col-sm-4 text-center">
                        <h4 class="mb-0">Adicionales</h4>
                      </div>
                  </div>
                  <div class="d-flex flex-row" v-if="form.contract.service_request.cable == 1">
                    <div class="p-1 col-sm-6">
                      <i class="fa fa-check blue" style="font-size:18px"></i>
                        <span><strong>Abono por Cable</strong> {{ (form.contract.service_request.mount_cable > 0) ? form.contract.service_request.mount_cable : '0.00' }} $</span>  
                      </div>
                  </div>
                  <div class="d-flex flex-row" v-if="form.contract.service_request.prorateo == 1">
                    <div class="p-1 col-sm-6">
                      <i class="fa fa-check blue" style="font-size:18px"></i>
                        <span><strong>Prorateo</strong> {{ (form.contract.service_request.mount_prorateo > 0) ? form.contract.service_request.mount_prorateo : '0.00' }} $</span>  
                      </div>
                  </div>
                  <div class="d-flex flex-row" v-if="form.contract.service_request.router == 1">
                    <div class="p-1 col-sm-6">
                      <i class="fa fa-check blue" style="font-size:18px"></i>
                        <span><strong>Adquisición de Router</strong> {{ form.contract.service_request.router_model }}</span>  
                      </div>
                  </div>
                </div>
              </div>
              <!-- tab de ubicacion -->
              <div
                class="tab-pane fade"
                id="nav-ubication"
                role="tabpanel"
                aria-labelledby="nav-ubication-tab"
              >
                <div
                  class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                >
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Carrete</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.reel"
                          placeholder="Carrete"
                          @input="form.reel=$event.target.value.toUpperCase()"
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Medida Inicial</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          class="form-control"
                          v-model="form.reel_start_mts"
                          pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==5) return false;"
                          placeholder="Medida Inicial"
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Medida Final</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          class="form-control"
                          v-model="form.reel_end_mts"
                          @input="compareSize"
                          
                          placeholder="Medida Final"
                          pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==5) return false;"
                        />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Mts Utilizados</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          disabled
                          v-model="distance_total"
                          class="form-control"
                          placeholder="Total Utilizados"
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Puerto en NAP</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          v-model="form.nap_port"
                          class="form-control"
                          placeholder="Puerto"
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Potencia en NAP</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          v-model="form.nap_potency"
                          class="form-control"
                          placeholder="Potencia"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Conector Rápido</label>
                        <input
                          class="form-control"
                          v-model="form.fast_conector"
                          placeholder="Conector"
                          type="number"
                          inputmode="numeric"
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Pigtail</label>
                        <input
                          class="form-control"
                          v-model="form.pgtail"
                          placeholder="Pigtail"
                          type="number"
                          inputmode="numeric"
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Fleje</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          class="form-control"
                          v-model="form.strapping"
                          placeholder="Flejes"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Aros</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          class="form-control"
                          v-model="form.hoops"
                          placeholder="Aros"
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Termoencogible</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          class="form-control"
                          v-model="form.heat_shrinkable"
                          placeholder="Termoencogible"
                        />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Rosetas</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          class="form-control"
                          v-model="form.rosettes"
                          placeholder="Rosetas"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-goup">
                        <label for="">Grapas</label>
                        <input
                          type="number"
                          inputmode="numeric"
                          class="form-control"
                          v-model="form.staples"
                          placeholder="Grapas"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin tab ubicacion-->
              <!-- Servicios -->
              <div
                class="tab-pane fade"
                id="nav-service"
                role="tabpanel"
                aria-labelledby="nav-service-tab"
              >
                <div
                  class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                >
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Potencia en Cliente</label>
                        <input 
                        type="number"
                        inputmode="numeric"
                        class="form-control"
                        v-model="form.client_potency"
                        placeholder="Potencia"
                        >
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Retorno</label>
                        <input 
                        type="number"
                        inputmode="numeric"
                        class="form-control"
                        v-model="form.return_potency"
                        placeholder="Potencia"
                        >
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Onu Instalada</label>
                        <input 
                        type="text"
                        inputmode="text"
                        class="form-control"
                        v-model="form.onu_serial"
                        placeholder="Serial"
                        >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Observaciones</label>
                      <textarea
                        placeholder="Observaciones sobre la instalación" 
                        name="observations"
                        id="observations" 
                        cols="30" 
                        rows="5" 
                        style="resize: none;" 
                        class="form-control"
                        v-model="form.observations"></textarea>
                    </div>
                    </div>

                  </div>
                </div>
              </div>
              <!-- fin servicio -->
              <div
                class="tab-pane fade"
                id="nav-questionnarie"
                role="tabpanel"
                aria-labelledby="nav-questionnarie-tab"
              >
                <div
                  class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                >
                 <!-- AQUI VAN LOS DATOS DE PAGOS ADICIONALES-->
                 <div class="row">
                      <div class="col-sm">
                        <div class="row form-group">
                          <!--label for="">Servicios Adicionales</label-->
                          <div v-for="(item, index) in services" :key="index" class="col-sm-6">
                            <input type="checkbox" v-model="selectedItems" :value="item">
                            <label>{{ item.name }}</label>
                        </div>
                          
                        </div>
                      </div>
                    </div>
                 <div>
                    <div class="row justify-content-center">
                      <div class="col-sm-4 text-center">
                        <h4 class="mb-0">Cargos Adicionales</h4>
                        <span class="" style="font-size: 0.7rem"
                          ><strong>BCV:{{ bcv.exchange.toFixed(3) }}</strong></span
                        >
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm">
                        <table class="table table-hover table-sm table-striped">
                          <thead>
                            <tr class="table-info">
                              <th style="width: 40%">Item</th>
                              <th style="width: 10%" class="text-center">Cantidad</th>
                              <th style="width: 10%" class="text-center">Precio</th>
                              <th style="width: 20%" class="text-center">
                                Monto Divisas
                              </th>
                              <th style="width: 20%" class="text-center">
                                Monto Bs.
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Mts de Cable Utilizados</td>
                              <td class="text-capitalize text-center">{{ distance_total }}</td>
                              <td class="text-capitalize text-center">
                                {{ cable_price }}<strong>$</strong>
                              </td>

                              <td class="text-capitalize text-center">
                                {{ (distance_total * cable_price).toFixed(2)
                                }}<strong></strong>
                              </td>
                              <td class="text-capitalize text-center">
                                {{ ((distance_total * cable_price)* bcv.exchange.toFixed(3)).toFixed(2)
                                }}<strong></strong>
                              </td>
                            </tr>
                            <tr v-for="it in selectedItems" :key="it.id">
                              <td class="text-capitalize">{{ it.name }}</td>
                              <td class="text-center text-center"> 1 </td>
                              <td class="text-capitalize text-center">
                                {{ it.price }}<strong>$</strong>
                              </td>
                              <td class="text-capitalize text-center">
                                {{ it.price }}<strong>$</strong>
                              </td>
                              <td class="text-capitalize text-center">
                                {{ (it.price * bcv.exchange).toFixed(2)
                                }}<strong></strong>
                              </td>
                            </tr>

                            <tr>
                              <td>
                                <p class="h6"><strong>IVA 16%</strong></p>
                              </td>
                              <td></td>
                              <td></td>
                              <td class="text-capitalize text-center"> - </td>
                              <td class="text-capitalize text-center">
                                <p class="h5" v-if="!isNaN(calcTotal)">
                                  <strong>{{ ((calcTotal * bcv.exchange * 16) / 100).toFixed(2)
                                }}</strong>
                                </p>
                                <p class="h5" v-else>
                                  <strong>{{ 0.00 }}</strong>
                                </p>
                              </td>
                            </tr>
                            
                          </tbody>
                          <tfoot>
                              <td class="text-capitalize" style="width: 60%">
                                <p class="h4"><strong>Total</strong></p>
                              </td>
                              <td></td>
                              <td></td>
                              <td class="text-capitalize text-center" style="width: 20%">
                                <p class="h4">
                                  <strong>{{ (calcTotal * 1).toFixed(2) }}$</strong>
                                </p>
                              </td>
                              <td class="text-capitalize text-center" style="width: 20%">
                                <p class="h4">
                                  <strong>{{  (parseFloat(((calcTotal * bcv.exchange * 16) / 100).toFixed(2)) + parseFloat((calcTotal * bcv.exchange.toFixed(3)).toFixed(2))).toFixed(2)
                                }}</strong>
                                </p>
                              </td>
                            </tfoot>
                        </table>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-sm-4 text-center">
                        <h4 class="mb-3">Descripción de pago</h4>
                      </div>
                    </div>
                    <div class="d-flex flex-row">
                      <div class="p-3 col-sm-4">
                       <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="cash_dl"
                          v-model="form.cash_dl"
                          value="1"
                          @change="addInfo($event)"
                        />
                        <label class="form-check-label" for="cash_dl"
                          >Divisas en efectivo</label
                        >
                      </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input inputmode="numeric" v-model="form.mount_cash_dl" class="form-control" :disabled="disabled_cash_dl" placeholder="Monto">
                      </div>
                      <div class="p-2 col-sm-4">
                        <input type="text" v-model="form.serials_cash_dl" class="form-control" :disabled="disabled_cash_dl" placeholder="Seriales de Billetes">
                      </div>

                    </div>

                    <div class="d-flex flex-row">
                      <div class="p-3 col-sm-4">
                       <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="cash_bs"
                          v-model="form.cash_bs"
                          value="1"
                          @change="addInfo($event)"
                        />
                        <label class="form-check-label" for="cash_dl"
                          >Bs. en efectivo</label
                        >
                      </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input inputmode="numeric" v-model="form.mount_cash_bs" class="form-control" :disabled="disabled_cash_bs" placeholder="Monto">
                      </div>
                      <!--div class="p-2 col-sm-4">
                        <input type="text" v-model="form.serials_cash_bs" class="form-control" :disabled="disabled_cash_bs">
                      </div-->

                    </div>
                    <div class="d-flex flex-row">
                      <div class="p-3 col-sm-4">
                       <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="zelle"
                          v-model="form.zelle"
                          value="1"
                          @change="addInfo($event)"
                        />
                        <label class="form-check-label" for="zelle"
                          >Zelle</label
                        >
                      </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input inputmode="numeric" v-model="form.mount_zelle" class="form-control" :disabled="disabled_zelle" placeholder="Monto">
                      </div>
                      <div class="p-2 col-sm-4">
                        <input inputmode="email" v-model="form.serial_zelle" class="form-control" :disabled="disabled_zelle" placeholder="Email">
                      </div>

                    </div>
                    <div class="d-flex flex-row" v-if="show_zelle">
                      <div class="p-3 col-sm-4"></div>
                        <div class="p-2 col-sm-4">
                          <input
                            inputmode="text"
                            v-model="form.titular_zelle"
                            class="form-control"
                            :disabled="disabled_zelle"
                            placeholder="Titular de Cuenta"
                            @input="
                            form.titular_zelle = $event.target.value.toUpperCase()
                          "
                          />
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                      <div class="p-3 col-sm-4">
                       <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="bank_transfer"
                          v-model="form.bank_transfer"
                          value="1"
                          @change="addInfo($event)"
                        />
                        <label class="form-check-label" for="bank_transfer"
                          >Transferencia Bancaria</label
                        >
                      </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input inputmode="numeric" v-model="form.mount_bank_transfer" class="form-control" :disabled="disabled_bank_transfer" placeholder="Monto">
                      </div>
                      <div class="p-2 col-sm-4">
                        <input type="text" v-model="form.serial_bank_transfer" class="form-control" :disabled="disabled_bank_transfer" placeholder="Referencia">
                      </div>

                    </div>
                    <div class="d-flex flex-row">
                      <div class="p-3 col-sm-4">
                       <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="movil_paid"
                          v-model="form.movil_paid"
                          value="1"
                          @change="addInfo($event)"
                        />
                        <label class="form-check-label" for="movil_paid"
                          >Pago Móvil</label
                        >
                      </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input inputmode="numeric" v-model="form.mount_movil_paid" class="form-control" :disabled="disabled_movil_paid" placeholder="Monto">
                      </div>
                      <div class="p-2 col-sm-4">
                        <input type="text" v-model="form.serial_movil_paid" class="form-control" :disabled="disabled_movil_paid" placeholder="Referencia">
                      </div>

                    </div>
                    <div class="d-flex flex-row">
                      <div class="p-3 col-sm-4">
                       <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="point"
                          v-model="form.point"
                          value="1"
                          @change="addInfo($event)"
                        />
                        <label class="form-check-label" for="movil_point"
                          >Punto de Venta</label
                        >
                      </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input inputmode="numeric" v-model="form.mount_point" class="form-control" :disabled="disabled_point" placeholder="Monto">
                      </div>
                      <div class="p-2 col-sm-4">
                        <input type="text" v-model="form.serial_point" class="form-control" :disabled="disabled_point" placeholder="Referencia">
                      </div>

                    </div>
                  </div>

                  <div class="row justify-content-center mt-4">
                      <div class="col-sm-4 text-center">
                        <h4 class="mb-0">Total Recibido</h4>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm">
                        <table class="table table-hover table-sm table-striped">
                          <thead>
                            <tr class="table-info">
                              <th style="width: 50%" class="text-center">
                                Monto Divisas
                              </th>
                              <th style="width: 50%" class="text-center">
                                Monto Bs.
                              </th>
                            </tr>
                          </thead>
                          <tr>
                            <td class="text-capitalize text-center">{{  calcDiv }}</td>
                            <td class="text-capitalize text-center">{{  calcBs }}</td>
                          </tr>
                          <tbody>
                          </tbody>  
                      </table>
                      </div>
                    </div>
                  
                  
                </div>
              </div>
              
              <div
                class="tab-pane fade"
                id="nav-gps"
                role="tabpanel"
                aria-labelledby="nav-gps-tab"
              >
                
              <button class="btn btn-primary mb-2" type="button" @click="watchMap"><i class="fa fa-map-marker mr-2"></i>Ver Ubicación</button>
              <main class="text-center">
                  
                      <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                  
              </main>
              <div id="map2" style="width: 100%; height: 400px;" class="row justify-content-center"></div>  
            </div>
          
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="clearForm"
            >
              Cerrar
            </button>
            <button
              v-show="editmode"
              type="submit"
              class="btn btn-success"
              v-if="actualTab == 4 && (user.role_id == 1 || user.role_id == 5)"
            >
              Actualizar
            </button>
            <button
              v-show="editmode"
              type="button"
              class="btn btn-primary"
              v-if="actualTab == 4 && (user.role_id == 1 || user.role_id == 5) && !isNaN(calcTotal)"
              @click.prevent="finish"

            >
              Finalizar
            </button>
            <button
              v-show="!editmode"
              type="submit"
              class="btn btn-primary"
              v-if="actualTab == 4"
            >
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import mapboxgl from 'mapbox-gl';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'


export default {
  props: {
    editmode: {
      type: Boolean,
    },
  },
  components:{
    PulseLoader
  },
  data() {
    return {
      selectedItems: [],
      form: new Form({
        id: "",
        instalator: [],
        observations: "",
        contract: {
          id: "",
          social_razon: "",
          document: "",
          //total_distance: 0,
          service_request: {
            num_form: "",
            distance: "",
            seller: {
              name: "",
            },
            instalation: {
              name: "",
            },
            observations: "",
            router: '',
            router_model: '',
            router_serial: '',
            cable:'',
            mount_cable:'',
            mount_prorateo: '',
            prorateo: '',
          },
          client: {
            celphone: "",
            email: "",
            address: "",
          },
          sector: {
            name: "",
          },
          nap: {
            id: "",
            name: "",
          },
          plan: {
            name: "",
          },
          subsector: {
            name: "",
          },

        },
        reel: "",
        reel_start_mts: 0,
        reel_end_mts: 0,
        nap: "",
        nap_port: "",
        nap_potency: "",
        total_distance: 0,
        fast_conector: "",
        pgtail: "",
        strapping: "",
        hoops: "",
        heat_shrinkable: "",
        rosettes: "",
        staples: "",
        onu_serial: "",
        client_potency: "",
        return_potency: "",
        cash_dl: false,
        mount_cash_dl:0,
        serials_cash_dl: '',
        cash_bs: false,
        mount_cash_bs: 0,
        serials_cash_bs: '',
        bank_transfer: false,
        mount_bank_transfer:0,
        serial_bank_transfer: '',
        zelle: false,
        mount_zelle: 0,
        serial_zelle: '',
        email_zelle: '',
        movil_paid: false,
        mount_movil_paid: 0,
        serial_movil_paid: '',
        point: false,
        mount_point: 0,
        serial_point: '',
        total_dls_received:0,
        total_bs_received:0,
        amount_total:0,
        titular_zelle:''
      }),
      actualTab: "",
      instalators: [],
      clearable: true,
      bcv:{
        exchange: 0
      },
      services:[],
       disabled_cash_dl: true,
      disabled_cash_bs: true,
      disabled_bank_transfer: true,
      disabled_zelle: true,
      disabled_movil_paid: true,
      disabled_point: true,
      amount_total:0,
      user: window.user,
      nap_clearable: true,
      naps:[],
      accessToken: 'pk.eyJ1IjoicmVkbGVvbiIsImEiOiJjbGgxMzZtcTkwZDNpM2txb2RrY3k0ZWk5In0.w5l9ROdTknAIzsS-EvdHoA',
      mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
      map: '',
      loading: false,
      color: '#FFDAB9',
      size: '20px',
      limit: 5,
      show_zelle: false,
      argumentResolutionError:'',
      length:''
    };
  },
  mounted() {
    
    
    
  },
  created() {
   
    this.techUsers();
    this.get_price_dollar();
    this.getServices();
    this.getNaps();
    //this.mapbox = Mapbox;
  },
  computed: {
    distance_total: {
      get:function(){
        if(parseFloat(this.form.reel_end_mts) > parseFloat(this.form.reel_start_mts)){
          this.form.total_distance = 0;  
        }else{
          this.form.total_distance = parseFloat(this.form.reel_start_mts) - parseFloat(this.form.reel_end_mts);
        }
        
        return this.form.total_distance
      },
      set:function(newValue){
       
      }
      
    },
    cable_price(){
      if(this.form.total_distance < 150){
        return 0.3
      }else if(this.form.total_distance >= 150 && this.form.total_distance < 250){
        return 0.25
      }else{
        return 0.2
      }
    },
    calcTotal(){
      let cable = (this.distance_total * this.cable_price).toFixed(2)
      this.amount_total = 0;
      this.selectedItems.forEach((it) => {
        this.amount_total = (parseFloat(this.amount_total) + parseFloat(it.price)).toFixed(2);
      });
      this.amount_total = parseFloat(this.amount_total) + parseFloat(cable);
      return this.amount_total.toFixed(2);
    },
    calcDiv(){
      return (this.calcBs/this.bcv.exchange).toFixed(2);
    },
    calcBs(){
      this.form.mount_cash_dl = (this.form.mount_cash_dl == null) ? 0 : this.form.mount_cash_dl;
      this.form.mount_cash_bs = (this.form.mount_cash_bs == null) ? 0 : this.form.mount_cash_bs;
      this.form.mount_zelle = (this.form.mount_zelle ==  null) ? 0 : this.form.mount_zelle;
      this.form.mount_bank_transfer = (this.form.mount_bank_transfer == null) ? 0 : this.form.mount_bank_transfer;
      this.form.mount_movil_paid = (this.form.mount_movil_paid == null) ? 0 : this.form.mount_movil_paid;
      this.form.mount_point = (this.form.mount_point == null) ? 0 : this.form.mount_point;
      return (parseFloat(this.form.mount_cash_dl * this.bcv.exchange) + parseFloat(this.form.mount_cash_bs) + parseFloat(this.form.mount_zelle * this.bcv.exchange) + parseFloat(this.form.mount_bank_transfer) + parseFloat(this.form.mount_movil_paid) + parseFloat(this.form.mount_point)).toFixed(2);
    }
  },
  methods: {
    nextTab(val) {
      this.actualTab = val;
    },
    
    techUsers() {
      axios.get("api/user/role/" + 5).then((response) => {
        
        this.instalators = response.data.data.data;
      });
    },
    get_price_dollar() {
      axios.get("api/bcv").then((response) => {
        this.bcv = response.data[0];
        
      });
    },
    getServices(){
      axios.get('api/services').then((response) => {
        this.services = response.data
        
      })
    },
    addInfo(e){
      //console.log(e)
     if (e.target) {
      if(e.target.id == "cash_dl"){
        this.disabled_cash_dl = (e.target.checked) ? false : true;
        this.form.mount_cash_dl = (!e.target.checked) ? 0 : this.form.mount_cash_dl; 
        this.form.serials_cash_dl = (!e.target.checked) ? '' : this.form.serials_cash_dl;
      }else if(e.target.id == "cash_bs"){
        this.disabled_cash_bs = (e.target.checked) ? false : true;
        this.form.mount_cash_bs = (!e.target.checked) ? 0 : this.form.mount_cash_bs; 
        //this.form.serials_cash_bs = (!e.target.checked) ? '' : this.form.serials_cash_bs;
      }else if(e.target.id == "zelle"){
        this.show_zelle = !this.show_zelle;
        this.disabled_zelle = (e.target.checked) ? false : true;
        this.form.mount_zelle = (!e.target.checked) ? 0 : this.form.mount_zelle; 
        this.form.serial_zelle = (!e.target.checked) ? '' : this.form.serial_zelle;
      }else if(e.target.id == "bank_transfer"){
        this.disabled_bank_transfer = (e.target.checked) ? false : true;
        this.form.mount_bank_transfer = (!e.target.checked) ? 0 : this.form.mount_bank_transfer; 
        this.form.serial_bank_transfer = (!e.target.checked) ? '' : this.form.serial_bank_transfer;
      }else if(e.target.id == "movil_paid"){
        this.disabled_movil_paid = (e.target.checked) ? false : true;
        this.form.mount_movil_paid = (!e.target.checked) ? 0 : this.form.mount_movil_paid; 
        this.form.serial_movil_paid = (!e.target.checked) ? '' : this.form.serial_movil_paid;
      }else if(e.target.id == "point"){
        this.disabled_point = (e.target.checked) ? false : true;
        this.form.mount_point = (!e.target.checked) ? 0 : this.form.mount_point; 
        this.form.serial_point = (!e.target.checked) ? '' : this.form.serial_point;
      }
      
       
    }
    },
    update(){
      Swal.fire({
        title: "Esta seguro",
        text: "de actualizar los datos esta instalación ?",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.value) {
          this.form.total_bs_received = this.calcBs;
          this.form.total_dls_received = this.calcDiv;
          this.form.nap =  this.form.contract.nap.id;
          this.form.amount_total = this.amount_total;
          this.$Progress.start();
      this.form.put(`api/odis/update/${this.form.id}`)
        .then((response) => {
            $('#addNew').modal('hide');
            if(response.status == 201){
                Toast.fire({
                    icon: "success",
                    title: response.data.message,
                });
                this.$Progress.finish();
                this.actualTab = '1';
                //this.clearForm();
                $('a[href="#nav-ubication"]').removeClass('active');
                $('a[href="#nav-service"]').removeClass('active');
                $('a[href="#nav-questionnarie"]').removeClass('active');
                $('a[href="#nav-client"]').tab("show");
                this.show_zelle = false;
                this.$emit("reloadOdis");
            } else {
                Toast.fire({
                    icon: "error",
                    title: "Ups, ocurrió un error que resolveremos lo antes posible",
                });
            }
        })
        }
      });
      
    },
    finish(){
      Swal.fire({
        title: "Esta seguro",
        text: "de finalizar esta instalación ?",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.value) {
          this.form.total_bs_received = this.calcBs;
          this.form.total_dls_received = this.calcDiv;
          this.form.nap =  this.form.contract.nap.id;
          this.form.amount_total = this.amount_total;
          this.$Progress.start();
          this.form.put(`api/odis/finish/${this.form.id}`)
          .then((response) => {
            $('#addNew').modal('hide');
            if(response.status == 201){
                this.$emit("reloadOdis");
                Toast.fire({
                    icon: "success",
                    title: response.data.message,
                });
                this.$Progress.finish();
                this.actualTab = '1';
                this.clearForm();
                $('a[href="#nav-ubication"]').removeClass('active');
                $('a[href="#nav-service"]').removeClass('active');
                $('a[href="#nav-questionnarie"]').removeClass('active');
                $('a[href="#nav-client"]').tab("show");
                
            } else {
                Toast.fire({
                    icon: "error",
                    title: response.data.message,
                });
            }
        })
        }
      });
      
      
    },
    clearForm(){
      $('a[href="#nav-ubication"]').removeClass('active');
      $('a[href="#nav-service"]').removeClass('active');
      $('a[href="#nav-questionnarie"]').removeClass('active');
      $('a[href="#nav-client"]').tab("show");
      this.form.reset();
      this.selectedItems = [];
      this.show_zelle = false;
      //this.map.remove();
    },
    getNaps(){
      axios.get("api/nap/all").then((response) => {
       // console.log(response)
        this.naps = response.data;
        
      });
    },
    compareSize(){
      //console.log()
      if(parseFloat(this.form.reel_end_mts) > parseFloat(this.form.reel_start_mts))
      {
        Toast.fire({
            icon: "error",
            title: "La media final NO puede ser mayor a la inicial",
        });
        this.distance_total = 0;

      }
    },
    watchMap(){
        if(this.map){
          this.map.remove()
        } 
        let client_pos = JSON.parse(this.form.contract.gps)
        this.loading = true;
        if (navigator.geolocation) {
          if (!mapboxgl.supported()) {
            alert('Your browser does not support Mapbox GL');
          } else {
          navigator.geolocation.getCurrentPosition(
            (position) => {
              const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
              };
              //console.log("pos", pos) 
              mapboxgl.accessToken = 'pk.eyJ1IjoicmVkbGVvbiIsImEiOiJjbGgxMzZtcTkwZDNpM2txb2RrY3k0ZWk5In0.w5l9ROdTknAIzsS-EvdHoA';
               this.map = new mapboxgl.Map({
                container: 'map2',
                style: 'mapbox://styles/mapbox/satellite-v9',
                center: [pos.lng, pos.lat], 
                zoom: 17
              });
              var popup = new mapboxgl.Popup({ offset: 25 }).setText("Cliente: " + this.form.contract.social_razon);
              let lngClient = (this.form.contract.gps) ? client_pos.lng : pos.lng;
              let latClient = (this.form.contract.gps) ? client_pos.lat : pos.lat;
              const el = document.createElement('div');
              el.className = 'marker2';
              const marker = new mapboxgl.Marker(el)
                .setLngLat([lngClient, latClient])
                .setPopup(popup)
                .addTo(this.map);
                const nav = new mapboxgl.NavigationControl();
                this.map.addControl(nav, "top-right");
                const geolocate = new mapboxgl.GeolocateControl({
                positionOptions: {
                  enableHighAccuracy: true
                },
                  trackUserLocation: true
                });
                this.map.addControl(geolocate, "top-right")
                this.loading = false;
            },
            (error) => {
              console.log("error", error)
              //handleLocationError(true, infoWindow, map.getCenter());
            }
          );
          


          

          
          }
        }
    }
   
  },
};
</script>
<style>
#map {
  height: 400px;
  width: 100%;
}
.marker2 {
  background-image: url('/images/image.png');
  background-size: cover;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  cursor: pointer;
}
</style>