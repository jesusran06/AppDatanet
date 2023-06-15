<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><strong>Ventas</strong></h3>

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
                    <div class="col-md-4 mb-4">
                      <input type="text" @keyup="filterAllSales" class="form-control" id="filterInput" placeholder="Buscar" v-model="tofilter">
                    </div>
                    <table class="table table-hover">
                      <tr v-if="requests.length == 0 && !loading">
                          <td class="text-center" colspan="9">No hay ventas para mostrar</td>
                       </tr>
                      <thead v-if="requests.length > 0">
                        <tr class="text-center">
                          <th>N° Venta</th>
                          <th>Solicitante</th>
                          <th>Documento</th>
                          <th>Teléfono</th>
                          <th>Sector</th>
                          <th>Vendedor</th>
                          <th>Estatus</th>
                          <th>Fecha de Venta</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="loading">
                            <td colspan="11" class="text-center">
                                <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                            </td>
                        </tr>
                        <tr v-for="request in requests" :key="request.id" class="text-center">
                          <td>{{ request.id }}</td>
                          <td class="text-capitalize">{{ request.type_client == 'J' ? request.social_razon : request.names + ' '+ request.last_names }}</td>
                          <td class="text-capitalize">{{ request.type_client == 'J' ? request.document : request.document2 }}</td>
                          <td class="text-capitalize">{{ request.celphone }}</td>
                          <td class="text-capitalize">{{ request.sector.name }}</td>
                          <td class="text-capitalize">{{ request.seller.name }}</td>
                          <td class="text-capitalize">{{ request.type_aproved }}</td>
                          <td class="text-capitalize">{{ request.created_date }}</td>

                          <td>
                            <a href="#" @click="editOrApproveRequest(request, false)" data-toggle="tooltip"
                              data-placement="top" title="Editar">
                              <i class="fa fa-edit blue"></i>
                            </a>
                            <a href="#" @click="editOrApproveRequest(request, true)" aria-placeholder="Aprobar"
                              v-if="request.approved == 0" data-toggle="tooltip" data-placement="top" title="Aprobar">
                              <i class="fa fa-check green"></i>
                            </a>
                            <a href="#" aria-placeholder="Aprobar" v-if="request.approved == 1" data-toggle="tooltip"
                              data-placement="top" title="Aprobado">
                              <i class="fas fa-check-double green "></i>
                            </a>
                            <a href="#" @click="deleteSale(request)" v-if="request.approved == 0" data-toggle="tooltip"
                              data-placement="top" title="Eliminar">
                              <i class="fa fa-trash red"></i>
                            </a>
                          </td>
                        </tr>
                        
                      </tbody>
                    </table>

                  </div>
                </div>

                <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
                  <div class="align-content-center d-flex justify-content-between mb-3 title-container flex-column">
                    <div class="col-md-4 mb-4">
                      <input type="text" @keyup="filterSalesApproved" class="form-control" id="filterApprovInput" placeholder="Buscar" v-model="tofilterApprov">
                    </div>
                    <table class="table table-hover">
                      <thead v-if="requestsApproved.length > 0">
                        <tr class="text-center">
                          <th>N° Venta</th>
                          <th>N° Contrato</th>
                          <th>Cliente</th>
                          <th>Documento</th>
                          <th>Teléfono</th>
                          <th>Sector</th>
                          <th>Vendedor</th>
                          <th>Estatus</th>
                          <th>Fecha de Venta</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="request in requestsApproved" :key="request.id" class="text-center">
                          <td>{{ request.num_form }}</td>
                          <td>{{ request.nro_contrato  }}</td>
                          <td class="text-capitalize">{{ request.type_client == 'J' ? request.social_razon : request.names + ' '+ request.last_names }}</td>
                          <td class="text-capitalize">{{ request.type_client == 'J' ? request.document : request.document2 }}</td>
                          <td class="text-capitalize">{{ request.celphone }}</td>
                          <td class="text-capitalize">{{ request.sector.name }}</td>
                          <td class="text-capitalize">{{ request.seller.name }}</td>
                          <td class="text-capitalize">{{ request.type_aproved }}</td>
                          <td class="text-capitalize">{{ request.created_date }}</td>

                          <td>
                            <!--a href="#" @click="editOrApproveRequest(request, false)" data-toggle="tooltip"
                              data-placement="top" title="Editar">
                              <i class="fa fa-edit blue"></i>
                            </a-->
                            <a href="#" @click="showInfo(request, true)" aria-placeholder="Ver Datos"
                              v-if="request.approved == 1" data-toggle="tooltip" data-placement="top" title="Ver Datos">
                              <i class="fa fa-eye blue"></i>
                            </a>
                            <a href="#" aria-placeholder="Aprobar" v-if="request.approved == 1" data-toggle="tooltip"
                              data-placement="top" title="Aprobado">
                              <i class="fas fa-check-double green "></i>
                            </a>
                            <!--a href="#" @click="deleteSale(request)" v-if="request.approved == 0" data-toggle="tooltip"
                              data-placement="top" title="Eliminar">
                              <i class="fa fa-trash red"></i>
                            </a-->
                          </td>
                        </tr>
                        <tr v-if="requestsApproved.length == 0 && !loading">
                          <td class="text-center" colspan="9">
                            No hay ventas aprobadas
                          </td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <div>

              </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination :data="list" @pagination-change-page="filterAllSales" v-if="actualTab == 1 && tofilter!=''" :limit="limit"></pagination>
              <pagination :data="list" @pagination-change-page="allSales" v-if="actualTab == 1 && tofilter==''" :limit="limit"></pagination>
              <pagination :data="listApproved" @pagination-change-page="filterSalesApproved" v-if="actualTab == 2 && tofilter!=''" :limit="limit"></pagination>
              <pagination :data="listApproved" @pagination-change-page="allSalesApproved" v-if="actualTab == 2 && tofilter==''" :limit="limit"></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <form-modal :parro="parroquias" :editmode="editmode" :bcv="bcv" @reloadSales="reloadSales"></form-modal>
      <show-info :request="request_info"></show-info>
    </div>
  </section>
</template>
<script>
import FormModal from "./Form.vue";
import ShowInfo from "./Info.vue";
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
import moment from 'moment';

export default {
  components: {
    FormModal,
    ShowInfo,
    PulseLoader
  },
  data() {
    moment.locale('es');
    return {
      loading: false,
      requests: [],
      requestsApproved: [],
      bcv: {
        exchange: 0
      },
      parroquias: [],
      editmode: false,
      list: new Object(),
      listApproved: new Object(),
      actualTab: 1,
      request_info: new Object({
        parroquia:[],
        client:[],
        nap:[],
        instalation:[],
        sector:[],
        seller:[],
        plan:[]
      }),
      color: '#FFDAB9',
      size: '20px',
      limit:5,
      tofilter:'',
      tofilterApprov:''
    }
  },
  created() {
    this.allSales();
    this.allSalesApproved();
    this.getParroquias();
    this.get_price_dollar();
  },
  methods: {
    allSales(page = 1) {
      this.loading = true;
        axios.get("api/request/list?page=" + page).then((response) => {
          this.requests = response.data.data;
          let copy = JSON.parse(JSON.stringify(response.data));
          this.list = copy;
          this.requests.map((p) => {
            p.type_aproved = "Por Aprobar";
            p.created_date = moment(p.created_at).format('L')
          });
          this.loading = false;
        });
    },
    filterAllSales(page) {
      if(this.tofilter){
        this.loading = true;
        if(typeof(page)!= 'number') {
          page = 1;
        }
        axios.get(`api/request/filterAllSales/${this.tofilter}?page=`+page).then((response) => {
          this.requests = response.data.data;
          this.requests = this.requests.filter(obj=>{
                if ('approved' in obj && obj.approved == 0) {
                    return true;
                } else {
                    return false;
                }})
          let copy = JSON.parse(JSON.stringify(response.data));
          this.list = copy;
          this.requests.map((p) => {
            p.type_aproved =( p.approved === 1)? "Aprobado" : "Por Aprobar";
            p.created_date = moment(p.created_at).format('L')
          });
          this.loading = false
        });
      } else {
        this.allSales(1)
      }
    },
    allSalesApproved(page = 1) {
      
        this.loading = true;
        axios.get("api/request/listApproved?page=" + page).then((response) => {
          this.requestsApproved = response.data.data;
          //console.log("this.requestsApproved", this.requestsApproved)
          let copy = JSON.parse(JSON.stringify(response.data));
          this.listApproved = copy;
          this.requestsApproved.map((p) => {
            //p.type_aproved = p.approved ? "Aprobado" : "Por Aprobar";
            p.type_aproved = "Aprobado";
            p.created_date = moment(p.created_at).format('L')
            if(p.type_client == 'N' || p.type_client == 'n'){
              p.nro_contrato = (p.contract) ? p.contract.nro_contract : 'S/N';
            }else{
              p.nro_contrato = (p.juridict_contract) ? p.juridict_contract.nro_contract : 'S/N';
            }
            //p.total_router = (p.router ==  1) ? p.router_model.price : 0;
            //p.total_invoice = parseFloat(p.instalation.total_cost) + parseFloat(p.plan.price) + parseFloat(p.mount_cable) + parseFloat(p.mount_prorateo) + parseFloat(p.total_router);
          });
          this.loading = false;
        });
      
    },
    filterSalesApproved(page) {
      this.requestsApproved = [];
      if(this.tofilterApprov){
        this.loading = true;
        if(typeof(page)!= 'number') {
            page = 1;
        }
        axios.get(`api/request/filterSalesApproved/${this.tofilterApprov}?page=`+page).then((response) => {
          this.requestsApproved = response.data.data;
          let copy = JSON.parse(JSON.stringify(response.data));
          this.listApproved = copy;
          this.requestsApproved.map((p) => {
            p.type_aproved = p.approved ? "Aprobado" : "Por Aprobar";
            p.created_date = moment(p.created_at).format('L')
            if(p.type_client == 'N' || p.type_client == 'n'){
              p.nro_contrato = (p.contract) ? p.contract.nro_contract : 'S/N';
            }else{
              p.nro_contrato = (p.juridict_contract) ? p.juridict_contract.nro_contract : 'S/N';
            }
          });   
          this.loading =false
        });
      } else {
        this.allSalesApproved(1);
      }
    },
    getParroquias() {
      axios.get("api/parroquias").then((response) => {
        this.parroquias = response.data;
      });
    },
    get_price_dollar() {
      axios.get("api/bcv").then((response) => {
        this.bcv = response.data[0];
      });
    },
    editOrApproveRequest(request, disable) {

      this.editmode = true;
      this.$children[1].form.reset();
      $("#addNew").modal("show");
      $("#nav-client-tab").tab("show");
      request.name = request.social_razon;
      request.parroquia = request.parroquia;
      request.typeClient = request.type_client;
      Object.defineProperty(request.plan, "type", {
        value: "plan",
        writable: false,
      });

      this.$children[1].itemsSelected.push(request.plan);

      Object.defineProperty(request.instalation, "type", {
        value: "instalacion",
        writable: false,
      });
      Object.defineProperty(request.instalation, "price", {
        value: request.instalation.total_cost,
        writable: false,
      });
      if (disable) {
        this.editmode = false;
        this.$children[1].disable_approve = true;
        
      } else {
        this.$children[1].disable_approve = false;
      }
      this.$children[1].itemsSelected.push(request.instalation);
      
      
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
      
    },
    reloadSales() {
      this.allSales();
      this.allSalesApproved();
    },
    approveRequest(request) {
      this.$Progress.start();
      Swal.fire({
        title: "Esta seguro?",
        text: "de aprobar la venta " + request.num_form,
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
      }).then((result) => {
        if (result.value) {
          axios
            .post("api/approve-sale", request)
            .then((response) => {
              Toast.fire({
                icon: "success",
                title: "Aprobada, se ha generado un ODI para este cliente",
              });
              this.$Progress.finish();
              this.allSales();
            })
            .catch((error) => {
              console.log(error);
              Toast.fire({
                icon: "error",
                title: "Some error occured! Please try again",
              });
            });
        }
      });
    },
    deleteSale(request) {
      this.$Progress.start();
      Swal.fire({
        title: "Esta seguro?",
        text: "de Eliminar la solicitud de servicio " + request.num_form,
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
      }).then((result) => {
        if (result.value) {
          axios
            .delete(`api/request/delete/${request.id}`)
            .then(response => {
              Toast.fire({
                icon: "success",
                title: "Solicitud de Servicio eliminada!",
              });
              this.$Progress.finish();
              this.allSales();
            }).catch(error => {
              Toast.fire({
                icon: "error",
                title: "Ocurrió un error!",
              });
              this.$Progress.finish();

            })
        }
      })

    },
    newModal() {
      this.editmode = false;
      this.$children[1].disable_approve = false;
      this.$children[1].form.reset();
      $("#addNew").modal("show");
      this.$refs.FormModal.$el.querySelector(`a[href="#nav-client"]`).tab("show");
      $('a[href="#nav-questionnarie"]').removeClass('active');
      $('a[href="#nav-ubication"]').removeClass('active');
      $('a[href="#nav-service"]').removeClass('active');
      $('a[href="#nav-client"]').tab("show");
      
    },
    nextTab(val) {
      this.actualTab = val;
    },
    showInfo(request){
      this.request_info = [];
      this.request_info = request;
      $("#showInfo").modal("show");
    }
  },
};
</script>
