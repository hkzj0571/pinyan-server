<template>
    <div class="content">
        <div class="author">
            <router-link :to="{name:'user.show.profile',params:{user:id}}">
                <Avatar :src="avatar" size="large"></Avatar>
            </router-link>
            <div class="info">
                <router-link class="nickname" v-text="name"
                             :to="{name:'user.show.profile',params:{user:id}}"></router-link>
                <span>加入了品言 <span class="speacd">·</span> {{ user.created_at }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        data() {
            return {
                user: this.machine.user,
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