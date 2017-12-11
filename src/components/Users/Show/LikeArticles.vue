<template>
    <ul class="media_list">
        <transition-group name="fade">
            <li v-for="(article,index) in articles" :class="{'have-img':article.cover}" :key="index">
                <router-link class="wrap-img" :to="'/article/'+article.id" v-if="article.cover">
                    <img :src="article.cover">
                </router-link>
                <div class="content">
                    <div class="author">
                        <router-link to="/">
                            <Avatar icon="person" :src="article.user.avatar"/>
                        </router-link>
                        <div class="info">
                            <a class="nickname" href="" v-text="article.user.name"></a>
                            <span class="time" v-text="article.created_at"></span>
                        </div>
                    </div>
                    <router-link class="title" :to="{name:'article.show',params:{article:article.id}}" v-text="article.title"></router-link>
                    <p class="abstract" v-text="article.content"></p>
                    <div class="meta">
                        <a class="topic" href="/c/71a87e510a58" v-text="article.topic.name"></a>
                        <a href="">
                            <Icon type="eye"></Icon>
                            {{ article.read_count }}</a>
                        <a href="">
                            <Icon type="chatbox-working"></Icon>
                            {{ article.comments_count }}</a>
                        <a href="">
                            <Icon type="android-favorite"></Icon>
                            {{ article.like_count }}</a>
                        <a href="javascript:void(0);" class="destroy" @click="cancelLike(article,index)">
                            <Icon type="trash-b"></Icon>
                            取消喜欢</a>
                    </div>
                </div>
            </li>
        </transition-group>
        <li class="end">
            <Button type="text" icon="chevron-down" :loading="loading" v-show="!end"
                    @click="getArticles">加载更多
            </Button>
            <Button type="text" v-show="end">加载完毕</Button>
        </li>
    </ul>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                end: false,
                page: 0,
                articles: []
            }
        },
        created: function () {
            this.getArticles()
        },
        methods: {
            getArticles() {
                this.loading = true
                this.page++
                this.$axios.get('user/like_article?page=' + this.page, {}).then(resource => {
                    this.loading = false
                    if (resource.data.data.articles.length === 0) {
                        this.end = true
                    }
                    this.articles = this.articles.concat(resource.data.data.articles)
                })
            },
            cancelLike(article, index) {
                this.articles.splice(index, 1)
            }
        }
    }
</script>