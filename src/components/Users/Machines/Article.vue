<template>
    <div class="content" :class="{'cover':article.cover}">
        <router-link class="wrap-img" :to="{name:'article.show',params:{article:article.id}}" v-if="article.cover">
            <img :src="article.cover">
        </router-link>
        <div class="author">
            <router-link :to="{name:'user.show.profile',params:{user:id}}">
                <Avatar :src="avatar" size="large"></Avatar>
            </router-link>
            <div class="info">
                <router-link class="nickname" v-text="name" :to="{name:'user.show.profile',params:{user:id}}"></router-link>
                <span>发表了文章 <span class="speacd">·</span> {{ article.created_at }}</span>
            </div>
        </div>
        <router-link class="title" v-text="article.title" :to="{name:'article.show',params:{article:article.id}}"></router-link>
        <p class="abstract" v-text="article.content"></p>
        <div class="meta">
            <router-link class="topic" :to="{name:'topics.index',params:{topic:topic.id}}" v-text="topic.name"></router-link>
            <router-link :to="{name:'article.show',params:{article:article.id}}">
                <Icon type="eye"></Icon>
                {{ article.read_count }}
            </router-link>
            <router-link :to="{name:'article.show',params:{article:article.id}}">
                <Icon type="chatbox-working"></Icon>
                {{ article.comments_count }}</router-link>
            <router-link :to="{name:'article.show',params:{article:article.id}}">
                <Icon type="android-favorite"></Icon>
                {{ article.like_count }}
            </router-link>
            <router-link class="action" :to="{name:'article.show',params:{article:article.id}}">
                查看全文
            </router-link>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    export default {
        data() {
            return {
                article:this.machine.article,
                user:this.machine.article.user,
                topic:this.machine.article.topic,
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