<template>
  <input
    type="submit"
    class="btn btn-danger d-block mb-2 w-100"
    value="Eliminar"
    @click="eliminarReceta"
  />
</template>

<script>
export default {
  name: "EliminarReceta",
  props: ["recetaId"],
  methods: {
    eliminarReceta() {
      this.$swal
        .fire({
          title: "¿Está seguro de eliminar esta Receta?",
          text: "Está acción no se podra revertir!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, quiero eliminarlo!",
          cancelButtonText: "No",
        })
        .then((result) => {
          if (result.isConfirmed) {
            const params = {
              id: this.recetaId,
            };

            axios
              .post(`/recetas/${this.recetaId}`, {
                params,
                _method: "delete",
              })
              .then((respuesta) => {
                this.$swal.fire(
                  "Eliminación Exitosa!",
                  "Tú receta se ha eliminado.",
                  "success"
                );

                // ! Eliminar receta del DOM
                this.$el.parentNode.parentNode.parentNode.removeChild(
                  this.$el.parentNode.parentNode
                );
              })
              .catch((error) => {
                console.log(error);
              });
          } else {
            this.$swal.fire(
              "Cancelado",
              "Tú receta no ha sido eliminada :)",
              "error"
            );
          }
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
