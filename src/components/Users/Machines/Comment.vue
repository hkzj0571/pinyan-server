<template>
    <div class="content">
        <div class="author">
            <router-link :to="{name:'user.show.profile',params:{user:id}}">
                <Avatar :src="avatar" size="large"></Avatar>
            </router-link>
            <div class="info">
                <router-link class="nickname" v-text="name" :to="{name:'user.show.profile',params:{user:id}}"></router-link>
                <span>发表了评论 <span class="speacd">·</span> {{ comment.created_at }}</span>
            </div>
        </div>
        <router-link :to="{name:'article.show',params:{article:article.id}}">
            <p class="comment" v-text="comment.content"></p>
        </router-link>
        <blockquote>
            <router-link :to="{name:'article.show',params:{article:article.id}}" class="title" v-text="article.title"></router-link>
            <p class="abstract" v-text="article.content"></p>
            <div class="meta">
                <router-link class="topic" :to="{name:'topics.index',params:{topic:topic.id}}" v-text="topic.name"></router-link>
                <router-link :to="{name:'user.show.profile',params:{user:author.id}}" class="origin_name" v-text="author.name"></router-link>
                <router-link :to="{name:'article.show',params:{article:article.id}}">
                    <Icon type="eye"></Icon>
                    {{ article.read_count }}
                </router-link>
                <router-link :to="{name:'article.show',params:{article:article.id}}">
                    <Icon type="chatbox-working"></Icon>
                    {{ article.comments_count }}
                </router-link>
                <router-link :to="{name:'article.show',params:{article:article.id}}">
                    <Icon type="android-favorite"></Icon>
                    {{ article.like_count }}
                </router-link>
            </div>
        </blockquote>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    export default {
        data() {
            return {
                comment:this.machine.comment,
                article:this.machine.article,
                topic:this.machine.article.topic,
                author:this.machine.article.user,
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