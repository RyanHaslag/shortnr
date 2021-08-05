<template>
    <div class="container mx-auto pt-10">
        <h1 class="text-center text-4xl text-green-600 mb-2">Short<span class="font-thin">nr</span></h1>
        <p class="text-center text-gray-600">Enter the URL that you would like to shorten below to get started!</p>
        <div class="w-1/2 mx-auto">
            <input class="select mx-auto mt-4"  v-model="fullURL"/>
            <button @click="submitURL" class="button block my-4 mx-auto h-10 px-6 w-1/4 cursor-pointer">Submit</button>
            <h2 class="text-center mt-8 text-green-900 font-bold text-3xl">{{ shortURL }}</h2>
        </div>
    </div>
</template>

<script>
    const axios = require('axios');
    export default {
        data() {
            return {
                fullURL: null,
                shortURL: null
            }
        },
        mounted() {
        },
        methods: {
            submitURL() {
                //Reset the short URL displayed to the user
                this.shortURL = null;

                let _this = this;
                axios.post("/shorten", {
                    'fullURL': this.fullURL
                }).then(function (response) {
                    _this.shortURL = response.data.url;
                });
            }
        }
    }
</script>
