<template>
  <section v-if="transactions">
    <b-card class="mt-3" header="Payment History">
      <b-table striped hover :items="transactions"></b-table>
    </b-card>
  </section>
</template>

<script lang="ts">
import { Component, Vue, namespace } from "nuxt-property-decorator";

import { Transaction } from "../models/Transaction";

const account = namespace('account');
@Component
export default class PaymentFormComponent extends Vue {
  @account.Getter
  transactions!: Transaction[];
}
</script>
