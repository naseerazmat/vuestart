<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                  <button class="btn btn-success btn-lg" @click="addNewUser">Add New
                      <i class="fas fa-user-plus fa-fw"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Bio</th>
                      <th>Registered At</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in users">
                      <td>{{ index+1 }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type | capitalize }}</td>
                      <td>{{ user.bio }}</td>
                      <td><span class="tag tag-success">{{ user.created_at | humanDate }}</span></td>
                      <td>
                          <a href="#" @click="editUser(user.id)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a href="#">
                              <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- User Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel" v-text="modalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form @submit.prevent="formTypeTest ? storeNewUser : updateUser"> -->
                <form @submit.prevent="submitForm(userId)">
                <div class="modal-body">
                        <div class="mb-3">
                            <input id="name" v-model="form.name" type="text" placeholder="Name" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name')}">
                            <HasError :form="form" field="name" />
                        </div>
                        <div class="mb-3">
                            <input id="email" v-model="form.email" type="email" value="admin@gmail.com" autocomplete="off" placeholder="E-mail" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email')}">
                            <HasError :form="form" field="email" />
                        </div>
                        <div class="mb-3">
                            <input id="password" v-model="form.password" type="password" placeholder="Password" name="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password')}">
                            <HasError :form="form" field="password" />
                        </div>
                        <div class="mb-3">
                            <select name="type" id="type" v-model="form.type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <option value="">Select User role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="author">Author</option>
                            </select>
                            <HasError :form="form" field="type" />
                        </div>
                        <div class="mb-3">
                            <textarea name="bio" v-model="form.bio" cols="30" rows="3" placeholder="Short Bio for user (optional)" class="form-control" :class="{ 'is-invalid':form.errors.has('bio') }"></textarea>
                            <HasError :form="form" field="bio" />
                        </div>
                        <div class="mb-3">
                            <input type="text" name="photo" v-model="form.photo" value="image.png" placeholder="will be use for photo upload" class="form-control" :class="{ 'is-invalid':form.errors.has('photo') }" />
                            <HasError :form="form" field="photo" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" v-if="formType == 'create'" class="btn btn-primary">Create</button>
                        <button type="submit" v-if="formType == 'edit'" class="btn btn-primary">Edit</button>
                    </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: {},
                selectUser: {},
                modalLabel: 'Add new user',
                userId: '',
                formType: '',
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: 'image.png'
                })
            }
        },
        methods: {
            loadUsers() {
                // this.form.get('api/user');
                axios.get('api/user').then(({ data }) => (this.users = data));
            },
            addNewUser() {
                $('#userModal').modal('show');
                this.modalLabel = 'Add New User';
                this.formType = 'create';
                this.userId = '';
                this.form.fill({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: '',
                })
            },
            submitForm(id) {
                if(id === '') {
                    // alert('create user');
                    this.createNewUser();
                } else {
                    // alert('update user');
                    this.updateUser();
                }
                return false;
            },
            createNewUser() {
                this.$Progress.start();
                let formData = this.form.post('api/user');
                Fire.$emit('loadUsersEvent');
                this.$Progress.finish();
                Toast.fire({
                    icon: 'success',
                    title: 'User Created successfully'
                })
                console.log(formData);
                // this.form.reset();
                // this.form.clear();
                // this.form.fill({ 
                //     name: 'Muhammad Naseer Azmat - Auto Generated', 
                //     email: 'auto_admin@gmail.com', 
                //     password: '123456', 
                //     bio: 'Short by Auto', 
                //     type: 'author', 
                //     photo: 'image.png' 
                //     })
                // this.loadUsers();
            },
            updateUser() {
                this.form.clear();
                console.log(this.form);
                this.form.post('api/user');
                Fire.$emit('loadUsersEvent');
                this.form.reset();
                this.form.fill({ 
                    name: 'Muhammad Naseer Azmat - Auto Generated', 
                    email: 'auto_admin@gmail.com', 
                    password: '123456', 
                    bio: 'Short by Auto', 
                    type: 'author', 
                    photo: 'image.png' 
                    })
                // this.loadUsers();
            },
            editUser(id) {
                let self = this;
                self.userId = id;
                this.formType = 'edit';
                this.modalLabel = 'Update User';
                axios.get('api/user/'+id).then( function (selectedUser) {
                    $('#userModal').modal('show');
                    self.selectUser = selectedUser.data;
                    console.log(self.selectUser);
                    self.form.fill({
                        name: self.selectUser.name, 
                        email: self.selectUser.email, 
                        password: self.selectUser.password, 
                        bio: self.selectUser.bio, 
                        type: self.selectUser.type, 
                        photo: self.selectUser.photo
                    })
                });
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('loadUsersEvent', () => {
                this.loadUsers();
            });
            
            // let self = this;

            // Use of intervals to update users data after every 3 seconds - Not Efficient (Available Option)
            // setInterval(() => {
            //     self.loadUsers();
            // }, 3000);
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>