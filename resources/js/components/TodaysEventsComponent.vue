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

            <div v-for="event in events">

                <a :href="'/' + event.sport_name + '/' + event.id">
                <!--  <a href="https://scores.camelpride.com/{{event.sport_name}}/{{event.id}}">. -->
                    
                    <div class="card card-default mb-4">
                                
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>{{event.sport_name | capitalize}}</strong>
                            <div v-if="event.sport_name === 'baseball' || event.sport_name === 'softball'">
                                <span v-if="event.inning === null">
                                    <strong>{{event.game_time.time}}</strong>
                                </span>
                                <span v-else>
                                    <span v-if="event.inning === 99">
                                        <strong>Final</strong>
                                    </span>
                                    <span v-else>
                                        <strong>{{event.inning}} Inning</strong>
                                    </span>
                                </span>
                            </div>
                            <div v-else-if="event.sport_name === 'girls-tennis' || event.sport_name === 'boys-tennis'">
                                <span v-if="event.winning_team !== null">
                                    <strong>Final</strong>
                                </span>
                                <span v-else>
                                    {{event.game_time.time}}
                                </span>
                            </div>
                            <div v-else>
                                <strong>{{event.game_time.time}}</strong>
                            </div>
                        </div>
                                
                        <div class="card-body">

                            <div v-if="event.sport_name === 'baseball' || event.sport_name === 'softball'">

                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.away_team.logo" class="mr-3"/>{{event.away_team.school_name}}</div>
                                    <div>
                                        <span v-if="event.inning !== null">
                                            <div v-if="event.away_team_final_score === null || event.away_team_final_score === ''">
                                                {{event.away_score_sum}}
                                            </div>
                                            <div v-else>
                                                {{event.away_team_final_score}}
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.home_team.logo" class="mr-3"/>{{event.home_team.school_name}}</div>
                                    <div>
                                        <span v-if="event.inning !== null">
                                            <div v-if="event.home_team_final_score === null || event.home_team_final_score === ''">
                                                {{event.home_score_sum}}
                                            </div>
                                            <div v-else>
                                                {{event.home_team_final_score}}
                                            </div>
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <div v-else-if="event.sport_name === 'girls-tennis' || event.sport_name === 'boys-tennis'">

                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.away_team.logo" class="mr-3"/>{{event.away_team.school_name}}</div>
                                    <div>{{event.away_team_final_score}}</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.home_team.logo" class="mr-3"/>{{event.home_team.school_name}}</div>
                                    <div>{{event.home_team_final_score}}</div>
                                </div>

                            </div>

                            <div v-else>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div><img :src="'https://scores.camelpride.com/images/team-logos/' + event.host_team.logo" class="mr-3"/>{{event.tournament_name}}</div>
                                    <div>
                                        <div v-if="event.boys_result">Boys Result: {{event.boys_result}}</div>
                                        <div v-if="event.girls_result">Girls Result: {{event.girls_result}}</div>
                                    </div>
                                </div>

                            </div><!--  End V-If  -->

                        </div><!--  Card Body  -->

                    </div><!--  Card  -->

                </a>

            </div>

        </div>
        
    </div>
</template>

<script>

    export default {
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
