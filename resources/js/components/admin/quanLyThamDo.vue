<template>
    <el-row
        :gutter="24"
        v-loading.fullscreen.lock="loading.status" class="row">
        <el-col :span="6" style="padding-bottom: 15px;">
            <label>Tìm kiếm thăm dò</label>
            <el-input v-model="dataSearch.tieu_de" placeholder="Nội dung câu hỏi" clearable></el-input>
        </el-col>
        <el-col :span="6">
            <label style="color: transparent;display:block">Tìm kiếm</label>
            <el-button type="success" @click.prevent="getData()">Tìm kiếm</el-button>
        </el-col>
        <el-col :span="24">
            <div class="card">
                <div class="card-header">
                    <el-row :gutter="24">
                        <el-col :span="12"><h5 class="card-title">Thăm dò</h5></el-col>
                        <el-col :span="12" class="text-right">
                            <el-button type="primary" @click.prevent="showAdd()">Thêm mới</el-button>
                        </el-col>
                    </el-row>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table-bordered table hover-table">
                            <thead class="thead-light">
                            <tr>
                                <th>STT</th>
                                <th>Nội dung câu hỏi</th>
                                <th>Số lựa chọn</th>
                                <th>Câu mặc định</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody v-if="list_data&&list_data.length">
                            <tr v-for="(item,index) in list_data" :key="index">
                                <td class="text-center">{{(paging.currentPage - 1) * paging.limit + index + 1}}</td>
                                <td><p>{{ item.content }}</p></td>
                                <td><p>{{ item.users.length }}</p></td>
                                <td><p>{{ item.is_select ? "Câu hiển thị": "" }}</p></td>
<!--                                <td>-->
<!--                                    <div v-html="item.noi_dung"></div>-->
<!--                                </td>-->
                                <td class="text-center"><p>{{ item.created_at }}</p></td>
                                <td class="text-center">
                                    <el-button size="mini" @click.prevent="showView(item)" type="primary">
                                        Xem câu hỏi
                                    </el-button>
                                    <el-button size="mini" @click.prevent="showUpdate(item)" type="warning">
                                        Chỉnh sửa
                                    </el-button>
                                    <el-button size="mini" @click.prevent="confirmDel(item)" type="danger">
                                        Xóa
                                    </el-button>
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                            <tr>
                                <td colspan="10" class="text-center">
                                    <p>Không có dữ liệu</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <PhanTrang v-show="paging.total>0" :tongbanghi="paging.total"
                                   :batdau="trangbatdau"
                                   @pageChange="layLai($event)">
                        </PhanTrang>
                    </div>
                </div>
            </div>
        </el-col>
        <el-col :span="24">
            <el-dialog
                title="Thêm mới thăm dò"
                :visible.sync="show_add"
                custom-class="minWidth375"
                fullscreen
                :before-close="handleClose">
                <div>
                    <el-row :gutter="24">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <label>Nội dung câu hỏi</label>
                            <el-input type="text" placeholder="Nội dung câu hỏi" clearable
                                      v-model="dataAdd.tieu_de"></el-input>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-checkbox v-model="dataAdd.is_select" label="Đặt làm câu hỏi mặc định" size="large" />
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <label>Danh sách lựa chọn</label>
                            <el-button @click="themLuaChon" class="ms-4" type="success">Thêm lựa chọn</el-button>
                        </el-col>
                        <template v-for="(item, index) in dataAdd.list_lua_chon">
                            <el-col class="d-flex px-4" :xs="24" :sm="24" :md="24" :lg="24" :xl="24" :key="index">
                                <el-input type="text" placeholder="Nội dung lựa chọn" clearable
                                          v-model="dataAdd.list_lua_chon[index]"></el-input>
                                <el-button class="ms-4" @click="boLuaChon(index)" type="danger">Xóa lựa chọn</el-button>
                            </el-col>
                        </template>

                    </el-row>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="show_add = false">Đóng</el-button>
                    <el-button type="primary" @click="confirmAdd()">Thêm mới</el-button>
                </span>
            </el-dialog>
            <el-dialog
                title="Chỉnh sửa thăm dò"
                :visible.sync="show_update"
                custom-class="minWidth375"
                fullscreen
                :before-close="handleClose">
                <div>
                  <el-row :gutter="24">
                    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                      <label>Nội dung câu hỏi</label>
                      <el-input type="text" placeholder="Nội dung câu hỏi" clearable
                                v-model="dataUpdate.content"></el-input>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                      <el-checkbox v-model="dataUpdate.is_select" label="Đặt làm câu hỏi mặc định" size="large" />
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                      <label>Danh sách lựa chọn</label>
                      <el-button @click="suaThemLuaChon" class="ms-4" type="success">Thêm lựa chọn</el-button>
                    </el-col>
                    <template v-for="(item, index) in dataUpdate.votes">
                      <el-col class="d-flex px-4" :xs="24" :sm="24" :md="24" :lg="24" :xl="24" :key="index">
                        <el-input type="text" placeholder="Nội dung lựa chọn" clearable
                                  v-model="dataUpdate.votes[index].name"></el-input>
                        <el-button class="ms-4" @click="suaBoLuaChon(index)" type="danger">Xóa lựa chọn</el-button>
                      </el-col>
                    </template>
                  </el-row>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="show_update = false">Đóng</el-button>
                    <el-button type="warning" @click="confirmUpdate()">Chỉnh sửa</el-button>
                </span>
            </el-dialog>

            <el-dialog
                title="Xem thăm dò"
                :visible.sync="show_view"
                custom-class="minWidth375"
                fullscreen
                :before-close="handleClose">
                <div>
                    <el-row :gutter="24">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <label>Nội dung câu hỏi</label>
                            <el-input type="text" placeholder="Nội dung câu hỏi" clearable
                                      v-model="dataUpdate.content" :disabled="true"></el-input>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-checkbox v-model="dataUpdate.is_select" label="Đặt làm câu hỏi mặc định" size="large" :disabled="true"/>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <label>Danh sách lựa chọn ({{ dataUpdate.users?.length ?? 0}} lượt chọn)</label>
                        </el-col>
                        <template v-for="(item, index) in dataUpdate.votes">
                            <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" :key="index">
                                <el-input type="text" placeholder="Nội dung lựa chọn" clearable
                                          v-model="dataUpdate.votes[index].name" :disabled="true"></el-input>
                                <p>({{ dataUpdate.votes[index].total }} lượt chọn)</p>
                            </el-col>
                        </template>
                    </el-row>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="show_view = false">Đóng</el-button>
                </span>
            </el-dialog>
        </el-col>
    </el-row>
</template>
<script>
import rest_api from "../../api/rest_api";
import Vue from 'vue';
import ESelectVue from '../Ui/ESelect.vue';
import ElementUI from 'element-ui';
import PhanTrang from "../Ui/phanTrang";
import {
    Icon
} from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

import Vue2Editor from "vue2-editor";

Vue.use(Vue2Editor);
Vue.use(ElementUI);
Vue.use(Icon);
export default {
    components: {
        PhanTrang,
        'eselect': ESelectVue,
    },
    data() {
        return {
            dataSearch: {
                tieu_de: ''
            },
            dataAdd: {
                tieu_de: '',
                is_select: false,
                list_lua_chon: [],
            },
            list_data: [],
            loading: {
                status: false,
                text: 'Loading...'
            },
            show_update: false,
            show_add: false,
            show_view: false,
            trangbatdau: false,
            paging: {
                total: 0,
                start: 0,
                limit: 10,
                currentPage: 1
            },
            dataUpdate: {},
        }
    },
    mounted() {
        this.getData();
        this.checkDanhSachYeuCau()
    },
    methods: {
        checkDanhSachYeuCau() {
            rest_api.post('/admin/check-danh-sach-yeu-cau', {}).then(
                response => {
                    if (response && response.data.rc == 0) {
                        // this.thongBao('warning', response.data.rd)
                    } else {
                        this.thongBao('warning', response.data.rd)
                    }
                    localStorage.setItem('thongBaoChuaXem', response.data.data);
                    window.dispatchEvent( new Event('storage'));
                    this.loading.status = false;
                }
            ).catch((e) => {
            })

            setInterval(() => {
                this.checkDanhSachYeuCauBackground();
            }, 20000);
        },

        checkDanhSachYeuCauBackground() {
            rest_api.post('/admin/check-danh-sach-yeu-cau', {}).then(
                response => {
                    if (response && response.data) {
                        localStorage.setItem('thongBaoChuaXem', response.data.data);
                        window.dispatchEvent( new Event('storage'));
                    }
                }
            ).catch((e) => {
            })
        },

        confirmDel(item) {
            this.$confirm('Xác nhận xoá thăm dò?', 'Thông báo', {
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy',
            })
                .then(_ => {
                    var url = '/admin/delete-tham-do'
                    this.loading.status = true;
                    this.loading.text = 'Loading...'
                    rest_api.post(url, {id: item.id}).then(
                        response => {
                            if (response.data.rc == 0) {
                                this.getData()
                                this.thongBao('success', 'Xoá dữ liệu thành công')
                            } else {
                                this.thongBao('error', response.data.rd)
                            }
                            this.loading.status = false;
                        }
                    ).catch((e) => {
                    })
                })
                .catch(_ => {
                });
        },
        getData() {
            this.handleClose();
            let params = {
                start: this.paging.start,
                limit: this.paging.limit,
                key: this.dataSearch.tieu_de
            }
            var url = '/admin/lay-danh-sach-tham-do'
            this.loading.status = true;
            this.loading.text = 'Loading...'
            rest_api.post(url, params).then(
                response => {
                    if (response.data.rc == 0) {
                        this.list_data = response.data.data;
                        this.paging.total = response.data.total
                    } else {
                        this.list_data = [];
                        this.paging.total = 0;
                        this.thongBao('error', response.data.rd)
                    }
                    this.loading.status = false;
                }
            ).catch((e) => {
            })
        },
        showView(item){
            this.dataUpdate = {...item, is_select: item.is_select === 1};
            this.show_view = true;
        },

        showUpdate(item) {
            console.log(item);
            this.dataUpdate = {...item, is_select: item.is_select === 1};
            this.show_update = true;
        },
        arrayStringToNumber(arr) {
            let arrOfNum = arr.map(str => {
                return parseInt(str, 10);
            });
            return arrOfNum
        },
        confirmUpdate() {
            if (this.dataUpdate.content === '') {
                this.thongBao('error', 'Vui lòng thêm tiêu đề!')
                return;
            }
            this.dataUpdate.votes = this.dataUpdate.votes.filter(item => item.name !== '');
            if (this.dataUpdate.votes.length === 0) {
                this.thongBao('error', 'Vui lòng thêm ít nhất 1 lựa chọn!')
                return;
            }
            rest_api.post('/admin/sua-tham-do', this.dataUpdate).then(
                response => {
                    if (response && response.data.rc == 0) {
                        this.handleClose();
                        this.getData()
                        this.thongBao('success', 'Thành công')
                    } else {
                        this.thongBao('error', response.data.rd)
                    }
                    this.loading.status = false;
                }
            ).catch((e) => {
            })
        },
        confirmAdd() {
            if (this.dataAdd.tieu_de === '') {
                this.thongBao('error', 'Vui lòng thêm tiêu đề!')
                return;
            }
            this.dataAdd.list_lua_chon = this.dataAdd.list_lua_chon.filter(item => item !== '');
            if (this.dataAdd.list_lua_chon.length === 0) {
                this.thongBao('error', 'Vui lòng thêm ít nhất 1 lựa chọn!')
                return;
            }
            rest_api.post('/admin/them-tham-do', this.dataAdd).then(
                response => {
                    if (response && response.data.rc == 0) {
                        this.handleClose();
                        this.getData()
                        this.thongBao('success', 'Thành công');
                        this.dataAdd = {
                          tieu_de: '',
                          is_select: false,
                          list_lua_chon: []
                        }
                    } else {
                        this.thongBao('error', response.data.rd)
                    }
                    this.loading.status = false;
                }
            ).catch((e) => {
            })
        },
        showAdd() {
            this.show_add = true;
        },
        handleClose() {
            this.show_add = false;
            this.show_update = false;
            this.show_view = false;
        },
        layLai(e) {
            this.paging.start = e.start;
            this.paging.limit = e.limit;
            this.paging.currentPage = e.currentPage;
            this.getData()
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
        themLuaChon() {
            this.dataAdd.list_lua_chon.push('');
        },
        suaThemLuaChon() {
            this.dataUpdate.votes.push({
                id: 0,
                name: '',
            });
        },
        boLuaChon(index){
            this.dataAdd.list_lua_chon.splice(index, 1);
        },
        suaBoLuaChon(index){
            this.dataUpdate.votes.splice(index, 1);
        }
    }
}

</script>
<style scoped="scoped">
th {
    text-align: center;
}

.el-col {
    padding-top: 15px;
}

.el-col label {
    margin-bottom: 0;
}
</style>
