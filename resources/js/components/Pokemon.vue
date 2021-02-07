<template>
<div class="container">
    <div class="input-group rounded m-3">
        <input type="search" class="form-control rounded" placeholder="Nombre" />
        <button class="input-group-text border-0 text-white bg-primary">
            <i class="material-icons ">search</i>
        </button>
    </div>
    <div class="row">
        <div v-for="pokemon in pokemones" :key="pokemon.id" class="col-md-6 col-lg-3">
            <div class="card">
                <div class="text-white bg-danger">
                    <h5 class="text-center card-title text-capitalize mt-2">{{pokemon.id}}. {{pokemon.name}}</h5>
                </div>
                <div class="text-white bg-dark">
                    <div class="text-center mb-2 mt-2">
                        <img class="image" :src="pokemon.image" alt="Card image cap">
                    </div>
                    <div class="text-center list-group-item active border border-secondary rounded-0 bg-primary">
                        <div v-if="pokemon.types.length==1">
                            <h6>Type:</h6>
                        </div>
                        <div v-else>
                            <h6>Types</h6>
                        </div>
                    </div>
                    <ul v-for="(type, index) of pokemon.types" :key="index" class="list-group">
                        <li class="list-group-item text-dark border border-secondary rounded-0 text-center bg-info text-capitalize small"><strong>{{type.type.name}}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
import axios from "axios";
import urlAPI from "../../config/config.js"

export default {
    data: () => ({
        pokemones: [],
        search: '',
        max: 15,
        cant: 0,
    }),

    created() {
        this.iniciar();
    },

    methods: {
        iniciar() {
            this.getCant();
        },

        async getPokemons(cantidad) {
            'pokemon?limit=15&offset=1';
            for (let i = 1; i < cantidad; i++) {
                await axios.get(urlAPI+'pokemon/'+i)
                    .then(res => {
                        this.pokemones.push({
                            "id": res.data.id,
                            "name": res.data.species.name,
                            "types": res.data.types,
                            "image": res.data.sprites.front_default
                        });
                    });
            }
        },
        async getCant() {
            await axios.get(urlAPI+'pokemon?')
                .then(res => {
                    this.cant = res.data != null & res.data.count != null ? res.data.count : 0;
                }).then(res => {
                    if (this.max < this.cant) {
                        this.getPokemons(this.max);
                    }
                });
        }
    },
}
</script>

<style scoped>
.image {
    width: 120px;
    height: 120px;
    background-color: white;
    border-radius: 50%;
    border: 3px solid lightslategrey;
}

.card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
    margin-bottom: 5px;
    cursor: pointer;
    border-radius: 30px;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    margin: 1px;
}
</style>
