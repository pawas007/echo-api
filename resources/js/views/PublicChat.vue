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
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="profileImage"> {{ user.name.charAt(0) }}</div>
                                        <p class="fw-bold pl-2 m-0">{{ user.name }}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{ authUser }}
            <div class="col-md-6 col-lg-7 col-xl-8">
                <div class="pb-4 h6" v-if="!messages.length">{{ $t("No messages") }}</div>
                <ul class="list-unstyled chat-box me-2" id="chat-box" ref="chatWindow">
                    <li class="d-flex justify-content-between  mb-4" v-for="message in messages"
                        :class="{'flex-row-reverse': message.userId == authUser.id}">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                             class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                        <div class="card w-100">
                            <div class="card-header d-flex justify-content-between p-3">
                                <p class="fw-bold mb-0">{{ message.name }}</p>
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
                    <span class="text-muted" v-if="typingUsers">{{ typingUsers.name }} {{ $t("is typing") }}...</span>
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
import {ref, computed, onMounted, onBeforeUnmount} from "vue";
import {notify} from "@kyvg/vue3-notification";
import {useI18n} from "vue-i18n";
import {useStore} from "vuex";

export default {
    name: "Chat",

    setup() {
        const authUser = computed(function () {
            return useStore().getters.AUTH_USER
        });
        const {t} = useI18n();
        const message = ref('');
        const messages = ref([]);
        const users = ref([]);
        const typingUsers = ref(null);
        const typingTimer = ref(null);
        const chatWindow = ref(null);
        const chanel = Echo.join('publicChat')

        const removeUserFromList = id =>
            users.value.splice(users.value.findIndex((obj) => obj.id === id), 1);
        const sendTypingEvent = () => {
            return Echo.join('publicChat')
                .whisper('typing', authUser.value);
        }

        const scrollToEnd = () =>
            setTimeout(() => {
                let chat = chatWindow.value;
                chat.scrollTop = chat.scrollHeight + 200;
            }, 100)


        const sendMessage = () =>
            axios.post('public-chat/message', {'message': message.value}).then(() => {
                messages.value.push({
                    myMessage: message.value,
                    name: authUser.value.name,
                    userId: authUser.id
                })
                message.value = '';
                scrollToEnd()
            });

        onMounted(() => {
                chanel
                    .here((usersOnline) => {
                        users.value = usersOnline
                    })
                    .joining((user) => {
                        users.value.push(user)
                        notify({
                            type: 'success',
                            title: t("Join to chat"),
                            text: user.name,
                        })
                    })
                    .leaving((user) => {
                        removeUserFromList(user.id)
                        notify({
                            type: 'warn',
                            title: t("Left chat"),
                            text: user.name,
                        })
                    })
                    .listen('PublicChatMessageEvent', (message) => {
                        messages.value.push({
                            myMessage: message.message,
                            name: message.name,
                            userId: message.user_id
                        })
                        scrollToEnd()
                    })
                    .listenForWhisper('typing', (user) => {
                        typingUsers.value = user;
                        typingTimer.value = true
                        if (typingTimer.value)
                            clearTimeout(typingTimer.value);
                        typingTimer.value = setTimeout(() => {
                            typingUsers.value = null;
                        }, 3000);
                    })
            },
        )

        onBeforeUnmount(() => {
            Echo.leave('publicChat');
        })

        return {
            message,
            messages,
            users,
            typingUsers,
            typingTimer,
            chanel,
            sendTypingEvent,
            sendMessage,
            chatWindow,
            authUser
        }
    }
}
</script>

