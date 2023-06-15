<template>
    <section class="content">
        <div class="container-fluid">
            <div class="modal fade" id="subsectorsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Subsectores de {{sector}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table
                                data-page-list="[10, 25, 50, 100, all]"
                                data-show-footer="true"
                                data-side-pagination="server"
                                class="table  mb-0"
                                v-if="subsectors.length > 0"
                            >
                                <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Nombre</th>
                                </tr>
                                </thead>

                                <tbody>
                                    <tr class="text-center" v-for="(data, index) in subsectors" :key='data.id'>
                                        <td>{{index + 1}}</td>
                                        <td >{{data.name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data(){
        return {
            index: 1,
        }
    },
    props: {
        sector: String,
        subsectors: Array
    },
    methods:{
        
    }
}
</script>

<style>

</style>