<template>
    <div class="layout-auth">
        <div class="logo">
            <router-link to="/">
                <img src="../../assets/images/logo.png">
            </router-link>
        </div>
        <i-col span="8" offset="8" class="center">
            <AuthCard></AuthCard>
        </i-col>
    </div>
</template>
<script>
    import {mapState} from 'vuex';
    import AuthCard from '../../components/Auth/AuthCard.vue'

    export default {
        data() {
            return {}
        },
        components: {
            AuthCard
        },
        computed: mapState({
            authenticated: state => state.user.authenticated,
        }),
        created: function () {
            if (this.authenticated) {
                return this.$router.push('/')
            }
        }
    }
</script>