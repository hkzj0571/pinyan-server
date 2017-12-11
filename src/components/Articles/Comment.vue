<template>
    <div class="comment-list">
        <div class="new_commet">
            <Avatar icon="person" size="large"/>
            <textarea rows="3" class="ivu-input" v-model="comment.content" @click="vilast = true"></textarea>
            <transition name="fade">
                <div class="function-block" v-show="vilast">
                    <Icon type="android-happy"></Icon>
                    <Button type="text" shape="circle" size="large" @click="vilast = false">取消
                    </Button>
                    <Button type="success" shape="circle" size="large" :disabled="!comment.content" @click="store"
                            :loading="loading">发送
                    </Button>
                </div>
            </transition>
        </div>
        <div class="normal-comment-list">
            <div class="top-title">
                <span>{{ article.comments_count }} 条评论</span>
                <a class="author-only" :class="{active:only}" @click="onlyAuthor">只看作者</a>
                <a class="close-btn" style="display: none;">关闭评论</a>
                <div class="pull-right">
                    <a href="javascript:void(0);" :class="{active:sort == 'vote'}" @click="awsort('vote')">按赞同排序</a>
                    <a href="javascript:void(0);" :class="{active:sort == 'asc'}" @click="awsort('asc')">按时间正序</a>
                    <a href="javascript:void(0);" :class="{active:sort == 'desc'}" @click="awsort('desc')">按时间倒序</a>
                </div>
            </div>
            <Reply :comment="comment" v-for="comment in comments"></Reply>
        </div>
        <div class="close">
            <Button type="text" icon="chevron-down" :loading="more_loading" v-show="!loading_end" @click="getComment">
                加载更多
            </Button>
            <Button type="text" v-show="loading_end">加载完毕</Button>
        </div>
    </div>
</template>
<script>
    import Reply from './Reply'

    export default {
        data() {
            return {
                vilast: false,
                comment: {
                    article_id: this.$route.params.article,
                    content: null,
                    reply_id: null,
                },
                loading: false,
                page: 0,
                more_loading: false,
                loading_end: false,
                only: false,
                sort: 'vote',
                comments: [],
            }
        },
        components: {
            Reply,
        },
        computed: {},
        props: ['article'],
        created: function () {
            this.getComment()
        },
        methods: {
            store() {
                this.loading = true
                this.$axios.post('comments/store', this.comment).then(resource => {
                    let respond = resource.data
                    this.loading = false
                    if (respond.status) {
                        this.comment.content = null
                        this.vilast = false
                        this.article.comments_count++
                        this.comments.unshift(respond.data.comment)
                    } else {
                        this.$Message.error(respond.message)
                    }
                })
            },
            awsort(type){
                this.sort = type
                this.comments = []
                this.page = 0
                this.getComment()
            },
            onlyAuthor(){
                this.only = !this.only
                this.comments = []
                this.page = 0
                this.getComment()
            },
            getComment() {
                this.more_loading = true
                this.page++
                this.$axios.post(`article/${this.$route.params.article}/comments`,{
                    page: this.page,
                    only: this.only,
                    sort: this.sort,
                }).then(resource => {
                    this.more_loading = false
                    let respond = resource.data
                    this.$nextTick(() => {
                        this.comments = this.comments.concat(respond.data.comments)
                    })
                    if (respond.data.comments.length == 0) {
                        this.loading_end = true
                    }
                })
            }
        },
    }
</script>