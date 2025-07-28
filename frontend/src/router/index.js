import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import FavoritesView from '../views/FavoritesView.vue';

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/favorites', name: 'Favorites', component: FavoritesView },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
