<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <strong
                  >Información de Contrato N° {{ contract.parroquia_id }}-{{
                    contract_id
                  }}</strong
                >
                
              </h3>
              <div class="card-tools">
                <router-link to="/contracts" class="nav-link">
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
                              <p>{{ contract.social_razon }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Cédula / Rif: </span>
                              </strong>
                              <p>{{ contract.document }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Télefono: </span>
                              </strong>
                              <p>{{ contract.client.celphone }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Whatsapp: </span>
                              </strong>
                              <p>{{ contract.client.whatsapp }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Correo Electrónico:</span>
                              </strong>
                              <p>{{ contract.client.email }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Cumpleaños:</span>
                              </strong>
                              <p>{{ contract.client.birthday }}</p>
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
                              <p>{{ contract.parroquia.parroquia }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Sector: </span>
                              </strong>
                              <p>{{ contract.sector.name }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Subsector:</span>
                              </strong>
                              <p>{{ contract.subsector.name }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Dirección: </span>
                              </strong>
                              <p>{{ contract.client.address }}</p>
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
                              <p>{{ contract.nap.name }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Puerto: </span>
                              </strong>
                              <p>{{ odi.nap_port }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Carrete: </span>
                              </strong>
                              <p>{{ odi.reel }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Mts de Cable Utilizados: </span>
                              </strong>
                              <p>{{ odi.total_distance }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Potencia en Nap: </span>
                              </strong>
                              <p>{{ odi.nap_potency }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Conector Rápido: </span>
                              </strong>
                              <p>{{ odi.fast_conector }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Pigtail: </span>
                              </strong>
                              <p>{{ odi.pgtail }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Flejes: </span>
                              </strong>
                              <p>{{ odi.strapping }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Aros: </span>
                              </strong>
                              <p>{{ odi.hoops }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Termoencogible: </span>
                              </strong>
                              <p>{{ odi.heat_shrinkable }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Rosetas: </span>
                              </strong>
                              <p>{{ odi.rosettes }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Grapas: </span>
                              </strong>
                              <p>{{ odi.staples }}</p>
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
                              <p>{{ odi.instalation_date }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Técnico Instalador: </span>
                              </strong>
                              <p>{{ odi.instalator.name }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Potencia en Cliente: </span>
                              </strong>
                              <p>{{ odi.client_potency }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Retorno: </span>
                              </strong>
                              <p>{{ odi.return_potency }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Onu Instalada: </span>
                              </strong>
                              <p>{{ odi.onu_serial }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Observaciones: </span>
                              </strong>
                              <p>{{ odi.observations }}</p>
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
                              <p>{{ contract.type_client_text }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Fecha Inicio de Contrato: </span>
                              </strong>
                              <p>{{ contract.start_contract }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>N° de Contrato: </span>
                              </strong>
                              <p>
                                {{ contract.parroquia_id }}- {{ contract.id }}
                              </p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Razón Social: </span>
                              </strong>
                              <p>{{ contract.social_razon }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Estatus Actual: </span>
                              </strong>
                              <p :class="contract.class_status">
                                {{ contract.status_text }}
                              </p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span> </span>
                              </strong>
                              <p></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header text-white bg-info">
                          <div class="d-flex justify-content-between">
                            <strong>Planes y Balance</strong>
                            <i class="fa fa-money-bill white"></i>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row my-2">
                            <div class="col-3">
                              <strong>
                                <span>Plan Actual: </span>
                              </strong>
                              <p>{{ contract.plan.name }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span>Precio Plan </span>
                              </strong>
                              <p>{{ contract.plan.price }}</p>
                            </div>
                          </div>
                          <div class="row my-2">
                            <div class="col-sm">
                              <strong>
                                <span>Saldo: </span>
                              </strong>
                              <p>{{ contract.balance_dls }}</p>
                            </div>
                            <div class="col-sm">
                              <strong>
                                <span> </span>
                              </strong>
                              <p></p>
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
                                    <p>{{ contract.service_request.num_form }}</p>
                                </div>
                                <div class="col-sm">
                                    <strong>
                                        <span>Fecha de Venta: </span>
                                    </strong>
                                    <p>{{ contract.service_request.created_at.slice(0,10) }}</p>
                                </div>
                                <div class="col-sm">
                                    <strong>
                                        <span>Vendedor: </span>
                                    </strong>
                                    <p>{{ contract.service_request.seller.name }}</p>
                                </div>
                                <div class="col-sm">
                                    <strong>
                                        <span>Total pagado en Bs: </span>
                                    </strong>
                                    <p>{{ contract.service_request.total_bs_received }} bs</p>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-sm">
                                    <strong>
                                        <span>Total a pagado en dolares: </span>
                                    </strong>
                                    <p>{{ contract.service_request.total_dls_received}}$</p>
                                </div>
                                <div class="col-sm" v-if="contract.service_request.mount_zelle > 0">
                                    <strong>
                                        <span>Método de pago: <strong>Zelle</strong> </span>
                                    </strong>
                                    <p>{{ contract.service_request.mount_zelle }}$</p>
                                </div>
                                <div class="col-sm" v-if="contract.service_request.mount_bank_transfer > 0">
                                    <strong>
                                        <span>Monto total en transferencia: </span>
                                    </strong>
                                    <p>{{ contract.service_request.mount_bank_transfer }} bs</p>
                                </div>
                                <div class="col-sm" v-if="contract.service_request.mount_cash_bs > 0">
                                    <strong>
                                        <span>Monto total de bolivares en efectivo: </span>
                                    </strong>
                                    <p>{{ contract.service_request.mount_cash_bs }} bs</p>
                                </div>
                                <div class="col-sm" v-if="contract.service_request.mount_cash_dl > 0">
                                    <strong>
                                        <span>Monto total de dolares en efectivo: </span>
                                    </strong>
                                    <p>{{ contract.service_request.mount_cash_dl }}$</p>
                                </div>
                                <div class="col-sm" v-if="contract.service_request.mount_movil_paid > 0">
                                    <strong>
                                        <span>Monto total en transferencia por pago movil: </span>
                                    </strong>
                                    <p>{{ contract.service_request.mount_movil_paid }} bs</p>
                                </div>
                                <div class="col-sm" v-if="contract.service_request.mount_cash_bs > 0">
                                    <strong>
                                        <span>Monto total en Bs en efectivo: </span>
                                    </strong>
                                    <p>{{ contract.service_request.mount_cash_bs }} bs</p>
                                </div>
                                <div class="col-sm" v-if="contract.service_request.mount_point > 0">
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
      contract_id: this.$route.params.id,
      contract: [],
      odi: [],
      actualTab: 1,
    };
  },
  created() {
    this.getInfo();
  },
  methods: {
    getInfo() {
      axios.get("/api/contract/" + this.contract_id).then((response) => {
        this.contract = response.data;
        this.contract.type_client_text =
          this.contract.type_client === "n" || this.contract.type_client === "N"
            ? "Natural"
            : "Jurídico";
        this.contract.status_text =
          this.contract.active == 1 ? "Activo" : "Inactivo";
        this.contract.class_status =
          this.contract.active == 1 ? "text-success" : "text-danger";
        this.contract.balance_dls =
          this.contract.balance_dls == null
            ? "0.00"
            : this.contract.balance_dls;
      });

      axios.get("/api/odis/byContract/" + this.contract_id).then((response) => {
        this.odi = response.data;
      });
    },
    nextTab(value) {
      this.actualTab = value;
    },
  },
};
</script>