<template>
    <div class="layout">
        <IndexHeader></IndexHeader>
        <div class="container">
            <i-col :span="16" class="left">
                <div class="user-detail">
                    <router-link class="avatar" :to="{name:'user.show.profile',params:{user:id}}">
                        <img :src="user.avatar">
                    </router-link>
                    <div class="info">
                        <span class="name">
                            <router-link :to="{name:'user.show.profile',params:{user:id}}" v-text="user.name"></router-link>
                        </span>
                        <Icon :type="user.gender" v-show="user.gender"></Icon>
                        <p class="daska">发布了 {{ user.article_count }} 篇文章，关注了 {{ user.follower_count }} 人 ，被 {{ user.follower_count }} 人关注</p>
                        <p class="daska" v-text="user.describe"></p>
                    </div>
                </div>
                <router-view/>
            </i-col>
            <i-col :span="7" offset="1" class="right">
                <div class="title">
                    <span>个人介绍</span>
                </div>
                <div class="description">
                    <div class="resume" v-html="user.resume"></div>
                </div>
                <ul class="synamic">
                    <li>
                        <router-link :to="{name:'user.show.follow',params:{user:id}}">
                            <Icon type="android-person"></Icon>
                            关注的用户
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'user.show.focus',params:{user:id}}">
                            <Icon type="android-bookmark"></Icon>
                            关注的专题
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'user.show.focus',params:{user:id}}">
                            <Icon type="android-favorite-outline"></Icon>
                            喜欢的文章
                        </router-link>
                    </li>
                </ul>
                <div class="topics_options">
                    <div class="title">
                        我创建的专题
                        <router-link :to="{name:'topics.create'}">
                            <Button type="text" icon="plus-round">创建一个新专题</Button>
                        </router-link>
                    </div>
                    <ul class="collection">
                        <li v-for="topic in user.create_topics">
                            <router-link :to="{name:'topics.index',params:{topic:topic.id}}">
                                <Avatar icon="person" shape="square" :src="topic.cover"></Avatar>
                                {{ topic.name }}
                            </router-link>
                        </li>
                    </ul>
                </div>
            </i-col>
        </div>
    </div>
</template>

<script>
    import IndexHeader from '../../../components/Commons/Header.vue'
    import {mapState} from 'vuex'

    export default {
        data() {
            return {
                user: {
                    create_topics: {}
                }
            }
        },
        components: {
            IndexHeader,
        },
        computed: mapState({
            id: state => state.user.id,
        }),
        created: function () {
            var user = this.$route.params.user

            return this.$axios.get('user/' + user).then(resource => {
                let respond = resource.data
                if (respond.status) {
                    this.user = respond.data.user
                } else {
                    this.$Message.error(respond.message)
                }
            })
        }
    }
</script>