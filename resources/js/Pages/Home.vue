<template>
    <div class="container">
        <div class="row">
            <!-- BEGIN SEARCH RESULT -->
            <div class="col-md-12">
                <div class="grid search">
                    <div class="grid-body">
                        <div class="row">
                            <!-- BEGIN FILTERS -->
                            <div class="col-md-3">
                                <h2 class="grid-title"><i class="fa fa-filter"></i> Filter</h2>
                                <hr>
                                <!-- BEGIN FILTER BY CATEGORY -->
                                <h4>Kategorie:</h4>
                                <div class="checkbox" v-for="category in categories">
                                    <label>
                                        <input type="checkbox" class="icheck" :value="category.slug"
                                               v-model="categoryFilter" v-on:change="search">
                                        {{ category.name }}
                                    </label>
                                </div>
                                <!-- END FILTER BY CATEGORY -->

                                <!-- BEGIN FILTER BY PRICE -->
                                <h4>Preis:</h4>
                                <div class="checkbox" v-for="(star, index) in stars">
                                    <label><input type="checkbox" class="icheck" :value="index"
                                                  v-model="priceFilter" v-on:change="search"> <span
                                        v-html="star"></span></label>
                                </div>
                                <!-- END FILTER BY PRICE -->

                                <!-- BEGIN FILTER BY PRICE -->
                                <h4>Entfernung:</h4>
                                <div class="checkbox" v-for="(star, index) in stars">
                                    <label><input type="checkbox" class="icheck" :value="index"
                                                  v-model="distanceFilter" v-on:change="search"> <span
                                        v-html="star"></span></label>
                                </div>
                                <!-- END FILTER BY PRICE -->

                                <!-- BEGIN FILTER BY PRICE -->
                                <h4>Veggie-Tauglich:</h4>
                                <div class="checkbox" v-for="(star, index) in stars">
                                    <label><input type="checkbox" class="icheck" :value="index"
                                                  v-model="veggieSuitableFilter" v-on:change="search"> <span
                                        v-html="star"></span></label>
                                </div>
                                <!-- END FILTER BY PRICE -->
                            </div>
                            <!-- END FILTERS -->
                            <!-- BEGIN RESULT -->
                            <div class="col-md-9">
                                <h2><i class="fa fa-file-o"></i> Ergebnisse</h2>
                                <hr>
                                <!-- BEGIN SEARCH INPUT -->
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="query">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" v-on:click="search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button class="btn btn-danger" type="button" v-on:click="clearSearch">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </span>
                                </div>
                                <!-- END SEARCH INPUT -->

                                <div class="padding"></div>

                                <!-- BEGIN TABLE RESULT -->
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Kategorie</th>
                                            <th class="text-center">Address</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="restaurant in restaurants">
                                            <td class="text-center">{{ restaurant.name }}</td>
                                            <td class="text-center">{{ restaurant.category.name }}</td>
                                            <td class="text-center">
                                                {{ restaurant.address ? restaurant.address.label : '' }}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- END TABLE RESULT -->
                            </div>
                            <!-- END RESULT -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SEARCH RESULT -->
        </div>
    </div>
</template>

<script>
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Home",
    props: {
        categories: Object,
        restaurants: Object
    },
    data() {
        return {
            stars: {
                '*': '<i class="fa fa-star">',
                '**': '<i class="fa fa-star"><i class="fa fa-star">',
                '***': '<i class="fa fa-star"><i class="fa fa-star"><i class="fa fa-star">'
            },
            query: null,
            categoryFilter: [],
            priceFilter: [],
            distanceFilter: [],
            veggieSuitableFilter: []
        }
    },
    methods: {
        route,
        search() {
            const form = reactive({
                'query': this.query,
                'categories': this.categoryFilter,
                'prices': this.priceFilter,
                'distances': this.distanceFilter,
                'veggie_suitables': this.veggieSuitableFilter,
            })

            Inertia.post("" + route('home') + "", form)
        },
        clearSearch() {
            this.query = null;
            this.categoryFilter = [];
            this.priceFilter = [];
            this.distanceFilter = [];
            this.eggieSuitableFilter = [];
            this.search()
        }
    }
}
</script>

<style scoped>

</style>
