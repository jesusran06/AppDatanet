import axios from "axios";

export default {
    methods: {
      get() {
        console.log("Hola");
        let response;
        axios.get('/api/plans').then( (res) => {
          response = res.data;
        })
        return response;
      }
    }
  };