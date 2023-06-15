<template>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <strong
                    >Información de Contrato N° {{ data.contract.nro }}</strong
                  >
                  
                </h3>
                <div class="card-tools" v-if="user.role_id == 1">
                  <router-link to="/manage-odis" class="nav-link">
                    <i class="fa fa-arrow-left nav-icon blue"></i>
                    <span>Regresar</span>
                  </router-link>
                </div>
                <div class="card-tools" v-else>
                  <router-link to="/install-odis" class="nav-link">
                    <i class="fa fa-arrow-left nav-icon blue"></i>
                    <span>Regresar</span>
                  </router-link>
                </div>
                
              </div>
              <div class="card-body">
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
                      id="nav-tech-tab"
                      data-toggle="tab"
                      href="#nav-tech"
                      role="tab"
                      aria-controls="nav-tech"
                      aria-selected="true"
                      @click="nextTab(2)"
                      >Datos de Técnicos</a
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
                      >Datos de Servicio</a
                    >
                    <a
                      class="nav-item nav-link"
                      id="nav-sales-tab"
                      data-toggle="tab"
                      href="#nav-sales"
                      role="tab"
                      aria-controls="nav-sales"
                      aria-selected="false"
                      @click="nextTab(4)"
                      >Datos de Venta</a
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
                      <div class="card-deck">
                        <div class="card">
                          <div class="card-header text-white bg-info">
                            <div class="d-flex justify-content-between">
                              <strong>Datos Personales</strong>
                              <i class="fa fa-user white"></i>
                            </div>
                          </div>
                          <div class="card-body">
                            <!--CARD Datos Personales-->
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Cliente / Razón Social: </span>
                                </strong>
                                <p>{{ data.contract.social_razon }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Cédula / Rif: </span>
                                </strong>
                                <p>{{ data.contract.document }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Télefono: </span>
                                </strong>
                                <p>{{ data.contract.client.celphone }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Whatsapp: </span>
                                </strong>
                                <p>{{ data.contract.client.whatsapp }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Correo Electrónico:</span>
                                </strong>
                                <p>{{ data.contract.client.email }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Cumpleaños:</span>
                                </strong>
                                <p>{{ data.contract.client.birthday }}</p>
                              </div>
                            </div>
                          </div>
                        </div>
  
                        <div class="card">
                          <div class="card-header text-white bg-info">
                            <div class="d-flex justify-content-between">
                              <strong>Ubicación</strong>
                              <i class="fa fa-map white"></i>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Parroquia: </span>
                                </strong>
                                <p>{{ data.contract.parroquia.parroquia }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Sector: </span>
                                </strong>
                                <p>{{ data.contract.sector.name }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Subsector:</span>
                                </strong>
                                <p>{{ data.contract.subsector.name }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Dirección: </span>
                                </strong>
                                <p>{{ data.contract.client.address }}</p>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade show"
                    id="nav-tech"
                    role="tabpanel"
                    aria-labelledby="nav-tech-tab"
                  >
                    <div
                      class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                    >
                      <div class="card-deck">
                        <div class="card">
                          <div class="card-header text-white bg-info">
                            <div class="d-flex justify-content-between">
                              <strong>Cableado</strong>
                              <i class="fa fa-plug white"></i>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Nap: </span>
                                </strong>
                                <p>{{ data.contract.nap.name }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Puerto: </span>
                                </strong>
                                <p>{{ data.nap_port }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Carrete: </span>
                                </strong>
                                <p>{{ data.reel }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Mts de Cable Utilizados: </span>
                                </strong>
                                <p>{{ data.total_distance }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Potencia en Nap: </span>
                                </strong>
                                <p>{{ data.nap_potency }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Conector Rápido: </span>
                                </strong>
                                <p>{{ data.fast_conector }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Pigtail: </span>
                                </strong>
                                <p>{{ data.pgtail }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Flejes: </span>
                                </strong>
                                <p>{{ data.strapping }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Aros: </span>
                                </strong>
                                <p>{{ data.hoops }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Termoencogible: </span>
                                </strong>
                                <p>{{ data.heat_shrinkable }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Rosetas: </span>
                                </strong>
                                <p>{{ data.rosettes }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Grapas: </span>
                                </strong>
                                <p>{{ data.staples }}</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header text-white bg-info">
                            <div class="d-flex justify-content-between">
                              <strong>Instalación</strong>
                              <i class="fa fa-wrench white"></i>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Fecha de Instalación: </span>
                                </strong>
                                <p>{{ data.instalation_date }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Técnico Instalador: </span>
                                </strong>
                                <p>{{ data.instalator.name }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Potencia en Cliente: </span>
                                </strong>
                                <p>{{ data.client_potency }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Retorno: </span>
                                </strong>
                                <p>{{ data.return_potency }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Onu Instalada: </span>
                                </strong>
                                <p>{{ data.onu_serial }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Observaciones: </span>
                                </strong>
                                <p>{{ data.observations }}</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
  
                    <div></div>
                  </div>
                  <div
                    class="tab-pane fade show"
                    id="nav-service"
                    role="tabpanel"
                    aria-labelledby="nav-service-tab"
                  >
                    <div
                      class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                    >
                      <div class="card-deck">
                        <div class="card">
                          <div class="card-header text-white bg-info">
                            <div class="d-flex justify-content-between">
                              <strong>Datos del Contrato</strong>
                              <i class="fa fa-id-badge white"></i>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Tipo de cliente: </span>
                                </strong>
                                <p>{{ data.contract.type_client_text }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Fecha Inicio de Contrato: </span>
                                </strong>
                                <p>{{ data.contract.start_contract }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>N° de Contrato: </span>
                                </strong>
                                <p>
                                  {{ data.contract.nro }}
                                </p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Razón Social: </span>
                                </strong>
                                <p>{{ data.contract.social_razon }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Estatus Actual: </span>
                                </strong>
                                <p :class="data.contract.class_status">
                                  {{ data.contract.status_text }}
                                </p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Plan Actual: </span>
                                </strong>
                                <p>{{ data.contract.plan.name }}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>
                                  <span>Mensualidad </span>
                                </strong>
                                <p>{{ data.contract.plan.price }}$</p>
                              </div>
                              <div class="col-sm">
                                <strong>
                                  <span>Saldo Actual: </span>
                                </strong>
                                <p>{{ data.contract.balance_dls }}$</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header text-white bg-info">
                            <div class="d-flex justify-content-between">
                              <strong>Datos de Instalación</strong>
                              <i class="fa fa-money-bill white"></i>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>Fecha de Asignación de ODI:</strong>
                                <p>{{data.asignated_date}}</p>
                              </div>
                              <div class="col-sm">
                                <strong>Fecha de Instalación:</strong>
                                <p>{{data.instalation_date}}</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm">
                                <strong>Fecha de Aprobación de ODI:</strong>
                                <p>{{(data.approved_date == null || data.approved_date == '') ? 'Sin Fecha' : data.approved_date }}</p>
                              </div>
                              <div class="col-sm">
                                <strong>Estado de Instalación:</strong>
                                <p>{{data.instalated_text}}</p>
                              </div>
                              
                            </div>
                            <div class="row my-2" v-if="data.mount_cash_dl > 0">
                              <div class="col-sm" >
                                <strong>Forma de Pago:</strong>
                                <p>Divisas en efectivo</p>
                              </div>
                              <div class="col-sm">
                                <strong>Monto pagado en Divisas:</strong>
                                <p>{{ data.mount_cash_dl }}$</p>
                              </div>
                            </div>
                            <div class="row my-2" v-if="data.mount_cash_bs > 0">
                              <div class="col-sm" >
                                <strong>Forma de Pago:</strong>
                                <p>Bolívares en efectivo</p>
                              </div>
                              <div class="col-sm">
                                <strong>Monto pagado en Bs. :</strong>
                                <p>{{ data.mount_cash_bs }}Bs.</p>
                              </div>
                            </div>
                            <div class="row my-2" v-if="data.mount_zelle > 0">
                              <div class="col-sm" >
                                <strong>Forma de Pago:</strong>
                                <p>Zelle</p>
                              </div>
                              <div class="col-sm">
                                <strong>Monto pagado por Zelle:</strong>
                                <p>{{ data.mount_zelle }}$</p>
                              </div>
                            </div>
                            <div class="row my-2" v-if="data.mount_bank_transfer > 0">
                              <div class="col-sm" >
                                <strong>Forma de Pago:</strong>
                                <p>Transferencia Bancaria</p>
                              </div>
                              <div class="col-sm">
                                <strong>Monto pagado en Bs.</strong>
                                <p>{{ data.mount_bank_transfer }}Bs.</p>
                              </div>
                            </div>
                            <div class="row my-2" v-if="data.mount_movil_paid > 0">
                              <div class="col-sm" >
                                <strong>Forma de Pago:</strong>
                                <p>Pago Móvil</p>
                              </div>
                              <div class="col-sm">
                                <strong>Monto pagado en Bs.</strong>
                                <p>{{ data.mount_movil_paid }}Bs.</p>
                              </div>
                            </div>
                            <div class="row my-2" v-if="data.mount_point > 0">
                              <div class="col-sm" >
                                <strong>Forma de Pago:</strong>
                                <p>Punto de Venta</p>
                              </div>
                              <div class="col-sm">
                                <strong>Monto pagado en Bs.</strong>
                                <p>{{ data.mount_point }}Bs.</p>
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col-sm" v-if="data.total_dls_received > 0">
                                <strong>Total recibido en Divisas:</strong>
                                <p>{{ data.total_dls_received }}$</p>
                              </div>
                              <div class="col-sm" v-if="data.total_bs_received > 0">
                                <strong>Total recibido en Bolívares:</strong>
                                <p>{{ data.total_bs_received }}Bs.</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
  
                  <div
                    class="tab-pane fade show"
                    id="nav-sales"
                    role="tabpanel"
                    aria-labelledby="nav-sales-tab"
                  >
                    <div
                      class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                    >
                      <div class="card">
                          <div class="card-header text-white bg-info">
                            <div class="d-flex justify-content-between">
                              <strong>Datos de Venta</strong>
                              <i class="fa fa-id-badge white"></i>
                            </div>
                          </div>
                          <div class="card-body">
                              <div class="row my-2">
                                  <div class="col-3">
                                      <strong>
                                          <span>Planilla: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.num_form }}</p>
                                  </div>
                                  <div class="col-sm">
                                      <strong>
                                          <span>Fecha de Venta: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.created_at.slice(0,10) }}</p>
                                  </div>
                                  <div class="col-sm">
                                      <strong>
                                          <span>Vendedor: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.seller.name }}</p>
                                  </div>
                                  <div class="col-sm">
                                      <strong>
                                          <span>Total pagado en Bs: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.total_bs_received }} bs</p>
                                  </div>
                              </div>
                              <div class="row my-2">
                                  <div class="col-sm">
                                      <strong>
                                          <span>Total a pagado en dolares: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.total_dls_received}}$</p>
                                  </div>
                                  <div class="col-sm" v-if="data.contract.service_request.mount_zelle > 0">
                                      <strong>
                                          <span>Método de pago: <strong>Zelle</strong> </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.mount_zelle }}$</p>
                                  </div>
                                  <div class="col-sm" v-if="data.contract.service_request.mount_bank_transfer > 0">
                                      <strong>
                                          <span>Monto total en transferencia: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.mount_bank_transfer }} bs</p>
                                  </div>
                                  <div class="col-sm" v-if="data.contract.service_request.mount_cash_bs > 0">
                                      <strong>
                                          <span>Monto total de bolivares en efectivo: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.mount_cash_bs }} bs</p>
                                  </div>
                                  <div class="col-sm" v-if="data.contract.service_request.mount_cash_dl > 0">
                                      <strong>
                                          <span>Monto total de dolares en efectivo: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.mount_cash_dl }}$</p>
                                  </div>
                                  <div class="col-sm" v-if="data.contract.service_request.mount_movil_paid > 0">
                                      <strong>
                                          <span>Monto total en transferencia por pago movil: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.mount_movil_paid }} bs</p>
                                  </div>
                                  <!--div class="col-sm" v-if="data.contract.service_request.mount_cash_bs > 0">
                                      <strong>
                                          <span>Monto total en Bs en efectivo: </span>
                                      </strong>
                                      <p>{{ data.contract.service_request.mount_cash_bs }} bs</p>
                                  </div-->
                                  <div class="col-sm" v-if="data.contract.service_request.mount_point > 0">
                                      <strong>
                                          <span>Monto total pagado por punto de venta: </span>
                                      </strong>
                                      <p>{{ contract.service_request.mount_point }} bs</p>
                                  </div>
                                  
                              </div>
                          </div>
                      </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>
  <script>
  export default {
    data() {
      return {
        odi_id: this.$route.params.id,
        actualTab: 1,
        data:[],
        user: "",
      };
    },
    created() {
      this.user = window.user;
      this.getInfo();
    },
    methods: {
      getInfo() {
        
        axios.get(`/api/odis/${this.odi_id}`).then((response) => {
          this.data = response.data;
          console.log(this.data.contract.type_client)  
          this.data.contract.type_client_text =
            (this.data.contract.type_client === "n" || this.data.contract.type_client === "N")
              ? "Natural"
              : "Jurídico";
          this.data.contract.status_text =
            this.data.contract.active == 1 ? "Activo" : "Inactivo";
          this.data.contract.class_status =
            this.data.contract.active == 1 ? "text-success" : "text-danger";
          this.data.contract.balance_dls =
            this.data.contract.balance_dls == null
              ? "0.00"
              : this.data.contract.balance_dls;
          this.data.instalated_text = (this.data.instalated == 1 && (this.data.approved_date == null || this.data.approved_date == '')) ? 'Instalado por Aprobar' : 'Instalado y Aprobado'
        });
  
        /*axios.get("/api/odis/byContract/" + this.contract_id).then((response) => {
          this.odi = response.data;
        });*/
      },
      nextTab(value) {
        this.actualTab = value;
      },
    },
  };
  </script>