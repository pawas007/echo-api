<template>
    <div>
        <div class="row">
            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Chanel Members</h5>
            <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="p-2 " v-for="(user, index) in users" :key="index"
                                :class="{ 'border-bottom': index !== users.length -1 }">
                                <a href="#!" class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="profileImage"> {{ user.name.charAt(0) }}</div>
                                        <p class="fw-bold pl-2 m-0">{{ user.name }}</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-7 col-xl-8">
                <div class="pb-4 h6" v-if="!messages.length">No messages</div>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between  mb-4" v-for="message in messages"
                        :class="{'flex-row-reverse': message.userId == currentUser.id}">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                             class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                        <div class="card w-100">
                            <div class="card-header d-flex justify-content-between p-3">
                                <p class="fw-bold mb-0">{{ message.name }}</p>
                                <!--                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 10 mins ago</p>-->
                            </div>
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ message.myMessage }}
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="bg-white mb-3">
                        <div class="form-outline">
                                    <textarea class="form-control" id="textAreaExample2" v-model="message"
                                              rows="4"></textarea>
                        </div>
                    </li>
                    <button type="button" class="btn btn-info btn-rounded float-end" @click="sendMessage">Send</button>
                </ul>
            </div>
        </div>
    </div>
    <notifications/>
</template>

<script>
import axios from "axios";

export default {
    name: "Chat",
    data() {
        return {
            currentUser: window.authUser,
            message: '',
            messages: [],
            users: []
        }
    },
    computed: {
        chanel() {
            return Echo.join('public-chat');
        }
    },
    mounted() {
        this.chanel
            .here((users) => {
                this.users = users
            })
            .joining((user) => {
                this.users.push(user)
                this.$notify({
                    type: 'success',
                    title: "Join to chat",
                    text: user.name,
                })
            })
            .leaving((user) => {
                this.removeObjectWithId(this.users, user.id)
                this.$notify({
                    type: 'warn',
                    title: "Left chat",
                    text: user.name,
                })
            })
            .listen('PublicChat', (message) => {
                this.messages.push({
                    myMessage: message.message,
                    name: message.name,
                    userId: message.user_id
                })
            })
    },
    methods: {
        sendMessage() {
            axios.post('message', {'message': this.message}).then(() => {
                this.messages.push({
                    myMessage: this.message,
                    name: this.currentUser.name,
                    userId: this.currentUser.id
                })
                this.message = '';
            });
        },

        removeObjectWithId(arr, id) {
            const objWithIdIndex = arr.findIndex((obj) => obj.id === id);
            arr.splice(objWithIdIndex, 1);
            return arr;
        }
    }
}
</script>

<style scoped>
a {
    text-decoration: none;
}

.profileImage {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #512DA8;
    font-size: 26px;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
}
</style>
