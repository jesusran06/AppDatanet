<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title"><strong>Contratos</strong></h3>

                        <!--div class="card-tools">
                            <button
                            type="button"
                            class="btn btn-sm btn-primary"
                            @click="newModal"
                            >
                            <i class="fa fa-plus-square"></i>
                            Nuevo
                            </button>
                        </div-->
                        </div>
                        <div class="card-body table-responsive p-0">
                            <div class="align-content-center d-flex justify-content-between mb-3 title-container flex-column">
                                <div class="col-md-4 mb-4 mt-4">
                                    <input type="text" @keyup="filter" class="form-control" id="filterInput" placeholder="Buscar" v-model="tofilter">
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th>N° de Contrato</th>
                                        <th>Razón Social</th>
                                        <th>Dirección</th>
                                        <th>Sector</th>
                                        <th>Plan</th>
                                        <th>Desde</th>
                                        <th>Saldo</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="loading">
                                        <td colspan="8" class="text-center">
                                            <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                                        </td>
                                    </tr>
                                    <tr v-for="contract in contracts" :key="contract.id" class="text-center">
                                        <td>{{  contract.nro }}</td>   
                                        <td> {{ contract.social_razon }}</td>
                                        <td>{{ contract.client.address }}</td>
                                        <td>{{  contract.sector.name }}</td>
                                        <td>{{ contract.plan.name }}</td>
                                        <td>{{ contract.start_contract }}</td>
                                        <td :class="contract.class_balance"> {{ contract.balance_dls }}</td>
                                        <td :class="contract.class_status"><strong>{{ contract.status_text }}</strong></td>
                                        <td>
                                            <a href="#">
                                                <router-link :to="{ path: `/contract/${contract.id}`}">
                                                    <i class="fa fa-eye blue"></i>
                                                </router-link>
                                                
                                            </a>
                                            <a href="#">
                                                <i :class="contract.class_icon" data-toggle="tooltip" data-placement="top"
                                                    :title="(contract.active == 1) ? 'Desactivar Contrato' : 'Activar Contrato'"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                        <pagination
                            :data="list"
                            v-if="tofilter==''"
                            @pagination-change-page="getContracts"
                            :limit="limit"
                        ></pagination>
                        <pagination
                            :data="list"
                            v-if="tofilter!=''"
                            @pagination-change-page="filter"
                            :limit="limit"
                        ></pagination>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
</template>
<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import moment from 'moment';
export default {
    components:{
        PulseLoader
    },
    data() {
        moment.locale('es');
        return {
            contracts: [],
            list: new Object(),
            limit:5,
            class_balance: 'text-success',
            loading: false,
            color: '#FFDAB9',
            size: '20px',
            tofilter:'',
        }
    },
    created(){
        this.getContracts();
    },
    methods:{
        getContracts(page = 1){
            this.$Progress.start();
            this.loading = true;
            axios.get('api/contracts?page='+page)
            .then((response) => {
                this.contracts = response.data.data
                this.contracts.map(c => {
                    c.balance_dls = (c.balance_dls == null) ? '0.00' : Number(c.balance_dls).toFixed(2)
                    if(c.balance_dls == null || c.balance_dls <= 0){
                        c.class_balance = 'text-danger'
                    }else{
                        c.class_balance = 'text-success'
                    }
                    c.status_text = (c.active == 1) ? 'Activo' : 'Inactivo';
                    c.class_status =  (c.active == 1) ? 'text-success' : 'text-danger';
                    c.class_icon =  (c.active == 1) ? 'fa fa-toggle-on green' : 'fa fa-toggle-off red';
                    c.start_contract = moment(c.start_contract).format('L')
                })
                let copy  = JSON.parse(JSON.stringify(response.data))
                this.list = copy           
                this.loading = false;
                })
            this.$Progress.finish();
                    
        },
        filter(page){
            this.$Progress.start();
            this.loading = true;
            if(this.tofilter){
                if(typeof(page)!= 'number') {
                page = 1;
                }
                axios.get(`api/contracts/filter/${this.tofilter}?page=`+page)
                    .then((response) => {
                        this.contracts = response.data.data
                        this.contracts.map(c => {
                            c.balance_dls = (c.balance_dls == null) ? '0.00' : Number(c.balance_dls).toFixed(2)
                            if(c.balance_dls == null || c.balance_dls <= 0){
                                c.class_balance = 'text-danger'
                            }else{
                                c.class_balance = 'text-success'
                            }
                            c.status_text = (c.active == 1) ? 'Activo' : 'Inactivo';
                            c.class_status =  (c.active == 1) ? 'text-success' : 'text-danger';
                            c.class_icon =  (c.active == 1) ? 'fa fa-toggle-on green' : 'fa fa-toggle-off red';
                            c.start_contract = moment(c.start_contract).format('L')
                        })
                        let copy  = JSON.parse(JSON.stringify(response.data))
                        this.list = copy           
                        this.loading = false;
                        })
                this.$Progress.finish();
            } else {
                this.getContracts(1)
            }
        },
        show(id){
            this.route.push({ path: '/contract/' + id });
        }
    
    }
}
</script>
