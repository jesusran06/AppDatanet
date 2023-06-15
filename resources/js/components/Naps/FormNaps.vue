<template>
    <section class="content">
        <div class="container-fluid">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!tittle">Registrar NAP</h5>
                            <h5 class="modal-title" v-show="tittle">Actualizar datos de NAP</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="tittle ? update() : create()">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-4">
                                            <div class="form-row">
                                                <label>Nro de caja</label>
                                                <input type="number" class="form-control" id="nro" 
                                                placeholder="Numero" v-model.trim="$v.nap.nro.$model">
                                                <div v-if="$v.nap.nro.$error">
                                                    <span v-if="!$v.nap.nro.required" class="text text-danger">
                                                        * Campo requerido
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 mb-4">
                                            <div class="form-row">
                                                <label>Nombre</label>
                                                <input type="text" class="form-control" id="nombre" placeholder="Nombre" v-model.trim="$v.nap.name.$model">
                                                <div v-if="$v.nap.name.$error">
                                                    <span v-if="!$v.nap.name.required" class="text text-danger">
                                                        * Campo requerido
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label>Parroquia</label>
                                                <v-select
                                                    :options="parroquias"
                                                    label="parroquia"
                                                    v-model.trim="$v.nap.parroquia.$model"
                                                    clearable
                                                    placeholder="Parroquias">
                                                </v-select>
                                                <div v-if="$v.nap.parroquia.$error">
                                                    <span v-if="!$v.nap.parroquia.required" class="text text-danger">
                                                        * Campo requerido
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label>Sector</label>
                                                <v-select
                                                :options="sectors"
                                                label="name"
                                                v-model.trim="$v.nap.sector.$model"
                                                clearable
                                                placeholder="Sectores">
                                                </v-select>
                                                <div v-if="$v.nap.sector.$error">
                                                    <span v-if="!$v.nap.sector.required" class="text text-danger">
                                                        * Campo requerido
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 mb-4">
                                            <div class="form-group">
                                                <label>Subsector</label>
                                                <v-select
                                                :options="subsectors"
                                                label="name"
                                                v-model="nap.subsector"
                                                clearable
                                                placeholder="Subsectores">
                                                </v-select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="form-row">
                                            <label>Dirección</label>
                                            <textarea type="text" class="form-control" id="direccion" placeholder="Dirección" v-model="nap.address" 
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                    >
                                    Cerrar
                                    </button>
                                    <button v-show="tittle" type="submit" class="btn btn-primary">
                                    Guardar
                                    </button>
                                    <button
                                    v-show="!tittle"
                                    type="submit"
                                    class="btn btn-primary"
                                    >
                                    Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { required } from "vuelidate/lib/validators";
export default {
    data() {
        return {
            nap: {
                id: "",
                name: "",
                nro: "",
                address: "",
                sector:"",
                subsector: "",
                parroquia:"",
                sector:""
            },
        }
    },
    validations: {
        nap:{
            name: {
                required
            },
            nro:{
                required
            },
            sector:{
                required
            },
            parroquia:{
                required
            }
        }
    },
    props: {
        tittle: Boolean,
        nap: Object,
        parroquias: Array,
        sectors: Array,
        subsectors: Array
    },
    computed : {
        parro(){
            return this.nap.parroquia;
        },
        sect(){
            return this.nap.sector;
        }
    },
    watch:{
        parro(val) {
            this.$emit('getSectors', val.id);
        },
        sect(val) {
            this.$emit('getSubsectors', val.id);
        }
    },
    methods :{
        create() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                let form = {
                    nro: this.nap.nro,
                    name:this.nap.name,
                    sector_id:this.nap.sector.id,
                    subsector_id:this.nap.subsector? this.nap.subsector.id : null,
                    address: this.nap.address,
                }
                axios
                .post("api/nap/create", form)
                .then((response) => {
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
        update() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                this.$Progress.start();
                let form = {
                    id: this.nap.id,
                    nro: this.nap.nro,
                    name:this.nap.name,
                    sector_id: this.nap.sector.id,
                    subsector_id:this.nap.subsector? this.nap.subsector.id : null,
                    address: this.nap.address,
                }
                axios
                .put(`api/nap/update/${this.nap.id}`, form)
                .then((response) => {
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
                })
            }
        }
    }
}
</script>

<style>

</style>