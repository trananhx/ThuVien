<template>
    <el-row :gutter="24" v-loading.fullscreen.lock="loading.status">
        <el-col :span="6" :xs="24">
<!--            <div class="text-center">-->
<!--                <el-button type="success"> Về trang chủ</el-button>-->
<!--                <el-button type="primary" @click.prevent="show_add = true"> Thêm phản hồi</el-button>-->
<!--            </div>-->
            <p class="fs-3 border-bottom border-dark-subtle pb-1">DANH MỤC</p>
            <div class="mb-4">
                <div>
                    <el-button class="w-100" @click="changeTab('gop-y')">
                        <div class="d-flex justify-content-between">
                            <div class="fw-lighter">
                                Góp ý
                            </div>
                            <div>
                                <el-icon name="el-icon-info"/>
                            </div>
                        </div>
                    </el-button>
                </div>
                <div>
                    <el-button class="w-100 mt-2" @click="changeTab('bo-sung')">
                        <div class="d-flex justify-content-between">
                            <div class="fw-lighter">
                                Đề nghị bổ sung tài liệu
                            </div>
                            <div>
                                <el-icon name="el-icon-info"/>
                            </div>
                        </div>
                    </el-button>
                </div>
                <div>
                    <el-button class="w-100 mt-2" @click="changeTab('gia-han')">
                        <div class="d-flex justify-content-between">
                            <div class="fw-lighter">
                                Yêu cầu gia hạn online
                            </div>
                            <div>
                                <el-icon name="el-icon-info"/>
                            </div>
                        </div>
                    </el-button>
                </div>
                <div>
                    <el-button class="w-100 mt-2" @click="changeTab('tham-do')">
                        <div class="d-flex justify-content-between">
                            <div class="fw-lighter">
                                Thăm dò ý kiến
                            </div>
                            <div>
                                <el-icon name="el-icon-info"/>
                            </div>
                        </div>
                    </el-button>
                </div>
            </div>
        </el-col>

        <el-col :span="18" :xs="24" class="">
            <div v-if="tab === 'gop-y' || tab === 'bo-sung' || tab === 'gia-han'">
                <div class="px-4 py-2 mb-4 fw-bold bg-light fs-5">
                    {{ tab === 'gop-y' ? 'Góp ý' : ''}}
                    {{ tab === 'bo-sung' ? 'Đề nghị bổ sung tài liệu' : ''}}
                    {{ tab === 'gia-han' ? 'Yêu cầu gia hạn online' : ''}}
                </div>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <p v-if="tab === 'bo-sung' || tab === 'gop-y'" class="text-muted">
                            Bạn có những thắc mắc hoặc góp ý. Hãy điền các thông tin vào biểu mẫu và gửi cho thư viện, chúng tôi sẽ trả lời cho bạn trong thời gian sớm nhất
                        </p>
                        <p v-if="tab === 'gia-han'" class="text-muted">
                            Bạn muốn gia hạn thông tin sách đã mượn. Hãy điền các thông tin vào biểu mẫu và gửi cho thư viện, chúng tôi sẽ trả lời cho bạn trong thời gian sớm nhất
                        </p>
                    </el-col>
                    <el-col :span="24" class="text-left">
                        <label>Tiêu đề <span class="required" style="color: red">*</span></label>
                        <el-input type="text" placeholder="Nhập" clearable v-model="dataYeuCau.tieu_de"></el-input>
                    </el-col>

                    <el-col :span="24" class="text-left mt-3">
                        <label>Nội dung <span class="required" style="color: red;text-align: left">*</span></label>
                        <vue-editor v-model="dataYeuCau.noi_dung"/>
                    </el-col>
                </el-row>
                <div class="d-flex justify-content-center my-4">
                    <el-button type="primary" @click="xacNhanThemMoi">Gửi đi</el-button>
                </div>
            </div>
            <div v-if="tab === 'tham-do'">
                <div class="px-4 py-2 mb-4 fw-bold bg-light fs-5">
                    Thăm dò ý kiến
                </div>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <p class="text-muted">
                            Bạn hãy chọn một trong số các lựa chọn sau. Ý kiến của bạn giúp cho chúng tôi có thể cải thiện và trở nên tốt hơn
                        </p>
                        <p class="mt-2 fs-5">
                            {{ dataThamDo?.content }}
                        </p>
                    </el-col>
                    <el-col :span="24">
                        <template v-for="vote in dataThamDo.votes">
                            <div @click="guiThamDo(vote.id)" style="cursor:pointer">
                                <p class="mb-0">{{ vote.name }} ({{ vote.count }} lượt chọn)</p>
                                <template v-if="dataThamDo.userSelect !== null && dataThamDo.userSelect.id === vote.id">
                                    <k-progress :percent="vote.percent" status="error" line-height="10" active></k-progress>
                                </template>
                                <template v-else>
                                    <k-progress :percent="vote.percent" line-height="10" color="#c8cddb"></k-progress>
                                </template>
                            </div>
                        </template>
                    </el-col>
                </el-row>
                <p class="mt-4 fw-bold">Tổng lượt chọn: {{ dataThamDo.totalVote }} lượt</p>
            </div>
        </el-col>
    </el-row>

</template>

<script>
import rest_api from "../../api/rest_api";
import Vue from 'vue';
import ElementUI from 'element-ui';
import Vue2Editor from "vue2-editor";
import { Icon } from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import eselect from "../Ui/ESelect.vue";
import KProgress from 'k-progress';

Vue.use(ElementUI);
Vue.use(Vue2Editor);
Vue.use(Icon);
export default {
    components: {
        eselect,
        'k-progress': KProgress
    },
    data()
    {
        return {
            // show_add: false,
            tab: 'gop-y',
            loading:
            {
                status: false,
                text: 'Loading...'
            },
            dataYeuCau:
            {
                tieu_de: '',
                noi_dung: ''
            },
            dataThamDo: {
                questionId: '',
                content: '',
                votes: [],
                userSelect: null,
                totalVote: 0,
            },
            vote: '',
        }
    },
    mounted()
    {
        console.log('Created...');
        this.layThongTinThamDo();
    },
    methods: {
        changeTab(tabName){
            if (this.tab === tabName) return;
            this.tab = tabName;
            this.dataYeuCau.tieu_de = '';
            this.dataYeuCau.noi_dung = '';
            console.log(this.dataThamDo);
        },
        xacNhanThemMoi()
        {
            console.log('Xác nhận thêm mới')
            if(!this.dataYeuCau.tieu_de||this.dataYeuCau.tieu_de==''||!this.dataYeuCau.noi_dung||this.dataYeuCau.noi_dung=='')
            {
                this.thongBao('error','Vui lòng bổ sung thông tin.')
                return;
            }
            var url = '/them-yeu-cau'
            this.loading.status = true;
            this.loading.text = 'Loading...'
            rest_api.post(url, this.dataYeuCau).then(
                response => {
                    if (response.data.rc == 0)
                    {
                        this.thongBao('success','Thêm yêu cầu thành công')
                        setTimeout(()=>
                        {
                            window.location.reload(true);
                        },1500)
                    }
                    else
                    {
                        this.thongBao('error', response.data.rd)
                    }
                    this.loading.status = false;
                }
            ).catch((e) => {})
        },
        layThongTinThamDo(){
            this.loading.status = true;
            this.loading.text = 'Loading...'
            rest_api.get('/xem-tham-do', null).then(result => {
                this.dataThamDo.content = result.data.question.content;
                this.dataThamDo.questionId = result.data.question.id;
                this.dataThamDo.votes = result.data.votes;
                this.dataThamDo.totalVote = result.data.total_vote;
                this.dataThamDo.userSelect = result.data.user_select;
                console.log(this.dataThamDo);
            }).catch(e => {console.log("Error "+e)})
                .finally(() => this.loading.status = false)
        },
        guiThamDo(id){
            if (id === this.dataThamDo.userSelect?.id) return;
            this.loading.status = true;
            this.loading.text = 'Loading...'
            rest_api.post('/gui-tham-do', { question_id: this.dataThamDo.questionId, vote_id: id })
                .then(result => {
                    if (result.data.rc === '0'){
                        this.layThongTinThamDo();
                    }
                })
                .catch(err => console.log(err))
                .finally(() => this.loading.status = false)
        },
        handleClose()
        {
            this.show_add = false
        },
        thongBao(typeNoty, msgNoty) {
            let msg = "";
            let cl = "";
            if (msgNoty) {
                msg = msgNoty;
            }
            let type = "success";
            if (typeNoty) {
                type = typeNoty
            }
            if (type == "success") {
                cl = "dts-noty-success"
            }
            if (type == "warning") {
                cl = "dts-noty-warning"
            }
            if (type == "error") {
                cl = "dts-noty-error"
            }
            if (type == "info") {
                cl = "dts-noty-info"
            }
            this.$message({
                customClass: cl,
                showClose: true,
                message: msg,
                type: type,
                duration: 3000
            });
        },
    }
}

</script>
<style scoped="scoped">
th {
    text-align: center;
    }
</style>
