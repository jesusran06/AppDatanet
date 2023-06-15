<template>
    <section class="content">
        <div class="container-fluid">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{tittle}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="mb-6">
                                            <label>Sector</label>
                                            <input type="text" class="form-control" id="sector" placeholder="Nombre del sector" v-model.trim="$v.sector.name.$model" 
                                            >
                                            
                                            <div v-if="$v.sector.name.$error">
                                                <span v-if="!$v.sector.name.required" class="text text-danger">
                                                    * Campo requerido
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="mb-4">
                                            <label>Parroquia</label>
                                            <v-select
                                                :options="parroquias"
                                                label="parroquia"
                                                v-model="sector.parroquia"
                                                placeholder="Parroquias"
                                                >
                                            </v-select>
                                            <div v-if="$v.sector.parroquia.$error">
                                                <span v-if="!$v.sector.parroquia.required" class="text text-danger">
                                                    * Campo requerido
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mt-3 ml-2">Subsectores</h5>
                                    <div class="input-group mb-3"
                                    v-for="(input, index) in sector.subsectors"
                                    :key="`subsector-${index}`">
                                        <input type="text" class="form-control ml-1" id="subsectors" placeholder="Nombre del susbsector" v-model="sector.subsectors[index].name">
                                        <br>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-danger rounded-circle ml-2" @click="removeField(index, sector.subsectors)" 
                                            type="button" v-show="sector.subsectors.length > 1">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <button class="btn btn-outline-primary" type="button" @click="addField(sector.subsectors)">
                                    <i class="fa fa-plus">Agregar</i>
                                </button>
                            </div>

                        </form>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" @click="Guardar()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { required, minLength } from 'vuelidate/lib/validators'

export default {
    data() {
        return {
            clearable: false,
            sector: {
                name: '',
                parroquia: '',
                subsectors: [],
            },
        };
    },
    validations: {
        sector:{
            name: {
                required
            },
            parroquia:{
                required
            }
        }
    },
    props: {
        tittle: String,
        sector: Object,
        parroquias: Array
    },
    methods:{
        addField(fieldType) {
            fieldType.push({});
        },
        removeField(index, fieldType) {
            fieldType.splice(index, 1);
        },
        async Guardar() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                let form = {
                    id: this.sector.id? this.sector.id : null,
                    name:this.sector.name,
                    subsectors:this.sector.subsectors[0].name == "" ? null :  this.sector.subsectors,
                    parroquia_id: this.sector.parroquia.id
                }
                await axios.post("api/sector/saveSector", form).then((response) => {
                    $('#exampleModal').modal('hide');
                    if(response.status == 201){
                        Toast.fire({
                            icon: "success",
                            title: response.data.message,
                        });
                        this.$v.$reset();
                        this.$emit('getResults');
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.data.message,
                        });
                    }
                });
            }
        },
    }
}
</script>

<style scoped>
.text-danger {
  font-size: 0.675em;
}
</style>