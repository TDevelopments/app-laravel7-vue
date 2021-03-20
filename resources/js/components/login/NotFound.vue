<template>
  <v-app>
    <div class="containers">
      <div class="panels-container">
        <div class="panel right-panel">
          <img src="images/not_found.svg" class="image" />
        </div>
        <div class="title-page">
          <h1>Page Not Found</h1>
        </div>
        <div class="text-page">
          <p>We're sorry, the page you requested could not be found.</p>
          <p>Please go back to the homepage</p>
        </div>
        <div>
          <v-btn
            color="#254378"
            class="mt-6 w-button"
            @click="go"
            rounded
            large
            dark
          >
            Go home
          </v-btn>
        </div>
      </div>
    </div>
  </v-app>
</template>
<script>
export default {
  methods: {
    go() {
      this.$router.push({ name: "login" });
    }
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");
h1 {
  font-family: "Poppins", sans-serif;
  text-align: center;
  font-size: 4.5rem;
  font-weight: 500;
  color: #254378;
  margin-bottom: 40px;
  font-weight: bold;
}
p {
  font-family: "Poppins", sans-serif;
  text-align: center;
  font-size: 1rem;
  font-weight: 500;
  color: #7da0ca;
  margin: 0 0 0 0;
}

.containers {
  text-align: center;
  margin-top: 10%;
}
.title-page {
  margin-top: 2%;
  color: #254378;
}
.w-button {
  width: 10%;
}
.image {
  width: 25%;
}
@media (max-width: 1400px) {
  .containers {
    text-align: center;
    margin-top: 15%;
  }
  .title-page {
    margin-top: 2%;
    color: #254378;
  }
  .image {
    width: 35%;
  }
}
@media (max-width: 1050px) {
  .containers {
    text-align: center;
    margin-top: 15%;
  }
  .title-page {
    margin-top: 2%;
    color: #254378;
  }
  .w-button {
    width: 15%;
  }
  .image {
    width: 35%;
  }
}
@media (max-width: 870px) {
  h1 {
    font-size: 3.5rem;
  }
  .containers {
    text-align: center;
    margin-top: 30%;
  }
  .title-page {
    margin-top: 2%;
    color: #254378;
  }
  .w-button {
    width: 20%;
  }
  .image {
    width: 35%;
  }
}
@media (max-width: 570px) {
  h1 {
    font-size: 3.5rem;
  }
  .containers {
    text-align: center;
    margin-top: 50%;
  }
  .title-page {
    margin-top: 2%;
    color: #254378;
  }
  .w-button {
    width: 20%;
  }
  .image {
    width: 40%;
  }
}
</style>
