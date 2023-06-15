<template>
  <div
    class="modal fade"
    id="asingInstalator"
    tabindex="-1"
    role="dialog"
    aria-labelledby="addNewLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Asignar ODI-{{ form.id }}
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

        <form @submit.prevent="update()">
          <div
            class="align-content-center d-flex justify-content-between mx-3 title-container flex-column"
          >
            <div class="row">
              <div class="col-sm-6">
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
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Contrato N°</label>
                  <input
                    v-model="form.contract.nro"
                    type="text"
                    name="nro_contract"
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
                    name="social_razon"
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
                    class="form-control"
                    name="sector"
                    v-model="form.contract.sector.name"
                    disabled
                  />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="">Subsector</label>
                  <input
                    type="text"
                    class="form-control"
                    name="subsector"
                    v-model="form.contract.subsector.name"
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <div class="form-group">
                  <label>Nap</label>
                  <input
                    v-model="form.contract.nap.name"
                    type="text"
                    name="nap"
                    class="form-control"
                    disabled
                  />
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
                  <label>Instalador</label>
                  <v-select
                    @option:selected="asignado"
                    @clear="asignado"
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
              type="submit"
              class="btn btn-primary"
              :disabled="disabled"
            >
              Asignar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      disabled: true,
      clearable: true,
      form: new Form({
        id: "",
        instalator: [],
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
            observations: "",
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
            name: "",
          },
          plan: {
            name: "",
          },
          subsector: {
            name: "",
          },
        },
      }),
      instalators: [],
      length:''
    };
  },
  created(){
    this.techUsers();
  },
  methods: {
    update() {
         this.$Progress.start();
        this.form.put(`api/odis/set-instalator/${this.form.id}`)
        .then((response) => {
            $('#asingInstalator').modal('hide');
            if(response.status == 201){
                Toast.fire({
                    icon: "success",
                    title: response.data.message,
                });
                this.$Progress.finish();
                this.clearForm();
                this.selectedItems = [];
                this.$emit("reloadOdis");
            } else {
                Toast.fire({
                    icon: "error",
                    title: response.data.message,
                });
            }
        })

    },
    techUsers() {
      axios.get("api/user/role/" + 5).then((response) => {
        //console.log(response);
        this.instalators = response.data.data.data;
      });
    },
    clearForm(){
        this.form.reset()
    },
    asignado(){
        //console.log("entro ",this.form.instalator)
        this.disabled = (this.form.instalator !== []) ? false : true;
    }
  },
};
</script>