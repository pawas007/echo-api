<template>
    <div>
        <div class="mt-5" v-if="!friendRequests.length">
            <h5 class="h5">{{ $t("There are no friends waiting for confirmation") }}</h5>
        </div>
        <div class="row border-bottom mb-2 py-2" v-for="user in friendRequests">
            <div class="col-md-2 col-sm-2">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="user"
                     class="profile-photo-lg">
            </div>
            <div class="col-md-7 col-sm-7">
                <h5><p class="profile-link">{{ user.name }}</p></h5>
                <p>{{ user.email }}</p>
            </div>
            <div class="col align-self-center d-flex justify-content-end">
                <button class="btn btn-secondary pull-right mx-1" @click="acceptFriend(user.id)">{{
                        $t("Accept")
                    }}
                </button>
                <button class="btn btn-secondary pull-right" @click="declineFriend(user.id)">{{
                        $t("Decline")
                    }}
                </button>
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-center" v-if="paginator.pageCount > 1">
            <paginate
                :page-count="paginator.pageCount"
                :page-range="3"
                :margin-pages="1"
                :click-handler="requestList"
                prev-text="<"
                next-text=">"
                :container-class="'pagination'"
                :page-class="'page-item'">
            </paginate>
        </div>
    </div>
</template>
<script>
import Paginate from "vuejs-paginate-next";
import axios from "axios";
import {onBeforeMount, reactive, ref} from "vue";

export default {
    name: "RequestFriends",
    components: {
        Paginate
    },

    setup() {
        const friendRequests = ref([])
        const paginator = reactive({
            currentPage: 1,
            pageCount: 0,
        })

        const requestList = (page = 1) =>
            axios.get(`friend/request?page=${page}`).then(({data}) => {
                friendRequests.value = data.data
                paginator.pageCount = data.last_page
            })


        const acceptFriend = user =>
            axios.get(`friend/request/${user}/accept`).then(() =>
                requestList(paginator.currentPage)
            )

        const declineFriend = id =>
            axios.get(`friend/request/${id}/decline`).then(() =>
                requestList(paginator.currentPage)
            )

        onBeforeMount(() => {
            requestList()
        })

        return {requestList, declineFriend, acceptFriend, friendRequests, paginator}

    },
}
</script>


