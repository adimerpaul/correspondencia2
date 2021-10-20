<template>
<q-page>
  <h3>Seguimiento</h3>
   <q-from @submit.prevent="ver">
     
        <div ><q-input dense label="Codigo"  outlined /></div>
        <div ><q-btn type="submit" color="primary" icon="add_circle" label="VER" />  
      
  </q-from>
  <table border="1" style="width:100%">
      <thead>
        <tr>
          <th>codigo</th>
          <th>tipo</th>
          <th>tipo2</th>
          <th>ref</th>
          <th>cargo</th>
          <th>institucion</th>
          <th>fecha</th>
          <th>fechacarta</th>
          <th>estado</th>
          <th>folio</th>
          <th>archivo</th>
          <th>codinterno</th>
          <th>codexterno</th>

        </tr>
      </thead>
      <tbody>
        <tr v-for="(mail,index) in mails" :key=index>
          <td>{{mail.codigo}}</td>
          <td>{{mail.tipo}}</td>
          <td>{{mail.tipo2}}</td>
          <td>{{mail.ref}}</td>
          <td>{{mail.cargo}}</td>
          <td>{{mail.institucion}}</td>
          <td>{{mail.fecha}}</td>
          <td>{{mail.fechacarta}}</td>
          <td>{{mail.estado}}</td>
          <td>{{mail.folio}}</td>
          <td>{{mail.archivo}}</td>
          <td>{{mail.codinterno}}</td>
          <td>{{mail.codexterno}}</td>
        </tr>
      </tbody>
      </table>
  
</q-page>
</template>

<script>
import { defineComponent } from 'vue';

export default {
  name: "Seguimiento",
  data(){
    return{
      mails:[],
      mail:{}
    }
  },
  created(){
    this.misdatos()
  },
  methods:{
    misdatos(){
      this.$axios.get('http://localhost:8000/api/mail').then(res=>{
      console.log(res.data)
      this.mails=res.data
      })
    },
    crear()
    {
      this.$axios.get('http://localhost:8000/api/mail').then(res=>{
      console.log(res.data)
      this.mails=res.data
      })
    },
  }
}
</script>


<style scoped>

</style>
