<template>
    <div class="container mx-auto pt-10">
        <h1 class="text-center text-4xl text-green-600 mb-2">Short<span class="font-thin">nr</span></h1>
        <p class="text-center text-gray-600">Enter the URL that you would like to shorten below to get started!</p>
        <div class="w-1/2 mx-auto">
            <input class="select mx-auto mt-4" />
            <input class="input w-1/4 mx-auto mt-4 cursor-pointer" type="submit" />
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('URL shortener component mounted and ready for axios.')
        }
    }
</script>
