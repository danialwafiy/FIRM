
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
Vue.use(Vuetify);

/**Passport */
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);

/**Vform and HasError */
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

/**vRoutes */
import VueRouter from 'vue-router';
Vue.use(VueRouter)
let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/student/profile/:id', component: require('./components/Profile-Student.vue').default },
    { path: '/lecture/profile/:id', component: require('./components/Profile-Lecture.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/logbook-add', component: require('./components/Logbook-Add.vue').default },
    { path: '/logbook/:id', component: require('./components/Logbook.vue').default },
    { path: '/logbook/log/:id', component: require('./components/Logbook-Single.vue').default },
    { path: '/student-list', component: require('./components/Student-List.vue').default },
    { path: '/student-list-admin', component: require('./components/StudentList-Admin.vue').default },
    { path: '/lecture-list-admin', component: require('./components/LectureList-Admin.vue').default },
    { path: '/my-students', component: require('./components/MyStudents.vue').default },
    { path: '/change-password', component: require('./components/ChangePassword.vue').default },
    { path: '/news', component: require('./components/News.vue').default },
    { path: '/news-add', component: require('./components/News-Add.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/internship', component: require('./components/Sort-Admin.vue').default},
    { path: '/internship/:id/sort', name:'internshipsort', component: require('./components/SortStudent-Admin.vue').default },
    { path: '/student/:id/meeting', component: require('./components/MeetingDetails.vue').default },
    { path: '/meet-list', component: require('./components/MeetingList-Lecture.vue').default },




  ]
  const router = new VueRouter({
  mode: 'history', 
  routes // short for `routes: routes`
})

/**Global filters and moments */
import moment from 'moment';
Vue.filter('uppercaseFIRST',function(text){
    return text.charAt(0).toUpperCase()+text.slice(1);
});
Vue.filter('uppercaseALL',function(text){
  return text.toUpperCase();
});
Vue.filter('lowercaseALL',function(text){
  return text.toLowerCase();
});
Vue.filter('dateFormatText',function(date){
    return moment(date).format('Do MMMM YYYY')
});
Vue.filter('dateFormatNum',function(date){
  return moment(date).format('DD/MM/YYYY')
});

/**Progress bar */
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

/**Sweet alert */
import swal from 'sweetalert2';
window.swal = swal;
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.toast = toast;

  

window.Fire = new Vue();

var VueTruncate = require('vue-truncate-filter')
Vue.use(VueTruncate);

import VueSession from 'vue-session'
Vue.use(VueSession);


const app = new Vue({
    el: '#app',
    router
});

