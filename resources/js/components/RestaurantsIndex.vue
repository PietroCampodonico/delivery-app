<template>
  <div>
      <type-filter-button
        :types="typesList"
        v-model="filterList"
      ></type-filter-button>

    <div class="restaurant-container">
      <restaurant-card
        v-for="restaurant in restaurantsList"
        :key="restaurant.id"
        :name="restaurant.name"
        :img="restaurant.cover_UR"
        :link="restaurant.link"
        :types="restaurant.types"
      ></restaurant-card>
    </div>

    <div class="pb-container" v-if="totalPages > 1">
      <button v-for="i in totalPages" :key="i" :value="i" v-on:click="changePage(i)">{{ i }}</button>
    </div>
  </div>
</template>

<script>
import RestaurantCard from "./RestaurantCard.vue";
import TypeFilterButton from "./TypeFilterButton.vue";
// import axios from "axios";

export default {
  components: { RestaurantCard, TypeFilterButton },
  name: "RestaurantsIndex",
  props: {},
  data() {
    return {
      allRestaurantsList: [],
      typesList: [],
      filterList: [],
      totalPages: 0,
      sliceStart: 0,
      sliceEnd: 12,
      maxRestPerPage: 12
    };
  },
  computed: {
    restaurantsList() {
      var result = [];
      if (this.filterList.length == 0) {
        result = this.allRestaurantsList;
      } else {
        var temp = this.allRestaurantsList;
        for (let i = 0; i < this.filterList.length; i++) {
          var result = [];
          temp.forEach((element) => {
            for (let j = 0; j < element.types.length; j++) {
              if (element.types[j].id == this.filterList[i]) {
                  if (!result.includes(element)) {
                    result.push(element);
                    }
                }
              }
            }
          );
          temp = result;
        }
      }
      this.totalPages = Math.ceil(result.length / this.maxRestPerPage);
      return result.slice(this.sliceStart, this.sliceEnd);
    },
  },
  methods: {
    changePage(num) {
      this.sliceStart = (num - 1) * this.maxRestPerPage;
      this.sliceEnd = num * this.maxRestPerPage;
    }
  },
  mounted() {
    axios
      .get("/api/user")
      .then((resp) => {
        this.allRestaurantsList = resp.data.results;
      })
      .catch((er) => {
        alert("Impossibile recuperare l'elenco dei ristoranti.");
      });
    axios
      .get("/api/types")
      .then((resp) => {
        this.typesList = resp.data.results;
      })
      .catch((er) => {
        alert("Impossibile recuperare l'elenco delle tipologie.");
      });
  },
};
</script>
