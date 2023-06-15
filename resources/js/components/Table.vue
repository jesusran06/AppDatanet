<template>
  <!-- eslint-disable vue/no-use-v-if-with-v-for,vue/no-confusing-v-for-v-if -->
<section class="content">
    <div class="container-fluid">
      <div class="row mt-3 justify-content-center">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <div class="row mt-3">
                <div
                class="col-md-4 mb-4 text-right"
                style="
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                "
                >
                    <span><strong>{{ tittle }}</strong></span>
                  </div>
                <div class="col-md-6 mb-6 offset-2 text-right">
                  <button type="button" class="btn btn-info" @click="$emit('ChangeTittle', action='new', id=0);" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-plus"> Nuevo </i>
                  </button>
                </div>
              </div>
            </div>
            <div class="card-body table-responsive">
              <div class="col-md-4 mb-4">
                  <input type="text" @keyup="filter" class="form-control" id="sector" placeholder="Buscar" v-model="tofilter">
                </div>
              <div class="row justify-content-center align-items-center">
                
                <table
                    class="table  mb-0"  
                >
                  <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th  v-for="header in headers" :key='header'>{{header}}</th>
                        <th v-if="actions">Acciones</th>
                    </tr>
                  </thead>
                    <tbody>
                      <tr v-if="loading">
                            <td colspan="6" class="text-center">
                                <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                            </td>
                        </tr>
                        <tr class="text-center" v-for="(item, index) in data.data" :key='index'>
                            <td>{{index + 1}}</td>
                            <td v-for="(field, index) in item" :key='index' v-if="index != 'id'">{{field}}</td>
                            <td>
                                <a href="#" v-if="actions[0]" @click="$emit('ChangeTittle', action='view', id = item);">
                                    <i class="fa fa-eye green"></i>
                                </a>
                                <a href="#" v-if="actions[1]" @click="$emit('ChangeTittle', action='edit', id =item);" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa fa-pen blue"></i>
                                </a>

                                <a href="#" v-if="actions[2]" @click="$emit('ChangeTittle', action='delete', id =item);">
                                    <i class="fa fa-trash red"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="mb-0 text-center" v-if="(!data.data || data.data.length == 0) && !loading">
                    <strong>No hay registros.</strong>
                </p>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

export default {
  components:{
    PulseLoader
  },
    data() {
        return {
            index: 1,
            items: {},
            tofilter:'',
            color: '#FFDAB9',
            size: '20px',
        }
    },
    props:{
        headers: {
            type: Array
        },
        data: { 
            type: Object
        },
        actions: {
            type: Array
        },
        tittle: {
            type: String
        },
        loading:{
          type: Boolean,
          default: false
        }
    },
    methods :{
        deleteItem(id) {
            this.$emit("delete", id);
        },
        addNew() {
          this.actionbutton('new');
        },
        getResults() {
          this.$emit("getResults");
        },
        filter() {
          this.$emit('getSearch', this.tofilter);
          this.$emit("getResults");
        }
    }
}
</script>

<style>

</style>