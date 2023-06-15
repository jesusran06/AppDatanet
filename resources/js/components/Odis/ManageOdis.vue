<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><strong>Ordenes de Instalación</strong></h3>
              <div class="card-tools">
                <i class="fas fa-dot-circle red" v-if="actualTab == 1"><span>Pendiente</span></i>
                <i class="fas fa-dot-circle orange ml-2" v-if="actualTab == 1"><span>Asignado</span> </i>
                <i class="fas fa-dot-circle green ml-2" v-if="actualTab == 2"><span>Instalado-Aprobado</span> </i>
                <i class="fas fa-dot-circle blue ml-2" v-if="actualTab == 2"><span>Instalado por Aprobar</span> </i>
                <button type="button" class="btn btn-sm btn-primary ml-4" v-if="groupOdi.length > 0 && actualTab == 1" @click="assingByGroup" >
                  <i class="fa fa-wrench"></i>
                  Asignar por Lote
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-client-tab" data-toggle="tab" href="#nav-unapprove"
                    role="tab" aria-controls="nav-unapprove" aria-selected="true" @click="nextTab(1)">Por
                    Instalar</a>
                  <a class="nav-item nav-link" id="nav-ubication-tab" data-toggle="tab" href="#nav-approved" role="tab"
                    aria-controls="nav-approved" aria-selected="true" @click="nextTab(2)">Instaladas</a>
                </div>
              </nav>
              <div class="tab-content mt-4" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-unapprove" role="tabpanel"
                  aria-labelledby="nav-unapprove-tab">
                  <div class="align-content-center d-flex justify-content-between mb-3 title-container flex-column">
                      <div class="col-md-4 mb-4 mt-4">
                          <input type="text" @keyup="filterAll" class="form-control" id="filterInput" placeholder="Buscar" v-model="filter">
                      </div>
                    </div>
                    <table class="table table-hover table-responsive-md">
                      <thead v-if="odis.length > 0">
                        <tr style="font-size: 14px;">
                          <th></th>
                          <th style="width: 7%">ODI</th>
                          <th style="width: 7%">Contrato</th>
                          <th>Cliente</th>
                          <th>Documento</th>
                          <th>Teléfono</th>
                          <th>Fecha Venta</th>
                          <th class="text-center">Días Transcurridos</th>
                          <th>Sector</th>
                          <th style="width: 20%">Dirección</th>
                          <th class="text-center">Estatus</th>
                          <th>Instalador Asignado</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="loading">
                            <td colspan="11" class="text-center">
                                <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                            </td>
                        </tr>
                        <tr v-for="odi in odis" :key="odi.id">
                          <td class="text-center">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox4" v-model="groupOdi"
                              :value="odi" v-if="!odi.instalator_id" />
                          </td>
                          <td style="font-size: medium;">ODI-{{ odi.id }}</td>
                          <td class="text-capitalize" style="font-size: medium;">{{ (odi.contract.nro) ? odi.contract.nro : 'S/N' }}</td>
                          <td class="text-capitalize">{{ odi.contract.social_razon }}</td>
                          <td class="text-capitalize">{{ odi.contract.document }}</td>
                          <td class="text-capitalize">{{ odi.contract.client.celphone }}</td>
                          <td class="text-capitalize">{{ odi.contract.service_request.approved_date.slice(0,10) }}</td>
                          <td class="text-capitalize text-center">{{ odi.diffDays }}</td>
                          <td class="text-capitalize">{{ odi.contract.sector.name }}</td>
                          <td class="text-capitalize">{{ odi.contract.client.address }}</td>
                          <td class="text-capitalize text-center"><i class="fas fa-dot-circle" :class="odi.color"></i>
                          </td>
                          <td class="text-capitalize">{{ odi.instalator.name }}</td>

                          <td>
                            <a href="#" @click="asingOdi(odi)" data-toggle="tooltip" data-placement="top" title="Asignar"
                              :disabled="odi.instalator !== ''">
                              <i class="fa fa-wrench orange"></i>
                            </a>
                            <a href="#" @click="editOdi(odi)" data-toggle="tooltip" data-placement="top" title="Editar">
                              <i class="fa fa-edit blue"></i>
                            </a>
                            
                            <a href="#" @click="deleteOdi(odi.id)" v-if="approved == 0" data-toggle="tooltip"
                              data-placement="top" title="Eliminar">
                              <i class="fa fa-trash red"></i>
                            </a>
                            <a class="btn btn-default btn-sm" @click="generateOdi(odi.id)">
                              <i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top"
                                title="Generar Odi" />
                            </a>
                          </td>
                        </tr>
                        <tr v-if="odis.length == 0">
                          <td class="text-center" colspan="11">No hay Odis para mostrar</td>
                        </tr>
                      </tbody>
                    </table>
                </div>



                <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
                    <div class="align-content-center d-flex justify-content-between mb-3 title-container flex-column">
                      <div class="col-md-4 mb-4 mt-4">
                          <input type="text" @keyup="filterApproved" class="form-control" id="filterApproInput" placeholder="Buscar" v-model="filterAppro">
                      </div>
                    </div>
                    <!-- Tabla aqui Odis Ejecutadas-->
                    <table class="table table-hover">
                      <thead v-if="odisApproved.length > 0">
                        <tr style="font-size: 14px;">
                          <th style="width: 7%">ODI</th>
                          <th style="width: 7%">Contrato</th>
                          <th>Cliente</th>
                          <th>Documento</th>
                          <th>Teléfono</th>
                          <th>Sector</th>
                          <th style="width: 20%">Dirección</th>
                          <th class="text-center">Estatus</th>
                          <th>Instalador</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="loading">
                            <td colspan="11" class="text-center">
                                <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                            </td>
                        </tr>
                        <tr v-for="odi in odisApproved" :key="odi.id">
                          <td style="font-size: medium;">ODI-{{ odi.id }}</td>
                          <td class="text-capitalize" style="font-size: medium;">{{ (odi.contract.nro) ? odi.contract.nro : 'S/N'  }}</td>
                          <td class="text-capitalize">{{ odi.contract.social_razon }}</td>
                          <td class="text-capitalize">{{ odi.contract.document }}</td>
                          <td class="text-capitalize">{{ odi.contract.client.celphone }}</td>
                          <td class="text-capitalize">{{ odi.contract.sector.name }}</td>
                          <td class="text-capitalize">{{ odi.contract.client.address }}</td>
                          <td class="text-capitalize text-center"><i class="fas fa-dot-circle" :class="odi.color"></i>
                          </td>
                          <td class="text-capitalize">{{ odi.instalator.name }}</td>

                          <td>
                            <a href="#">
                              <router-link :to="{ path: `/odi/${odi.id}`}">
                                  <i class="fa fa-eye blue" title="Ver detalles"></i>
                              </router-link>
                              
                          </a>
                            <a href="#" @click="approveOdi(odi)" aria-placeholder="Aprobar" data-toggle="tooltip"
                              data-placement="top" title="Aprobar" v-show="odi.isApproved" >
                              <i class="fa fa-check green"></i>
                            </a>
                            <a class="btn btn-default btn-sm" @click="generateOdi(odi.id)">
                              <i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top"
                                title="Generar Odi" />
                            </a>
                          </td>
                        </tr>
                        <tr v-if="odisApproved.length == 0">
                          <td class="text-center" colspan="10">No hay Odis para mostrar</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination :data="list" @pagination-change-page="allOdis" v-if="actualTab == 1 && filter==''" :limit="limit"></pagination>
              <pagination :data="list" @pagination-change-page="filterAll" v-if="actualTab == 1 && filter!=''" :limit="limit"></pagination>
              <pagination :data="listApproved" @pagination-change-page="allOdisApproved" v-if="actualTab == 2 && filterAppro==''" :limit="limit"></pagination>
              <pagination :data="listApproved" @pagination-change-page="filterApproved" v-if="actualTab == 2 && filterAppro!=''" :limit="limit"></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!--form-modal
        :parro="parroquias"
        :editmode="editmode"
        :bcv="bcv"
        @reloadSales="reloadSales"
      ></form-modal-->
    </div>
    <form-modal :editmode="editmode" @reloadOdis=reloadOdis></form-modal>
    <asing-form @reloadOdis=reloadOdis>
    </asing-form>
    <batch-asing @reloadOdis=reloadOdis :odiGroup="groupOdi">
    </batch-asing>
    <show-info :request="request_info"></show-info>
  </section>
</template>
<script>
import AsingForm from './AsingForm.vue';
import FormModal from './Form.vue';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
import BatchAsing from './BatchAsing.vue';
import ShowInfo from "./Info.vue";


export default {
  components: {
    FormModal,
    AsingForm,
    PulseLoader,
    BatchAsing,
    ShowInfo
  },
  data() {
    return {
      odis: [],
      odisApproved: [],
      editmode: false,
      color_dot: 'red',
      approved: 0,
      list: new Object(),
      listApproved: new Object(),
      groupOdi: [],
      actualTab: 1,
      loading: false,
      color: '#FFDAB9',
      size: '20px',
      limit:5,
      coord: '',
      filterAppro: '',
      filter: '',
      request_info: new Object({
        contract:{
          nro_contract:'',
          nro:'',
          client:{
            email: '',
            address: '',
            celphone: ''
          },
          parroquia:{
            parroquia: "",
          },
          sector:{
            name:""
          },
          subsector:{
            name:''
          },
          nap:{
            name:''
          },
          plan:{
            name: ''
          },
          service_request:{
            approved_date: ''
          }
         
        },
        instalator:{
          name: ''
        }

      }),
      argumentResolutionError:'',
     
    }
  },
  created() {
    this.allOdis();
    this.allOdisApproved();
  },
  methods: {

    allOdis(page = 1) {
      this.loading = true;
      axios.get("api/odis?page=" + page).then((response) => {
        this.odis = response.data.data;
        this.list = response.data;
        this.odis.map(x => {
          x.instated_text = (x.instalated == 1) ? 'Instalado' : 'Pendiente'
          if (x.instalated == 1 && x.instalator_id !== null) {
            x.color = 'green';
          } else if (x.instalated == 0 && x.instalator_id !== null) {
            x.color = 'orange';
          } else {
            x.color = 'red';
          }

          if (x.instalator == null) {
            x.instalator = []
            x.instalator.name = 'Por Asignar'
          }
          
        })
        
        this.loading = false;

      });
    },
    filterAll(page){
      this.loading = true;
      if(this.filter){
        if(typeof(page)!= 'number') {
        page = 1;
        }
        axios.get(`api/odis/filter/${this.filter}?page=` + page).then((response) => {
        
        this.odis = response.data.data;
        this.list = response.data;
        this.odis.map(x => {
          x.instated_text = (x.instalated == 1) ? 'Instalado' : 'Pendiente'
          if (x.instalated == 1 && x.instalator_id !== null) {
            x.color = 'green';
          } else if (x.instalated == 0 && x.instalator_id !== null) {
            x.color = 'orange';
          } else {
            x.color = 'red';
          }

          if (x.instalator == null) {
            x.instalator = []
            x.instalator.name = 'Por Asignar'
          }
          
        })
        
        this.loading = false;

      });
      } else {
        this.allOdis(1);
        }
    },
    
    allOdisApproved(page = 1) {
      this.loading = true;
      axios.get("api/odis/listApproved?page=" + page).then((response) => {
        this.odisApproved = response.data.data;
        this.listApproved = response.data;
        this.odisApproved.map(x => {
          x.instated_text = (x.instalated == 1) ? 'Instalado' : 'Pendiente'
          if (x.instalated == 1 &&  x.approved == 1) {
            x.color = 'green';
          } else if (x.instalated == 1 && x.approved == 0) {
            x.color = 'blue';
          } else {
            x.color = 'grey';
          }
          x.isApproved = (x.instalated == 1 && x.approved == 1) ? false : true;
        })
        this.loading = false;
      });
    },
    filterApproved(page){
      this.loading = true;
      if(this.filterAppro){
        if(typeof(page)!= 'number') {
        page = 1;
        }
        axios.get(`api/odis/filterA/${this.filterAppro}?page=` + page).then((response) => {
        this.odisApproved = response.data.data;
        console.log(this.odisApproved)
        this.listApproved = response.data;
        this.odisApproved.map(x => {
          x.instated_text = (x.instalated == 1) ? 'Instalado' : 'Pendiente'
          if (x.instalated == 1 &&  x.approved == 1) {
            x.color = 'green';
          } else if (x.instalated == 1 && x.approved == 0) {
            x.color = 'blue';
          } else {
            x.color = 'grey';
          }
          x.isApproved = (x.instalated == 1 && x.approved == 1) ? false : true;
        })
      });
      } else {
        this.allOdisApproved(1);
      }
      this.loading = false;
    },
    editOdi(odi) {
      
      this.editmode = true;
      //this.$children[1].form.reset();
      $("#addNew").modal("show");
      $('#nav-client-tab').tab("show")
      this.$children[1].form.fill(odi);
    },
    approveOdi(odi) {
      this.$Progress.start();
      Swal.fire({
        title: "Esta seguro?",
        text: "de aprobar la  ODI" + odi.id,
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
        cancelButtonText: "No"
      }).then((result) => {
        if (result.value) {
          axios
            .put("api/odis/approve-odi/"+odi.id, odi)
            .then((response) => {
              Toast.fire({
                icon: "success",
                title: "Instalación aprobada",
              });
              this.$Progress.finish();
              this.allOdis();
              this.allOdisApproved();
            })
            .catch((error) => {
              
              Toast.fire({
                icon: "error",
                title: "Error inesperado, si persiste comuniquese con el Administrador del sistema",
              });
            });
        }
      });

    },
    deleteOdi(id) {

    },
    asingOdi(odi) {

      $("#asingInstalator").modal("show");
      this.$children[2].form.fill(odi);
    },
    generateOdi(id) {
      axios.get('api/odis-form/' + id).then((response) => {
        
        let file = new Blob([response.data], { type: "application/pdf" });
        const fileURL = URL.createObjectURL(file);
        const link = document.createElement('a');
        link.href = fileURL;
        link.setAttribute('download', "ODI-" + id + '.pdf');
        document.body.appendChild(link);
        link.click();
      }).catch(err => {
        console.log(err)
      })
    },
    reloadOdis() {
      this.allOdis();
    },
    nextTab(val) {
      this.actualTab = val;
    },
    /*seeOdi(odi) {
      console.log(odi)
      $("#showInfo").modal("show");
      this.request_info = odi;

    },*/
    assingByGroup(){
      $("#batchAsing").modal("show");
      /*let form = new FormData();
      form.append('groupOdi', this.groupOdi);
      axios({
        url: `/api/odis/assing-group`,
        method: 'post',
        data: form
      })
      .then( response => {
        console.log(response)
      }).catch(err => {
        console.log(err)
      })*/
    }
  }


}
</script>
