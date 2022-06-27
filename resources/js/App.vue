
<template>
    <main class="container">
        <div class="text-center w-100 py-3">
            <h3>Weather Check</h3>
        </div>
        <div class="d-flex flex-wrap justify-content-center align-items-center">
            <div v-for="div in divs" :key="div.id" class="outer-box">
                <div class="inner-box">
                    <div>
                        <img :src="'img/' + div.image" :id="'img_id_' + div.id" class="weather-img">
                        <p> City name: {{div.city}}</p>
                        <p> Temparature: <span :id="'temp_id_' + div.id">{{div.temp}}</span></p>
                        <p> Staus: <span :id="'weather_id_' + div.id">{{div.weather}}</span></p>
                    </div>
                </div>
                <div class="black-delete">
                    <div class="inner-del">
                        <button class="btn btn-danger" @click="deleteTile(div.id)">Delete</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="py-3 text-center d-flex align-items-center justify-content-center">
            <input type="hidden" id="last_id" value="0">
            City: <input type="text" id="city" class="form-control mx-2" style="max-width: 300px;">
            <button class="btn btn-success" @click="addTile()">Add</button>
        </div>

    </main>
</template>
<script>
import axios from "axios";
import $ from "jquery";
export default ({
    data() {
        return {
            index: 0,
            divs: []
        };
    },

    methods: {
        addTile() {
            var place = $("#city").val();
            axios.post("api/getweather", {city:place}).then((response) => {
                if(response.data.status == 'success'){
                    var datainput = response.data;
                    this.divs.push({
                        id: this.index,
                        image: datainput.img,
                        weather: datainput.weather,
                        temp: datainput.temp,
                        city: datainput.city,
                    });
                    var count = 1;
                    var run = this.index;
                    
                    window['counterInterval' + this.index] = setInterval(function () {
                        this.getWeather(place, run);
                        count++;
                    }.bind(this), 60000);
                    this.index++;
                }
                else{
                    alert("City Not Found");
                }
            });
            
        },
        deleteTile(index) {
            this.divs.forEach((value, i) => {
                if (value.id == index) {
                    this.divs.splice(i, 1);
                    console.log(index);
                    clearInterval( window['counterInterval' + value.id] );
                }
            });
        },
        getWeather(place, index){
            axios.post("api/getweather", {city:place}).then((response) => {
                if(response.data.status == 'success'){
                     var datainput = response.data;
                    $("#img_id_" + index).attr("src","img/" + datainput.img);
                    $("#temp_id_" + index).html(datainput.temp);
                    $("#weather_id_" + index).html(datainput.weather);
                }
                else{
                    clearInterval( window['counterInterval' + index] );
                    alert("City Not Found");
                }
            });
        }
    }
})
</script>