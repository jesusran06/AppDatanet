import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    icons: {
        iconfont: 'mdi',
    },
    theme: {
        themes: {
          light: {
            primary: '#007a8b',
            secondary: '#00A2AE',
            accent: '#8c9eff',
            error: '#b71c1c',
          },
        },
      },
}

export default new Vuetify(opts)