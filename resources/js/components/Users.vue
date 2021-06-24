<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                  <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#userModal">Add New
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
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>
                          <a href="#">
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
                    <h5 class="modal-title" id="userModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="createUser">
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
                            <textarea name="bio" v-model="form.bio" id="" cols="30" rows="3" placeholder="Short Bio for user (optional)" class="form-control" :class="{ 'is-invalid':form.errors.has('bio') }"></textarea>
                            <HasError :form="form" field="bio" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
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
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods: {
            createUser() {
                console.log(this.form);
                this.form.post('api/user');
                this.form.reset();
                this.form.clear();
                this.form.fill({ 
                    name: 'Muhammad Naseer Azmat - Auto Generated', 
                    email: 'auto_admin@gmail.com', 
                    password: '123456', 
                    bio: 'Short by Auto', 
                    type: 'author', 
                    photo: 'image.png' 
                    })
            }
        },
        created() {
            this.form.fill({ 
                    name: 'Muhammad Naseer Azmat', 
                    email: 'admin@gmail.com', 
                    password: '123456', 
                    bio: 'Short Bio when created user', 
                    type: 'author', 
                    photo: 'image.png' 
                    })
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>