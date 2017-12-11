<template>
    <div class="layout">
        <div class="container">
            <i-col :span="18" offset="3">
                <div class="article-header">
                    <div class="header-logo">
                        <router-link to="/"></router-link>
                    </div>
                    <Dropdown trigger="click">
                        <a href="javascript:void(0)">
                            <Button shape="circle" icon="arrow-down-b">发布文章</Button>
                        </a>
                        <div class="topic-select" slot="list">
                            <p>请选择专题</p>
                            <Select v-model="article.topic_id"
                                    filterable
                                    placeholder="请输入专题关键词"
                                    :remote-method="getTopics"
                                    :loading="loading"
                                    remote>
                                <Option :value="topic.id" :label="topic.name" v-for="topic in topics">
                                    <img :src="topic.cover">
                                    <span>{{ topic.name }}</span>
                                </Option>
                            </Select>
                            <Button type="ghost" @click="store" :disabled="!create_validate">确定发布</Button>
                        </div>
                    </Dropdown>
                </div>
                <div class="line"></div>
                <div class="article-fored">
                    <Input type="textarea" v-model="article.title" :rows="1" class="double_title"
                           placeholder="请输入文章标题"/>
                    <ArticleQuill v-model="article.content"></ArticleQuill>
                </div>
            </i-col>
        </div>
    </div>
</template>
<script>
    import ArticleQuill from '../../components/Articles/Quill.vue'

    export default {
        data() {
            return {
                topics: [],
                loading: false,
                article: {
                    content: null,
                    title: null,
                    topic_id: null,
                }
            }
        },
        components: {
            ArticleQuill
        },
        methods: {
            getTopics(query) {
                this.topics = []
                if (query !== '') {
                    this.loading = true
                    this.$axios.get('article/topic', {query: query}).then(resource => {
                        let respond = resource.data
                        this.loading = false
                        return respond.status
                            ? this.topics = respond.data.topics
                            : this.$Message.error(respond.message)
                    })
                }
            },
            store() {
                this.$axios.post('article/store', this.article).then(resource => {
                    let respond = resource.data
                    if (respond.status) {
                        this.$router.push({name: 'article.show', params: {article: respond.data.article.id}})
                        this.$Message.success('文章发布成功')
                    } else {
                        this.$Message.error(respond.message)
                    }
                })
            },
        },
        computed: {
            create_validate: function () {
                return this.article.title && this.article.topic_id && this.article.content
            }
        },
    }
</script>