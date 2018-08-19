<template>
<div>

    <div class="row page-titles">
        <div class="col-md-6 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Blutdruck, Gewicht und Glucose</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link to="/home">Home</router-link>
                </li>
                <li class="breadcrumb-item active">Werte</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div id="accordion">
                <!-- card 1 new entry -->
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link nounderline" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                           <span>Neuer Eintrag</span>
                        </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <saude-form @completed="getData"></saude-form>
                        </div>
                    </div>
                </div>

                <!-- card 2 list entries -->
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link nounderline" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                           <span>Liste</span>
                        </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">                        
                            <h4 class="card-title">Werteliste</h4>
                            <h6 class="card-subtitle" v-if="daten.total">Total {{daten.total}} result found!</h6>
                            <h6 class="card-subtitle" v-else>No result found!</h6>
                            <div class="table-responsive">
                                <table class="table" v-if="daten.total">
                                    <thead>
                                        <tr>
                                            <th>Datum</th>
                                            <th>Uhrzeit</th>
                                            <th>Gewicht</th>
                                            <th>Diastole</th>
                                            <th>Systole</th>
                                            <th>Puls</th>
                                            <th style="width:180px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="d in daten.data">

                                            <td>{{ d.datum | moment }}</td>
                                            <td v-text="d.uhrzeit"></td>
                                            <td v-text="d.gewicht"></td>
                                            <td v-text="d.diastole"></td>
                                            <td v-text="d.systole"></td>
                                            <td v-text="d.puls"></td>

                                            <td class ="btn-group">
                                                <button class="btn btn-info btn-sm" @click.prevent="editData(d)" data-toggle="tooltip" title="Edit Data">
                                                    <i class="fa fa-pencil"></i></button>

                                                <click-confirm yes-class="btn btn-success" no-class="btn btn-danger">
                                                    <button class="btn btn-danger btn-sm" @click.prevent="deleteData(d)" data-toggle="tooltip" title="Delete Data"><i class="fa fa-trash"></i></button>
                                                </click-confirm>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-md-8">
                                        <pagination :data="daten" :limit=3 v-on:pagination-change-page="getData"></pagination>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="float-right">
                                            <select name="pageLength" class="form-control" v-model="filterDataForm.pageLength" @change="getData" v-if="daten.total">
                                            <option value="5">5 per page</option>
                                            <option value="10">10 per page</option>
                                            <option value="25">25 per page</option>
                                            <option value="100">100 per page</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
</template>

<script>
import SaudeForm from "./form";
import pagination from "laravel-vue-pagination";
import helper from "../../services/helper";
import ClickConfirm from "click-confirm";

export default {
    components: {
        SaudeForm,
        pagination,
        ClickConfirm
    },

    data() {
        return {
            daten: {},
            filterDataForm: {
                sortBy : 'datum',
                order: 'desc',
                //status: '',
                //title: '',
                pageLength: 5
            }
        };
    },

    created() {
        this.getData();
    },

    methods: {
        getData(page) {
            if (typeof page === "undefined") {
                page = 1;
            }

            let url = helper.getFilterURL(this.filterDataForm);

            axios
                .get("/api/saude?page=" + page + url)
                .then(response => (this.daten = response.data));
        },

        deleteData(d) {

            axios.delete('/api/saude/' + d.id).then(response => {

                toastr['success'](response.data.message);

                this.getData();

            }).catch(error => {

                toastr['error'](error.response.data.message);

            });

        },

        editData(saude) {
            this.$router.push("/saude/" + saude.uuid + "/edit");
        }

    },

    filters: {
        moment(date) {
            let d = helper.formatDate(date);
            debugger;
            let dx = d.split("/"); 
            return dx[1]+"/"+dx[0]+"/"+dx[2];          
        }
    }
};
</script>

<style>
.nounderline:hover {
    text-decoration: none;
}
.btn-group {
  display: flex;
  justify-content: space-around;
}
</style>
