/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// // components vue
// Vue.component('TypeFilterButton', require('./components/TypeFilterButton.vue').default);
// Vue.component('RestaurantCard', require('./components/RestaurantCard.vue').default);
// Vue.component('RestaurantsIndex', require('./components/RestaurantsIndex.vue').default);
// Vue.component('TypeUser', require('./components/TypeUser.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


/*---- Cambio stile div al click----*/

window.addEventListener("load", function () {

    const myOverlay= document.querySelectorAll(".my-overlay");
    myOverlay.forEach(div => {
  
        div.addEventListener("click", () => { 
            div.classList.add('hide');
        })
    
    })
}); 



/* vecchio senza styles, non ha animazioni intermedie
window.addEventListener("load", function () {

    const myOverlay= document.querySelectorAll(".my-overlay");
    myOverlay.forEach(div => {
  
        div.addEventListener("click", () => { 
            div.style.width = "0%";
        })
    })
});  */

/*--
window.addEventListener("load", function () {

    const myOverlay= document.querySelectorAll(".my-overlay");
    myOverlay.forEach(div => {
  
        div.addEventListener("click", () => { 
            div.classList.add('hide');
        })
    
    })
    
}); -*/