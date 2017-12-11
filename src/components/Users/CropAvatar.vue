<template>
    <Upload action="http://up-z2.qiniu.com"
            :max-size="3072"
            :data="token"
            :show-upload-list="false"
            :format="['jpg','jpeg','png','gif']"
            :before-upload="getUploadToken"
            :on-format-error="FormatError"
            :on-success="uploadSucceed"
            :on-error="uploadFail"
            :on-exceeded-size="exceededSize"
    >
        <Spin v-show="vistal" fix>
            <Icon type="load-c" size=18 class="spin-icon-load"></Icon>
            <div>上传中...</div>
        </Spin>
        <Avatar shape="square" :src="avatar" size="large"/>
    </Upload>
</template>

<script>
    import {mapState} from 'vuex'
    export default {
        data () {
            return {
                vistal: false,
                token: null,
            }
        },
        components: {},
        computed: mapState({
            avatar: state => state.user.avatar,
        }),
        methods: {
            FormatError(){
                this.vistal = false
                return this.$Message.error('文件格式错误')
            },
            uploadFail(){
                this.vistal = false
                return this.$Message.error('文件上传失败，请重试')
            },
            exceededSize(){
                this.vistal = false
                return this.$Message.error('图片最大为3M')
            },
            uploadSucceed(response){
                var avatar = this.$env.oss_domain + response.key + '?imageView2/1/w/200/h/200/q/75|imageslim'
                this.vistal = false
                this.$axios.put('user/avatar', {avatar: avatar}).then(resource => {
                    let respond = resource.data
                    if (respond.status) {
                        this.$Message.success(respond.message)
                        this.$store.dispatch('refresh')
                    } else {
                        this.$Message.error(respond.message)
                    }
                })
            },
            getUploadToken(file){
                this.vistal = true

                return this.$axios.get('upload/token', {}).then(resource => {
                    let respond = resource.data
                    this.token = respond.data
                })
            },
        }
    }
</script>