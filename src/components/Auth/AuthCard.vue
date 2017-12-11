<template>
    <div class="auth-card">
        <Tabs value="login" :animated="false" class="auth-card-nav">
            <TabPane label="登录" name="login">
                <Form ref="login_form" :rules="rules" :model="login_form">
                    <FormItem prop="email">
                        <i-input v-model="login_form.email" placeholder="请输入您的邮箱" icon="android-mail"/>
                    </FormItem>
                    <FormItem prop="password">
                        <i-input v-model="login_form.password" type="password" placeholder="请输入您的密码" icon="locked"/>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" shape="circle" size="large" long @click="login('login_form')">登录</Button>
                    </FormItem>
                    <FormItem>
                        <p class="tips"><a href="">忘记密码</a></p>
                    </FormItem>
                </Form>
            </TabPane>
            <TabPane label="注册" name="register">
                <Form ref="register_form" :rules="rules" :model="register_form">
                    <FormItem prop="name">
                        <i-input v-model="register_form.name" placeholder="请设置您的昵称" icon="android-person"/>
                    </FormItem>
                    <FormItem prop="email">
                        <i-input v-model="register_form.email" placeholder="请输入您的邮箱" icon="android-mail"/>
                    </FormItem>
                    <FormItem prop="password">
                        <i-input v-model="register_form.password" type="password" placeholder="请设置您的密码" icon="locked"/>
                    </FormItem>
                    <FormItem>
                        <Button type="success" shape="circle" size="large" long @click="register('register_form')">注册
                        </Button>
                    </FormItem>
                    <FormItem>
                        <p class="tips">
                            点击 “注册” 即表示您同意并愿意遵守品言<br>
                            <a target="_blank" href="http://www.jianshu.com/p/c44d171298ce">《用户协议》</a>
                            与 <a target="_blank" href="http://www.jianshu.com/p/2ov8x3">《隐私政策》</a>
                        </p>
                    </FormItem>
                </Form>
            </TabPane>
        </Tabs>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                rules: {
                    name: [
                        {required: true, message: '请输入您的昵称', trigger: 'blur'},
                        {min: 2, message: '昵称最短为 2 位', trigger: 'blur'},
                        {max: 12, message: '昵称最长为 12 位', trigger: 'blur'}
                    ],
                    email: [
                        {required: true, message: '请输入您的邮件地址', trigger: 'blur'},
                        {type: 'email', message: '请输入正确的邮件地址', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '请输入您的密码', trigger: 'blur'},
                        {min: 6, message: '密码最短为 6 位', trigger: 'blur'},
                        {max: 30, message: '密码最长为 30 位', trigger: 'blur'}
                    ],
                },
                login_form: {
                    email: '',
                    password: '',
                },
                register_form: {
                    name: '',
                    email: '',
                    password: '',
                }
            }
        },
        methods: {
            login(name) {
                this.$refs[name].validate((valid) => {
                    if (!valid) return
                    this.$axios.post('login', this.login_form).then(resource => {
                        let respond = resource.data
                        return respond.status ? this.$store.dispatch('authenticated', respond.data).then(() => {
                            this.$router.push('/')
                            return this.$Message.success('登陆成功')
                        }) : this.$Message.error(respond.message)
                    })
                })
            },
            register(name) {
                this.$refs[name].validate((valid) => {
                    if (!valid) return
                    this.$axios.post('register', this.register_form).then(resource => {
                        let respond = resource.data
                        return respond.status ? this.$store.dispatch('authenticated', respond.data).then((data) => {
                            this.$router.push('/')
                            return this.$Message.success('注册成功')
                        }) : this.$Message.error(respond.message)
                    })
                })
            },
        }
    }
</script>