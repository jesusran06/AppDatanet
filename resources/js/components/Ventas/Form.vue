<template>
  <!-- Modal -->
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
            Nueva Solicitud de Servicio
          </h5>
          <h5 class="modal-title" v-show="editmode">
            Actualizar Solicitud de Servicio
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

        <form
          @submit.prevent="
            editmode ? update() : disable_approve ? approveRequest() : create()
          "
        >
          <div class="modal-body">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a
                  class="nav-item nav-link active show"
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
                  >Datos de Ubicación</a
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
                  id="nav-questionnarie-tab"
                  data-toggle="tab"
                  href="#nav-questionnarie"
                  role="tab"
                  aria-controls="nav-questionnarie"
                  aria-selected="false"
                  @click="nextTab(4)"
                  >Encuesta</a
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
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label for="">Tipo de Cliente</label>
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="radio"
                            v-model="form.typeClient"
                            id="typeClient1"
                            value="N"
                            :disabled="disable_approve"
                            @change="clearMe(), choiceSelected()"
                          />
                          <label class="form-check-label" for="typeClient1"
                            >Natural</label
                          >
                        </div>
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="radio"
                            v-model="form.typeClient"
                            id="typeClient2"
                            value="J"
                            :disabled="disable_approve"
                            @change="clearMe(), choiceSelected()"
                          />
                          <label class="form-check-label" for="typeClient2"
                            >Juridico</label
                          >
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <label for="">N° de Planilla</label>
                      <div class="form-group">
                        <input
                          type="number"
                          class="form-control-sm"
                          v-model.trim="$v.form.num_form.$model"
                          :class="{ 'is-invalid': form.errors.has('num_form') }"
                          placeholder="N° de Planilla"
                          :disabled="disable_approve"
                          maxlength="10"
                        />
                        <div v-if="$v.form.num_form.$error">
                          <span
                            v-if="!$v.form.num_form.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                          <span
                            v-if="!$v.form.num_form.minLength"
                            class="text text-danger"
                          >
                            Mínimo
                            {{
                              $v.form.num_form.$params.minLength.min
                            }}
                            caractéres.
                          </span>
                          <span
                            v-if="!$v.form.num_form.maxLength"
                            class="text text-danger"
                          >
                            Máx
                            {{
                              $v.form.num_form.$params.maxLength.max
                            }}
                            caractéres.
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6" v-if="form.typeClient == 'J'">
                      <div class="form-group">
                        <label>Nombre/Razón Social del Cliente</label>
                        <input
                          v-model.trim="$v.form.name.$model"
                          type="text"
                          name="name"
                          class="form-control"
                          :class="{ 'is-invalid': form.errors.has('name') }"
                          placeholder="Nombre/Razón Social"
                          :disabled="disable_approve"
                          @input="form.name = $event.target.value.toUpperCase()"
                        />
                        <div v-if="$v.form.name.$error">
                          <span
                            v-if="!$v.form.name.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6" v-if="form.typeClient == 'J'">
                      <div class="form-group">
                        <label>Cedula/Rif</label>
                        <the-mask
                          type="text"
                          class="form-control"
                          name="document"
                          v-model.trim="$v.form.document.$model"
                          :mask="['A#########']"
                          :masked="true"
                          :disabled="disable_approve"
                          :class="{
                            'is-invalid': form.errors.has('document'),
                          }"
                          @input="clearMe()"
                          placeholder="Nº de Documento"
                        />
                        <div v-if="$v.form.document.$error">
                          <span
                            v-if="!$v.form.document.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="" v-show="form.typeClient == 'N'"
                          >Nombres del Solicitante</label
                        >
                        <label for="" v-show="form.typeClient == 'J'"
                          >Nombres de Representante</label
                        >
                        <input
                          type="text"
                          v-model.trim="$v.form.names.$model"
                          name="names"
                          class="form-control"
                          :disabled="disable_approve"
                          :class="{
                            'is-invalid': form.errors.has('names'),
                          }"
                          placeholder="Nombres"
                          @input="
                            form.names = $event.target.value.toUpperCase()
                          "
                        />
                        <div v-if="$v.form.names.$error">
                          <span
                            v-if="!$v.form.names.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="" v-show="form.typeClient == 'N'"
                          >Apellidos del Solicitante</label
                        >
                        <label for="" v-show="form.typeClient == 'J'"
                          >Apellidos de Representante</label
                        >
                        <input
                          type="text"
                          v-model.trim="$v.form.last_names.$model"
                          name="last_names"
                          class="form-control"
                          :disabled="disable_approve"
                          :class="{
                            'is-invalid': form.errors.has('last_names'),
                          }"
                          placeholder="Apellidos"
                          @input="
                            form.last_names = $event.target.value.toUpperCase()
                          "
                        />
                        <div v-if="$v.form.last_names.$error">
                          <span
                            v-if="!$v.form.last_names.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="" v-show="form.typeClient == 'N'"
                          >Cédula del Solicitante</label
                        >
                        <label for="" v-show="form.typeClient == 'J'"
                          >Cédula de Representante</label
                        >
                        <the-mask
                          type="text"
                          class="form-control"
                          name="cedula"
                          v-model="$v.form.document2.$model"
                          :mask="['#########']"
                          :masked="true"
                          :disabled="disable_approve"
                          :class="{
                            'is-invalid': form.errors.has('cedula'),
                          }"
                          placeholder="Cedula de Identidad"
                        />
                        <div v-if="$v.form.document2.$error">
                          <span
                            v-if="!$v.form.document2.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Fecha de Nacimiento</label>
                        <input
                          type="date"
                          class="form-control"
                          name="birthdate"
                          :disabled="disable_approve"
                          v-model="$v.form.birthdate.$model"
                          @input="isAdult(form.birthdate)"
                          :class="{
                            'is-invalid': form.errors.has('birthdate'),
                          }"
                        />
                        <div v-if="!isAdult(form.birthdate)">
                          <span class="text text-danger">
                            * El solicitante debe ser Mayor de Edad
                          </span>
                        </div>
                        <div v-if="$v.form.birthdate.$error">
                          <span
                            v-if="!$v.form.birthdate.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm">
                      <div class="form-group">
                        <label>Dirección Completa</label>
                        <input
                          v-model="$v.form.address.$model"
                          type="text"
                          name="address"
                          class="form-control"
                          :disabled="disable_approve"
                          :class="{
                            'is-invalid': form.errors.has('address'),
                          }"
                          placeholder="Avenida/Calle/Urbanizacion/Edif./N° Casa-Apto"
                          @input="
                            form.address = $event.target.value.toUpperCase()
                          "
                        />
                        <div v-if="$v.form.address.$error">
                          <span
                            v-if="!$v.form.address.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Parroquia</label>
                        <v-select
                          :options="parro"
                          label="parroquia"
                          v-model="$v.form.parroquia.$model"
                          :disabled="disable_approve"
                          placeholder="Parroquias"
                          :class="{
                            'is-invalid': form.errors.has('parroquia'),
                          }"
                        >
                        </v-select>
                        <div v-if="$v.form.parroquia.$error">
                          <span
                            v-if="!$v.form.parroquia.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Sector</label>
                        <v-select
                          :options="sectores"
                          label="name"
                          v-model="$v.form.sector.$model"
                          :disabled="disable_approve"
                          :clearable="clearable"
                          placeholder="Sectores"
                          :class="{
                            'is-invalid': form.errors.has('sector'),
                          }"
                          @option:selected="getSubsectors"
                        >
                        </v-select>
                        <div v-if="$v.form.sector.$error">
                          <span
                            v-if="!$v.form.sector.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Subsector</label>
                        <v-select
                          :options="subsectores"
                          label="name"
                          v-model="$v.form.subsector.$model"
                          :disabled="disable_approve"
                          :clearable="clearable"
                          placeholder="Sub-Sectores"
                          :class="{
                            'is-invalid': form.errors.has('subsector'),
                          }"
                        >
                        </v-select>
                        <div v-if="$v.form.subsector.$error">
                          <span
                            v-if="!$v.form.subsector.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Teléfono Móvil</label>
                        <the-mask
                          type=""
                          class="form-control"
                          name="celphone"
                          v-model="$v.form.celphone.$model"
                          :mask="['####-#######']"
                          :masked="true"
                          :disabled="disable_approve"
                          :class="{
                            'is-invalid': form.errors.has('celphone'),
                          }"
                          placeholder="Teléfono Móvil"
                          @input="checkCellphone"
                        />
                        <div v-if="$v.form.celphone.$error">
                          <span
                            v-if="!$v.form.celphone.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="haveWs"
                            id="haveWs"
                            @click="haveWsp"
                            :disabled="notCellphone"
                          />
                          <i class="fab fa-whatsapp text-primary"></i>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Whatsapp</label>
                        <the-mask
                          type=""
                          class="form-control"
                          name="whatsapp"
                          v-model="form.whatsapp"
                          :mask="['####-#######']"
                          :masked="true"
                          :disabled="disable_approve"
                          placeholder="Whatsapp"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Email</label>
                        <input
                          v-model="$v.form.email.$model"
                          type="email"
                          name="email"
                          class="form-control"
                          :disabled="disable_approve"
                          :class="{
                            'is-invalid': form.errors.has('email'),
                          }"
                          autocomplete="false"
                          placeholder="nombre@correo.com"
                          @input="
                            form.email = $event.target.value.toUpperCase()
                          "
                        />
                        <div v-if="$v.form.email.$error">
                          <span
                            v-if="!$v.form.email.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                          <span
                            v-if="!$v.form.email.email"
                            class="text text-danger"
                          >
                            * Formato invalido
                          </span>
                        </div>
                      </div>
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
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">NAP</label>
                        <v-select
                          :options="naps"
                          label="name"
                          v-model="$v.form.nap.$model"
                          :clearable="nap_clearable"
                          :disabled="disable_approve"
                          placeholder="Naps"
                          :class="{
                            'is-invalid': form.errors.has('nap'),
                          }"
                        >
                        </v-select>
                        <div v-if="$v.form.nap.$error">
                          <span
                            v-if="!$v.form.nap.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>

                        
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label for="">Dist.Aprox</label>
                      <input
                        v-model="form.distance"
                        name="distance"
                        inputmode="numberic"
                        class="form-control"
                        :disabled="disable_approve"
                        placeholder="Dist.Aprox Mts"
                      />
                    </div>
                  </div>

                  <div class="row align-items-center">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for=""
                          >Ubicación GPS
                          <a
                            href="#"
                            @click="coordenates()"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Pulse para recibir la ubicación GPS"
                          >
                            <i
                              class="fa fa-map-marker"
                              :class="color_gps"
                              v-show="!disable_approve"
                            ></i>
                          </a>
                          <a
                            href="#"
                            @click="editCoordenates()"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Pulse para recibir la ubicación GPS"
                          >
                            <i class="fa fa-pen" v-show="!disable_approve"></i>
                          </a>
                        </label>
                        <div class="row">
                          <div class="col-6">
                            <label for="">Latitud</label>
                            <input
                              v-model="gps.lat"
                              type="text"
                              class="form-control"
                              placeholder="Latitud"
                              inputmode="numberic"
                              :disabled="disable_coord"
                            />
                          </div>
                          <div class="col-6">
                            <label for="">Longitud</label>
                            <input
                              v-model="gps.lng"
                              type="text"
                              :disabled="disable_coord"
                              class="form-control"
                              placeholder="Longitud"
                              inputmode="numberic"
                            />
                          </div>
                        </div>
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
                    <div class="col-sm">
                      <div class="form-group">
                        <label for="">Instalación </label>
                        <v-select
                          :options="instalations"
                          v-model="$v.form.instalation.$model"
                          label="name"
                          @option:selected="showInstalarionSelected"
                          :clearable="clearable"
                          :disabled="disable_approve"
                          placeholder="Paquetes de Instalación"
                          :class="{
                            'is-invalid': form.errors.has('instalation'),
                          }"
                          ref="instalations_ref"
                        >
                        </v-select>
                        <div v-if="$v.form.instalation.$error">
                          <span
                            v-if="!$v.form.instalation.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm">
                      <div class="form-group">
                        <label>Planes</label>
                        <v-select
                          :options="plans"
                          label="name"
                          v-model="$v.form.plan.$model"
                          @option:selected="showPlanSelected"
                          :clearable="clearable"
                          :disabled="disable_approve || disabled_by_onu_instalation"
                          placeholder="Planes"
                          :class="{
                            'is-invalid': form.errors.has('plans'),
                          }"
                        >
                        </v-select>
                        <div v-if="$v.form.plan.$error">
                          <span
                            v-if="!$v.form.plan.required"
                            class="text text-danger"
                          >
                            * Campo requerido
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="row" v-if="form.instalation.id > 2 && form.instalation.id < 7">
                    <div class="col-sm">
                      <div class="form-group">
                        <label for="">Operadora Actual </label>
                        <v-select
                          :options="operators_filtered"
                          v-model="form.operator"
                          label="name"
                          :clearable="clearable"
                          :disabled="disable_approve"
                          placeholder="Operadoras"
                        >
                        </v-select>
                      </div>
                    </div>
                  </div>
                  <label for="">Adicionales</label>
                  <div class="d-flex flex-row">
                    <div class="p-3 col-sm-2">
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="router"
                          v-model="form.router"
                          :disabled="disable_approve"
                          value="1"
                          @change="activeAdditional($event)"
                        />
                        <label class="form-check-label" for="router"
                          >Router</label
                        >
                      </div>
                    </div>

                    <div class="p-2 col-sm-4">
                      <v-select
                        :options="itemPrices"
                        v-model="form.router_model"
                        label="name"
                        :clearable="clearable"
                        @input="addRouter"
                        placeholder="Routers Disponibles"
                        :disabled="form.router == 0"
                      >
                      </v-select>
                    </div>
                    <div class="p-2 col-sm-4">
                      <input
                        type="text"
                        v-model="form.router_serial"
                        placeholder="Serial del Router"
                        class="form-control"
                        :disabled="form.router == 0"
                      />
                    </div>
                  </div>
                  <div class="d-flex flex-row">
                    <div class="p-3 col-sm-2">
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            id="cable"
                            v-model="form.cable"
                            :disabled="disable_approve"
                            value="1"
                            @change="activeAdditional($event)"
                          />
                          <label class="form-check-label" for="cable"
                            >Cable</label
                          >
                        </div>
                      </div>
                    <div class="p-2 col-sm-4">
                      
                      <input
                        inputmode="numeric"
                        v-model="form.mount_cable"
                        class="form-control"
                        placeholder="Monto Abonado"
                        :disabled="form.cable == 0"
                        @input="addCable"
                      />
                    </div>
                  </div>
                  <div class="d-flex flex-row">
                    <div class="p-3 col-sm-2">
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="prorateo"
                          v-model="form.prorateo"
                          :disabled="disable_approve"
                          value="1"
                          @change="activeAdditional($event)"
                        />
                        <label class="form-check-label" for="prorateo"
                          >Prorateo</label
                        >
                      </div>
                    </div>
                    <div class="p-2 col-sm-4">
                      <input
                        inputmode="numeric"
                        v-model="form.mount_prorateo"
                        class="form-control"
                        placeholder="Monto abonado"
                        @input="addProrateo"
                        :disabled="form.prorateo == 0"
                      />
                    </div>
                  </div>
                  <div class="row justify-content-center" v-if="this.form.instalation.id == 7">
                    <div class="p-2 col-sm">
                      <div style="font-size: 12px" class="red">
                        <strong>
                          Esta Promo debe ser cancelada en su totalidad al momento de la contratación
                        </strong> 
                      </div>
                    </div>
                  </div>

                  <hr />
                  <div>
                    <div class="row justify-content-center">
                      <div class="col-sm-4 text-center">
                        <h4 class="mb-0">Recibo de Afiliación</h4>
                        <span class="" style="font-size: 0.7rem"
                          ><strong
                            >BCV: {{ bcv.exchange.toFixed(3) }}</strong
                          ></span
                        >
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm">
                        <table class="table table-hover table-sm table-striped">
                          <thead>
                            <tr class="table-info">
                              <th style="width: 60%">Item</th>
                              <th style="width: 20%" class="text-center">
                                Monto Divisas
                              </th>
                              <th style="width: 20%" class="text-center">
                                Monto Bs.
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="it in itemsSelected" :key="it.id">
                              <td>{{ it.name }}</td>

                              <td class="text-capitalize text-center">
                                {{ it.price }}<strong>$</strong>
                              </td>

                              <td class="text-capitalize text-center">
                                {{ (it.price * bcv.exchange).toFixed(2)
                                }}<strong></strong>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-capitalize">
                                <p class="h6"><strong>IVA 16%</strong></p>
                              </td>
                              <td class="text-capitalize text-center">
                                <p class="h4">
                                  <strong>-</strong>
                                </p>
                              </td>
                              <td class="text-capitalize text-center">
                                <p>
                                  <strong>{{
                                    (
                                      (calcTotal * bcv.exchange * 16) /
                                      100
                                    ).toFixed(2)
                                  }}</strong>
                                </p>
                              </td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <td class="text-capitalize">
                              <p class="h4"><strong>Total</strong></p>
                            </td>
                            <td class="text-capitalize text-center">
                              <p class="h4">
                                <strong>{{ calcTotal }}$</strong>
                              </p>
                            </td>
                            <td class="text-capitalize text-center">
                              <p class="h4">
                                <strong>{{
                                  parseFloat(
                                    (
                                      (calcTotal * bcv.exchange * 16) /
                                      100
                                    ).toFixed(2)
                                  ) +
                                  parseFloat(
                                    (calcTotal * bcv.exchange).toFixed(2)
                                  )
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
                            :disabled="disable_approve"
                            value="1"
                            @change="addInfo($event)"
                          />
                          <label class="form-check-label" for="cash_dl"
                            >Divisas en efectivo</label
                          >
                        </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input
                          inputmode="numeric"
                          v-model="form.mount_cash_dl"
                          class="form-control"
                          :disabled="disabled_cash_dl || disable_approve"
                          placeholder="Monto"
                        />
                      </div>
                      <div class="p-2 col-sm-4">
                        <input
                          type="text"
                          v-model="form.serials_cash_dl"
                          class="form-control"
                          :disabled="disabled_cash_dl || disable_approve"
                          placeholder="Seriales de Billetes"
                        />
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
                            :disabled="disable_approve"
                            value="1"
                            @change="addInfo($event)"
                          />
                          <label class="form-check-label" for="cash_dl"
                            >Bs. en efectivo</label
                          >
                        </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input
                          inputmode="numeric"
                          v-model="form.mount_cash_bs"
                          class="form-control"
                          :disabled="disabled_cash_bs || disable_approve"
                          placeholder="Monto"
                        />
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
                            :disabled="disable_approve"
                            @change="addInfo($event)"
                          />
                          <label class="form-check-label" for="zelle"
                            >Zelle</label
                          >
                        </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input
                          inputmode="numeric"
                          v-model="form.mount_zelle"
                          class="form-control"
                          :disabled="disabled_zelle || disable_approve"
                          placeholder="Monto"
                        />
                      </div>
                      <div class="p-2 col-sm-4">
                        <input
                          inputmode="email"
                          v-model="form.serial_zelle"
                          class="form-control"
                          :disabled="disabled_zelle || disable_approve"
                          placeholder="Email"
                        />
                      </div>
                      
                    </div>
                    <div class="d-flex flex-row" v-if="show_zelle">
                      <div class="p-3 col-sm-4"></div>
                        <div class="p-2 col-sm-4">
                          <input
                            inputmode="text"
                            v-model="form.titular_zelle"
                            class="form-control"
                            :disabled="disabled_zelle || disable_approve"
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
                            :disabled="disable_approve"
                            value="1"
                            @change="addInfo($event)"
                          />
                          <label class="form-check-label" for="bank_transfer"
                            >Transferencia Bancaria</label
                          >
                        </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input
                          inputmode="numeric"
                          v-model="form.mount_bank_transfer"
                          class="form-control"
                          :disabled="disabled_bank_transfer || disable_approve"
                          placeholder="Monto"
                        />
                      </div>
                      <div class="p-2 col-sm-4">
                        <input
                          type="text"
                          v-model="form.serial_bank_transfer"
                          class="form-control"
                          :disabled="disabled_bank_transfer || disable_approve"
                          placeholder="Referencia"
                        />
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
                            :disabled="disable_approve"
                            @change="addInfo($event)"
                          />
                          <label class="form-check-label" for="movil_paid"
                            >Pago Móvil</label
                          >
                        </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input
                          inputmode="numeric"
                          v-model="form.mount_movil_paid"
                          class="form-control"
                          :disabled="disabled_movil_paid || disable_approve"
                          placeholder="Monto"
                        />
                      </div>
                      <div class="p-2 col-sm-4">
                        <input
                          type="text"
                          v-model="form.serial_movil_paid"
                          class="form-control"
                          :disabled="disabled_movil_paid || disable_approve"
                          placeholder="Referencia"
                        />
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
                            :disabled="disable_approve"
                            @change="addInfo($event)"
                          />
                          <label class="form-check-label" for="movil_point"
                            >Punto de Venta</label
                          >
                        </div>
                      </div>
                      <div class="p-2 col-sm-2">
                        <input
                          inputmode="numeric"
                          v-model="form.mount_point"
                          class="form-control"
                          :disabled="disabled_point || disable_approve"
                          placeholder="Monto"
                        />
                      </div>
                      <div class="p-2 col-sm-4">
                        <input
                          type="text"
                          v-model="form.serial_point"
                          class="form-control"
                          :disabled="disabled_point || disable_approve"
                          placeholder="Referencia"
                        />
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
                              <th style="width: 20%" class="text-center">#</th>
                              <th style="width: 40%" class="text-center">
                                Monto Divisas
                              </th>
                              <th style="width: 40%" class="text-center">
                                Monto Bs.
                              </th>
                            </tr>
                          </thead>
                          <tr>
                            <td>Recibido</td>
                            <td class="text-capitalize text-center">
                              {{ calcDiv }}
                            </td>
                            <td class="text-capitalize text-center">
                              {{ calcBs }}
                            </td>
                          </tr>
                          <tr>
                            <td>Total a Pagar</td>
                            <td class="text-capitalize text-center">
                              {{ calcTotal }}$
                            </td>
                            <td class="text-capitalize text-center">
                              {{
                                parseFloat(
                                  (
                                    (calcTotal * bcv.exchange * 16) /
                                    100
                                  ).toFixed(2)
                                ) +
                                parseFloat(
                                  (calcTotal * bcv.exchange).toFixed(2)
                                )
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td>Diferencia</td>
                            <td class="text-capitalize text-center">
                              {{ parseFloat(calcDiv) - parseFloat(calcTotal) }}$
                            </td>
                            <td class="text-capitalize text-center">
                              {{
                                parseFloat(calcBs).toFixed(2) - [
                                  parseFloat(
                                    (
                                      (calcTotal * bcv.exchange * 16) /
                                      100
                                    ).toFixed(2)
                                  ) +
                                    parseFloat(
                                      (calcTotal * bcv.exchange).toFixed(2)
                                    ),
                                ]
                              }}
                            </td>
                          </tr>

                          <tbody></tbody>
                        </table>
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
                  <div class="row">
                    <div class="col-sm">
                      <label for="">Como supo de nosotros ?</label>
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="inlineCheckbox1"
                          v-model="form.questionnaire"
                          :disabled="disable_approve"
                          value="1"
                        />
                        <label class="form-check-label" for="inlineCheckbox1"
                          >Radio</label
                        >
                      </div>
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="inlineCheckbox2"
                          :disabled="disable_approve"
                          v-model="form.questionnaire"
                          value="2"
                        />
                        <label class="form-check-label" for="inlineCheckbox2"
                          >TV</label
                        >
                      </div>
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="inlineCheckbox3"
                          :disabled="disable_approve"
                          v-model="form.questionnaire"
                          value="3"
                        />
                        <label class="form-check-label" for="inlineCheckbox3"
                          >RRSS</label
                        >
                      </div>

                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="inlineCheckbox4"
                          :disabled="disable_approve"
                          v-model="form.questionnaire"
                          value="4"
                        />
                        <label class="form-check-label" for="inlineCheckbox3"
                          >Volante</label
                        >
                      </div>
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="inlineCheckbox5"
                          :disabled="disable_approve"
                          v-model="form.questionnaire"
                          value="5"
                        />
                        <label class="form-check-label" for="inlineCheckbox3"
                          >Referido</label
                        >
                      </div>
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="inlineCheckbox6"
                          :disabled="disable_approve"
                          v-model="form.questionnaire"
                          value="6"
                        />
                        <label class="form-check-label" for="inlineCheckbox3"
                          >Parada Pub.</label
                        >
                      </div>
                      <div class="form-check form-check-inline">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="inlineCheckbox7"
                          :disabled="disable_approve"
                          v-model="form.questionnaire"
                          value="7"
                        />
                        <label class="form-check-label" for="inlineCheckbox3"
                          >DTD</label
                        >
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="row">
                    <div class="col-sm">
                      <label for="floatingTextarea">Observaciones</label>
                      <div class="form-floating">
                        <textarea
                          class="form-control"
                          v-model="form.observations"
                          placeholder="Observaciones"
                          :disabled="disable_approve"
                          id="floatingTextarea"
                          @input="
                            form.observations =
                              $event.target.value.toUpperCase()
                          "
                        ></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-light"
              @click.prevent="prevTab"
              v-show="actualTab != 1"
            >
              <strong>❮ Anterior</strong>
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="clearForm"
            >
              Cerrar
            </button>
            <button
              type="button"
              class="btn btn-light"
              @click.prevent="nextTab2"
              v-show="actualTab !== 4"
            >
              <strong>Siguiente ❯</strong>
            </button>
            <button
              v-show="editmode"
              type="submit"
              class="btn btn-primary"
              v-if="actualTab == 4"
            >
              Actualizar
            </button>
            <button
              v-show="!editmode && !disable_approve"
              type="submit"
              class="btn btn-primary"
              v-if="actualTab == 4"
            >
              Guardar
            </button>
            <button
              v-show="disable_approve"
              type="buttom"
              @click="approveRequest"
              class="btn btn-success"
              v-if="actualTab == 4"
              :disabled="buttonDisabled"
            >
              Aprobar Venta
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import {
  required,
  maxLength,
  minLength,
  requiredIf,
  email,
} from "vuelidate/lib/validators";
export default {
  props: {
    parro: {
      type: Array,
    },
    editmode: {
      type: Boolean,
    },
    bcv: {
      type: Object,
    },
  },
  data() {
    return {
      form: new Form({
        id: "",
        num_form: "",
        name: "",
        address: "",
        document: "",
        document2: "",
        names: "",
        last_names: "",
        sector: "",
        subsector: "",
        celphone: "",
        whatsapp: "",
        email: "",
        plan: "",
        typeClient: "N",
        questionnaire: [],
        observations: "",
        nap: "",
        instalation: "",
        gps: [],
        distance: 0,
        parroquia: "",
        birthdate: null,
        cash_dl: false,
        mount_cash_dl: 0,
        serials_cash_dl: "",
        cash_bs: false,
        mount_cash_bs: 0,
        serials_cash_bs: "",
        bank_transfer: false,
        mount_bank_transfer: 0,
        serial_bank_transfer: "",
        zelle: false,
        mount_zelle: 0,
        serial_zelle: "",
        titular_zelle: "",
        email_zelle: "",
        movil_paid: false,
        mount_movil_paid: 0,
        serial_movil_paid: "",
        point: false,
        mount_point: 0,
        serial_point: "",
        total_dls_received: 0,
        total_bs_received: 0,
        mount_prorateo: "",
        mount_cable: "",
        cable: 0,
        router: 0,
        prorateo: 0,
        router_model: "",
        router_serial: "",
        operator: [],
      }),
      disable_approve: false,
      disabled_cash_dl: true,
      disabled_cash_bs: true,
      disabled_bank_transfer: true,
      disabled_zelle: true,
      disabled_movil_paid: true,
      disabled_point: true,
      sectores: [],
      subsectores: [],
      sales: [],
      plans: [],
      requests: [],
      list: [],
      selectedPlan: [{ name: "", price: "" }],
      itemPrices: [],
      itemsSelected: [],
      amount_total: 0,
      checkeds: [],
      haveWs: false,
      notCellphone: true,
      naps: [],
      instalations: [],
      clearable: true,
      selectedInstalation: [],
      actualTab: "1",
      nap_clearable: true,
      isJuridic: false,
      color_gps: "green",
      _names: "Apellido de Solicitante",
      _last_names: "Apellido de Solicitante",
      _document2: "Cédula de Solicitante",
      pos: [],
      gps: {
        lat: "",
        lng: "",
      },
      disable_coord: true,
      operators: [],
      operators_filtered: [],
      argumentResolutionError: "",
      length: "",
      buttonDisabled: false,
      disabled_router: true,
      objCable: new Object(),
      disabled_cable: true,
      disabled_prorateo: true,
      objProrateo: new Object(),
      show_zelle: false,
      disabled_by_onu_instalation:false
    };
  },
  validations: {
    form: {
      num_form: {
        required,
        minLength: minLength(2),
        maxLength: maxLength(10),
      },
      names: { required },
      name: {
        required: requiredIf(function () {
          if (this.form.typeClient == "J") {
            return true;
          } else return false;
        }),
      },
      address: { required },
      document: {
        required: requiredIf(function () {
          if (this.form.typeClient == "J") {
            return true;
          } else return false;
        }),
      },
      document2: { required },
      last_names: { required },
      sector: { required },
      subsector: { required },
      celphone: { required },
      email: {
        required,
        email,
      },
      plan: { required },
      birthdate: {
        required: requiredIf(function () {
          if (this.form.typeClient == "N") {
            return true;
          } else return false;
        }),
      },
      instalation: { required },
      parroquia: { required },
      nap: { required },
    },
  },
  created() {
    this.getPlans();
    this.getItemPrices();
    this.getInstalations();
    this.getNaps();
    this.getOperators();
  },
  watch: {
    loadParro(val) {
      return this.getSectors(val.id);
    },
  },
  computed: {
    loadParro() {
      return this.form.parroquia;
    },
    calcTotal() {
      this.amount_total = 0;
      this.itemsSelected.forEach((it) => {
        this.amount_total = (
          parseFloat(this.amount_total) + parseFloat(it.price)
        ).toFixed(2);
      });
      return this.amount_total;
    },
    calcDiv() {
      return (this.calcBs / this.bcv.exchange).toFixed(2);
    },
    calcBs() {
      return (
        parseFloat(this.form.mount_cash_dl * this.bcv.exchange) +
        parseFloat(this.form.mount_cash_bs) +
        parseFloat(this.form.mount_zelle * this.bcv.exchange) +
        parseFloat(this.form.mount_bank_transfer) +
        parseFloat(this.form.mount_movil_paid) +
        parseFloat(this.form.mount_point)
      ).toFixed(2);
    },
  },
  methods: {
    getPlans() {
      axios.get("api/plan/list").then((response) => {
        this.plans = response.data.data;
        /*this.plans.filter((p) => {
          return p.active;
        });*/
      });
    },
    getItemPrices() {
      axios.get("api/itemprice").then((response) => {
        this.itemPrices = response.data.filter((x) => x.category == "router");
      });
    },
    getSectors(id) {
      this.sectores = [];
      axios.get(`api/sector/getSelect/${id}`).then((response) => {
        this.sectores = response.data;
      });
    },
    selectSubsectors() {
      return true;
    },

    getNaps() {
      axios.get("api/nap/all").then((response) => {
        this.naps = response.data;
      });
    },

    getOperators() {
      axios.get("api/operators").then((response) => {
        this.operators = response.data;
      });
    },

    showPlanSelected() {
      this.selectedPlan = this.form.plan;
      this.selectedPlan.type = "plan";
      
      if(this.form.instalation != null || this.form.instalation != ""){
        if(this.form.instalation.id == 4){
          let price = parseFloat(this.selectedPlan.price) - 30;
          this.selectedPlan.price = parseFloat(this.selectedPlan.price) - 30;
          console.log("this.instalation",  price)
          if(this.selectedPlan.price < 0 || isNaN(this.selectedPlan.price)){
            this.selectedPlan.price = 0;         
          }
        }
      }else{
        Toast.fire({
                icon: "error",
                title: "Seleccione primero un tipo de Instalación",
              });
        //this.$refs.instalations_ref.focus();
      }
   
      let pos = this.itemsSelected.map((e) => e.type).indexOf("plan");

      if (pos == -1) {
        this.itemsSelected.push(this.selectedPlan);
      } else {
        this.itemsSelected.splice(pos, 1);
        this.itemsSelected.push(this.selectedPlan);
      }
    },
    showInstalarionSelected() {
      if(this.form.instalation.id == 2){
        this.form.plan = this.plans[1];
        this.disabled_by_onu_instalation = true;
        this.showPlanSelected();
      }else{
        this.disabled_by_onu_instalation = false;
      }
      this.selectedInstalation = this.form.instalation;
      this.selectedInstalation.type = "instalacion";
      if(this.form.instalation != null || this.form.instalation != ""){
        if(this.form.instalation.id == 4){
          let price = parseFloat(this.selectedPlan.price) - 30;
          this.selectedPlan.price = parseFloat(this.selectedPlan.price) - 30;
          console.log("this.instalation",  price)
          if(this.selectedPlan.price < 0 || isNaN(this.selectedPlan.price)){
            this.selectedPlan.price = 0;         
          }
        }
      }else{
        Toast.fire({
                icon: "error",
                title: "Seleccione primero un tipo de Instalación",
              });
        //this.$refs.instalations_ref.focus();
      }

      let pos = this.itemsSelected.map((e) => e.type).indexOf("instalacion");

      if (pos == -1) {
        this.itemsSelected.push(this.selectedInstalation);
      } else {
        this.itemsSelected.splice(pos, 1);
        this.itemsSelected.push(this.selectedInstalation);
      }

      if (this.form.instalation.id == 3 || this.form.instalation.id == 6) {
        //console.log(this.form.instalation);
        this.operators_filtered = [];
        this.form.operator = [];
        this.operators_filtered = this.operators.filter(
          (x) => x.category == "cable"
        );
      } else if (this.form.instalation.id == 5 || this.form.instalation.id == 4) {
        this.operators_filtered = [];
        this.form.operator = [];
        this.operators_filtered = this.operators.filter(
          (x) => x.category == "antena"
        );
      } else {
        this.operators_filtered = [];
        this.form.operator = [];
      }
    },

    clearMe() {
      let fc = this.form.document.substring(0).charCodeAt(0);
      let char = this.form.document.substring(0, 1);
      if (this.form.document.length > 1) {
        if (fc !== 69 || fc !== 86 || fc !== 80) {
          if (this.form.typeClient == "n") {
            this.form.document = this.form.document.replace(char, "V");
          } else {
            this.form.document = this.form.document.replace(char, "J");
          }
        }
      }
      return;
    },
    haveWsp() {
      if (!this.haveWs) {
        this.form.whatsapp = this.form.celphone;
      } else {
        this.form.whatsapp = "";
      }
    },
    checkCellphone() {
      if (this.form.celphone.length == 0) {
        this.notCellphone = true;
        this.form.whatsapp = "";
        this.haveWs = true;
      } else {
        this.notCellphone = false;
        this.haveWs = false;
      }
    },
    getInstalations() {
      axios.get("api/active-instalations").then((response) => {
        //console.log("instalations", response);
        this.instalations = response.data;
        this.instalations.map((e) => {
          e.price = e.total_cost;
        });
      });
    },
    approveRequest() {
      this.form.total_bs_received = this.calcBs;
      this.form.total_dls_received = this.calcDiv;
      this.$Progress.start();
      this.buttonDisabled = !this.buttonDisabled;
      Swal.fire({
        title: "Esta seguro?",
        text: "de aprobar la venta " + this.form.num_form,
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.value) {
          axios
            .post("api/approve-sale", this.form)
            .then((response) => {
              Toast.fire({
                icon: "success",
                title: "Aprobada, se ha generado un ODI para este cliente",
              });
              $("#addNew").modal("hide");
              this.$Progress.finish();
              this.actualTab = "1";
              this.clearForm();
              this.disable_approve = false;
              this.itemsSelected = [];
              $('a[href="#nav-questionnarie"]').removeClass("active");
              $('a[href="#nav-service"]').removeClass("active");
              $('a[href="#nav-ubication"]').removeClass("active");
              $('a[href="#nav-client"]').tab("show");
              this.$emit("reloadSales");
              this.buttonDisabled = !this.buttonDisabled;
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
    create() {
      this.$v.$touch();
      if (!this.$v.$invalid && this.isAdult(this.form.birthdate)) {
        if (this.form.birthdate != null) {
          this.form.birthdate = moment(this.form.birthdate).format(
            "YYYY-MM-DD"
          );
        }
        this.form.total_bs_received = this.calcBs;
        this.form.total_dls_received = this.calcDiv;
        this.pos.lat = this.gps.lat;
        this.pos.lng = this.gps.lng;

        this.form.gps = JSON.stringify(this.pos);
        this.form
          .post("api/request/store")
          .then((response) => {
            $("#addNew").modal("hide");
            $('a[href="#nav-questionnarie"]').removeClass("active");
            $('a[href="#nav-service"]').removeClass("active");
            $('a[href="#nav-ubication"]').removeClass("active");
            $('a[href="#nav-client"]').tab("show");
            Toast.fire({
              icon: "success",
              title: response.data.message,
            });

            this.$Progress.finish();
            this.clearForm();
            this.itemsSelected = [];
            this.$v.$reset();
            this.$emit("reloadSales");
            this.show_zelle = false;
          })
          .catch((error) => {
            console.log(error);
            Toast.fire({
              icon: "error",
              title: "Algo salió mal, por favor revise el formulario",
            });
          });
      } else {
        Toast.fire({
          icon: "error",
          title: "Rellene correctamente el formulario",
        });
        if(this.$v.form.nap.$invalid){
          this.actualTab = 2;
          $('a[href="#nav-client"]').removeClass("active");
          $('a[href="#nav-service"]').removeClass("active");
          $('a[href="#nav-questionnarie"]').removeClass("active");
          $('a[href="#nav-ubication"]').tab("show");
        }else{
          this.actualTab = 1;
          $('a[href="#nav-ubication"]').removeClass("active");
          $('a[href="#nav-service"]').removeClass("active");
          $('a[href="#nav-questionnarie"]').removeClass("active");
          $('a[href="#nav-client"]').tab("show");
        }
        
      }
    },
    update() {
      this.$v.$touch();
      if (!this.$v.$invalid && this.isAdult(this.form.birthdate)) {
        this.$Progress.start();
        this.form.birthdate = moment(this.form.birthdate).format("YYYY-MM-DD");
        this.form.total_bs_received = this.calcBs;
        this.form.total_dls_received = this.calcDiv;
        this.pos.lat = this.gps.lat;
        this.pos.lng = this.gps.lng;
        this.form.gps = JSON.stringify(this.pos);
        this.form.put(`api/request/update/${this.form.id}`).then((response) => {
          $("#addNew").modal("hide");
          if (response.status == 201) {
            Toast.fire({
              icon: "success",
              title: response.data.message,
            });
            this.$Progress.finish();
            this.actualTab = "1";
            this.clearForm();
            this.itemsSelected = [];
            $('a[href="#nav-questionnarie"]').removeClass("active");
            $('a[href="#nav-service"]').removeClass("active");
            $('a[href="#nav-ubication"]').removeClass("active");
            $('a[href="#nav-client"]').tab("show");
            this.$emit("reloadSales");
          } else {
            Toast.fire({
              icon: "error",
              title: response.data.message,
            });
          }
        });
      } else {
        Toast.fire({
          icon: "error",
          title: "Rellene correctamente el formulario",
        });
        this.actualTab = 1;
        $('a[href="#nav-ubication"]').removeClass("active");
        $('a[href="#nav-service"]').removeClass("active");
        $('a[href="#nav-questionnarie"]').removeClass("active");
        $('a[href="#nav-client"]').tab("show");
      }
    },
    nextTab(val) {
      this.actualTab = val;
      if (val == 2 && Object.entries(this.form.gps).length > 0) {
        this.gps.lat = this.form.gps.lat;
        this.gps.lng = this.form.gps.lng;
      }
    },
    clearForm() {
      this.itemsSelected = [];
      this.disabled_cash_dl = true;
      this.disabled_cash_bs = true;
      this.disabled_bank_transfer = true;
      this.disabled_zelle = true;
      this.disabled_movil_paid = true;
      this.disabled_point = true;
      this.form.reset();
      this.color_gps = "green";
      this.actualTab = 1;
      $('a[href="#nav-questionnarie"]').removeClass("active");
      $('a[href="#nav-service"]').removeClass("active");
      $('a[href="#nav-ubication"]').removeClass("active");
      $('a[href="#nav-client"]').tab("show");
    },
    addInfo(e) {
      //console.log(e)
      if (e.target) {
        if (e.target.id == "cash_dl") {
          this.disabled_cash_dl = e.target.checked ? false : true;
          this.form.mount_cash_dl = !e.target.checked
            ? 0
            : this.form.mount_cash_dl;
          this.form.serials_cash_dl = !e.target.checked
            ? ""
            : this.form.serials_cash_dl;
        } else if (e.target.id == "cash_bs") {
          this.disabled_cash_bs = e.target.checked ? false : true;
          this.form.mount_cash_bs = !e.target.checked
            ? 0
            : this.form.mount_cash_bs;
          //this.form.serials_cash_bs = (!e.target.checked) ? '' : this.form.serials_cash_bs;
        } else if (e.target.id == "zelle") {
          this.show_zelle = !this.show_zelle;
          this.disabled_zelle = e.target.checked ? false : true;
          this.form.mount_zelle = !e.target.checked ? 0 : this.form.mount_zelle;
          this.form.serial_zelle = !e.target.checked
            ? ""
            : this.form.serial_zelle;
        } else if (e.target.id == "bank_transfer") {
          this.disabled_bank_transfer = e.target.checked ? false : true;
          this.form.mount_bank_transfer = !e.target.checked
            ? 0
            : this.form.mount_bank_transfer;
          this.form.serial_bank_transfer = !e.target.checked
            ? ""
            : this.form.serial_bank_transfer;
        } else if (e.target.id == "movil_paid") {
          this.disabled_movil_paid = e.target.checked ? false : true;
          this.form.mount_movil_paid = !e.target.checked
            ? 0
            : this.form.mount_movil_paid;
          this.form.serial_movil_paid = !e.target.checked
            ? ""
            : this.form.serial_movil_paid;
        } else if (e.target.id == "point") {
          this.disabled_point = e.target.checked ? false : true;
          this.form.mount_point = !e.target.checked ? 0 : this.form.mount_point;
          this.form.serial_point = !e.target.checked
            ? ""
            : this.form.serial_point;
        }
      }
    },
    activeAdditional(e) {
      if (e.target.id == "cable") {
        this.disabled_cable = !this.disabled_cable;
        this.objCable.id = 88;
        this.objCable.name = "Cable";
        this.objCable.type = "cable";
        let pos = this.itemsSelected.map((e) => e.type).indexOf("cable");
        if (pos != -1) {
          this.itemsSelected.splice(pos, 1);
          this.form.mount_cable = '';
          this.objCable = new Object();
        }

        
      } else if (e.target.id == "prorateo") {
        this.disabled_prorateo = !this.disabled_prorateo;
        this.objProrateo.id = 99;
        //obj.price = this.form.mount_prorateo;
        this.objProrateo.name = "Prorateo";
        this.objProrateo.type = "prorateo";

        let pos = this.itemsSelected.map((e) => e.type).indexOf("prorateo");
        if (pos != -1) {
          this.itemsSelected.splice(pos, 1);
          this.form.mount_prorateo = '';
          this.objProrateo = new Object();
        }
        
      } else if (e.target.id == "router") {
        //console.log(this.form.router)
        this.disabled_router = (this.form.router == 0) ? true : false;
        let pos = this.itemsSelected.map((e) => e.type).indexOf("router");
        if (pos != -1) {
          this.itemsSelected.splice(pos, 1);
          this.form.router_model = null;
        }
      }
    },
    addRouter() {
      if (this.form.router_model) {
        this.selectedRouter = this.form.router_model;
        this.selectedRouter.type = "router";
      } else {
        return;
      }

      let pos = this.itemsSelected.map((e) => e.type).indexOf("router");

      if (pos == -1) {
        this.itemsSelected.push(this.selectedRouter);
      } else {
        this.itemsSelected.splice(pos, 1);
        this.itemsSelected.push(this.selectedRouter);
      }
    },
    addCable(){

      this.objCable.price = this.form.mount_cable;
      let pos = this.itemsSelected.map((e) => e.type).indexOf("cable");

        if (pos == -1) {
          this.itemsSelected.push(this.objCable);
        } else {
          this.itemsSelected.splice(pos, 1);
          this.itemsSelected.push(this.objCable);
        }
    },
    addProrateo(){
      this.objProrateo.price = this.form.mount_prorateo;
      let pos = this.itemsSelected.map((e) => e.type).indexOf("prorateo");
      if (pos == -1) {
          this.itemsSelected.push(this.objProrateo);
        } else {
          this.itemsSelected.splice(pos, 1);
          this.itemsSelected.push(this.objProrateo);
        }

    },
    choiceSelected() {
      this.isJuridic = this.form.typeClient == "j" ? true : false;
      if (this.form.typeClient == "j") {
        this._names = "Nombre de Representante";
        this._last_names = "Apellido de Representante";
        this._document2 = "Cédula de Representante";
      } else {
        this._names = "Nombre de Solicitante";
        this._last_names = "Apellido de Solicitante";
        this._document2 = "Cédula de Solicitante";
      }
    },
    coordenates() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            const pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };

            this.form.gps = JSON.stringify(pos); //pos.lat+";"+pos.lng;
            this.pos = pos;
            this.gps.lng = pos.lng;
            this.gps.lat = pos.lat;

            this.color_gps = "red";
            //infoWindow.setPosition(pos);
            //infoWindow.setContent("Location found.");
            //infoWindow.open(map);
            //map.setCenter(pos);
          },
          (error) => {
            console.log("error", error);
            //handleLocationError(true, infoWindow, map.getCenter());
          }
        );
      }
    },
    isAdult(dateString) {
      // Convertir la cadena de fecha en un objeto de fecha
      var selectedDate = new Date(dateString);

      // Obtener la fecha actual
      var currentDate = new Date();

      // Calcular la diferencia en milisegundos entre las dos fechas
      var diff = currentDate.getTime() - selectedDate.getTime();

      // Convertir la diferencia a años
      var age = Math.floor(diff / (1000 * 60 * 60 * 24 * 365));

      // Comprobar si la edad es mayor o igual a 18
      if (age >= 18) {
        return true;
      } else {
        return false;
      }
    },
    nextTab2() {
      console.log(this.actualTab);
      if (this.actualTab == 1) {
        this.actualTab = 2;
        $('a[href="#nav-client"]').removeClass("active");
        $('a[href="#nav-questionnarie"]').removeClass("active");
        $('a[href="#nav-service"]').removeClass("active");
        $('a[href="#nav-ubication"]').tab("show");
      } else if (this.actualTab == 2) {
        this.actualTab = 3;
        $('a[href="#nav-client"]').removeClass("active");
        $('a[href="#nav-ubication"]').removeClass("active");
        $('a[href="#nav-questionnarie"]').removeClass("active");
        $('a[href="#nav-service"]').tab("show");
      } else if (this.actualTab == 3) {
        this.actualTab = 4;
        $('a[href="#nav-client"]').removeClass("active");
        $('a[href="#nav-ubication"]').removeClass("active");
        $('a[href="#nav-service"]').removeClass("active");
        $('a[href="#nav-questionnarie"]').tab("show");
      }
    },
    prevTab() {
      console.log(this.actualTab);
      if (this.actualTab == 2) {
        this.actualTab = 1;
        $('a[href="#nav-questionnarie"]').removeClass("active");
        $('a[href="#nav-service"]').removeClass("active");
        $('a[href="#nav-ubication"]').removeClass("active");
        $('a[href="#nav-client"]').tab("show");
      } else if (this.actualTab == 3) {
        this.actualTab = 2;
        $('a[href="#nav-client"]').removeClass("active");
        $('a[href="#nav-questionnarie"]').removeClass("active");
        $('a[href="#nav-service"]').removeClass("active");
        $('a[href="#nav-ubication"]').tab("show");
      } else if (this.actualTab == 4) {
        this.actualTab = 3;
        $('a[href="#nav-client"]').removeClass("active");
        $('a[href="#nav-ubication"]').removeClass("active");
        $('a[href="#nav-questionnarie"]').removeClass("active");
        $('a[href="#nav-service"]').tab("show");
      }
    },
    editCoordenates() {
      this.disable_coord = !this.disable_coord;
    },
    getSubsectors() {
      //console.log("llego", this.form.sector)
      this.subsectores = [];
      this.subsectores =
        this.form.sector.subsectors !== null
          ? this.form.sector.subsectors
          : { id: 0, name: "", sector_id: this.form.sector.id };
    },
  },
};
</script>
<style scoped>
ul.no-bullets {
  list-style-type: none; /* Remove bullets */
  padding: 0; /* Remove padding */
  margin: 0; /* Remove margins */
}
hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 1;
  border-top: 2px solid rgba(0, 0, 0, 0.1);
}
</style>