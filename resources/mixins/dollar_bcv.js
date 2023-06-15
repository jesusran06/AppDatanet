import axios from "axios";

export default {
    methods: {
      get_price_dollar() {
        console.log("Hola");
        let response;
        axios.get('https://bcv-api.deno.dev/v1/exchange').then( (res) => {
          //response = res.data;
          console.log("bcv", res.data)
        })
        
        return response;
      }
    }
  };