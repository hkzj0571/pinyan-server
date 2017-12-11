<template>
    <ul class="media_list">
        <transition-group name="fade">
            <li v-for="(article,index) in articles" :class="{'have-img':article.cover}" :key="index">
                <router-link class="wrap-img" :to="'/article/'+article.id" v-if="article.cover">
                    <img :src="article.cover">
                </router-link>
                <div class="content">
                    <div class="author">
                        <router-link :to="'/user'+article.user.id+'/profile'">
                            <Avatar icon="person" :src="article.user.avatar"/>
                        </router-link>
                        <div class="info">
                            <router-link class="nickname" :to="'/user'+article.user.id+'/profile'" v-text="article.user.name"></router-link>
                            <span class="time" v-text="article.created_at"></span>
                        </div>
                    </div>
                    <router-link class="title" :to="'/article/'+article.id" v-text="article.title"></router-link>
                    <router-link :to="'/article/'+article.id">
                        <p class="abstract" v-text="article.content"></p>
                    </router-link>
                    <div class="meta">
                        <a class="topic" href="/c/71a87e510a58" v-text="article.topic.name"></a>
                        <a href=""><Icon type="eye"></Icon>{{ article.read_count }}</a>
                        <a href=""><Icon type="chatbox-working"></Icon>{{ article.comments_count }}</a>
                        <a href=""><Icon type="android-favorite"></Icon>{{ article.like_count }}</a>
                    </div>
                </div>
            </li>
        </transition-group>
        <li class="end">
            <Button type="text" icon="chevron-down" :loading="loading_article" v-show="!article_end" @click="getArticles">加载更多</Button>
            <Button type="text" v-show="article_end">加载完毕</Button>
        </li>
    </ul>
</template>

<script>
    export default {
        data() {
            return {
                loading_article:false,
                article_end:false,
                article_page: 0,
                articles: []
            }
        },
        created: function () {
            this.getArticles()
        },
        methods: {
            getArticles() {
                var topic = this.$route.params.topic
                this.loading_article = true
                this.article_page++
                this.$axios.post(`topics/${topic}/new_articles?page=` + this.article_page, {}).then(resource => {
                    this.loading_article = false
                    if (resource.data.data.articles.length === 0) {
                        this.article_end = true
                    }
                    this.articles = this.articles.concat(resource.data.data.articles)
                })
            }
        }
    }
</script>