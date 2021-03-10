<template>
  <span v-text="formatearFecha"> </span>
</template>

<script>
export default {
  name: "fecha-receta",
  props: ["fecha"],
  computed: {
    formatearFecha() {
      return moment(this.fecha).locale("es").format("DD [de] MMMM [del] YYYY");
    },
  },
  mounted() {
    console.log(this.formatearFecha);
  },
};
</script>
