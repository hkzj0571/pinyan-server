<template>
    <Form :model="basic_form" ref="basic_form" :rules="rules" :label-width="120" class="profile_form">
        <FormItem label="头像" class="avatar-item" prop="avatar">
            <CropAvatar></CropAvatar>
        </FormItem>
        <FormItem label="昵称" prop="name">
            <i-input placeholder="请输入你的昵称" v-model="basic_form.name" size="large"/>
        </FormItem>
        <FormItem label="邮箱">
            <p>{{ email }} <span class="label"><Icon type="checkmark-round"></Icon>已绑定</span></p>
        </FormItem>
        <FormItem>
            <Button type="success" shape="circle" @click="onSubmit('basic_form')">保存</Button>
        </FormItem>
    </Form>
</template>

<script>
    import CropAvatar from '../../../components/Users/CropAvatar.vue'
    import {mapState} from 'vuex'
    export default {
        data () {
            return {
                rules: {
                    name: [
                        {required: true, message: '请输入您的昵称', trigger: 'blur'},
                        {min: 2, message: '昵称最短为 2 位', trigger: 'blur'},
                        {max: 12, message: '昵称最长为 12 位', trigger: 'blur'}
                    ],
                },
                basic_form: {
                    name: null,
                }
            }
        },
        components: {
            CropAvatar
        },
        created: function () {
            this.basic_form.name = this.name
        },
        computed: mapState({
            name: state => state.user.name,
            avatar: state => state.user.avatar,
            email: state => state.user.email,
            is_active: state => state.user.is_active,
            authenticated: state => state.user.authenticated,
        }),
        methods: {
            onSubmit(name){
                this.$refs[name].validate((valid) => {
                    if (!valid) return
                    this.$axios.put('user/basic', this.basic_form).then(resource => {
                        let respond = resource.data
                        if (respond.status) {
                            this.$Message.success(respond.message)
                            this.$store.dispatch('refresh')
                        } else {
                            this.$Message.error(respond.message)
                        }
                    })
                })
            },
        }
    }
</script>