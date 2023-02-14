<template>
    <div class="notify_box me-3">
        <button class="position-relative alert-button" @click="isActiveBar=!isActiveBar">
            <i class="bi bi-bell" style="font-size: 20px;color: white"></i>
            <span :class="{'pulse':badgeCountAnimate}" class="count-badge">{{ notificationsCount }}</span>
        </button>
        <div class="notify_list_wrapper" :class="{'active':isActiveBar}">
            <div class="notify_header border-bottom mb-3 d-flex align-content-center justify-content-between">
                <h4 class="h4">{{ $t("Notifications") }} </h4>
                <button @click="isActiveBar=!isActiveBar" class="p-0 close_notify_modal">
                    <i class="bi bi-x-circle" style="font-size: 20px;color: black"></i>
                </button>
            </div>
            <ul class="notify_list" v-if="notificationsList.length">
                <li class="list-item" v-for="item in notificationsList"
                    :class="{'new-message':item.readAt== null}">
                    <div class="message_box">
                        <div class="notify-message-text">{{ item?.user?.name }} {{ $t(item?.message) }}</div>
                        <div class="notify-date text-capitalize">{{ momentTransform(item.created) }}</div>
                        <div class="button_box_actions d-flex align-content-center">
                            <button class="markAsRead" @click="markAsRead(item.id)">
                                <i class="bi bi-eye" style="font-size: 20px;color: black"></i>
                            </button>
                            <button class="removeNotify" @click="deleteNotification(item.id)">
                                <i class="bi bi-x-circle" style="font-size: 17px;color: black"></i>
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="no-notify" v-else>
                {{ $t("Notifications list empty") }}
            </div>
        </div>
    </div>
</template>
<script>
import {onMounted, reactive, computed, ref} from "vue";
import moment from "moment";
import 'moment/dist/locale/uk';
import {useI18n} from "vue-i18n";
import notifySound from '../../assets/audio/new_message_notice.wav'

export default {
    name: "PushNotifications",

    setup() {
        const isActiveBar = ref(false)
        const {locale} = useI18n()
        const audio = new Audio(notifySound)
        const badgeCountAnimate = ref(false)
        const notificationsList = ref([])
        const notificationsCount = ref(0)
        const currentLang = computed(() => locale.value)
        const momentTransform = date => {
            moment.locale(currentLang.value)
            return moment(date).format('MMMM Do YYYY, h:mm');
        }

        const getNotifications = () =>
            axios.get('notifications').then(responce => {
                const {notifications, count} = responce.data
                notificationsList.value = notifications
                notificationsCount.value = count
            })


        const subscribeToNotifications = () =>
            axios.get('user').then(responce => {
                Echo.private('push_notify.' + responce.data.id)
                    .notification((notification) => {
                        console.log(notification)
                        let message = notification.data
                        notificationsList.value.unshift({
                            "id": notification.id,
                            "user": {"name": message.user.name},
                            "message": message.message,
                            "created": message.created,
                            "readAt": null

                        })
                        notificationsCount.value++
                        badgeCountAnimate.value = true
                        audio.play().catch(error => {
                            audio.play()
                        })
                        setTimeout(() => {
                            badgeCountAnimate.value = false
                        }, 2000)
                    })
            })


        const markAsRead = id =>
            axios.get(`notifications/${id}/mark/toggle`).then(() =>
                notificationsList.value.map(obj => {
                    if (obj.id === id) {
                        if (obj.readAt) {
                            obj.readAt = null
                        } else {
                            obj.readAt = Date.now()
                        }
                    }
                    return obj;
                })
            )

        const deleteNotification = id => {
            axios.get(`notifications/${id}/destroy`).then(() => {
                const findNotify = notificationsList.value.findIndex((obj) => obj.id === id);
                notificationsList.value.splice(findNotify, 1);
                notificationsCount.value--
            })
        }

        onMounted(() => {
            getNotifications()
            subscribeToNotifications()
        })

        return {
            notificationsList,
            notificationsCount,
            momentTransform,
            currentLang,
            isActiveBar,
            badgeCountAnimate,
            markAsRead,
            deleteNotification
        }
    }
}
</script>

