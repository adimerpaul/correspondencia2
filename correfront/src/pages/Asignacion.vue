<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-table dense :title="'Correspodencia de '+$store.getters['login/user'].name" :rows="mails" :columns="columns">
        <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="codigo" :props="props">
            {{ props.row.codigo }}
          </q-td>
          <q-td key="codexterno" :props="props">
<!--            <q-badge color="green">-->
              {{ props.row.codexterno }}
<!--            </q-badge>-->
          </q-td>
          <q-td key="codinterno" :props="props">
<!--            <q-badge color="purple">-->
              {{ props.row.codinterno }}
<!--            </q-badge>-->
          </q-td>
          <q-td key="ref" :props="props">
<!--            <q-badge color="orange">-->
              {{ props.row.ref }}
<!--            </q-badge>-->
          </q-td>
          <q-td key="remitente" :props="props">
<!--            <q-badge color="primary">-->
              {{ props.row.remitente }}
<!--            </q-badge>-->
          </q-td>
          <q-td key="logs" :props="props">
<!--            <q-badge color="teal">-->
<!--              {{ props.row.logs }}-->
            <ul style="font-size: 0.6em;padding: 0px;margin: 0px;border: 0px;    list-style: none;">
              <li v-for="l in props.row.logs" :key="l.id">de {{l.remitente}} a {{l.destinatario}}</li>
            </ul>
<!--            </q-badge>-->
          </q-td>
          <q-td key="dias" :props="props">
            <q-badge :color="props.row.dias==0?'positive':props.row.dias==1?'amber':'negative'">
            {{ props.row.dias }} d
            </q-badge>
          </q-td>
          <q-td key="estado" :props="props">
            <q-badge :color="props.row.estado=='EN PROCESO'?'amber':'negative'">
              {{ props.row.estado }}
            </q-badge>
          </q-td>
          <q-td key="folio" :props="props">
<!--            <q-badge color="amber">-->
              {{ props.row.folio }}
<!--            </q-badge>-->
          </q-td>
          <q-td key="opciones" :props="props">
<!--            <q-badge color="amber">-->
<!--              {{ props.row.opciones }}-->
<!--            </q-badge>-->
            <q-btn-group >
<!--              <q-btn type="a"  target="__blank" dense :href="url+'/mail/'+props.row.id" color="primary" label="Imprimir" icon="timeline" size="xs" />-->
<!--              <q-btn dense@click= color="teal" label="Imprimir ticket" icon="visibility" size="xs" />-->
<!--              <q-btn dense @click="editar" color="teal" label="Editar" icon="edit" size="xs" />-->
              <q-btn dense @click="modalremitir=true" color="positive" label="Remitir" icon="code" size="xs" />
              <q-btn dense @click="anular" color="negative" label="Anular" icon="delete" size="xs" />
              <q-btn dense @click="archivar" color="accent" label="Archivar" icon="list" size="xs" />
<!--              <q-btn dense @click="archivo" color="amber" label="Archivo" icon="upload" size="xs" />-->
            </q-btn-group>
          </q-td>
        </q-tr>
        </template>
      </q-table>
      <q-dialog v-model="modalremitir">
        <q-card  style="width: 700px; max-width: 80vw;">
          <q-card-section >
            <div class="text-h6"> <q-icon name="code"/> Remitir</div>
          </q-card-section>
          <q-card-section class="q-pt-none">
            <q-form>
              <div class="row">
                <div class="col-12">
                  <q-input dense type="textarea" label="Mi accion"/>
                </div>
                <div class="col-12">
                  <q-select dense label="Destinatario" :options="usuarios"/>
                </div>
              </div>
            </q-form>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat label="Cerrar" color="primary" icon="delete" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>
    </div>
  </div>
</q-page>
</template>

<script>
// import $ from 'jquery'
// import { jsPDF } from "jspdf";
import {date} from 'quasar'
export default {
  data(){
    return {
      modalremitir:true,
      url:process.env.API,
      dato:{tipo:'INTERNO',fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),folio:1},
      folios:[],
      usuarios:[],
      accion:'',
      destinatario:'',
      mails:[],
      remitentes:[],
      remitentes2:[],
      remitente:'',
      cargo:'',
      institucion:'',
      columns:[
        {field:'codigo',name:'codigo',label:'codigo',align:'right'},
        {field:'codexterno',name:'codexterno',label:'codexterno',align:'right'},
        // {field:'codinterno',name:'codinterno',label:'codinterno',align:'right'},
        {field:'ref',name:'ref',label:'ref',align:'right'},
        {field:'remitente',name:'remitente',label:'remitente',align:'right'},
        // {field:'cargo',name:'cargo',label:'cargo',align:'right'},
        // {field:'institucion',name:'institucion',label:'institucion',align:'right'},
        // {field:'fecha',name:'fecha',label:'fecha',align:'right'},
        {field:'logs',name:'logs',label:'logs',align:'center'},
        {field:'dias',name:'dias',label:'dias',align:'right'},
        // {field:'estado',name:'estado',label:'estado',align:'right'},
        {field:'folio',name:'folio',label:'folio',align:'right'},
        {field:'opciones',name:'opciones',label:'opciones',align:'right'},
      ]
    }
  },
  created() {
    this.misdatos()
    for (let i=1;i<=1000;i++){
      this.folios.push(i)
    }
    // this.$axios.get(process.env.API+'/mail/create').then(res=>{
    //   // console.log(res.data)
    //   this.remitentes=res.data
    //   this.remitentes2=res.data
    // })
    this.$axios.post(process.env.API+'/usuarios').then(res=>{
      res.data.forEach(r=>{
        // console.log(r)
        this.usuarios.push({
          id:r.id,
          name:r.name,
          unit_id:r.unit_id,
          label:r.unit.nombre+'-'+r.name
        })
      })
    })
  },
  methods:{
    remitir(){
      this.modalremitir=true
    },
    misdatos(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/asignacion').then(res=>{
        // console.log(res.data)
        // return false
        // this.mails=res.data
        this.mails=[]
        res.data.forEach(r=>{
          const date1 = new Date()
          const date2 = date.extractDate(r.fecha, 'YYYY-MM-DD')
          const dias = date.getDateDiff(date1, date2, 'days')
          this.mails.push({
            id:r.id,
            codigo:r.codigo,
            tipo:r.tipo,
            tipo2:r.tipo2,
            ref:r.ref,
            remitente:r.remitente,
            cargo:r.cargo,
            institucion:r.institucion,
            fecha:r.fecha,
            fechacarta:r.fechacarta,
            estado:r.estado,
            folio:r.folio,
            logs:r.logs,
            archivo:r.archivo,
            codinterno:r.codinterno,
            codexterno:r.codexterno,
            dias:dias,
          })
        })
        this.$q.loading.hide()
      })
    },
    guardar(){
      // console.log(this.remitente)
      // return false
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/mail',this.dato).then(res=>{
        // console.log(res.data)
        this.misdatos()
        // this.$q.loading.hide()
      }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    }
  }

}
</script>

<style scoped>

</style>
