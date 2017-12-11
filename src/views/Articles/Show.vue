<template>
    <div class="layout">
        <IndexHeader></IndexHeader>
        <div class="container">
            <i-col :span="16" offset="4">
                <div class="article-detail">
                    <h1 class="title" v-text="article.title"></h1>
                    <div class="author">
                        <router-link :to="{name:'user.show.profile',params:{user:article.user.id}}" class="avatar">
                            <img :src="article.user.avatar">
                        </router-link>
                        <div class="info">
                            <span class="name">
                                <router-link :to="{name:'user.show.profile',params:{user:article.user.id}}" v-text="article.user.name"></router-link>
                            </span>
                            <p class="describe" v-text="article.user.describe"></p>
                            <div class="meta">
                                <span><Icon type="android-time"></Icon>{{ article.created_at }}</span>
                                <span>阅读 {{ article.read_count }}</span>
                                <span>评论 {{ article.comments_count }}</span>
                                <span>喜欢 {{ article.like_count }}</span>
                            </div>
                        </div>
                        <router-link :to="{name:'article.edit',params:{article:article.id}}" v-if="is_author">
                            <Button class="btn-edit" type="success" icon="android-create" shape="circle">编辑文章</Button>
                        </router-link>
                    </div>
                    <div class="content" v-html="article.content">
                    </div>
                    <div class="footer">
                        <router-link class="topic" :to="{name:'topics.index',params:{topic:article.topic.id}}">
                            <Icon type="android-bookmark"></Icon>
                            <span v-text="article.topic.name"></span>
                        </router-link>
                        <div class="copyright">© 著作权归作者所有</div>
                        <div class="options">
                            <a href="">
                                <Icon type="flag"></Icon>
                                举报文章
                            </a>
                        </div>
                    </div>
                    <Author :user="article.user"></Author>
                    <div class="meta-bottom">
                        <Like :article="article"></Like>
                        <share></share>
                    </div>
                    <Comment :article="article"></Comment>
                </div>
            </i-col>
        </div>
    </div>
</template>
<script>
    import IndexHeader from '../../components/Commons/Header.vue'
    import Author from '../../components/Articles/Author'
    import Like from '../../components/Articles/Like'
    import Comment from '../../components/Articles/Comment'
    import {mapState} from 'vuex'

    export default {
        data() {
            return {
                article: {
                    id: null,
                    title: null,
                    content: null,
                    read_count: null,
                    topic: {},
                    user: {},
                },
            }
        },
        components: {
            IndexHeader,
            Author,
            Like,
            Comment
        },
        computed: {
            is_author: function () {
                return this.id == this.article.user.id
            },
            ...mapState({
                id: state => state.user.id,
            })
        },
        created: function () {
            this.$axios.get('article/' + this.$route.params.article, {}).then(resource => {
                let respond = resource.data
                this.article = respond.data.article
            })
        },
        methods: {}
    }
</script>