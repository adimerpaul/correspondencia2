<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-form>
        <div class="row">
          <div class="col-6 flex flex-center"><q-radio v-model="dato.tipo" val="INTERNO" label="INTERO"/></div>
          <div class="col-6 flex flex-center"><q-radio v-model="dato.tipo" val="EXTERNO" label="EXTERNO"/></div>
          <div class="col-4"><q-input autofocus label="Referencia de correspondencia" v-model="dato.ref" outlined/></div>
          <div class="col-4"><q-input label="Fecha de correspondencia" v-model="dato.fecha" type="date" outlined/></div>
        </div>
      </q-form>
    </div>
  </div>
</q-page>
</template>

<script>
import {date} from 'quasar'
export default {
  data(){
    return {
      dato:{tipo:'INTERNO',fecha:date.formatDate(Date.now(),'YYYY-MM-DD')}
    }
  }
}
</script>

<style scoped>

</style>
