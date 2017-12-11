<template>
    <Form :model="profile_form" ref="profile_form" :rules="rules" :label-width="120" class="profile_form">
        <FormItem label="性别">
            <Select size="large" v-model="profile_form.gender">
                <Option value="female" label="女">
                    <Icon type="female"></Icon>
                    <span>女</span>
                </Option>
                <Option value="male" label="男">
                    <Icon type="male"></Icon>
                    <span>男</span>
                </Option>
                <Option value="transgender" label="跨性别者">
                    <Icon type="transgender"></Icon>
                    <span>跨性别者</span>
                </Option>
                <Option value="locked" label="保密">
                    <Icon type="locked"></Icon>
                    <span>保密</span>
                </Option>
            </Select>
        </FormItem>
        <FormItem label="个性签名" prop="describe">
            <Input v-model="profile_form.describe"/>
            <p class="help">请填写您的个性签名</p>
        </FormItem>
        <FormItem label="个人简介" prop="describe">
            <Input type="textarea" :rows="4" v-model="profile_form.resume"/>
            <p class="help">请填写您的个人简介</p>
        </FormItem>
        <FormItem label="个人站点" prop="website">
            <i-input placeholder="请输入你的个人站点" v-model="profile_form.website" size="large"/>
            <p class="help">填写后会在个人主页显示图标</p>
        </FormItem>
        <FormItem label="微信二维码" class="wechat-item">
            <CropWechatQrCode></CropWechatQrCode>
        </FormItem>
        <FormItem>
            <Button type="success" shape="circle" @click="onSubmit('profile_form')">保存</Button>
        </FormItem>
    </Form>
</template>

<script>
    import CropWechatQrCode from '../../../components/Users/CropWechatQrCode.vue'
    import {mapState} from 'vuex'

    export default {
        data() {
            return {
                rules: {
                    describe: [
                        {max: 100, message: '个性签名最多只能填写 100 字', trigger: 'blur'}
                    ],
                    website: [
                        {max: 100, message: '网址最长为 100 位', trigger: 'blur'}
                    ],
                },
                profile_form: {
                    gender: null,
                    describe: null,
                    website: null,
                    resume: null,
                }
            }
        },
        components: {
            CropWechatQrCode
        },
        created: function () {
            this.profile_form.gender = this.user.gender
            this.profile_form.describe = this.user.describe
            this.profile_form.website = this.user.website
            this.profile_form.resume = this.user.resume
        },
        computed: mapState({
            user: state => state.user,
        }),
        methods: {
            onSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (!valid) return

                    this.$axios.put('user/profile', this.profile_form).then(resource => {
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