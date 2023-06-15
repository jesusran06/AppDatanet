<template>
    <section class="content">
   <div class="container-fluid">
     <div class="row">
       <div class="col-12">
         <div class="card">
           <div class="card-header">
             <h3 class="card-title"><strong>Reporte de ODIs</strong></h3>

             <div class="card-tools">
               <button type="button" class="btn btn-sm btn-primary"  @click.prevent="search()">
                 <i class="fa fa-filter"></i>
                 Filtrar
               </button>
               <button type="button" class="btn btn-sm btn-success" @click.prevent="reporte(is_search = true)">
                   <i class="fa fa-file-excel"></i>
                 Excel
               </button>
               <button
                     class="btn btn-sm btn-warning"
                     type="button"
                     @click.prevent="clean()"
                   ><i class="fa fa-times"></i>
                     Reset
                   </button>
             </div>
           </div>
           <div class="card-body">
               <div class="form-row">
               <!-- Borrar -->
               <div class="form-group col-md-3">
                 <label for="name">Instalador</label>
                 <multiselect 
                   v-model="instalator" 
                   tag-placeholder="Instaladores" 
                   placeholder="Instaladores" 
                   label="name" 
                   track-by="id" 
                   :options="instalators" 
                   :multiple="true" 
                   :taggable="true" 
                   :select-label="'Seleccione'"
                   :deselect-label="'Remover'"
                 ></multiselect>
               </div>
               <div class="form-group col-3">
                 <label for="birthday">Fecha de Instalación(Desde)</label>
                 <datepicker
                   input-class="form-control"
                   :placeholder="dateFormat"
                   id="desde"
                   name="desde"
                   :format="dateFormatter"
                   v-model="desde"
                   :clear-button="true"
                   :language="es"
                 />
               </div>
               <div class="form-group col-3">
                 <label for="birthday">Fecha de Instalación(Hasta)</label>
                 <datepicker
                   input-class="form-control"
                   :placeholder="dateFormat"
                   id="hasta"
                   name="hasta"
                   :format="dateFormatter"
                   v-model="hasta"
                   :clear-button="true"
                   :language="es"
                 />
               </div>
               <div class="form-group col-sm-3">
                 <!--label class="ml-5">Sector</label-->
                 
               </div>
             </div>
           <div class="form-row">
               <!-- Borrar -->
               <div class="form-group col-md-3">
                 <label for="parroquia">Parroquia</label>
                 <v-select
                   :options="parroquias"
                   label="parroquia"
                   v-model="parroquia"
                   placeholder="Parroquias"
               >
               </v-select>
               </div>
               <div class="form-group col-md-3">
                 <label for="sector">Sector</label>
                 <v-select
                   :options="sectores"
                   label="name"
                   v-model="sector"
                   placeholder="Sectores"
                   @option:selected="getSubsectors"
               >
               </v-select>
               </div>
               <div class="form-group col-md-3">
                 <label for="subsector">Subsector</label>
                 <v-select
                   :options="subsectores"
                   label="name"
                   v-model="subsector"
                   placeholder="Subsectores"
               >
               </v-select>
               </div>
           </div>  
           <div class="align-content-center d-flex justify-content-between mb-3 title-container flex-column">
             <table class="table table-hover">
                     <tr v-if="requests.length == 0 && !loading">
                         <td class="text-center" colspan="9">No hay Ordenes de Instalación para mostrar</td>
                      </tr>
                     <thead v-if="requests.length > 0">
                       <tr class="text-center">
                         <th>N° Contrato</th>
                         <th>Solicitante</th>
                         <th>Documento</th>
                         <th>Teléfono</th>
                         <th>Sector</th>
                         <th>Instalador</th>
                         <th>Nap</th>
                         <th>Puerto</th>
                         <th>Estatus</th>
                         <th>Fecha de Instalación</th>
                         
                       </tr>
                     </thead>
                     <tbody>
                       <tr v-if="loading">
                           <td colspan="11" class="text-center">
                               <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                           </td>
                       </tr>
                       <tr v-for="request in requests" :key="request.id" class="text-center">
                         <td>{{ request.contract.nro }}</td>
                         <td class="text-capitalize">{{  request.contract.social_razon  }}</td>
                         <td class="text-capitalize">{{ request.contract.document }}</td>
                         <td class="text-capitalize">{{ request.contract.client.celphone }}</td>
                         <td class="text-capitalize">{{ request.contract.sector.name }}</td>
                         <td class="text-capitalize" :class="(request.instalator) ? '' : 'red' ">{{ (request.instalator) ? request.instalator.name : 'NO ASIGNADO'}}</td>
                         <td class="text-capitalize" :class="(request.contract.nap) ? '' : 'red' ">{{ (request.contract.nap) ? request.contract.nap.name : 'NO ASIGNADA' }}</td>
                         <td class="text-capitalize">{{ request.nap_port }}</td>
                         <td class="text-capitalize">{{ request.instalated }}</td>
                         <td class="text-capitalize">{{ request.instalation_date }}</td>

                         
                       </tr>
                       
                     </tbody>
                   </table>
                 </div>
                 <div class="card-footer">
                  <pagination :data="list" @pagination-change-page="search"  :limit="limit"></pagination>
                </div>

           </div>
       </div>
   </div>
</div>
</div>
    </section>
   
</template>
<script>
import Datepicker from "vuejs-datepicker";
import moment from 'moment';
import Multiselect from "vue-multiselect";
import { es } from "vuejs-datepicker/dist/locale";
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

export default {
   components: {
       Datepicker,
       Multiselect,
       PulseLoader
   },
   data(){
       return{
           es:es,
           dateFormat: 'DD-MM-AAAA',
           desde: null,
           hasta: null,
           parroquias:[],
           parroquia: null,
           sectores:[],
           sector: null,
           subsectores:[],
           subsector:null,
           is_search:false,
           requests: [],
           color: '#FFDAB9',
           size: '20px',
           limit:5,
           loading: false,
           list: new Object(),
           instalators: [],
           instalator: []
       }
   },
   created(){
       this.instalatorUsers();
       this.getParroquias();
   }, 
   watch: {
   parroquia(val) {
     return this.getSectors(val.id);
   },
 },
   methods:{
       search(page = 1){
         
           this.requests = [];
           let formData = new FormData();
           formData.append(
             "desde",
             this.desde != null ? moment(this.desde).format("YYYY-MM-DD") : ""
           );
           
           formData.append(
             "hasta",
             this.hasta != null ? moment(this.hasta).format("YYYY-MM-DD") : ""
           );
           formData.append(
             "parroquia",
             this.parroquia != null ?  this.parroquia.id : ""
           );
           formData.append(
             "sector",
             this.sector != null ?  this.sector.id : ""
           );
           formData.append(
             "subsector",
             this.subsector != null ?  this.subsector.id : ""
           );

           if(this.instalator){
             this.instalator.forEach(e => {
               formData.append("instalator[]", e.id);
             } );
           }
           this.loading = true;
           axios({
             url: `/api/odis/report_odi?page=${page}`,
             method: 'post',
             data: formData
           })
           .then( response => {
             //console.log(response)
             this.requests = response.data.data
             let copy = JSON.parse(JSON.stringify(response.data));
             this.list = copy;
             this.requests.map((p) => {
               p.type_aproved = (p.approved == 1) ? "Aprobado" : "Por Aprobar";
               p.created_date = p.created_at.slice(0,10)
             });
             this.loading = false;
           })
         

       },
       reporte(is_search){
         if(is_search){
           this.requests = [];
           let formData = new FormData();
           formData.append(
             "desde",
             this.desde != null ? moment(this.desde).format("YYYY-MM-DD") : ""
           );
           
           formData.append(
             "hasta",
             this.hasta != null ? moment(this.hasta).format("YYYY-MM-DD") : ""
           );
           formData.append(
             "parroquia",
             this.parroquia != null ?  this.parroquia.id : ""
           );
           formData.append(
             "sector",
             this.sector != null ?  this.sector.id : ""
           );
           formData.append(
             "subsector",
             this.subsector != null ?  this.subsector.id : ""
           );

           if(this.instalator){
             this.instalator.forEach(e => {
               formData.append("instalator[]", e.id);
             } );
           }
           this.loading = true;
         // This arrangement can be altered based on how we want the date's format to appear.
         const date = new Date();
         let day = date.getDate();
         let month = date.getMonth() + 1;
         let year = date.getFullYear();
         let currentDate = `${day}-${month}-${year}`;
         axios.post(
           `/api/odis/export`,
           formData, {responseType: 'arraybuffer'}
         ).then(response => {
             var fileURL = window.URL.createObjectURL(new Blob([response.data]));
             var fileLink = document.createElement('a');
             fileLink.href = fileURL;
             fileLink.setAttribute('download', 'Reporte Gcia de Ventas Datanet '+currentDate+'.xlsx');
             document.body.appendChild(fileLink);
             fileLink.click();
             this.loading = false;
         })
       }
       },
       clean(){},
       dateFormatter(date) {
           return moment(date).format("DD-MM-YYYY");
       },
       instalatorUsers() {
           axios.get("api/instalator").then((response) => {
             
               this.instalators = response.data.data;
           });
       },
       getParroquias() {
           axios.get("api/parroquias").then((response) => {
                   this.parroquias = response.data;        
     });
   },
   getSectors(id){
     this.sectores = [];
     axios.get(`api/sector/getSelect/${id}`).then((response) => {
         this.sectores = response.data;
         console.log(" this.sectores",  this.sectores)
     });
   },
   getSubsectors(option){
     console.log('Opción seleccionada:', option);
     this.subsectores = [];
     this.subsectores = (this.sector.subsectors !== null) ? this.sector.subsectors : {id:0, name:'', sector_id: this.sector.id}
   }

   }
}
</script>
<style>
.multiselect__tag {
background:rgb(190, 190, 190);
}

.multiselect__tag-icon{
 background:#8e8e91;
 color: white;
}

.multiselect__option multiselect__option--highlight{
    background:#8e8e91;
    color:white;
}

.multiselect .multiselect__tags-wrap .multiselect__tag {
   background: #8e8e91;
   color: white;
}
.multiselect
.multiselect__option--highlight {
   background: #8e8e91;
   color: #fff;
   font-weight: normal !important;
}
</style>