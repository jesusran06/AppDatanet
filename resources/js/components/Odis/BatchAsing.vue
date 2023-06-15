<template>
    <div
    class="modal fade"
    id="batchAsing"
    tabindex="-1"
    role="dialog"
    aria-labelledby="showInfoLabel"
    aria-hidden="true"
  >
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content"> 
                <div class="modal-header">
                <h5 class="modal-title">
                    Asignar ODI por Lotes
                </h5>
                
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form @submit.prevent="assing()">
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <p><strong>Asignar Técnico a ODIs:</strong> {{ odiGroup.map(obj => "ODI-"+obj.id).join(', ') }}</p>
                            <!--p v-for="odi in odiGroup" :key="odi.id">ODI-{{  odi.id }}</p-->
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
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
    props:{
        odiGroup:{
            type: Array,
            default: []
        }
    },
    data() {
        return {
            instalators: [],
            disabled: true,
            clearable: true,
            form: new Form({
                instalator: [],
                odis:this.odiGroup
            }),
            length:''
        }
    },
    created(){
        this.techUsers();
        
    },
    methods:{
        techUsers() {
            axios.get("api/user/role/" + 5).then((response) => {
                //console.log(response);
                this.instalators = response.data.data.data;
            });
        },
        asignado(){
        //console.log("entro ",this.form.instalator)
            this.disabled = (this.form.instalator !== []) ? false : true;
        },
        clearForm(){
        this.form.reset()
    },
    assing(){
      //$("#batchAsing").modal("show");
      //let form = new FormData();
      //this.form.append('groupOdi', this.groupOdi);
      Swal.fire({
        title: "Esta seguro",
        text: "de asignar este grupo de ODIs ?",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.value) {
          this.$Progress.start();
          this.form.odis = this.odiGroup
          axios({
                url: `/api/odis/assing-group`,
                method: 'post',
                data: this.form
            })
            .then( response => {
                //console.log(response)
                if(response.status == 200){
                Toast.fire({
                    icon: "success",
                    title: "Grupo de ODI asignadas con exito!",
                });
                    $("#batchAsing").modal("hide");
                    this.$Progress.finish();
                    this.clearForm();
                    this.$emit("reloadOdis");
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "Ups, ocurrió un error que resolveremos lo antes posible",
                    });
                }
            }).catch(err => {
                console.log(err)
            })
        }
      })

     
    }
    }
}
</script>
