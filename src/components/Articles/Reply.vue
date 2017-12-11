<template>
    <div class="comment">
        <div class="author">
            <Avatar icon="person" :src="comment.user.avatar" size="large"/>
            <div class="info">
                <a href="/u/4f5335659dc7" class="name" v-text="comment.user.name"></a>
                <div class="meta"><span v-text="comment.created_at"></span></div>
            </div>
        </div>
        <div class="comment-wrap">
            <p v-text="comment.content"></p>
            <div class="tool-group">
                <a href="javascript:void(0);" @click="vote(comment)" :class="{voted:comment.is_vote}">
                    <Icon type="thumbsup"></Icon>
                    <span>{{ comment.vote_count == 0 ? '赞' : comment.vote_count+' 人赞' }}</span>
                </a>
                <a href="javascript:void(0);" @click="check(comment.id)">
                    <Icon type="chatbox-working"></Icon>
                    <span>回复</span>
                </a>
                <a href="javascript:void(0);">
                    <Icon type="flag"></Icon>
                    <span>举报</span>
                </a>
            </div>
        </div>
        <div class="sub-comment-list">
            <div class="sub-comment" v-for="childer in comment.childers">
                <div class="content">
                    <a v-text="childer.user.name"></a>：
                    <span>
                        {{ childer.content}}
                    </span>
                </div>
                <div class="tool-group">
                    <span class="time" v-text="childer.created_at"></span>
                    <a href="javascript:void(0);" @click="vote(childer)" :class="{voted:childer.is_vote}">
                        <Icon type="thumbsup"></Icon>
                        <span>{{ childer.vote_count == 0 ? '赞' : childer.vote_count+' 人赞' }}</span>
                    </a>
                    <a href="javascript:void(0);" @click="check(comment.id,childer)">
                        <Icon type="chatbox-working"></Icon>
                        <span>回复</span>
                    </a>
                    <a href="javascript:void(0);">
                        <Icon type="flag"></Icon>
                        <span>举报</span>
                    </a>
                </div>
            </div>
            <transition name="fade">
                <div v-show="vlista">
                    <textarea rows="3" class="ivu-input" v-model="reply.content"></textarea>
                    <div class="function-block">
                        <Icon type="android-happy" @click="tgoogle()"></Icon>
                        <Button type="text" shape="circle" size="large" @click="vlista = false">取消</Button>
                        <Button type="success" shape="circle" size="large" :disabled="!reply.content" :loading="loading" @click="store">发送
                        </Button>
                    </div>
                </div>
            </transition>
            <transition name="fade">
                <div class="sub-comment new_commente" v-show="!vlista">
                    <Button type="text" icon="android-create" @click="check(comment.id)">添加新评论</Button>
                </div>
            </transition>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                vlista: false,
                loading: false,
                reply: {
                    article_id: this.$route.params.article,
                    reply_id: this.comment.id,
                    content: null,
                }
            }
        },
        props: ['comment'],
        computed: {
        },
        methods: {
            check(reply_id,childer = null) {
                this.vlista = true
                this.reply.reply_id = reply_id
                if (childer !== null) {
                    this.reply.content = `@${childer.user.name} `
                }
            },
            vote(comment){
                comment.is_vote = !comment.is_vote
                this.$axios.post(`comments/${comment.id}/vote`).then(resource => {
                    resource.data.data.type ? comment.vote_count++ : comment.vote_count--
                })
            },
            store() {
                this.loading = true
                this.$axios.post('comments/store', this.reply).then(resource => {
                    let respond = resource.data
                    this.loading = false
                    if (respond.status) {
                        this.reply.content = null
                        this.vlista = false

                        if (!this.comment.childers) {
                            this.comment.childers = []
                        }

                        this.comment.childers.push(respond.data.comment)
                    } else {
                        this.$Message.error(respond.message)
                    }
                })
            }
        },
    }
</script>