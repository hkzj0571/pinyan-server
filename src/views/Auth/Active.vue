<template>
</template>
<script>
    export default {
        data() {
            return {}
        },
        created: function () {
            var token = this.$route.params.token

            this.$store.dispatch('actived', {token:token}).then((message) => {
                return this.$Message.success(message)
            }).catch((message) => {
                return this.$Message.error(message)
            })

            this.$router.push('/login')
        }
    }
</script>