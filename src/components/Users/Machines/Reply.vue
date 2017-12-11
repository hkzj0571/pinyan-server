<template>
    <div class="content">
        <div class="author">
            <router-link :to="{name:'user.show.profile',params:{user:id}}">
                <Avatar :src="avatar" size="large"></Avatar>
            </router-link>
            <div class="info">
                <router-link class="nickname" v-text="name"
                             :to="{name:'user.show.profile',params:{user:id}}"></router-link>
                <span>回复了评论 <span class="speacd">·</span> {{ comment.created_at }}</span>
            </div>
        </div>
        <router-link :to="{name:'article.show',params:{article:article.id}}">
            <p class="comment" v-text="comment.content"></p>
        </router-link>
        <blockquote>
            <p class="abstract" v-text="reply.content"></p>
            <div class="single-line">
                <router-link to="" v-text="reply.user.name"></router-link>
                <span>评论自<router-link class="head" to="/p/8760acfd45f0" v-text="article.title">连续两起校园死亡：吃瓜群众要用什么姿势围观暴力？</router-link></span>
            </div>
        </blockquote>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        data() {
            return {
                comment: this.machine.comment,
                article: this.machine.article,
                reply: this.machine.reply,
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