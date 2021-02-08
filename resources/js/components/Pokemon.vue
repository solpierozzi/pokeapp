<template>
<div class="container">
    <div class="input-group rounded m-3">
        <input type="search" class="form-control rounded" v-model="search" placeholder="Nombre" />
        <button class="input-group-text border-0 text-white bg-primary" @click="searchPokemon">
            <i class="material-icons ">search</i>
        </button>
    </div>
    <div class="row">
        <div v-for="pokemon in pokemones" :key="pokemon.id" class="col-md-6 col-lg-3">
            <div class="card" @click="getMoreInfo(pokemon.id)">
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

    <div v-if="showModal">
        <transition name="model">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark">
                            <div class="modal-header bg-danger border-0">
                                <h4 class="modal-title text-white text-capitalize">{{titleModal}}</h4>
                                <button class="border-0 bg-danger text-white" @click="showModal=false;search=''"><i class="material-icons">close</i></button>
                            </div>
                            <div v-if="pokemon.id!==-1">
                                <div class="modal-body">
                                    <div class="text-center mb-2 mt-2">
                                        <img class="image" :src="pokemon.image" alt="Card image cap">
                                    </div>
                                </div>
                                <div class="text-center list-group-item active border border-secondary rounded-0 bg-primary">
                                    <h6>Weight</h6>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item text-dark border border-secondary rounded-0 text-center bg-info text-capitalize small"><strong>{{pokemon.weight}} </strong></li>
                                </ul>

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
                                <div class="text-center list-group-item active border border-secondary rounded-0 bg-primary">
                                    <div v-if="pokemon.abilities.length==1">
                                        <h6>Ability:</h6>
                                    </div>
                                    <div v-else>
                                        <h6>Abilities</h6>
                                    </div>
                                </div>
                                <ul v-for="ability in pokemon.abilities" class="list-group">
                                    <li class="list-group-item text-dark border border-secondary rounded-0 text-center bg-info text-capitalize small"><strong>{{ability.ability.name}}</strong></li>
                                </ul>
                            </div>
                            <div v-else>
                                <h4 class="text-center text-white m-3">Pokemón no encontrado!</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </transition>
    </div>

</div>
</template>

<script>
import axios from "axios";
import urlAPI from "../../config/config.js"

export default {
    data: () => ({
        pokemones: [],
        pokemonesMostrados: [],
        search: '',
        showModal: false,
        titleModal: '',
        max: 8,
        cant: 0,

        pokemon: {
            weight: 0,
            abilities: [],
            image: '',
            name: '',
            types: [],
            id: -1
        },

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
                await axios.get(urlAPI + 'pokemon/' + i)
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

        async getMoreInfo(idOrName) {
            await axios.get(`${urlAPI}pokemon/${idOrName}`)
                .then(res => {
                    let pokemon = res.data;
                    if (pokemon != null && pokemon.id != null) {
                        this.pokemon.weight = pokemon.weight;
                        this.pokemon.abilities = pokemon.abilities;
                        this.pokemon.image = pokemon.sprites.front_default;
                        this.pokemon.types = pokemon.types;
                        this.pokemon.id = pokemon.id;
                        this.pokemon.name = pokemon.species.name;
                        this.titleModal = this.pokemon.id + ". " + this.pokemon.name;
                        this.showModal = true;
                    } else {
                        this.mensajeError();
                    }
                }).catch(err => {
                    this.mensajeError();
                });
        },

        mensajeError() {
            this.pokemon.id = -1;
            this.titleModal = "Uups, algo ocurrió mal!";
            this.showModal = true;
        },

        searchPokemon() {
            let name = this.search.toLowerCase();

            if (name.length > 0) {
                this.getMoreInfo(name);
            }
        },

        async getCant() {
            await axios.get(urlAPI + 'pokemon?')
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

.card,
.modal-dialog {
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

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}
</style>
