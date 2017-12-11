<template>
    <div class="author-detail">
        <div class="info">
            <router-link class="avatar" :to="{name:'user.show.profile',params:{user:user.id}}">
                <img :src="user.avatar">
            </router-link>
            <Button class="btn-focus" :class="{active:user.is_follow}" type="success" :icon="icon" shape="circle" :loading="loading" @click="follow">{{ text }}
            </Button>
            <router-link class="title" :to="{name:'user.show.profile',params:{user:user.id}}" v-text="user.name"></router-link>
            <Icon :type="user.gender" v-show="user.gender"></Icon>
            <p class="describe" v-text="user.describe"></p>
            <p>发布了 {{ user.article_count }} 篇文章，关注了 {{ user.follower_count }} 人 ，被 {{ user.follower_count }} 人关注</p>
        </div>
        <div class="signature" v-text="user.resume"></div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                loading: false,
            }
        },
        props: ['user'],
        computed: {
            icon(){
                return this.user.is_follow ? 'checkmark-round':'plus-round'
            },
            text(){
                return this.user.is_follow ? '已关注' : '关注'
            }
        },
        methods: {
            follow() {
                this.loading = true
                this.$axios.post('user/follow', {user_id: this.user.id}).then(respond => {
                    this.loading = false
                    if (respond.data.status) {
                        this.user.is_follow = !this.user.is_follow
                    } else {

                    }
                })
            }
        },
    }
</script>