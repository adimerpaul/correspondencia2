<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-form @submit.prevent="guardar">
        <div class="row" style="border: 1px solid rgba(128,128,128,0.50)">
          <div class="col-6 flex flex-center"><q-radio dense v-model="dato.tipo" val="INTERNO" label="INTERO"/></div>
          <div class="col-6 flex flex-center"><q-radio dense v-model="dato.tipo" val="EXTERNO" label="EXTERNO"/></div>
          <div class="col-sm-2 col-12 q-pa-xs"><q-input dense autofocus label="Referencia" v-model="dato.ref" outlined/></div>
          <div class="col-sm-6 col-12 q-pa-xs">
            <q-input @change="cambio" @keyup="cambio" outlined dense label="remitente" list="browsers" name="myBrowser" v-model="remitente" />
            <datalist id="browsers">
              <option v-for="r in remitentes" :key="r.id">{{r.remitente}}</option>

            </datalist>
<!--            <q-input dense autofocus label="Remitente" v-model="dato.remitentes" outlined/>-->
<!--            <div class="row">-->
<!--              <div class="col-1 flex flex-center"><q-icon color="primary" name="add_circle" size="xs" /></div>-->
<!--              <div class="col-11">-->
<!--&lt;!&ndash;                <q-input dense label="Remitente" v-model="remitente" outlined/>&ndash;&gt;-->
<!--                  <q-select-->
<!--                    dense-->
<!--                    outlined-->
<!--                    v-model="remitente"-->
<!--                    use-input-->
<!--                    label="Remitente"-->
<!--                    :options="remitentes"-->
<!--                    @filter="filterFn"-->
<!--                    option-label="remitente"-->
<!--                  />-->
<!--              </div>-->
<!--            </div>-->



<!--            <input list="browsers" name="browser" id="browser">-->
<!--            <datalist id="browsers">-->
<!--              <option value="Edge">-->
<!--              <option value="Firefox">-->
<!--              <option value="Chrome">-->
<!--              <option value="Opera">-->
<!--              <option value="Safari">-->
<!--            </datalist>-->

<!--            {{remitente}}-->
          </div>
          <div class="col-sm-2 col-12 q-pa-xs"><q-input dense label="Cargo" v-model="cargo" outlined/></div>
          <div class="col-sm-2 col-12 q-pa-xs"><q-input dense label="Institucion" v-model="institucion" outlined/></div>
          <div class="col-sm-2 col-12 q-pa-xs"><q-input dense label="Fecha de correspondencia" v-model="dato.fecha" type="date" outlined/></div>
          <div class="col-sm-2 col-12 q-pa-xs"><q-select dense label="Folio" v-model="dato.folio" :options="folios" outlined /></div>
          <div class="col-sm-2 col-12 q-pa-xs"><q-input dense label="Cod externo" v-model="dato.codexterno" outlined /></div>
          <div class="col-sm-2 col-12 q-pa-xs flex flex-center"><q-btn type="submit" color="primary" icon="add_circle" label="Registrar" v-if="dato.id==undefined || dato.id==''"/>
          <q-btn type="submit" color="amber" icon="edit" label="Modificar" v-else /></div>
        </div>
      </q-form>
    </div>
    <div class="col-12">
      <q-table dense title="Correspodencia de unidad" :rows="mails" :columns="columns">
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
          <q-td key="fecha" :props="props">
<!--            <q-badge color="teal">-->
              {{ props.row.fecha }}
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
            <q-btn-group v-if="props.row.estado!='ARCHIVADO' && props.row.estado!='ANULADO'">
              <q-btn type="a"  target="__blank" dense :href="url+'/mail/'+props.row.id" color="primary" label="Imprimir" icon="timeline" size="xs" />
<!--              <q-btn dense@click= color="teal" label="Imprimir ticket" icon="visibility" size="xs" />-->
              <q-btn dense @click="editar(props)" color="teal" label="Editar" icon="edit" size="xs" />
              <q-btn dense @click="remitir" color="positive" label="Remitir" icon="code" size="xs" />
              <q-btn dense @click="anular(props.row)" color="negative" label="Anular" icon="delete" size="xs" />
              <q-btn dense @click="archivar(props)" color="accent" label="Archivar" icon="list" size="xs" />
              <q-btn dense @click="archivo" color="amber" label="Archivo" icon="upload" size="xs" />
            </q-btn-group>
          </q-td>
        </q-tr>
        </template>
      </q-table>
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
      url:process.env.API,
      dato:{tipo:'INTERNO',fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),folio:1},
      folios:[],
      usuarios:[],
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
        {field:'fecha',name:'fecha',label:'fecha',align:'right'},
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
    this.$axios.get(process.env.API+'/mail/create').then(res=>{
      console.log(res.data)
      this.remitentes=res.data
      this.remitentes2=res.data
    })
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
    cambio(){
      this.cargo=''
      this.institucion=''
      // console.log(this.remitente)
      this.remitentes.find(r=>{
        if (r.remitente==this.remitente){
          // console.log(r)
          this.cargo=r.cargo
          this.institucion=r.institucion
        }else{
          this.cargo=''
          this.institucion=''
        }
      })
    },
    remitir(){},
    archivar(props){
      this.$axios.post(process.env.API+'/archivar',props.row).then(res=>{
        this.misdatos();
        this.$q.notify({
           message: 'Correo Finalizado',
          caption: 'Archivado',
          color: 'green'
        });
      })
    },
    archivo(props){

    },
    editar(props){
      console.log(props.row);
      this.dato=props.row;
    },
    // imprimir(){
    //   let cm=this;
    //   function header(fecha){
    //     // var img = new Image()
    //     // img.src = 'logo.jpg'
    //     // doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
    //     doc.setFont(undefined,'bold')
    //     doc.text(5, 1, 'RESUMEN DIARIO DE INGRESOS')
    //     doc.text(5, 1.5, ' '+fecha)
    //     doc.text(1, 3, 'Nº COMPROBANTE')
    //     doc.text(4, 3, 'Nº TRAMITE')
    //     doc.text(7, 3, 'CONTRIBUYENTE')
    //     doc.text(13.5, 3, 'CI/RUN/RUC')
    //     doc.text(16, 3, 'MONTO BS.')
    //     doc.text(18, 3, 'CAJERO')
    //     doc.setFont(undefined,'normal')
    //   }
    //   var doc = new jsPDF('p','cm','letter')
    //   // console.log(dat);
    //   doc.setFont("courier");
    //   doc.setFontSize(9);
    //   // var x=0,y=
    //   header(Date.now())
    //   // let xx=x
    //   // let yy=y
    //   let y=0
    //   // this.pagos.forEach(r=>{
    //   //   // xx+=0.5
    //   //   y+=0.5
    //   //   doc.text(1, y+3, r.nrocomprobante)
    //   //   doc.text(4, y+3, r.nrotramite)
    //   //   doc.text(7, y+3, r.cliente)
    //   //   doc.text(13.5, y+3, r.ci)
    //   //   doc.text(16, y+3, r.total)
    //   //   doc.text(18, y+3, r.cajero )
    //   //   if (y+3>25){
    //   //     doc.addPage();
    //   //     header(this.fecha)
    //   //     y=0
    //   //   }
    //   // })
    //   doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
    //   doc.text(18, y+4, '1000 Bs')
    //   // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
    //   window.open(doc.output('bloburl'), '_blank');
    // },
    // filterFn (val, update) {
    //   // console.log(val)
    //   if (val === '') {
    //     update(() => {
    //       this.remitentes = this.remitentes2
    //       this.remitente=''
    //       // here you have access to "ref" which
    //       // is the Vue reference of the QSelect
    //     })
    //     return false
    //   }
    //
    //   update(() => {
    //     const needle = val.toLowerCase()
    //     this.remitentes = this.remitentes2.filter(v => v.remitente.toLowerCase().indexOf(needle) > -1)
    //   })
    // },
    misdatos(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/mail').then(res=>{
        // console.log(res.data)
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
            archivo:r.archivo,
            codinterno:r.codinterno,
            codexterno:r.codexterno,
            dias:dias,
          })
        })
        this.$q.loading.hide()
      })
    },
    anular(mail){
      this.$axios.post(process.env.API+'/eliminar/'+mail.id).then(res=>{
        this.misdatos();
        this.$q.notify({
           message: 'Eliminar',
          caption: 'registro elimando',
          color: 'green'
        });
        })

    },
    guardar(){
      // console.log(this.remitente)
      // return false
      if(this.dato.id==undefined || this.dato.id==''){
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
      })}
      else{
             this.$q.loading.show()
      this.$axios.post(process.env.API+'/updatemail',this.dato).then(res=>{
        this.dato={tipo:'INTERNO',fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),folio:1};
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

}
</script>

<style scoped>

</style>
