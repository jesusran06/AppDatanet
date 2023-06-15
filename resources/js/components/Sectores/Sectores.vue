<template>
    <section class="content">
        <div class="container-fluid">
            <Btable :data="list" 
            :headers="['Nombre de sector', 'Parroquia']" @ChangeTittle="ChangeTittle" @getResults="getResults" 
            @getSearch="setSearch" :actions="[true, true, true]" :tittle="titleTable">
            </Btable>
            <div class="row row justify-content-end mx-3">
                <pagination
                :data="list"
                @pagination-change-page="getResults"
              ></pagination>
            </div>
        </div>
        <FormSector :tittle="tittle" :sector="toEdit" @getResults="getResults" :parroquias="parroquias"></FormSector>
        <Subsectors :subsectors="subsector" :sector="sector"></Subsectors>
    </section>
</template>

<script>
import FormSector from '../Sectores/FormSector.vue';
import Subsectors from '../Sectores/Subsectors.vue';
import Btable from '../Table.vue';
import moment from 'moment';

export default {
    data(){
        return{
            titleTable: "Sectores",
            tittle: "",
            sectors: {},
            list: {},
            sector: "",
            search:"",
            subsector: [],
            parroquias:[],
            toEdit: {
                    id: null,
                    name:"",
                    parroquia: '',
                    subsectors:[{id: null, name:""}]
                },
        }
    },
    components:{
        FormSector,
        Btable,
        Subsectors,
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
        ChangeTittle(action , item) {
            
            let filtrado = this.sectors.filter(obj=>{
                if ('id' in obj && obj.id == item.id) {
                    return true;
                } else {
                    return false;
                }
            })
            if(action == 'edit'){
                this.tittle = 'Editar Sector'
                this.toEdit = filtrado[0]
            }
            else if(action == "new"){
                this.tittle = 'Nuevo Sector'
                this.toEdit= {
                    id: null,
                    name:"",
                    parroquia: '',
                    subsectors:[{id: null, name:""}]
                }
            } else if(action == "view"){
                this.sector = filtrado[0].name
                this.subsector = filtrado[0].subsectors
                $('#subsectorsModal').modal('show');
            } else if(action == "delete"){
                this.delete(item.id)
            }
        },
        getResults(page = 1) {
            this.$Progress.start();
            if(this.search == ''){
                axios.get("api/sector/list?page="+page).then((response) => {
                    this.sectors = response.data.data;
                    let copy  = JSON.parse(JSON.stringify(response.data))
                    copy.data.map((e)=>{
                        delete e['updated_at'];
                        delete e['created_at'];
                        delete e['parroquia_id'];
                        delete e['subsectors'];
                        e.parroquia = e.parroquia.parroquia
                        return e
                    })
                    this.list = copy
                }); 
            } else {
                this.filter(page, this.search);
            }
            this.$Progress.finish();
        },
        filter(page, searchable) {
            axios.get(`api/sector/filter/${searchable}?page=`+page).then((response) => {
                this.sectors = response.data.data;
                let copy  = JSON.parse(JSON.stringify(response.data))
                copy.data.map((e)=>{
                    delete e['updated_at'];
                    delete e['created_at'];
                    delete e['id_parroquia'];
                    delete e['parroquia_id'];
                    delete e['id_municipio'];
                    delete e['subsectors'];
                    e.parroquia = e.parroquia.parroquia
                    return e
                })
                this.list = copy
            });
            this.$Progress.finish();
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
                    axios.delete(`api/sector/deleteSector/${id}`).then((response) => {
                        $('#exampleModal').modal('hide');
                        if(response.status == 200){
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                            });
                            this.getResults();
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