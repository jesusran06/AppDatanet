<template>
  <!--section class="content"-->
  <!--div class="container-fluid"-->
  <!-- Modal -->
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ toEdit }}</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="modal-body">
                <div class="form-group">
                  <label for="plan">Nombre del Plan </label>
                <input
                  type="text"
                  class="form-control"
                  id="plan"
                  placeholder="Nombre del Plan"
                  v-model.trim="$v.item.name.$model"
                  ref="name"
                />
                <div v-if="$v.item.name.$error">
                  <span v-if="!$v.item.name.required" class="text text-danger">
                    * Campo requerido
                  </span>
                </div>
                </div>
                <div class="form-group">
                  <label for="plan">Descripción </label>
                <input
                  type="text"
                  class="form-control"
                  id="description"
                  placeholder="Descripción"
                  v-model="item.description"
                />
                </div>

                <div class="form-group">
                  <label for="price">Precio </label>
                <input
                  type="number"
                  min="0"
                  max="999"
                  class="form-control"
                  id="price"
                  placeholder="Precio"
                  v-model.trim="$v.item.price.$model"
                  />
                <div v-if="$v.item.price.$error">
                  <span v-if="!$v.item.price.required" class="text text-danger">
                    * Campo requerido
                  </span>
                </div>
                </div>

                <div class="form-group">
                  <div class="custom-control custom-switch">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="customSwitch1"
                    v-model="item.active"
                  />
                  <label class="custom-control-label" for="customSwitch1">{{
                    active_label
                  }}</label>
                </div>
                </div>
                
              </div>
               </form>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cerrar
          </button>
          <button type="button" class="btn btn-success" @click.prevent="sendData">
            Guardar
          </button>
        </div>
      </div>
    </div>
  </div>
  <!--/div-->
  <!--/section-->
</template>

<script>
import { required } from "vuelidate/lib/validators";

export default {
  props: {
    titulo: String,
    item: {
      type: Object,
    },
    edit: {
      type: Number,
      default: -1,
    },
  },
  data() {
    return {
      item: {
        name: "",
        description: "",
        price: "",
        active: "",
      },
    };
  },
  validations: {
    item:{
        name:{
          required
        },
        price:{
          required
        },
    }
  },
  computed: {
    active_label() {
      let change = this.item.active;
      if (change) {
        return "Activo";
      } else {
        return "Inactivo";
      }
    },
    toEdit() {
      return this.edit == 1 ? "Editar Plan" : "Agregar Plan";
      /*get: function () {
                return this.edit;
            },
            set: function (val) {
                this.edit === 1 ? (this.toEdit = -1) : (this.toEdit = 1);
            },*/
    },
  },
  methods: {
    sendData() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        let formData = new FormData();
        formData.append("name", this.item.name);
        formData.append("description", this.item.description);
        formData.append("price", this.item.price);
        formData.append("active", this.item.active);
        if (this.edit == -1) {
          axios.post("api/plan/store", formData).then((response) => {
            Toast.fire({
              icon: "success",
              title: "Datos creados!",
            });
            this.$v.$reset();
            this.$emit("add");
          });
        } else {
          formData.append("_method", "PUT");
          axios
            .post(`api/plan/update/${this.item.id}`, formData)
            .then((response) => {
              Toast.fire({
                icon: "success",
                title: "Datos actualizados!",
              });
              this.$emit("add");
            });
        }
        this.item.name = "";
        this.item.description = "";
        this.item.price = 0;
        $("#exampleModal").modal("hide");
      }
    },
  },
};
</script>

<style scoped>
.text-danger {
  font-size: 0.675em;
}
</style>