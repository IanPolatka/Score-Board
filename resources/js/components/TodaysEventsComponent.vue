<template>
    <div>

        <div v-if="isLoading">

            <div class="card card-default mb-4">

                <div class="card-body">
                    loading...
                </div>

            </div>
        </div>

        <div v-else>

            <div v-if="events.length">

                <div v-for="event in events">

                    <div v-if="event.sport_name === 'baseball'">

                        <Baseball :id="event.id" class="mb-4"></Baseball>

                    </div>

                    <div v-if="event.sport_name === 'boys-golf'" class="mb-4">

                        <BoysGolf :id="event.id"></BoysGolf>

                    </div>

                    <div v-if="event.sport_name === 'girls-golf'" class="mb-4">

                        <GirlsGolf :id="event.id"></GirlsGolf>

                    </div>

                    <div v-if="event.sport_name === 'boys-soccer'">

                        <BoysSoccer :id="event.id" class="mb-4"></BoysSoccer>

                    </div>

                    <div v-if="event.sport_name === 'girls-soccer'">

                        <GirlsSoccer :id="event.id" class="mb-4"></GirlsSoccer>

                    </div>

                    <div v-if="event.sport_name === 'softball'" class="mb-4">

                        <Softball :id="event.id"></Softball>

                    </div>

                    <div v-if="event.sport_name === 'football'" class="mb-4">

                        <Football :id="event.id"></Football>

                    </div>

                    <div v-if="event.sport_name === 'volleyball'" class="mb-4">

                        <Volleyball :id="event.id"></Volleyball>

                    </div>

                    <div v-if="event.sport_name === 'boys-basketball'" class="mb-4">

                        <BoysBasketball :id="event.id"></BoysBasketball>

                    </div>

                    <div v-if="event.sport_name === 'girls-basketball'" class="mb-4">

                        <GirlsBasketball :id="event.id"></GirlsBasketball>

                    </div>

                    <div v-if="event.sport_name === 'wrestling'" class="mb-4">

                        <Wrestling :id="event.id"></Wrestling>

                    </div>

                </div>

            </div>

            <div v-else>

                <div class="card card-default mb-4">

                    <div class="card-body">
                        No Events Today
                    </div>

                </div>

            </div>

        </div>
        
    </div>
</template>

<script>

    import Baseball from './TodaysEvents/Baseball'
    import BoysGolf from './TodaysEvents/BoysGolf'
    import GirlsGolf from './TodaysEvents/GirlsGolf'
    import BoysSoccer from './TodaysEvents/BoysSoccer'
    import Football from './TodaysEvents/Football'
    import GirlsSoccer from './TodaysEvents/GirlsSoccer'
    import Softball from './TodaysEvents/Softball'
    import Volleyball from './TodaysEvents/Volleyball'
    import BoysBasketball from './TodaysEvents/BoysBasketball'
    import GirlsBasketball from './TodaysEvents/GirlsBasketball'
    import Wrestling from './TodaysEvents/Wrestling'

    export default {
        components: {
            Baseball,
            BoysGolf,
            GirlsGolf,
            BoysSoccer,
            Football,
            GirlsSoccer,
            Softball,
            Volleyball,
            BoysBasketball,
            GirlsBasketball,
            Wrestling
        },
        mounted() {
            this.fetchEvents();
            this.interval = setInterval(function () {
                this.fetchEvents();
            }.bind(this), 10000);
        },
        data() {
            return {
                isLoading: true,
                events: '',
            }
        },
        methods: {
            fetchEvents() {
                axios.get('/api/todays-events')
                .then(res =>  {
                    this.events = res.data,
                    this.isLoading = false
                    console.log(res.data)
                })
                .catch(err => console.log(err));
                }
        }
    }
</script>

<style scoped>

img {
    height: 45px;
    width: 45px;
}

a {
    color: black;
}

a:hover {
    text-decoration: none;
    color: #663366;
}

</style>
