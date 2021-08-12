<template>
  <div>
    <a :href="link">
      <div class="restaurant-card">
        <div class="type-container">
          <div class="my-icon"><i class="fas fa-utensils"></i></div>

            <div class="mini-types">
              <span class="type-item" v-for="type in types" :key="type.id"><i class="fas fa-circle"></i> {{ type.name }}</span>
            </div>

        </div>
        <div class="img-container">
          <img :src="img" alt="">
        </div>
        <div class="name-container">
          <h5>{{ name }}</h5>
        </div>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  name: "RestaurantCard",
  props: {
    name: String,
    link: String,
    img: String,
    types: Array,
  }
};
</script>