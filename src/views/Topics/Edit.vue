<template>
    <div class="layout">
        <IndexHeader></IndexHeader>
        <div class="container">
            <i-col :span="18" offset="3">
                <div class="topic-fored">
                    <Form :label-width="120" class="create-topic-form">
                        <FormItem label="专题封面" class="wechat-item">
                            <CropCover v-model="topic.cover"></CropCover>
                        </FormItem>
                        <FormItem label="专题名称" prop="describe">
                            <Input v-model="topic.name"/>
                            <p class="help">请填写专题的名称，唯一且不可重复</p>
                        </FormItem>
                        <FormItem label="专题描述" prop="describe">
                            <Input type="textarea" :rows="5" v-model="topic.describe"/>
                            <p class="help">请填写专题的描述</p>
                        </FormItem>
                        <FormItem label="管理用户">
                            <Select v-model="topic.manages"
                                    placeholder="请输入用户名称"
                                    filterable
                                    multiple
                                    :loading="select_loading"
                                    remote
                                    :remote-method="getUsers"
                            >
                                <Option v-for="(user, index) in users" :value="user.id" :key="index" :label="user.name">
                                    <Avatar icon="person" :src="user.avatar" shape="square"></Avatar>
                                    <span v-text="user.name"></span>
                                    <Icon :type="user.gender" v-show="user.gender"></Icon>
                                </Option>
                            </Select>
                        </FormItem>
                        <FormItem>
                            <Button type="success" shape="circle" @click="update" :disabled="!is_create">更新专题</Button>
                        </FormItem>
                    </Form>
                </div>
            </i-col>
        </div>
    </div>
</template>
<script>
    import IndexHeader from '../../components/Commons/Header'
    import CropCover from '../../components/Topics/CropCover'

    export default {
        data() {
            return {
                topic: {
                    cover: null,
                    name: null,
                    describe: null,
                    manages: [],
                },
                select_loading: false,
                users: [],
            }
        },
        components: {
            CropCover,
            IndexHeader
        },
        methods: {
            update() {
                this.$axios.put(`topics/${this.$route.params.topic}`, this.topic).then(resource => {
                    let respond = resource.data
                    if (respond.status) {
                        this.$router.push('/topics/' + this.$route.params.topic)
                        this.$Message.success(respond.message)
                    } else {
                        this.$Message.error(respond.message)
                    }
                })
            },
            getUsers(query) {
                this.users = []
                if (query !== '') {
                    this.select_loading = true
                    this.$axios.get('topics/users?query=' + query).then(resource => {
                        let respond = resource.data
                        this.select_loading = false
                        return respond.status
                            ? this.users = respond.data.users
                            : this.$Message.error(respond.message)
                    })
                }
            }
        },
        computed: {
            is_create() {
                return this.topic.cover && this.topic.name && this.topic.describe;
            }
        },
        created: function () {
            return this.$axios.post(`topics/${this.$route.params.topic}`, {}).then(resource => {
                let respond = resource.data

                this.topic.cover = respond.data.topic.cover
                this.topic.name = respond.data.topic.name
                this.topic.describe = respond.data.topic.describe

                var data = []

                for (var i = 0; i < respond.data.topic.manages.length; i++) {
                    var user = respond.data.topic.manages[i]
                    if (user.is_creator == 0) {
                        this.users.push(user)
                        data.push(user.id)
                    }
                }

                this.$nextTick(() => {
                    this.topic.manages = data
                })

            })
        }
    }
</script>