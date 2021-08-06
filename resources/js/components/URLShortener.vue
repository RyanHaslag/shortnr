<template>
    <div class="container mx-auto pt-10">
        <h1 class="text-center text-4xl text-green-600 mb-2">Short<span class="font-thin">nr</span></h1>
        <p class="text-center text-gray-600">Enter the URL that you would like to shorten below to get started!</p>
        <div class="w-2/3 mx-auto">
            <input class="select mx-auto mt-4"  v-model="fullURL"/>
            <div class="text-center mt-4">
                <input type="checkbox" id="checkbox" v-model="nsfw">
                <label for="checkbox">Is this link NSFW?</label>
            </div>
            <button @click="submitURL" class="button block my-4 mx-auto h-10 px-6 w-1/4 cursor-pointer">Submit</button>
            <div v-if="shortURL" class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                <p class="font-bold">Your shortcode is ready!</p>
                <p class="text-sm">Follow this link to go to your webpage: <a v-bind:href="shortURL" target="_blank" class="font-bold">{{ shortURL }}</a></p>
            </div>
            <div v-if="errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-auto" role="alert">
                <div v-for="error in errors">
                    <span v-for="errorText in error" class="top-0 bottom-0 right-0 px-4 py-3 text-sm">Error: {{ errorText }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const axios = require('axios');
    export default {
        data() {
            return {
                fullURL: null,
                shortURL: null,
                nsfw: false,
                errors: null
            }
        },
        mounted() {
            console.log('mounted.');
        },
        methods: {
            submitURL() {
                //Clear any existing errors for the user
                this.errors = null;

                //Reset the short URL displayed to the user
                this.shortURL = null;

                let _this = this;
                axios.post("/shorten", {
                    'fullURL': this.fullURL,
                    'nsfw': this.nsfw
                }).then(function (response) {
                    _this.shortURL = response.data.data;
                })
                .catch(function(error) {
                    _this.errors = error.response.data.errors;
                });
            }
        }
    }
</script>
