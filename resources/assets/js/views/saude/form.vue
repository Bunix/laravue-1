<template>
	<form @submit.prevent="proceed">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="">Datum</label>
					<datepicker v-model="saudeForm.datum" :bootstrapStyling="true"></datepicker>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="">Uhrzeit</label>
					<vue-timepicker hide-clear-button v-model="saudeForm.uhrzeit" format="HH:mm" :bootstrapStyling="true"></vue-timepicker>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">

				<div class="form-group">
					<label for="">Gewicht</label>
					<input class="form-control" type="number" step="0.1" value="" v-model="saudeForm.gewicht">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="">Diastole</label>
					<input class="form-control" type="number" step="1" value="" v-model="saudeForm.diastole">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="">Systole</label>
					<input class="form-control" type="number" step="1" value="" v-model="saudeForm.systole">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="">Puls</label>
					<input class="form-control" type="number" step="1" value="" v-model="saudeForm.puls">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Description</label>
					<textarea class="form-control" type="text" value="" v-model="saudeForm.description" rows="3"></textarea>
				</div>
			</div>

		</div>
		<button type="submit" class="btn btn-info waves-effect waves-light m-t-10">
			<span v-if="id">Update</span>
			<span v-else>Save</span>
		</button>
		<router-link to="/saude" class="btn btn-danger waves-effect waves-light m-t-10" v-show="id">Cancel</router-link>
	</form>
</template>


<script>
import datepicker from 'vuejs-datepicker';
import VueTimepicker from 'vue2-timepicker';
import helper from '../../services/helper';

export default {
	data() {
		return {
			saudeForm: new Form({
				datum: '',
				uhrzeit: {
					HH: '06',
					mm: '00'
				},
				gewicht: 0,
				diastole: 0,
				systole: 0,
				puls: 0,
				description: ''
			})
		};
	},
	components: { datepicker, VueTimepicker },
	props: ['id'],
	mounted() {
		if (this.id) this.getData();
	},
	methods: {
		proceed() {
			this.saudeForm.datum = moment(this.saudeForm.datum).format('YYYY-MM-DD');
			let hh = this.saudeForm.uhrzeit.HH;
			let mm = this.saudeForm.uhrzeit.mm;
			this.saudeForm.uhrzeit = hh + ':' + mm + ':00';
			if (this.id) this.updateData();
			else this.storeData();
		},
		storeData() {
			this.saudeForm
				.post('/api/saude')
				.then(response => {
					debugger;
					toastr['success'](response.message);
					this.$emit('completed', response.saude);
				})
				.catch(response => {
					debugger;
					toastr['error'](response.message);
				});
		},
		getData() {
			debugger;
			var _this = this;
			axios
				.get('/api/saude/' + this.id)
				.then(function(response) {
					debugger;
					_this.saudeForm.datum = response.data.datum;
					let s = response.data.uhrzeit.split(':');
					_this.saudeForm.uhrzeit = { HH: s[0], mm: s[1] };
					_this.saudeForm.gewicht = response.data.gewicht;
					_this.saudeForm.diastole = response.data.diastole;
					_this.saudeForm.systole = response.data.systole;
					_this.saudeForm.puls = response.data.puls;
					_this.saudeForm.description = response.data.description;
				})
				.catch(function(response) {
					debugger;
					toastr['error'](response.message);
				});
		},
		updateData() {
			this.saudeForm
				.patch('/api/saude/' + this.id)
				.then(response => {
					if (response.type == 'error') toastr['error'](response.message);
					else {
						this.$router.push('/saude');
					}
				})
				.catch(response => {
					toastr['error'](response.message);
				});
		}
	}
};
</script>
<style>
</style>
