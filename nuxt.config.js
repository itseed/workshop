require('dotenv').config({ path: `.env.${process.env.NODE_ENV}` })
export default {
  // Target (https://go.nuxtjs.dev/config-target)
  target: 'static',

  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    title: 'workshop',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      {
        rel: 'stylesheet',
        href: 'https://fonts.googleapis.com/css2?family=Prompt:wght@300;400&display=swap'
      }
    ],
    script: [
      { src: 'https://static.line-scdn.net/liff/edge/2/sdk.js', charset: 'utf-8' }
    ]
  },

  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: [
    // 'ant-design-vue/dist/antd.css'
  ],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    // '@/plugins/antd-ui',
    '@/plugins/BootstrapPlugin.js',
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    // https://go.nuxtjs.dev/stylelint
    '@nuxtjs/stylelint-module',
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    ['@nuxtjs/dotenv', { filename: `.env.${process.env.NODE_ENV}` }],
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/pwa',
    // https://go.nuxtjs.dev/content
    '@nuxt/content',
    'bootstrap-vue/nuxt',
    '@nuxtjs/auth'
  ],

  // Axios module configuration (https://go.nuxtjs.dev/config-axios)
  axios: {
    baseURL:process.env.BASE_URL,
    proxy: true,
    credentials: true,
  },

  proxy: [
    ['/api/', {
      target: process.env.BASE_API_URL,
      pathRewrite: {
        '^/api/verify' : '/api/v1/verify',
        '^/api/register' : '/api/v1/registerLine',
        '^/api/login' : '/api/v1/login',
        '^/api/me' : '/api/v1/profile'
      },
      changeOrigin: true
    }]
  ],

  // proxy: {
  //   '/api': {
  //     target: process.env.BASE_API_URL,
  //     pathRewrite: {
  //       '^/api/checkCustomer' : '/api/v1/customers/getID',
  //       '^/api/login' : '/api/v1/login'
  //     }
  //   }
  // },

  auth: {
    strategies: {
      local: {
        endpoints: {
          login: { url: '/api/login', method: 'post', propertyName: 'token' },
          user: { url: '/api/me', method: 'get', propertyName: 'user' },
          logout: false
        }
      }
    },
    redirect: {
      login: '/admin',
      logout: '/admin'
    }
  },

  // Content module configuration (https://go.nuxtjs.dev/config-content)
  content: {},

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {
  }
}
