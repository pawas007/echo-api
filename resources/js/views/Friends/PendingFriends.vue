<template>
    <div>
        <div class="mt-5" v-if="!pendingFriendRequests.length">
            <h5 class="h5">There are no friends waiting for confirmation</h5>
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
                <button class="btn btn-primary pull-right" @click="removeRequest(user.id)">Cansel request</button>
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-center" v-if="paginator.pageCount > 1">
            <paginate
                :page-count="paginator.pageCount"
                :page-range="3"
                :margin-pages="1"
                :click-handler="requestlist"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'">
            </paginate>
        </div>
    </div>
</template>

<script>
import Paginate from "vuejs-paginate-next";
import axios from "axios";

export default {
    name: "PendingFriends",
    components: {
        Paginate
    },
    data() {
        return {
            paginator: {
                currentPage: 1,
                pageCount: 0,
            },
            pendingFriendRequests: {
                type: Array,
                default: []
            }
        }
    },
    mounted() {
        this.requestlist()
    },
    methods: {
        requestlist(page = 1) {
            axios.get(`friend/pending?page=${page}`).then(({data}) => {
                this.pendingFriendRequests = data.data
                this.paginator.pageCount = data.last_page
            }).catch(({response}) => {
                console.error(response)
            })
        },
        removeRequest(user) {
            axios.get(`friend/pending/${user}/cansel`).then((req) => {
                this.requestlist(this.paginator.currentPage)
            }).catch(({response}) => {
                console.error(response)
            })
        }
    }
}
</script>



<!--MAKE NOTIFICATION-->
<!--SHOW FRIEND TO CONNECT LIST-->
<!--save public massages-->

