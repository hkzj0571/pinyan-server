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
                        <FormItem label="专题名称">
                            <Input v-model="topic.name"/>
                            <p class="help">请填写专题的名称，唯一且不可重复</p>
                        </FormItem>
                        <FormItem label="专题描述">
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
                            <Button type="success" shape="circle" @click="store" :disabled="!is_create">创建专题</Button>
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
            store() {
                this.$axios.post('topics/store', this.topic).then(resource => {
                    let respond = resource.data
                    if (respond.status) {
                        this.$router.push('/topics/' + respond.data.topic.id)
                        this.$Message.success('创建专题成功')
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
    }
</script>