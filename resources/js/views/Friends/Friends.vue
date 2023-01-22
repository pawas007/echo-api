<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                            <h3 class="h3 border-bottom pb-3">Friends</h3>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="my-friend-tab" data-bs-toggle="tab"
                                            data-bs-target="#my-friend" type="button" role="tab"
                                            aria-controls="my-friend" aria-selected="true">My Friends
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab"
                                            data-bs-target="#pending" type="button" role="tab" aria-controls="pending"
                                            aria-selected="false">Pending
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="my-friend" role="tabpanel"
                                     aria-labelledby="my-friend-tab">
                                    <MyFriends/>
                                </div>
                                <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                    <PendingFriends/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</template>
<script>

import MyFriends from "@/views/Friends/MyFriends.vue";
import PendingFriends from "@/views/Friends/PendingFriends.vue";

export default {
    name: "Friends",
    components: {
        PendingFriends,
        MyFriends,
    },
}
</script>

<style lang="scss">
</style>
