<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-form>
        <div class="row">
          <div class="col-6 flex flex-center"><q-radio v-model="dato.tipo" val="INTERNO" label="INTERO"/></div>
          <div class="col-6 flex flex-center"><q-radio v-model="dato.tipo" val="EXTERNO" label="EXTERNO"/></div>
          <div class="col-2"><q-input autofocus label="Referencia de correspondencia" v-model="dato.ref" outlined/></div>
          <div class="col-2"><q-input label="Fecha de correspondencia" v-model="dato.fecha" type="date" outlined/></div>
          <div class="col-2"><q-input label="Codigo externo" v-model="dato.codexterno" outlined /></div>
          <div class="col-2"><q-input label="Codigo interno" v-model="dato.codinterno" outlined /></div>
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
      dato:{tipo:'INTERNO',fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),folio:1},
      folios:[]
    }
  },
  created() {
    for (let i=1;i<=100;i++){
      this.folios.push(i)
    }
  }
}
</script>

<style scoped>

</style>
