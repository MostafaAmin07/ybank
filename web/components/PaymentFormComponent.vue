<template>
  <b-card class="mt-3" header="New Payment">
    <b-form @submit="onSubmit">
      <b-form-group id="input-group-1" label="To:" label-for="input-1">
        <b-form-input
          id="input-1"
          size="sm"
          v-model="payment.to"
          type="number"
          required
          placeholder="Destination ID"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Amount:" label-for="input-2">
        <b-input-group prepend="$" size="sm">
          <b-form-input
            id="input-2"
            v-model="payment.amount"
            type="number"
            required
            placeholder="Amount"
          ></b-form-input>
        </b-input-group>
      </b-form-group>

      <b-form-group id="input-group-3" label="Details:" label-for="input-3">
        <b-form-input
          id="input-3"
          size="sm"
          v-model="payment.details"
          required
          placeholder="Payment details"
        ></b-form-input>
      </b-form-group>
      <b-button type="submit" size="sm" variant="primary">Submit</b-button>
      <label v-if="errorMsg" class="error-msg"> {{ errorMsg }} </label>
    </b-form>
  </b-card>
</template>

<script lang="ts">
import { Component, Vue, Emit } from "nuxt-property-decorator";

import { AxiosResponse, AxiosError } from "axios";

import { $axios } from '~/utils/api';

//TODO Add Unit tests for this
@Component
export default class PaymentFormComponent extends Vue {
  payment: any = {};
  errorMsg: string = "";

  onSubmit(evt: Event) {
      let accountId = this.$route.params.id;

      evt.preventDefault();
      this.payment.from = accountId;
      $axios.post(
        `accounts/${accountId}/transactions`,
        this.payment
      ).then((response: AxiosResponse) => {
        this.payment = {};
        this.$store.dispatch('account/fetchAccount', accountId);
        this.$store.dispatch('account/fetchTransactions', accountId);
        this.success();
      }).catch((error: AxiosError) => {
        //TODO make the error msgs custom to fields and add styling
        console.log("===================================");
        console.log(error.response);
        this.errorMsg = error.response?.data.message;
      });

  }

  @Emit("success")
  success() {
      return false;
  }
}
</script>

<style scoped>
.error-msg {
  font-weight: bold;
  color: red;
}
</style>
