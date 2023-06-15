<template>
  <section class="content">
        <div class="container-fluid">
            <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><strong>Planes</strong></h3>

              <div class="card-tools">
                <button
                  type="button"
                  class="btn btn-sm btn-primary"
                  @click="newModal"
                >
                  <i class="fa fa-plus-square"></i>
                  Nuevo
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <div class="col-md-4 mb-4">
                  <input type="text" @keyup="filterPlans" class="form-control" id="filterInput" placeholder="Buscar" v-model="tofilter">
                </div>
                <table class="table table-hover">
                  <thead>
                    <tr class="text-center">
                      <th>Plan</th>
                      <th>Descripción</th>
                      <th>Precio</th>
                      <th>Activo</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="loading" class="text-center">
                        <td colspan="5" class="text-center">
                            <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                        </td>
                    </tr>
                    <tr v-for="plan in plans" :key="plan.id" class="text-center">
                      <td>{{ plan.name }}</td>
                      <td class="text-capitalize">{{ plan.description }}</td>
                      <td class="text-capitalize">{{ plan.price }}<strong>$</strong></td>
                      <td>{{ plan.active_text }}</td>
                      <td>
                        <a href="#" @click="edit(plan)">
                          <i class="fa fa-edit blue"></i>
                        </a>
                        
                        <a href="#" @click="deleteItem(plan.id)">
                          <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination
                :data="list"
                v-if="tofilter!=''"
                @pagination-change-page="filterPlans"
              ></pagination>
              <pagination
                :data="list"
                v-if="tofilter==''"
                @pagination-change-page="getResults"
              ></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
        <form-plan 
          :titulo="titulo" 
          v-on:click="handleAction()" 
          :item="the_item" 
          @add="add" 
          :edit="editedIndex">
        </form-plan>
    </section>
</template>
<script>
import Btable from '../Table.vue';
import FormPlan from './FormPlan.vue'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
export default {
  
  data() {
    return {
      planes: "PLANES",
      loading: false,
      editmode: false,
      titulo: 'Nuevo Plan',
      plans: [],
      editedIndex: -1,
      form: new Form({
        name: "",
        description: "",
        price: 0,
        active: true,
      }),
      headers: ['Plan', 'Descripción', 'Precio', 'Activo'],
      search: "",
      dialog: false,
      the_item: new Object(),
      list:new Object(),
      loading: false,
      color: '#FFDAB9',
      size: '20px',
      tofilter: '',
    };
  },
  components:{
        Btable,
        FormPlan,
        PulseLoader
      },
  created() {
    this.getResults();
  },

  computed: {},
  methods: {
    getResults(page = 1)  {
      this.$Progress.start();
      this.loading = true;
      axios.get("api/plan/list?page="+page).then((response) => {
        this.plans = response.data.data;
         let copy  = JSON.parse(JSON.stringify(response.data))
         this.list = copy
        this.plans.map((v) => {
          v.active_text = v.active ? "Si" : "No";
        });
        this.loading = false;
      });
      this.$Progress.finish();
    },
    filterPlans(page) {
      if(this.tofilter){
        this.loading = true;
        if(typeof(page)!= 'number') {
          page = 1;
        }
        axios.get(`api/plan/filter/${this.tofilter}?page=`+page).then((response) => {
          this.plans = response.data.data;
          let copy  = JSON.parse(JSON.stringify(response.data))
          this.list = copy
          this.plans.map((v) => {
            v.active_text = v.active ? "Si" : "No";
          });
          this.loading = false;
        });
      } else {
        this.getResults(1)
      }
    },
    edit(item) {
      $("#exampleModal").modal("show");
      this.the_item = item ;
      this.editedIndex = 1 ;
    },
    deleteItem(id) {
      console.log(id);
      Swal.fire({
        title: "Esta seguro?",
        text: "Los datos eliminados no podrán recuperarse",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          this.form
            .delete("api/plan/delete/" + id)
            .then(() => {
              Swal.fire("Listo!", "Plan eliminado.", "success");
              // Fire.$emit('AfterCreate');
              this.getPlans();
            })
            .catch((data) => {
              Swal.fire("Error!", data.message, "warning");
            });
        }
      });
    },
    newModal() {
       $("#exampleModal").modal("show");
      this.the_item = new Object();
      this.editedIndex = -1;
    },
    add() {
      this.getResults(); 
    },
    update(){
    },
     handleAction(accion) {
            if(accion == 'edit'){
                this.titulo = 'Editar Plan'
            }
            else {
                this.titulo = 'Nuevo Plan'
            }
        }
  },
};
</script>