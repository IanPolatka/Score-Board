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

                    <div v-if="event.sport_name === 'softball'" class="mb-4">

                        <Softball :id="event.id"></Softball>

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
    import Softball from './TodaysEvents/Softball'

    export default {
        components: {
            Baseball,
            Softball
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
