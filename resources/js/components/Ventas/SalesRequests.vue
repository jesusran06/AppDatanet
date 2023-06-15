<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><strong>Mis Ventas</strong></h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                  <i class="fa fa-plus-square"></i>
                  Nuevo
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-client-tab" data-toggle="tab" href="#nav-unapprove"
                    role="tab" aria-controls="nav-unapprove" aria-selected="true" @click="nextTab(1)">Ventas por
                    Aprobar</a>
                  <a class="nav-item nav-link" id="nav-ubication-tab" data-toggle="tab" href="#nav-approved" role="tab"
                    aria-controls="nav-approved" aria-selected="true" @click="nextTab(2)">Ventas Aprobadas</a>
                </div>
              </nav>
              <div class="tab-content mt-4" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-unapprove" role="tabpanel"
                  aria-labelledby="nav-unapprove-tab">
                  <div class="align-content-center d-flex justify-content-between mb-3 title-container flex-column">
                    <table class="table table-hover">
                      <tbody>
                        <tr v-if="requests.length == 0 && !loading">
                          <td class="text-center" colspan="9">No hay ventas pendientes</td>
                       </tr>
                       <tr v-if="loading">
                            <td colspan="11" class="text-center">
                                <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                            </td>
                        </tr>
                        <tr v-for="request in requests" :key="request.id">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">
                                Cliente N° <strong :class="(!request.client_id) ? 'text-danger' : ''">{{
                                  (request.client_id) ? request.client_id : "Por Aprobar" }}</strong>
                              </h5>
                              <br /><br />
                              <span class="h4">Plan Contratado {{ request.plan.name }}
                                <strong>{{ request.plan.price }}$</strong></span>
                              /mes <br /><br />
                              <div class="d-grid my-3">
                                <button class="btn btn-outline-dark btn-block" @click="editModal(request)"
                                  v-if="request.approved == 0">
                                  Ver
                                </button>
                              </div>
                              <ul class="no-bullets">
                                <li>
                                  <i class="fas fa-user-check text-primary"></i><strong class="text-primary">
                                    Cliente : {{ request.social_razon }}</strong>
                                </li>
                                <li>
                                  <i class="fas fa-globe text-primary"></i><strong class="text-primary">
                                    Dirección :{{ request.address }}</strong>
                                </li>
                                <li>
                                  <i class="fas fa-phone text-primary"></i><strong class="text-primary">
                                    Teléfono/ Whatsapp :{{
                                      request.celphone
                                    }}
                                    / {{ request.whatsapp }}</strong>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="mb-2"></div>

                          <!--td>{{ request.client.name }}</td>
                    <td class="text-capitalize">{{ request.addres }}</td>
                    <td class="text-capitalize">{{ request.date }}</td>
                    <td>
                      <a href="#" @click="editModal(user)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                    </td-->
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
                  <div class="align-content-center d-flex justify-content-between mb-3 title-container flex-column">
                    <table class="table table-hover">
                      <tbody>
                        <tr v-if="requestsApproved.length == 0">
                          <td class="text-center" colspan="9">No hay ventas para mostrar</td>
                       </tr>
                        <tr v-for="request in requestsApproved" :key="request.id">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">
                                Cliente  <strong :class="(!request.client_id) ? 'text-danger' : ''">{{
                                  (request.client_id) ? "C-"+request.client_id : "Por Aprobar" }}</strong>
                              </h5>
                              <br /><br />
                              <span class="h4">Plan Contratado {{ request.plan.name }}
                                <strong>{{ request.plan.price }}$</strong></span>
                              /mes <br /><br />
                              <div class="d-grid my-3">
                                <button class="btn btn-outline-dark btn-block" @click="editModal(request)"
                                  v-if="request.approved == 0">
                                  Ver
                                </button>
                              </div>
                              <div class="row">
                                <div class="col-sm">
                                  <ul class="no-bullets">
                                <li>
                                  <i class="fas fa-user-check text-primary"></i><strong class="text-primary">
                                    Cliente : {{ request.social_razon }}</strong>
                                </li>
                                <li>
                                  <i class="fas fa-globe text-primary"></i><strong class="text-primary">
                                    Dirección :{{ request.address }}</strong>
                                </li>
                                <li>
                                  <i class="fas fa-phone text-primary"></i><strong class="text-primary">
                                    Teléfono/ Whatsapp :{{
                                      request.celphone
                                    }}
                                    / {{ request.whatsapp }}</strong>
                                </li>

                                
                              </ul>
                                </div>
                                <div class="col-sm">
                                  <ul class="no-bullets">
                                
                                  <li>
                                    <i class="fas fa-edit text-primary"></i><strong class="text-primary">
                                      Nro de Contrato :
                                      {{ (request.contract) ? request.contract.nro_contract : 'S/N' }}</strong>
                                  </li>
                                  <li>
                                    <i class="fas fa-calendar text-primary"></i><strong class="text-primary">
                                      Fecha de Venta :
                                      {{ request.created_date  }}</strong>
                                  </li>
                                  <li>
                                    <i class="fas fa-check text-primary"></i><strong class="text-primary">
                                      Fecha de Aprobación :
                                      {{ request.approved_date  }}</strong>
                                  </li>
                              </ul>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          <div class="mb-2"></div>

                          <!--td>{{ request.client.name }}</td>
                    <td class="text-capitalize">{{ request.addres }}</td>
                    <td class="text-capitalize">{{ request.date }}</td>
                    <td>
                      <a href="#" @click="editModal(user)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                    </td-->
                        </tr>
                        <tr v-if="requestsApproved.length == 0">
                          <td class="text-center">No hay ventas para mostrar</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination :data="list" @pagination-change-page="mySales" v-if="actualTab == 1" :limit="limit"></pagination>
              <pagination :data="listApproved" @pagination-change-page="mySalesApproved" v-if="actualTab == 2" :limit="limit"></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <form-modal 
        :parro="parroquias" 
        :editmode="editmode" 
        :bcv="bcv" 
        @reloadSales="reloadSales">
      </form-modal>
    </div>
  </section>
</template>
<script>
import FormModal from './Form.vue';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
import moment from "moment";

export default {
  components: {
    FormModal,
    PulseLoader
  },
  //mixins:[dollar_bcv]

  data() {
    return {

      editmode: false,
      sectores: [],
      subsectors: [],
      sales: [],
      plans: [],
      requests: [],
      list: [],
      selectedPlan: [{ name: "", price: "" }],
      itemPrices: [],
      itemsSelected: [],
      amount_total: 0,
      checkeds: [],
      parroquias: [],
      bcv: {
        exchange: 0
      },
      requestsApproved:[],
      list: new Object(),
      listApproved: new Object(),
      actualTab: 1,
      color: '#FFDAB9',
      size: '20px',
      limit:5,
      loading: false,
      argumentResolutionError:'',
      length:''
    };
  },
  created() {
    this.mySales();
    this.mySalesApproved();
    this.getParroquias();
    this.get_price_dollar();
  },

  methods: {
    mySales(page = 1) {
      this.loading = true;
      axios.get("api/request/list?page=" + page).then((response) => {
        this.requests = response.data.data;
        let copy = JSON.parse(JSON.stringify(response.data));
        this.list = copy;
        this.requests.map((p) => {
          p.type_aproved = p.approved ? "Aprobado" : "Por Aprobar";
          p.gps = JSON.parse(p.gps);
        });
        console.log("this.requests", this.requests)
        this.loading = !this.loading;
      });
    },
    mySalesApproved(page = 1){
      axios.get("api/request/listApproved?page=" + page).then((response) => {
        this.requestsApproved = response.data.data;
        let copy = JSON.parse(JSON.stringify(response.data));
        this.listApproved = copy;
        this.requestsApproved.map((p) => {
          p.type_aproved = p.approved ? "Aprobado" : "Por Aprobar";
          
          p.created_date = p.created_at.slice(0, 10);
        });
      });
      console.log("ventas aprobadas", this.requestsApproved)
    },
    newModal() {
      this.$children[1].form.reset();
      this.editmode = false;
      $("#addNew").modal("show");
    },
    getParroquias() {
      axios.get("api/parroquias").then((response) => {
        this.parroquias = response.data;


        // console.log("parroquias", response);
      });
    },
    get_price_dollar() {
      axios.get("api/bcv").then((response) => {
        this.bcv = response.data[0]
        // console.log("bcv", response.data[0])
      });
    },
    reloadSales() {
      this.mySales();
      this.mySalesApproved();
    },
    editModal(request) {
      console.log("request ", request)
      this.editmode = true;
      this.$children[1].form.reset();
      $("#addNew").modal("show");
      $('#nav-client-tab').tab("show")
      request.name = request.social_razon;
      //request.parroquia = request.parroquia;
      request.typeClient = request.type_client;
      Object.defineProperty(request.plan, 'type', {
        value: 'plan',
        writable: false
      });

      this.$children[1].itemsSelected.push(request.plan)

      Object.defineProperty(request.instalation, 'type', {
        value: 'instalacion',
        writable: false
      });
      Object.defineProperty(request.instalation, 'price', {
        value: request.instalation.total_cost,
        writable: false
      });

      this.$children[1].itemsSelected.push(request.instalation)

      if(request.router == 1){
        Object.defineProperty(request.router_model, "type", {
          value: "router",
          writable: false,
        });
        this.$children[1].itemsSelected.push(request.router_model);
      }
      if(request.cable == 1){
        let objCable = new Object();
        objCable.id = 88;
        objCable.name = "Cable";
        objCable.type = "cable";
        objCable.price = request.mount_cable;
        
        this.$children[1].itemsSelected.push(objCable);
      }
      if(request.prorateo == 1){
        let objProrateo = new Object();
        objProrateo.id = 99;
        objProrateo.name = "Prorateo";
        objProrateo.type = "cable";
        objProrateo.price = request.mount_prorateo;
        
        this.$children[1].itemsSelected.push(objProrateo);
      }

      this.$children[1].form.fill(request);
      console.log("llego", request)
    },
    nextTab(val) {
      this.actualTab = val;
    },




  },
};
</script>
<style scoped>
ul.no-bullets {
  list-style-type: none;
  /* Remove bullets */
  padding: 0;
  /* Remove padding */
  margin: 0;
  /* Remove margins */
}

hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 1;
  border-top: 2px solid rgba(0, 0, 0, 0.1);
}
</style>
