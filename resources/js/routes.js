/*import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    {
        path: "/dashboard",
        component: require("./components/Dashboard.vue").default
    },
   
    { path: "/users", component: require("./components/Users.vue").default },

    //Configuraciones
    { path: "/configurations", component: require("./components/Configurations.vue").default },
    { path: "/sectors", component: require("./components/Sectores/Sectores.vue").default },
    { path: "/plans", component: require("./components/Plans/List.vue").default },
    { path: "/naps", component: require("./components/Naps/Naps.vue").default },

    //Ventas
    { path: "/solicitudes", component: require("./components/Ventas/SalesRequests.vue").default },
    { path: "/manage-ventas", component: require("./components/Ventas/Sales.vue").default },
    { path: "/reporte-ventas", component: require("./components/Ventas/Reportes.vue").default },

    // ODIS
    { path: "/manage-odis", component: require("./components/Odis/ManageOdis.vue").default },
    { path: "/install-odis", component: require("./components/Odis/InstallOdis.vue").default },
    
    //{ path: "*", component: require("./components/NotFound.vue").default }
    //Contratos
    { path: "/contracts", component: require("./components/Contracts/List.vue").default },
    { path: "/contract/:id", component: require("./components/Contracts/Info.vue").default },
];*/

export default [
    {
        path: "/dashboard",
        component: require("./components/Dashboard.vue").default
    },
   
    { path: "/users", component: require("./components/Users.vue").default },

    //Configuraciones
    { path: "/configurations", component: require("./components/Configurations.vue").default },
    { path: "/sectors", component: require("./components/Sectores/Sectores.vue").default },
    { path: "/plans", component: require("./components/Plans/List.vue").default },
    { path: "/naps", component: require("./components/Naps/Naps.vue").default },

    //Ventas
    { path: "/solicitudes", component: require("./components/Ventas/SalesRequests.vue").default },
    { path: "/manage-ventas", component: require("./components/Ventas/Sales.vue").default },
    { path: "/reporte-ventas", component: require("./components/Ventas/Reportes.vue").default },

    // ODIS
    { path: "/manage-odis", component: require("./components/Odis/ManageOdis.vue").default },
    { path: "/install-odis", component: require("./components/Odis/InstallOdis.vue").default },
    { path: "/reporte-odi", component: require("./components/Odis/Reportes.vue").default },
    { path: "/odi/:id", component: require("./components/Odis/Info.vue").default },
    //{ path: "*", component: require("./components/NotFound.vue").default }
    //Contratos
    { path: "/contracts", component: require("./components/Contracts/List.vue").default },
    { path: "/contract/:id", component: require("./components/Contracts/Info.vue").default },
];

/*const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active'
  })
  
  router.beforeEach((to, from, next) => {
    if (to.matched.some(m => m.meta.requiresAuth)) {
        return AuthService.check().then(authenticated => {
          if (!authenticated) {
            return next({ path: '/login' })
          }
    
          return next()
        })
      }
  
    if (to.meta.noCache) {
      to.meta.$metaInfo = {
        meta: [
          {
            httpEquiv: 'Cache-Control',
            content: 'no-store, private',
          },
        ],
      };
    }
  
    next();
  });
  
  export default router;*/
  
  
  
  
