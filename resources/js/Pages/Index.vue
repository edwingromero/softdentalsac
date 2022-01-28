<template>
  <div>
    <Head>
      <title>Inicio</title>
      <meta name="description" content="Your page description">
    </Head>
    
    <div class="container-fluid h-100">
      <div class="row justify-content-center h-100">
        <div class="col-4 hidden-md-down d-flex justify-content-center flex-column">
          <div class="row">
            <div class="col-12 text-center">
              <img class="img-fluid mb-4" style="max-width:70%" src="/images/dentalsac.png" alt="">
              <Link href="/registrar" class="btn-paciente btn btn-lg btn-primary btn-block mb-4">Registrar</Link>
              <Link class="btn-paciente btn btn-lg btn-dark btn-block mb-4">Nuevo Paciente</Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  
}
</script>

<style lang="scss">
  
  .btn-paciente{
    margin: 1em 0;
    height: 5em;
    line-height: 4;
  }
</style>