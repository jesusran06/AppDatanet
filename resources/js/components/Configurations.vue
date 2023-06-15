<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row mt-3 justify-content-center">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">CONFIGURACIONES</h3>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-sm d-flex justify-content-center">
                                    <router-link to="plans" class="nav-link">
                                        <i class="fa fa-columns fa-6x" style="color: #3b5998;"></i>
                                        <p style="text-align:center">Planes</p>
                                </router-link>
                                
                            </div>

                            <div class="col-4 d-flex justify-content-center">
                                <router-link to="/sectors" class="nav-link">
                                    <i class="fa fa-map fa-6x" style="color: #3b5998;"></i>
                                    <p style="text-align:center">Sectores</p>
                                </router-link>
                                
                            </div>
                            <div class="col-sm d-flex justify-content-center">
                                <router-link to="/users" class="nav-link">
                                    <i class="fa fa-users fa-6x" style="color: #3b5998;"></i>
                                    <p style="text-align: center">Usuarios</p>
                                </router-link>
                                
                            </div>
                            <div class="col-sm d-flex justify-content-center">
                                <router-link to="/naps" class="nav-link">
                                    <i class="fa fa-server fa-6x" style="color: #3b5998;"></i>
                                    <p style="text-align: center">NAPS</p>
                                </router-link>
                                
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </section>
    
    
</template>
<script>


export default {
  data() {
    return {
      
    };
  },
}
</script>
