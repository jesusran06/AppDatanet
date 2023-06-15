<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Usuarios</h3>

              <div class="card-tools">
                <button
                  type="button"
                  class="btn btn-sm btn-primary"
                  @click="newModal"
                >
                  <i class="fa fa-plus-square"></i>
                  Nuevo
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <div class="align-content-center d-flex justify-content-between mb-3 title-container flex-column">
                <div class="col-md-4 mb-4 mt-4">
                  <input type="text" @keyup="filterUsers" class="form-control" id="filterInput" placeholder="Buscar" v-model="tofilter">
                </div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Rol</th>
                      <th>Nombre</th>
                      <th>Email</th>
                      <th>Creación</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                      
                      <td>{{ user.id }}</td>
                      <td class="text-capitalize">{{ user.roles.name }}</td>
                      <td class="text-capitalize">{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.created_at }}</td>

                      <td>
                        <a href="#" @click="editModal(user)">
                          <i class="fa fa-edit blue"></i>
                        </a>
                        
                        <a href="#" @click="deleteUser(user.id)" v-if="user.roles.id !== 1">
                          <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination
                :data="users"
                v-if="tofilter!=''"
                @pagination-change-page="filterUsers"
              ></pagination>
              <pagination
                :data="users"
                v-if="tofilter==''"
                @pagination-change-page="getResults"
              ></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>

      <div v-if="users.length == 0">
        <not-found></not-found>
      </div>

      <!-- Modal -->
      <div
        class="modal fade"
        id="addNew"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addNew"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode">Crear Nuevo Usuario</h5>
              <h5 class="modal-title" v-show="editmode">Actualizar Usuario</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <!-- <form @submit.prevent="createUser"> -->

            <form @submit.prevent="editmode ? updateUser() : createUser()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Nombre</label>
                  <input
                    v-model.trim="$v.form.name.$model"
                    type="text"
                    name="name"
                    class="form-control"
                  />
                  <div v-if="$v.form.name.$error">
                      <span v-if="!$v.form.name.required" class="text text-danger">
                          * Campo requerido
                      </span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input
                    v-model.trim="$v.form.email.$model"
                    type="text"
                    name="email"
                    class="form-control"
                  />
                  <div v-if="$v.form.email.$error">
                      <span v-if="!$v.form.email.required" class="text text-danger">
                          * Campo requerido
                      </span>
                      <span v-if="!$v.form.email.email" class="text text-danger">
                          * Email no valido
                      </span>
                  </div>
                </div>

                <div class="form-group">
                  <label>Contraseña</label>
                  <div class="input-group" style="border: 1px solid#ccc;border-radius: 5px;">
                    <input
                    v-model.trim="$v.form.password.$model"
                    :type="show1 ? 'text' : 'password'"
                    name="password"
                    class="form-control"
                    autocomplete="false"
                  />
                  <span class="input-group-addon">
                      <span :class="show1 ? 'fas fa fa-eye' : 'fas fa fa-eye-slash'" style="cursor:pointer;font-size:18px;padding:5px;margin:5px;" @click="seePassword"></span>
                  </span>
                  </div>
                  <div v-if="$v.form.password.$error">
                      <span v-if="!$v.form.password.required" class="text text-danger">
                          * Campo requerido
                      </span>
                  </div>
                  
                  
                </div>

                <div class="form-group">
                  <label>Role</label>
                  <select
                    name="role_id"
                    v-model.trim="$v.form.role_id.$model"
                    id="type"
                    class="form-control"
                  >
                    <option value="">Rol de Usuario</option>
                     <option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
                    
                  </select>
                  <div v-if="$v.form.role_id.$error">
                      <span v-if="!$v.form.role_id.required" class="text text-danger">
                          * Campo requerido
                      </span>
                  </div>
                </div>
                <!--div class="form-group">
                  <label>Permission</label>
                  <select
                    name="type"
                    v-model="form.type"
                    id="type"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('type') }"
                  >
                    <option value="">Select Permission</option>
                    <option value="admin">Timesheet</option>
                    <option value="user">Expenses</option>
                    <option value="user">Sales</option>
                    <option value="user">Pay</option>
                    <option value="user">Manage Agencies</option>
                    <option value="user">Manage Managers</option>
                    <option value="user">Manage Clients</option>
                    <option value="user">Manage Consultants</option>
                    <option value="user">Manage Umbrellas</option>
                    <option value="user">Manage Workers</option>
                    <option value="user">Manage Placements</option>
                    <option value="user">Manage Configuration</option>
                  </select>
                  <has-error :form="form" field="type"></has-error>
                </div-->
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Cerrar
                </button>
                <button v-show="editmode" type="submit" class="btn btn-primary">
                  Actualizar
                </button>
                <button
                  v-show="!editmode"
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
  </section>
</template>

<script>
import moment from 'moment';
import { required, email } from "vuelidate/lib/validators";
export default {
  data() {
    moment.locale('es');
    return {
      editmode: false,
      users: {},
      form: new Form({
        id: "",
        role_id: "",
        name: "",
        email: "",
        password: "",
        email_verified_at: "",
      }),
      roles:[],
      tofilter: '',
      show1: false,
      type_input: 'password'
    };
  },
  validations: {
    form:{
        name:{
          required
        },
        email:{
          required,
          email
        },
        password:{
          required
        },
        role_id:{
          required
        }
    }
  },
  methods: {
    getResults(page = 1) {
      this.$Progress.start();
      axios
        .get("api/user?page=" + page)
        .then(({ data }) => {
          this.users = data.data
          this.users.data.map((e)=>{
            e.created_at = moment(e.created_at).format('l')
            return e
          })
        });

      this.$Progress.finish();
    },
    filterUsers(page){
      this.$Progress.start();
      if(this.tofilter){
        if(typeof(page)!= 'number') {
          page = 1;
        }
        axios
        .get(`api/users/filter/${this.tofilter}?page=` + page)
        .then(( data ) => {
          this.users = data.data.data
          this.users.map((e)=>{
            e.created_at = moment(e.created_at).format('l')
            return e
          })
        });
      this.$Progress.finish();
      } else {
        this.getResults(1);
      }
    },
    updateUser() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.$Progress.start();
        this.form
          .put("api/user/" + this.form.id)
          .then((response) => {
            // success
            $("#addNew").modal("hide");
            Toast.fire({
              icon: "success",
              title: "Datos actualizados!",
            });
            this.$Progress.finish();
            //  Fire.$emit('AfterCreate');

            this.getResults(1);
          })
          .catch(() => {
            this.$Progress.fail();
          });
        }
    },
    editModal(user) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteUser(id) {
      Swal.fire({
        title: "Esta seguro?",
        text: "Los datos eliminados no podrán recuperarse",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Si",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          this.form
            .delete("api/user/" + id)
            .then(() => {
              Swal.fire("Eliminado!", "Usuario eliminado.", "success");
              // Fire.$emit('AfterCreate');
              this.getResults(1);
            })
            .catch((data) => {
              Swal.fire("Error!", data.message, "warning");
            });
        }
      });
    },
    createUser() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.form
          .post("api/user")
          .then((response) => {
            $("#addNew").modal("hide");

            Toast.fire({
              icon: "success",
              title: response.data.message,
            });

            this.$Progress.finish();
            this.getResults(1);
          })
          .catch((error) => {
            console.log(error)
            Toast.fire({
              icon: "error",
              title: "Some error occured! Please try again",
            });
          })
        }
    },
    getRoles(){
      axios.get('api/roles').then((response) =>  {
        this.roles = response.data;
      })
    },
    seePassword(){
      this.show1 = !this.show1;
    }
  },
  mounted() {
    console.log("User Component mounted.");
  },
  created() {
    this.$Progress.start();
    this.getResults(1);
    this.getRoles();
    this.$Progress.finish();
  },
};
</script>
