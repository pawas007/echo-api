<template>
    <div>
        <div class="mt-5" v-if="!pendingFriendRequests.length">
            <h5 class="h5">{{ $t("There are pending requests") }}</h5>
        </div>
        <div class="row border-bottom mb-2 py-2" v-for="user in pendingFriendRequests">
            <div class="col-md-2 col-sm-2">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="user"
                     class="profile-photo-lg">
            </div>
            <div class="col-md-7 col-sm-7">
                <h5><p class="profile-link">{{ user.name }}</p></h5>
                <p>{{ user.email }}</p>
            </div>
            <div class="col align-self-center d-flex justify-content-end">
                <button class="btn btn-secondary pull-right" @click="removeRequest(user.id)">{{
                        $t("Cansel request")
                    }}
                </button>
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-center" v-if="paginator.pageCount > 1">
            <paginate
                :page-count="paginator.pageCount"
                :page-range="3"
                :margin-pages="1"
                :click-handler="pendingList"
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
    name: "PendingFriends",
    components: {
        Paginate
    },
    setup() {
        const pendingFriendRequests = ref([])
        const paginator = reactive({
            currentPage: 1,
            pageCount: 0,
        })

        const  removeRequest = (user) => {
            axios.get(`friend/pending/${user}/cansel`).then(() => {
                pendingList(paginator.currentPage)
            }).catch(({response}) => {
                console.error(response)
            })
        }

        const pendingList = async (page = 1) => {
            await axios.get(`friend/pending?page=${page}`).then(({data}) => {
                pendingFriendRequests.value = data.data
                paginator.pageCount = data.last_page
            }).catch(({response}) => {
                console.error(response)
            })
        }
        onBeforeMount(() => {
            pendingList()
        })

        return {pendingFriendRequests, removeRequest, paginator,pendingList}

    },

}
</script>


