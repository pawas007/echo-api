<template>
    <div class="notify_box me-3">
        <button class="position-relative alert-button"><i class="bi bi-bell" style="font-size: 20px;color: white"></i>
            <span class="badge badge-light custom-badge">443</span>
        </button>
    </div>
</template>

<script>


export default {
    name: "PushNotifications",
}
</script>

<style scoped>
.alert-button {
    outline: none;
    border: navajowhite;
    background: none;
    border-radius: 50%;
    background: #5c636a;
    width: 41px;
    height: 41px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-badge {
    position: absolute;
    top: -5px;
    left: 25px;
    background-color: mediumseagreen;
}
</style>
