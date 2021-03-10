<template>
  <div>
    <span
      class="like-btn"
      @click="likeReceta"
      :class="{ 'like-active': isActive }"
    ></span>
    <p>{{ totalLikes }} Les gustó esta receta</p>
  </div>
</template>

<script>
export default {
  name: "LikeButton",
  props: ["recetaId", "like", "likes"],
  data() {
    return {
      isActive: this.like,
      totalLikes: this.likes,
    };
  },
  methods: {
    likeReceta() {
      axios
        .post("/recetas/" + this.recetaId)
        .then((respuesta) => {
          if (respuesta.data.attached.length > 0) {
            this.totalLikes++;
            this.isActive = 1;
          } else {
            this.isActive = 0;
            this.totalLikes--;
          }
        })
        .catch((e) => {
          if (e.response.status === 401) {
            window.location = "/register";
          }
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
