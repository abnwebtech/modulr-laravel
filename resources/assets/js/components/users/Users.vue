<template lang="html">
    <div class="users">
        <!-- Actions Buttons -->
        <div class="row">
            <div class="col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Search" v-model="search">
                </div>
            </div>
            <div class="col-xs-6 text-right">
                <a href="#" class="btn btn-success" @click.prevent="add">
                    <i class="mdi mdi-person-add mdi-lg"></i> Add User
                </a>
            </div>
        </div>
        <br>
        <!-- List -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Name/Email</th>
                            <th class="text-center">Active</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in filteredUsers">
                            <td @click="edit(item, index)">
                                <img :src="item.avatar_url">
                            </td>
                            <td @click="edit(item, index)">
                                {{item.id}}
                            </td>
                            <td @click="edit(item, index)">
                                <p>{{item.name}}</p>
                                <small class="text-muted">{{item.email}}</small>
                            </td>
                            <td class="text-center" @click="edit(item, index)">
                                <i class="mdi mdi-2x" :class="{'mdi-mood text-success': item.active, 'mdi-mood-bad': !item.active}"></i>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-default btn-sm" @click.prevent="edit(item, index)" v-tooltip:top="'Edit'">
                                        <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                    </a>
                                    <a :href="'/profile/'+item.id+'/edit'" class="btn btn-default btn-sm" v-tooltip:top="'Profile'">
                                        <i class="fa fa-external-link fa-lg" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Create user-->
        <div class="modal fade" id="modalAdd">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add User</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-xs-12 text-center">
                                    <img :src="user.avatar_url" v-if="user.avatar_url">
                                    <i class="mdi mdi-account-circle mdi-5x" v-else></i>
                                    <br>
                                    <vue-core-image-upload
                                        class="btn btn-link"
                                        @imageuploaded="uploadAvatarTemp"
                                        extensions="png,jpeg,jpg"
                                        :headers=headers
                                        :url="'user/upload/avatar/temp'">
                                    </vue-core-image-upload>
                                </label>
                            </div>
                            <div class="form-group" :class="{'has-error': error.name}">
                                <label class="col-sm-2 control-label">Name *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-lg" placeholder="Name" required v-model="user.name">
                                    <span class="help-block" v-if="error.name">{{error.name[0]}}</span>
                                </div>
                            </div>
                            <div class="form-group" :class="{'has-error': error.email}">
                                <label class="col-sm-2 control-label">Email *</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" placeholder="Email" required v-model="user.email">
                                    <span class="help-block" v-if="error.email">{{error.email[0]}}</span>
                                </div>
                            </div>
                            <div class="form-group" :class="{'has-error': error.password}">
                                <label class="col-sm-2 control-label">Password *</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="password" class="form-control" required v-model="user.password">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" @click="generatePassword()">Generate password</button>
                                        </span>
                                    </div>
                                    <span class="help-block" v-if="error.password">{{error.password[0]}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="user.active"> Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" @click="store">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit user-->
        <div class="modal fade" id="modalEdit">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit User</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-12 text-center">
                                    <img :src="user.avatar_url">
                                    <br>
                                    <vue-core-image-upload
                                        class="btn btn-link"
                                        @imageuploaded="uploadAvatar"
                                        extensions="png,jpeg,jpg"
                                        :headers=headers
                                        :url="'user/upload/avatar/'+user.id">
                                    </vue-core-image-upload>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">ID</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">
                                        <strong>{{user.id}}</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Created</label>
                                <div class="col-sm-10">
                                    <p class="form-control-static">
                                        <small class="text-mute">{{user.created_at | date}}</small>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group" :class="{'has-error': error.name}">
                                <label class="col-sm-2 control-label">Name *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-lg" placeholder="Name" required v-model="user.name">
                                    <span class="help-block" v-if="error.name">{{error.name[0]}}</span>
                                </div>
                            </div>
                            <div class="form-group" :class="{'has-error': error.email}">
                                <label class="col-sm-2 control-label">Email *</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" placeholder="Email" required v-model="user.email">
                                    <span class="help-block" v-if="error.email">{{error.email[0]}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="user.active"> Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <a class="btn btn-link" role="button" data-toggle="collapse" href="#collapsePassword" aria-expanded="false" aria-controls="collapseExample">
                                        Change Password
                                    </a>
                                </div>
                            </div>
                            <div class="collapse" id="collapsePassword">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Password *</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="password" class="form-control" required v-model="user.password">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" @click="generatePassword()">Generate password</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" @click="destroy()">
                            <i class="mdi mdi-delete mdi-lg"></i> Delete
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="update">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import swal from 'sweetalert';
import VueCoreImageUpload from 'vue-core-image-upload';
Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'
    })
})
export default {
    data() {
        return {
            users: [],
            user: {},
            search: '',
            error: {},
            headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        }
    },
    mounted() {
        this.getAll();
    },
    components: {
        'vue-core-image-upload': VueCoreImageUpload
    },
    filters: {
        date(date) {
            return moment(date).format('LLL');
        }
    },
    computed: {
        filteredUsers: function () {
            var filteredArray = this.users,
                search = this.search;

            if(!search){
                return filteredArray;
            }

            search = search.trim().toLowerCase();

            filteredArray = filteredArray.filter(function(item){
                return Object.keys(item).some(function (key) {
                    return String(item[key]).toLowerCase().indexOf(search) !== -1
                })
            })

            return filteredArray;;
        }
    },
    methods: {
        getAll: function () {
            axios.get('/user/all')
            .then(response => {
                this.users = response.data;
            });
        },
        add: function () {
            this.user = {
                avatar_url: null,
                password: '',
                active: false
            };
            this.error = {};
            $('#modalAdd').modal('show');
        },
        store: function (e) {
            var btn = $(e.target).button('loading')
            axios.post('/user/store', this.user)
            .then(response => {
                this.users.push(response.data);
                this.user = {};
                this.error = {};
                var btn = $(e.target).button('reset')
                $('#modalAdd').modal('hide');
            })
            .catch(error => {
                this.error = error.response.data;
                var btn = $(e.target).button('reset')
            });
        },
        edit: function (user, index) {
            this.user = _.clone(user);
            this.user.index = index;
            this.$set(this.user, 'password', '');
            $('#modalEdit').modal('show');
        },
        update: function (e) {
            var btn = $(e.target).button('loading')
            axios.put('/user/update/'+this.user.id, this.user)
            .then(response => {
                this.users[this.user.index] = response.data;
                this.user = {};
                this.error = {};
                var btn = $(e.target).button('reset')
                $('#modalEdit').modal('hide');
            })
            .catch(error => {
                this.error = error.response.data;
                var btn = $(e.target).button('reset')
            });
        },
        destroy: function () {
            var self = this;
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this user!",
                type: "warning",
                showLoaderOnConfirm: true,
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(){
                axios.delete('/user/destroy/' + self.user.id)
                .then(response => {
                    self.users.splice(self.user.index, 1);
                    swal({
                        title: "Deleted!",
                        text: "The user has been deleted.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    self.error = {};
                    $('#modalEdit').modal('hide');
                })
                .catch(error => {
                    self.error = error.response.data;
                });
            });
        },
        uploadAvatarTemp(response) {
            this.user.avatar = response.avatar;
            this.user.avatar_url = response.avatar_url;
        },
        uploadAvatar(response) {
            this.user.avatar_url = response.avatar_url;
            this.users[this.user.index].avatar_url = response.avatar_url;
            if (this.user.id == Laravel.user.id) {
                Laravel.user.avatar_url =response.avatar_url;
            }
        },
        generatePassword: function () {
            var length = 10;
            var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var result = '';
            for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
            this.user.password = result;
        }

    }
}
</script>
