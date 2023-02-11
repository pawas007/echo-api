<template>
    <div class="notify_box me-3">
        <button class="position-relative alert-button" @click="isActiveBar=!isActiveBar">
            <i class="bi bi-bell" style="font-size: 20px;color: white"></i>
            <span :class="{'pulse':badgeCountAnimate}" class="count-badge">{{ notifications.count }}</span>
        </button>
        <div class="notify_list_wrapper" :class="{'active':isActiveBar}">
            <div class="notify_header border-bottom mb-3 d-flex align-content-center justify-content-between">
                <h4 class="h4">{{ $t("Notifications") }} </h4>
                <button @click="isActiveBar=!isActiveBar" class="p-0 close_notify_modal"><i class="bi bi-x-circle"
                                                                                            style="font-size: 20px;color: black"></i>
                </button>
            </div>
            <ul class="notify_list" v-if="notifications.notifications?.length">
                <li class="list-item" v-for="item in notifications.notifications"
                    :class="{'new-message':item.readAt== null}">
                    <div class="message_box">
                        <div class="notify-message-text">{{ item?.user?.name }} {{ $t(item?.message) }}</div>
                        <div class="notify-date text-capitalize">{{ momentTransform(item.created) }}</div>
                        <div class="button_box_actions d-flex align-content-center">
                            <button class="markAsRead" @click="markAsRead(item.id)"><i class="bi bi-eye"
                                                                                       style="font-size: 20px;color: black"></i></button>
                            <button class="removeNotify" @click="deleteNotification(item.id)"><i class="bi bi-x-circle"
                                                                                                 style="font-size: 17px;color: black"></i>
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
        const notifications = reactive({
            notifications: [],
            count: 0
        })
        const badgeCountAnimate = ref(false);
        const audio = new Audio(notifySound);
        const currentLang = computed(() => {
            return locale.value;
        })

        const momentTransform = (date) => {
            moment.locale(currentLang.value)
            return moment(date).format('MMMM Do YYYY, h:mm');
        }

        const getNotifications = () => {
            axios.get('notifications').then((r) => {
                notifications.notifications = r.data.notifications
                notifications.count = r.data.count
            })
        }

        const subscribeToNotifications = () => {
            axios.get('user').then((r) => {
                Echo.private('push_notify.' + r.data.id)
                    .notification((notification) => {
                        console.log(notification)
                        let newNotify = notification.notification.data
                        notifications.notifications.unshift({
                            "id": notification.id,
                            "user": {"name": newNotify.user.name},
                            "message": newNotify.message,
                            "created": newNotify.created
                        })
                        notifications.count++
                        badgeCountAnimate.value = true
                        audio.play()
                        setTimeout(() => {
                            badgeCountAnimate.value = false
                        }, 2000)
                    })
            })
        }

        const markAsRead = (id) => {
            axios.get(`notifications/${id}/mark/toggle`).then((r) => {
                markAsReadInList(notifications.notifications, id)
            })
        }

        const removeMessageFromList = (arr, id) => {
            const objWithIdIndex = arr.findIndex((obj) => obj.id === id);
            arr.splice(objWithIdIndex, 1);
            return notifications.notifications = arr;
        }

        const markAsReadInList = (arr, id) => {
            const notifyList = arr.map(obj => {
                if (obj.id === id) {
                    if (obj.readAt) {
                        obj.readAt = null
                    } else {
                        obj.readAt = Date.now()
                    }
                }
                return obj;
            });
            return notifications.notifications = notifyList;
        }

        const deleteNotification = (id) => {
            axios.get(`notifications/${id}/destroy`).then((r) => {
                removeMessageFromList(notifications.notifications, id)
                notifications.count--
            })
        }

        onMounted(() => {
            getNotifications()
            subscribeToNotifications()
        })

        return {
            notifications,
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

