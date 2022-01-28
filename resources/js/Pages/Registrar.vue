<template>

  <div>
    <Head>
      <title>Registrar</title>
      <meta name="description" content="Your page description">
    </Head>
    <div class="container p-4">
      <div class="row d-flex justify-content-center">
        <div class="col-sm-10">
          <form @submit.prevent="submit" autocomplete="off">
            <div class="row">
              <div class="col-sm-12 mb-4">
                <h1 class="text-center">Registrar Paciente</h1>
              </div>
              <div class="col-sm-4 form-group">
                <label class="form-label-lg">Tipo de Documento</label>
                <select v-model="form.tipo_documento" class="form-control form-control-lg">
                  <option value="1">DNI</option>
                  <option value="6">RUC</option>
                  <option value="4">Carnet Extranjero</option>
                  <option value="0">No Docimiliano, Sin Ruc (Exportación)</option>
                  <option value="7">Pasaporte a = Cedula Diplomatica de Identidad</option>
                </select>
              </div>
              <div class="col-sm-4 form-group">
                <label>Número de documento</label>
                <input type="text" v-model="form.numero_documento" class="form-control form-control-lg" :class="{'is-invalid':$page.props.errors.numero_documento}">
                <div v-if="$page.props.errors.numero_documento" class="text-danger">{{$page.props.errors.numero_documento}}</div>
              </div>
              <div class="col-sm-4 form-group">
                <label class="invisible">Validar</label>
                <button v-if="!procesando && form.tipo_documento==1" type="button" @click="verificarDNI()" class="btn btn-lg btn-block btn-danger">Validar</button>
                <button v-if="procesando" readonly type="button"  class="btn btn-lg btn-block btn-danger"><i class="fas fa-spinner fa-spin"></i> Procesando</button>
              </div>
              <div class="col-sm-12 form-group">
                <label>Apellidos</label>
                <input type="text" v-model="form.apellidos" class="form-control form-control-lg" :readonly="form.tipo_documento==1" :class="{'is-invalid':$page.props.errors.apellidos}">
                <div v-if="$page.props.errors.apellidos" class="text-danger">{{$page.props.errors.apellidos}}</div>
              </div>
              <div class="col-sm-12 form-group">
                <label>Nombres</label>
                <input type="text" v-model="form.nombres" class="form-control form-control-lg" :readonly="form.tipo_documento==1" :class="{'is-invalid':$page.props.errors.nombres}">
                <div v-if="$page.props.errors.nombres" class="text-danger">{{$page.props.errors.nombres}}</div>
              </div>
              <div class="col-sm-4 form-group">
                <label>Departamento</label>
                <b-form-select @change="getProvincias()" v-model="form.departamento" :options="$page.props.departamento" class="form-control" size="lg" :class="{'is-invalid':$page.props.errors.departamento}"></b-form-select>
                <div v-if="$page.props.errors.departamento" class="text-danger">{{$page.props.errors.departamento}}</div>
              </div>
              <div class="col-sm-4 form-group">
                <label>Provincia</label>
                <b-form-select @change="getDistritos()" v-model="form.provincia" :options="provincia" class="form-control" size="lg" :class="{'is-invalid':$page.props.errors.provincia}"></b-form-select>
                <div v-if="$page.props.errors.provincia" class="text-danger">{{$page.props.errors.provincia}}</div>
              </div>
              <div class="col-sm-4 form-group">
                <label>Distrito</label>
                <b-form-select v-model="form.distrito" :options="distrito" class="form-control" size="lg" :class="{'is-invalid':$page.props.errors.distrito}"></b-form-select>
                <div v-if="$page.props.errors.distrito" class="text-danger">{{$page.props.errors.distrito}}</div>
              </div>
              <div class="col-sm-12 form-group">
                <label>Dirección</label>
                <input type="text" v-model="form.direccion" class="form-control form-control-lg" :readonly="form.tipo_documento==1" :class="{'is-invalid':$page.props.errors.direccion}">
                <div v-if="$page.props.errors.direccion" class="text-danger">{{$page.props.errors.direccion}}</div>
              </div>
              <div class="col-sm-3 form-group">
                <label>Teléfono</label>
                <input type="text" v-model="form.telefono" class="form-control form-control-lg" :class="{'is-invalid':$page.props.errors.telefono}">
                <div v-if="$page.props.errors.telefono" class="text-danger" >{{$page.props.errors.telefono}}</div>
              </div>
              <div class="col-sm-3 form-group">
                <label>Fec. Nacimiento</label>
                  <b-form-datepicker
                    :show-decade-nav="true"
                    :hide-header="true"
                    @input="calularEdad()"
                    v-model="form.fec_nac"
                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                    locale="es"
                    placeholder="Fec. Nac"
                    class="form-control form-control-lg"
                    :disabled="form.tipo_documento==1"
                    :class="{'is-invalid':$page.props.errors.fec_nac}"
                  ></b-form-datepicker>
                  <div v-if="$page.props.errors.fec_nac" class="text-danger" >{{$page.props.errors.fec_nac}}</div>
              </div>
              <div class="col-sm-3 form-group">
                <label>Edad</label>
                <input type="text" v-model="form.edad" readonly class="form-control form-control-lg">
              </div>
              <div class="col-sm-3 form-group">
                <label>Estado civil</label>
                <select v-model="form.estado_civil"  class="form-control form-control-lg" :class="{'is-invalid':$page.props.errors.estado_civil}">
                  <option value="">Seleccione</option>
                  <option value="N">No Especifica</option>
                  <option value="C">Casado(a)</option>
                  <option value="S">Soltero(a)</option>
                  <option value="V">Viudo(a)</option>
                  <option value="D">Divorciado(a)</option>
                </select>
                <div v-if="$page.props.errors.estado_civil" class="text-danger" >{{$page.props.errors.estado_civil}}</div>
              </div>

              <div class="col-sm-6 form-group">
                <label>Sexo</label>
                <b-form-radio-group
                  v-model="form.sexo"
                  :options="[
                    { item: 'M', name: 'Masculino' },
                    { item: 'F', name: 'Femenino' }
                  ]"
                  value-field="item"
                  text-field="name"
                  size="lg"
                ></b-form-radio-group>
              </div>
              <div class="col-sm-3">
                <label>Nos conoció</label>
                <select v-model="form.informacion" class="form-control form-control-lg">
                  <option value="">Seleccione</option>
                  <option :value="info.cod_infor"  v-for="info in $page.props.informacion" :key="info.cod_infor">{{ info.nomb_infor }}</option>
                </select>
              </div>
              <div class="col-sm-3">
                <label>Tipo paciente</label>
                <select v-model="form.tipo" class="form-control form-control-lg">
                  <option value="">Seleccione</option>
                  <option :value="tipo.cod_tipac"  v-for="tipo in $page.props.tipo" :key="tipo.cod_tipac">{{ tipo.nomb_tipac }}</option>
                </select>
              </div>
              
            </div>
            <div class="row  mt-4">
              <div class="col-md-6 form-group d-flex justify-content-center">
                <Link href="/" class="btn btn-warning btn-lg btn-block"><i class="fa fa-long-arrow-alt-left fa-lg"></i> Salir</Link>
              </div>
              <div class="col-md-6 form-group d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg btn-block"> <i class="far fa-save fa-lg"></i>  Guardar datos</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <loading :active.sync="isLoading"
      :is-full-page="true"></loading>
  </div>
</template>

<script>
import Loading from 'vue-loading-overlay';

export default {
  components:{
    Loading
  },
  created() {
    
  },
  data() {
    return {
      isLoading: false,
      form:{
        tipo_documento: '1',
        numero_documento: '',
        apellidos: '',
        nombres: '',
        departamento:'',
        provincia:'',
        distrito:'',
        direccion: '',
        telefono: '',
        fec_nac: '',
        edad: '',
        estado_civil: '',
        sexo: 'M',
        informacion: '',
        tipo: '',
        aseguradora: '',
        empresa: ''
      },

      provincia:null,
      distrito:null,
      procesando:false
    }
  },
  methods: {
    getProvincias(){
      let vue = this;
      let departamento = vue.form.departamento;
      axios.post('/registrar/getProvincias',{departamento})
      .then(res => {
        vue.provincia = res.data;
        vue.form.provincia = vue.provincia[0]['value'];
        vue.getDistritos();
      })
    },
    getDistritos(){
      let vue = this;
      let provincia = vue.form.provincia;
      axios.post('/registrar/getDistritos',{provincia})
      .then(res => {
        vue.distrito = res.data;
        vue.form.distrito = vue.distrito[0]['value'];
      })
    },
    verificarDNI(){
      let vue = this;
      if(vue.form.tipo_documento!=1){
        return;
      }
      if(vue.form.numero_documento == ''){
        vue.$toast.open({
          message: "Ingrese un número de documento",
          type: "warning"
        });
        return;
      }
      if(vue.form.numero_documento.length != 8){
        vue.$toast.open({
          message: "El DNI debe ser de 8 dígitos",
          type: "warning"
        });
        return;
      }

      vue.limpiarDatos();

      let numero_documento = vue.form.numero_documento;
      vue.procesando = true;
      axios.post('/registrar/verificar-dni',{ numero_documento })
      .then(res => {
        vue.procesando = false;
        if(res.data.success){
          let data = res.data.data;
          vue.form.apellidos = data.apellidoPrimero +' '+ data.apellidoSegundo;
          vue.form.nombres = data.prenombreInscrito;
          vue.form.direccion = data.domicilio;
          vue.form.fec_nac = data.fechaNacimiento;
          vue.calularEdad();
          vue.$toast.open({
            message: "Documento válido",
            type: "success"
          });
        }else{
          if(res.data.type == 1){
            let paciente = res.data.data;
            vue.$swal('Ya existe!',paciente.nomb_pac +' '+ paciente.apel_pac+' ya se encuentra registrado','warning');
          }else{
            vue.$toast.open({
              message: "Documento inválido",
              type: "error"
            });
          }

        }
      })
    },
    calularEdad() {
      let vue = this;
      const fecha = vue.form.fec_nac.split('-');
      const dob = new Date(fecha[0], fecha[1], fecha[2])
      const diff_ms = Date.now() - dob.getTime();
      const age_dt = new Date(diff_ms); 
    
      vue.form.edad = Math.abs(age_dt.getUTCFullYear() - 1970);
    },
    limpiarDatos(){
      let vue = this;
      vue.form.apellidos = '';
      vue.form.nombres = '';
      vue.form.direccion = '';
      vue.form.fec_nac = '';
    },
    submit(){
      let vue = this;
      this.$inertia.post('/registrar/guardar', vue.form, {
        onStart: visit => {
          vue.isLoading = true;
        },onFinish: visit => {
          vue.isLoading = false;
        },onSuccess: page => {
          vue.form.tipo_documento = '1';
          vue.form.numero_documento = '';
          vue.form.apellidos = '';
          vue.form.nombres = '';
          vue.form.departamento = '';
          vue.form.provincia = '';
          vue.form.distrito = '';
          vue.form.direccion = '';
          vue.form.telefono = '';
          vue.form.fec_nac = '';
          vue.form.edad = '';
          vue.form.estado_civil = '';
          vue.form.sexo = 'M';
          vue.form.informacion = '';
          vue.form.tipo = '';
          vue.form.aseguradora = '';
          vue.form.empresa = '';  
          vue.$swal('Buen trabajo!','Los datos han sido correctamente guardados','success');
        }
      })
    }
  },
}
</script>