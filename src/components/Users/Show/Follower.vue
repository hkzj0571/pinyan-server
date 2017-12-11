<template>
    <ul class="topics_list">
        <transition-group name="fade">
            <li v-for="(follower,index) in followers" :key="index">
                <router-link class="cover" to="/c/1hjajt">
                    <Avatar :src="follower.avatar" shape="square" size="large"></Avatar>
                </router-link>
                <div class="info small-meta">
                    <a class="title" href="/c/1hjajt" v-text="follower.name"></a>
                    <div class="meta">发布了 {{ follower.article_count }} 篇文章，关注了 {{ follower.follower_count }} 人 ，被 {{ follower.follower_count }} 人关注</div>
                    <div class="meta" v-text="follower.describe"></div>
                </div>
                <Button icon="checkmark-round" shape="circle" size="large" @click="cancel(follower,index)">已关注</Button>
            </li>
        </transition-group>
        <li class="end">
            <Button type="text" icon="chevron-down" :loading="loading" v-show="!end" @click="getTopics">加载更多</Button>
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
                followers: []
            }
        },
        created: function () {
            this.getTopics()
        },
        methods: {
            getTopics() {
                this.loading = true
                this.page++
                this.$axios.get('user/follower?page=' + this.page, {}).then(resource => {
                    this.loading = false
                    if (resource.data.data.followers.length === 0) {
                        this.end = true
                    }
                    this.followers = this.followers.concat(resource.data.data.followers)
                })
            },
            cancel(follower, index) {
                this.followers.splice(index, 1)
            }
        }
    }
</script>