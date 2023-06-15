<template>
    <section class="content">
        <div class="container-fluid">
            <Btable :data="list" 
            :headers="['Nombre', 'Caja', 'Parroquia', 'Sector']" @ChangeTittle="ChangeTittle" @getResults="getResults" 
            @getSearch="setSearch" :actions="[false, true, true]" :tittle="title" :loading="loading">
            </Btable>
            <div class="row row justify-content-end mx-3">
                <pagination
                :data="list"
                @pagination-change-page="getResults"
                :limit="limit"
              ></pagination>
            </div>
        </div>
        <FormNaps :tittle="tittle" :nap="toEdit" @getResults="getResults" :parroquias="parroquias" :sectors="sectors" 
        @getSectors="getSectors" @getSubsectors="getSubsectors" :subsectors="subsectors"></FormNaps>
    </section>
</template>

<script>
import FormNaps from '../Naps/FormNaps.vue';
import Btable from '../Table.vue';

export default {
    data(){
        return{
            title:"NAPS",
            limit:5,
            tittle: false,
            naps: {},
            list: {},
            nap: "",
            search: "",
            parroquias: [],
            sectors: [],
            subsectors: [],
            toEdit: {
                    id: "",
                    name: "",
                    nro: "",
                    address: "",
                    subsector: "",
                    sector: "",
                    parroquia: ""
                },
            limit:10,
            loading: false,
        }
    },
    components:{
        FormNaps,
        Btable,
    },
    created() {
        this.getResults(1);
        this.getParroquias();
    },
    computed: {
    },
    methods:{
        setSearch(tofilter){
            this.search = tofilter;
        },
        getParroquias(){
            axios.get("api/parroquias").then((response) => {
                this.parroquias = response.data;
            });
        },
        getSectors(id){
            this.sectors = [];
            
            axios.get(`api/sector/getSelect/${id}`).then((response) => {
                this.sectors = response.data;
            });
        },
        getSubsectors(id){
            this.subsectors = []
            
            axios.get(`api/sector/getSubSelect/${id}`).then((response) => {
                this.subsectors = response.data;
            });
        },
        ChangeTittle(action , item) {
            let filtrado = this.toEdit = this.naps.filter(obj=>{
                if ('id' in obj && obj.id == item.id) {
                    return true;
                } else {
                    return false;
                }})
            if(action == 'edit'){
                if (filtrado[0].subsector_id){
                    filtrado[0].subsector = filtrado[0].subsectors.filter(obj=>{
                    if ('id' in obj && obj.id == filtrado[0].subsector_id) {
                        return true;
                    } else {
                        return false;
                    }})
                } else{
                    filtrado[0].subsectors = null;
                }
                this.tittle = true;
                this.toEdit = filtrado[0]                
            }
            else if(action == "new"){
                this.tittle = false;
                this.toEdit= {
                    id: "",
                    name: "",
                    nro: "",
                    address: "",
                    subsector: "",
                    sector: "",
                    parroquia: ""
                }
            } else if(action == "delete"){
                this.delete(item.id)
            }
        },
        getResults(page = 1) {
            this.$Progress.start();
            this.loading = true;
            if(this.search == ''){
                axios.get("api/nap/list?page="+page).then((response) => {
                    this.naps = response.data.data;                
                    let copy  = JSON.parse(JSON.stringify(response.data))
                    copy.data.map((e)=>{
                        delete e['updated_at'];
                        delete e['created_at'];
                        delete e['address'];
                        delete e['gps'];
                        delete e['sector_id'];
                        delete e['subsector_id'];
                        delete e['subsectors'];
                        e.parroquia = e.parroquia.parroquia
                        e.sector = e.sector.name
                        return e
                        })
                    this.list = copy;
                    this.loading = false;
                });
            } else {
                this.filter(page, this.search)
            }
            this.$Progress.finish();
        },
        filter(page, searchable) {
            this.$Progress.start();
            this.loading = true;
            axios.get(`api/nap/filter/${searchable}?page=`+page).then((response) => {
                this.naps = response.data.data;
                let copy  = JSON.parse(JSON.stringify(response.data))
                copy.data.map((e)=>{
                    delete e['updated_at'];
                    delete e['created_at'];
                    delete e['address'];
                    delete e['gps'];
                    delete e['sector_id'];
                    delete e['subsector_id'];
                    delete e['sectorName'];
                    delete e['id_parroquia'];
                    delete e['parroquia_id'];
                    e.parroquia = e.parroquia.parroquia
                    e.sector = e.sector.name
                    return e
                    })
                    this.loading = false;    
                this.list = copy
            });
        },
        async delete(id) {
            Swal.fire({
                title: "Esta seguro?",
                text: "Los datos eliminados no podrán recuperarse",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Si",
            }).then((result) => {
                if (result.value) {
                    axios.put(`api/nap/deleteNap/${id}`).then((response) => {
                        $('#exampleModal').modal('hide');
                        if(response.status == 200){
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            this.getsectors();
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response.data.message,
                            });
                        }
                    });
                }
            })
             
         },
        
    }
}
</script>

<style>

</style>