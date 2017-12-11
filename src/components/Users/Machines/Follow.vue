<template>
    <div class="content">
        <div class="author">
            <router-link :to="{name:'user.show.profile',params:{user:id}}">
                <Avatar :src="avatar" size="large"></Avatar>
            </router-link>
            <div class="info">
                <router-link class="nickname" v-text="name" :to="{name:'user.show.profile',params:{user:id}}"></router-link>
                <span>关注了用户</span>
                <span class="followed">
                    <router-link :to="{name:'user.show.profile',params:{user:user.id}}">
                        <Avatar :src="user.avatar" size="large"></Avatar>
                    </router-link>
                    <router-link class="nickname" v-text="user.name" :to="{name:'user.show.profile',params:{user:user.id}}"></router-link>
                </span>
                <span> <span class="speacd">·</span> {{ user.pivot_created_at }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    export default {
        data() {
            return {
                user:this.machine.user,
            }
        },
        props: ['machine'],
        computed: mapState({
            id: state => state.user.id,
            name: state => state.user.name,
            avatar: state => state.user.avatar,
        }),
        created: function () {
        },
        methods: {}
    }
</script>