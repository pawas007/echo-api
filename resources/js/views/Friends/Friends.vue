<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <h3 class="h3 border-bottom pb-3">{{ $t("Friends") }}</h3>
                    <div class="btn-group mb-3" role="group">
                        <button type="button" class="btn btn-secondary" @click="activeTab='MyFriends'"
                                :class="{'active':activeTab === 'MyFriends' }">{{ $t("Friends") }}
                            <span class="badge badge-light ms-1"
                                  style="background: dimgrey;"> {{ friendsCount.friends }} </span>
                        </button>
                        <button type="button" class="btn btn-secondary" @click="activeTab='PendingFriends'"
                                :class="{'active':activeTab === 'PendingFriends' }">{{ $t("Pending request") }}
                            <span class="badge badge-light  ms-1"
                                  style="background: dimgrey;">{{ friendsCount.pending }}</span>
                        </button>
                        <button type="button" class="btn btn-secondary" @click="activeTab='RequestFriends'"
                                :class="{'active':activeTab === 'RequestFriends' }"> {{ $t("Request") }}
                            <span class="badge badge-light  ms-1"
                                  style="background: dimgrey;">{{ friendsCount.request }}</span>
                        </button>
                    </div>
                    <div class="tab-content">
                        <component :is="activeTab"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import MyFriends from "@/components/Friends/MyFriends.vue";
import PendingFriends from "@/components/Friends/PendingFriends.vue";
import RequestFriends from "@/components/Friends/RequestFriends.vue";
import {onMounted, reactive, ref} from "vue";
import axios from "axios";

export default {
    name: "Friends",
    components: {
        RequestFriends,
        PendingFriends,
        MyFriends,
    },
    setup() {

        const activeTab = ref("MyFriends")
        const friendsCount = reactive({
            friends: null,
            pending: null,
            request: null
        })

        onMounted(() => {
            Echo.channel('friends').listen('FriendsCountUpdateEvent', (counts) => {
                const {friends, pending, request} = counts;
                friendsCount.friends = friends
                friendsCount.pending = pending
                friendsCount.request = request

            })
            axios.get('friend/count/refresh')
        })
        return {friendsCount, activeTab}
    },
}
</script>
