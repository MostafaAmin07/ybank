<template>
  <section v-if="account">
    <b-card :header="'Welcome, ' + account.name" class="mt-3">
      <b-card-text>
        <div>
          Account: <code>{{ account.id }}</code>
        </div>
        <div>
          Balance:
          <code
            >{{ account.currency === "usd" ? "$" : "€"
            }}{{ account.balance }}</code
          >
        </div>
      </b-card-text>
      <b-button size="sm" variant="success" @click="showPaymentForm = !showPaymentForm"
        >New payment</b-button
      >

      <b-button class="float-right" @click="logout" variant="danger" size="sm" nuxt-link to="/"
        >Logout</b-button
      >
    </b-card>

    <template v-if="showPaymentForm">
      <PaymentFormComponent @success="showPaymentForm = false"/>
    </template>
  </section>
</template>

<script lang="ts">
import { Component, Vue, namespace } from "nuxt-property-decorator";

import PaymentFormComponent from "./PaymentFormComponent.vue";

import { Account } from "../models/Account";

//TODO Add Unit tests for this if you have enough time
const account = namespace('account');
@Component({
  components: {
    PaymentFormComponent
  }
})
export default class AccountComponent extends Vue {
  @account.Getter
  account!: Account | null;

  showPaymentForm = false;

  logout() {
    this.$store.dispatch('account/logout');
  }
}
</script>
