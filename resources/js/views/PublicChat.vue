<template>
    <div class="container">
        <div class="row">
            <h5 class="font-weight-bold mb-3  text-lg-start">{{ $t("Online users") }}</h5>
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
                <div class="pb-4 h6" v-if="!messages.length">{{ $t("No messages") }}</div>
                <ul class="list-unstyled chat-box me-2" id="chat-box" ref="chat-window">
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
                </ul>
                <div class="control-box-chat">
                    <div class="form-outline me-2">
                                    <textarea class="form-control" id="textAreaExample2" v-model="message"
                                              @keyup="sendTypingEvent"
                                              rows="4"></textarea>
                    </div>
                    <span class="text-muted" v-if="typingUsers">{{ typingUsers.name }} {{ $t("No messages") }}...</span>
                    <button type="button" class="btn btn-secondary btn-rounded float-end me-2 mt-2" id="sendButton"
                            @click="sendMessage">{{ $t("Send") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
export default {
    name: "Chat",
    data() {
        return {
            currentUser: null,
            message: '',
            messages: [],
            users: [],
            typingUsers: null,
            typingTimer: false,
        }
    },
    computed: {
        chanel() {
            return Echo.join('publicChat');
        }
    },
    created() {
        axios.get('user').then((r) => {
            this.currentUser = r.data
        });
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
            .listen('PublicChatMessageEvent', (message) => {
                this.messages.push({
                    myMessage: message.message,
                    name: message.name,
                    userId: message.user_id
                })
                this.scrollToEnd()

            })
            .listenForWhisper('typing', (user) => {

                this.typingUsers = user;
                this.typingTimer = true
                if (this.typingTimer)
                    clearTimeout(this.typingTimer);
                this.typingTimer = setTimeout(() => {
                    this.typingUsers = null;
                }, 3000);

            })
    },
    methods: {
        sendMessage() {
            axios.post('public-chat/message', {'message': this.message}).then(() => {
                this.messages.push({
                    myMessage: this.message,
                    name: this.currentUser.name,
                    userId: this.currentUser.id
                })
                this.message = '';
                this.scrollToEnd()

            });

        },
        removeObjectWithId(arr, id) {
            const objWithIdIndex = arr.findIndex((obj) => obj.id === id);
            arr.splice(objWithIdIndex, 1);
            return arr;
        },
        sendTypingEvent() {
            Echo.join('public-chat')
                .whisper('typing', this.currentUser);
        },
        scrollToEnd() {
            setTimeout(() => {
                let chat = this.$refs["chat-window"];
                chat.scrollTop = chat.scrollHeight + 200;
            }, 100)
        }
    }
}
</script>

<style scoped>
a {
    text-decoration: none;
}

.chat-box {
    overflow-y: auto;
    max-height: 400px;
    scroll-behavior: smooth;

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

.chat-box::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #F5F5F5;
    border-radius: 10px;
}

.chat-box::-webkit-scrollbar {
    width: 5px;
    background-color: #F5F5F5;
}

.chat-box::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background-image: -webkit-gradient(linear,
    left bottom,
    left top,
    color-stop(0.44, rgb(122, 153, 217)),
    color-stop(0.72, rgb(73, 125, 189)),
    color-stop(0.86, rgb(28, 58, 148)));
}
</style>
