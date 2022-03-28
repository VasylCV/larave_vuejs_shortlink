<template>
    <div>
        <h3 class="text-center mb-3">Short link generator</h3>

        <Form @submit="add" class="row g-2">
            <div class="col-auto">
                <Field name="link" type="text" :class="{ 'is-invalid': isValid == false }"  class="form-control" v-model="data.link" placeholder="Input link" :rules="isValidUrl" />
                <div class="invalid-feedback">{{errors}}</div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Generate</button>
            </div>
        </Form>

        <div class="mt-4" :class="{ 'd-none' : isHidden == true}">
            <h5>Short link - <span class="link-primary" style="cursor: pointer;" @click="getFullLink()">{{shortLink}}</span></h5>
        </div>
    </div>
</template>

<script>
import { Field, Form } from 'vee-validate';

export default {
    data() {
        return {
            appUrl: process.env.MIX_APP_URL,
            data: {},
            linkParam: '',
            shortLink: '',
            isHidden: true,
            isValid: true,
            errors: '',
        }
    },
    components: {
        Field,
        Form,
    },
    methods: {
        add() {
            axios
                .post(this.appUrl + '/api/link/store', this.data)
                .then(response => {
                        this.isHidden = false;
                        this.linkParam = response.data.data;
                        this.shortLink = this.appUrl + '/' + this.linkParam;
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
        },
        getFullLink()
        {
            axios
                .get(this.appUrl + '/api/link/get',{
                    params: {
                        param: this.linkParam
                    }
                })
                .then(response => {
                    window.open(response.data.data, '_blank');
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
        },
        isValidUrl(value)
        {
            if (value) {
                 this.isValid = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(value);

                 if (this.isValid === false) {
                     this.errors = 'Link is not valid.';
                 }

                 return this.isValid;
            }

            return false;
        }
    }
}
</script>
