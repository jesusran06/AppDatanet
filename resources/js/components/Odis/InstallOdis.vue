<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <strong>Ordenes de Instalación</strong>
              </h3>
            </div>
            <div class="card-body table-responsive p-0">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a
                    class="nav-item nav-link active"
                    id="nav-client-tab"
                    data-toggle="tab"
                    href="#nav-unapprove"
                    role="tab"
                    aria-controls="nav-unapprove"
                    aria-selected="true"
                    @click="nextTab(1)"
                    >Por Instalar</a
                  >
                  <a
                    class="nav-item nav-link"
                    id="nav-ubication-tab"
                    data-toggle="tab"
                    href="#nav-approved"
                    role="tab"
                    aria-controls="nav-approved"
                    aria-selected="true"
                    @click="nextTab(2)"
                    >Instaladas</a
                  >
                </div>
              </nav>
              <div class="tab-content mt-4" id="nav-tabContent">
                <div
                  class="tab-pane fade show active"
                  id="nav-unapprove"
                  role="tabpanel"
                  aria-labelledby="nav-unapprove-tab"
                >
                  <div
                    class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                  >
                    <table class="table table-hover">
                      <tbody>
                        <tr v-if="loading">
                          <td class="text-center">
                            <pulse-loader
                              :loading="loading"
                              :color="color"
                              :size="size"
                            ></pulse-loader>
                          </td>
                        </tr>
                        <tr v-for="odi in odis" :key="odi.id">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">
                                Cliente N°
                                <strong class="text-danger'"
                                  >C-{{ odi.contract.client.id }}</strong
                                >
                              </h5>
                              <br /><br />
                              <div class="row justify-content-between">
                                <div class="col-8">
                                  <span class="h4"
                                    >Plan Contratado
                                    {{ odi.contract.plan.name }}
                                    <strong
                                      >{{ odi.contract.plan.price }}$</strong
                                    ></span
                                  >
                                  /mes
                                </div>
                                <div class="col-4 text-right">
                                  <a
                                    href="#"
                                    @click="dataSale(odi)"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Ver info de venta"
                                    style="text-decoration: none"
                                  >
                                    <i
                                      class="fa fa-tags red"
                                      style="font-size: 36px"
                                    ></i>
                                    <!--strong class="text-primary">
                                                                                    Ver Datos de Venta
                                                                                </strong-->
                                  </a>
                                </div>
                              </div>

                              <br /><br />
                              <div class="d-grid my-3">
                                <button
                                  class="btn btn-outline-dark btn-block"
                                  @click="editOdi(odi)"
                                >
                                  Ver ODI
                                </button>
                              </div>
                              <div class="row">
                                <div class="col-sm-6">
                                  <ul class="no-bullets">
                                    <li>
                                      <i
                                        class="fas fa-user-check text-primary"
                                      ></i
                                      ><strong class="text-primary">
                                        Cliente :
                                        {{ odi.contract.social_razon }}</strong
                                      >
                                    </li>
                                    <li>
                                      <i class="fas fa-home text-primary"></i
                                      ><strong class="text-primary">
                                        Dirección :{{
                                          odi.contract.client.address
                                        }}</strong
                                      >
                                    </li>
                                    <li>
                                      <i class="fas fa-globe text-primary"></i
                                      ><strong class="text-primary">
                                        Sector :{{ odi.contract.sector.name }}
                                      </strong>
                                    </li>
                                  </ul>
                                </div>
                                <div class="col-sm-6">
                                  <ul class="no-bullets">
                                    <li>
                                      <i class="fas fa-phone text-primary"></i
                                      ><strong class="text-primary">
                                        Teléfono/ Whatsapp :{{
                                          odi.contract.client.celphone
                                        }}
                                        /
                                        {{
                                          odi.contract.client.whatsapp
                                        }}</strong
                                      >
                                    </li>
                                    <li v-if="user.role_id == 1">
                                      <i class="fas fa-wrench text-primary"></i
                                      ><strong class="text-primary">
                                        Instalador Asignado :
                                        <span :class="odi.class">
                                          {{ odi.instalator.name }}</span
                                        >
                                      </strong>
                                    </li>
                                    <li>
                                      <i class="fas fa-edit text-primary"></i
                                      ><strong class="text-primary">
                                        Nro de Contrato :{{
                                          odi.contract.nro_contract
                                        }}
                                      </strong>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="mb-2"></div>
                        </tr>
                        <tr v-if="odis.length == 0 && loading == false">
                          <td class="text-center">No tienes ODI pendientes</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!--Tab de Odis instaladas AQUI -->
                <div
                  class="tab-pane fade"
                  id="nav-approved"
                  role="tabpanel"
                  aria-labelledby="nav-approved-tab"
                >
                  <div
                    class="align-content-center d-flex justify-content-between mb-3 title-container flex-column"
                  >
                    <table class="table table-hover">
                      <tbody>
                        <tr v-for="odi in odisApproved" :key="odi.id">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">
                                Cliente N°
                                <strong class="text-danger'"
                                  >C-{{ odi.contract.client.id }}</strong
                                >
                              </h5>
                              <br /><br />
                              <div class="row justify-content-between">
                                <div class="col-8">
                                  <span class="h4"
                                >Plan Contratado {{ odi.contract.plan.name }}
                                <strong
                                  >{{ odi.contract.plan.price }}$</strong
                                  ></span
                                >/mes
                                </div>
                                <div class="col-4 text-right" v-if="user.role_id != 1">
                                  <a
                                    href="#"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Ver info de instalación"
                                    style="text-decoration: none"
                                  >
                                  <router-link :to="{ path: `/odi/${odi.id}`}">
                                    <i
                                      class="fa fa-tags blue"
                                      style="font-size: 36px"
                                    ></i>
                                  </router-link>
                                    
                                  </a>
                                </div>
                                
                              </div>
                               <br /><br />
                             
                              <div class="row">
                                <div class="col-sm-6">
                                  <ul class="no-bullets">
                                    <li>
                                      <i
                                        class="fas fa-user-check text-primary"
                                      ></i
                                      ><strong class="text-primary">
                                        Cliente :
                                        {{ odi.contract.social_razon }}</strong
                                      >
                                    </li>
                                    <li>
                                      <i class="fas fa-home text-primary"></i
                                      ><strong class="text-primary">
                                        Dirección :{{
                                          odi.contract.client.address
                                        }}</strong
                                      >
                                    </li>
                                    <li>
                                      <i class="fas fa-globe text-primary"></i
                                      ><strong class="text-primary">
                                        Sector :{{ odi.contract.sector.name }}
                                      </strong>
                                    </li>
                                  </ul>
                                </div>
                                <div class="col-sm-6">
                                  <ul class="no-bullets">
                                    <li>
                                      <i class="fas fa-phone text-primary"></i
                                      ><strong class="text-primary">
                                        Teléfono/ Whatsapp :{{
                                          odi.contract.client.celphone
                                        }}
                                        /
                                        {{
                                          odi.contract.client.whatsapp
                                        }}</strong
                                      >
                                    </li>
                                    <li>
                                      <i
                                        class="fas fa-calendar text-primary"
                                      ></i
                                      ><strong class="text-primary">
                                        Fecha de Instalación :{{
                                          odi.instalation_date
                                        }}
                                      </strong>
                                    </li>
                                    <li>
                                      <i class="fas fa-edit text-primary"></i
                                      ><strong class="text-primary">
                                        Nro de Contrato :{{
                                          odi.contract.nro_contract
                                        }}
                                      </strong>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="mb-2"></div>
                        </tr>
                        <tr v-if="odisApproved.length == 0 && loading == false">
                          <td class="text-center">No hay ODI aprobadas</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <pagination
                :data="list"
                @pagination-change-page="pedingOdis"
                v-if="actualTab == 1"
                :limit="limit"
              ></pagination>
              <pagination
                :data="listApproved"
                @pagination-change-page="allOdisApproved"
                v-if="actualTab == 2"
                :limit="limit"
              ></pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
    <form-modal :editmode="editmode" @reloadOdis="reloadOdis"></form-modal>
    <sales-info :request="salesData"> </sales-info>
  </section>
</template>
<script>
import FormModal from "./Form.vue";
import PulseLoader from "vue-spinner/src/PulseLoader.vue";
import SalesInfo from "./SalesInfo.vue";

export default {
  components: {
    FormModal,
    PulseLoader,
    SalesInfo,
  },
  data() {
    return {
      actualTab: 1,
      list: new Object(),
      listApproved: new Object(),
      odis: [],
      odisApproved: [],
      editmode: true,
      loading: false,
      color: "#FFDAB9",
      size: "20px",
      limit: 5,
      user: "",
      argumentResolutionError: "",
      length: "",
      salesData: {
        service_request: {
          instalation: {
            total_cost: 0,
          },
        },
        plan: {
          name: "",
        },
      },
    };
  },
  created() {
    this.user = window.user;
    this.pedingOdis();
    this.allOdisApproved();
  },
  methods: {
    nextTab(val) {
      this.actualTab = val;
    },
    pedingOdis(page = 1) {
      this.loading = true;
      axios.get("api/odis?page=" + page).then((response) => {
        //console.log("response", response.data)
        this.odis = response.data.data;
        let copy = JSON.parse(JSON.stringify(response.data));
        this.list = response.data;
        this.loading = !this.loading;
        this.odis.map((x) => {
          if (x.instalator == null) {
            x.instalator = [];
            x.instalator.name = "Por Asignar";
            x.class = "text-danger";
          } else {
            x.class = "text-primary";
          }
        });
        //console.log("odis", this.odis)
      });
    },
    allOdisApproved(page = 1) {
      axios.get("api/odis/listApproved?page=" + page).then((response) => {
        //console.log("response", response.data)
        this.odisApproved = response.data.data;
        let copy = JSON.parse(JSON.stringify(response.data));
        this.listApproved = response.data;
      });
    },
    editOdi(odi) {
      console.log(odi);
      this.editmode = true;
      $("#addNew").modal("show");
      $("#nav-client-tab").tab("show");
      //this.$children[1].form.reset();
      this.$children[1].form.fill(odi);
    },
    reloadOdis() {
      this.pedingOdis();
      this.allOdisApproved();
    },
    dataSale(odi) {
      axios.get(`/api/odis/${odi.id}`).then((response) => {
        this.salesData = response.data.contract;
        $("#showInfo").modal("show");
        console.log(this.salesData);
      });
    },
  },
};
</script>
