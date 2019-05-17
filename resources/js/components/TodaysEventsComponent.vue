<template>
    <div>
        <div v-for="event in events">

            <div v-if="event.sport_name != 'track-and-field' && event.sport_name != 'wrestling'">

                <a v-bind:href="'/' + event.sport_name + '/' + event.id">
                <!--  <a href="https://scores.camelpride.com/{{event.sport_name}}/{{event.id}}">. -->
                
                    <div class="card card-default mb-4">
                
                        <div class="card-header"><strong>{{event.sport_name | capitalize}}</strong></div>

                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.away_team.logo" class="mr-3"/>{{event.away_team.school_name}}</div>
                                <div>
                                    <span v-if="event.sport_name !== 'boys-tennis' && event.sport_name !== 'girls-tennis'">
                                        {{event.away_score_sum}}
                                    </span>
                                    <span v-else>
                                        {{event.away_team_final_score}}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.home_team.logo" class="mr-3"/>{{event.home_team.school_name}}</div>
                                <div>
                                    <span v-if="event.sport_name !== 'boys-tennis' && event.sport_name !== 'girls-tennis'">
                                        {{event.home_score_sum}}
                                    </span>
                                    <span v-else>
                                        {{event.home_team_final_score}}
                                    </span>
                                </div>
                            </div>
                        </div><!--  Card Body  -->
                    
                    </div><!--  Card  -->

                </a>

            </div>

            <div v-else>

                <a v-bind:href="'/' + event.sport_name + '/' + event.id">
                <!--  <a href="https://scores.camelpride.com/{{event.sport_name}}/{{event.id}}">. -->
                
                    <div class="card card-default mb-4">
                
                        <div class="card-header"><strong>{{event.sport_name | capitalize}}</strong></div>

                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.host_team.logo" class="mr-3"/>{{event.tournament_name}}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.the_team.logo" class="mr-3"/>{{event.the_team.school_name}}</div>
                            </div>
                        </div><!--  Card Body  -->
                    
                    </div><!--  Card  -->

                </a>

            </div>
        
        </div><!--  V-For  -->
    </div>
</template>

<script>

    export default {
        mounted() {
            this.fetchEvents();
            this.interval = setInterval(function () {
                this.fetchEvents();
            }.bind(this), 10000);
            // this.isLoading = true;
            // //axios.get('/api/todays-events/campbell county').then(res => this.events = res.data);
            // axios.get('/api/todays-events/campbell county')
            // .then(res =>  {
            //     this.events = res.data,
            //     this.isLoading = false
            // })
            // .catch(err => console.log(err));
        },
        data() {
            return {
                isLoading: false,
                events: '',
                pizza: 'cheese'
            }
        },
        methods: {
            fetchEvents() {
                this.isLoading = true;
                axios.get('/api/todays-events/campbell county')
                .then(res =>  {
                    this.events = res.data,
                    this.isLoading = false
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
