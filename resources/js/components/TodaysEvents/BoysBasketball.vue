<template>
	<div>
		<a :href="'/boys-basketball/' + game.id" class="link-no-decoration text-dark">
			<div v-if="isLoading" class="card">

				<div class="card-body">

					loading...

				</div>

			</div>
			
			<div v-else class="card">
				
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<span><strong>Boys Basketball</strong></span>
						<span v-if="game.game_status === 1">
							<strong>Final</strong>
						</span>
						<span v-else-if="game.game_status > 1">
							<strong v-if="game.game_status === 4">
								Halftime
							</strong>
							<strong v-else-if="game.game_status > 1 && game.game_status < 4">
								{{game.game_status - 1 }} Quarter
							</strong>
							<strong v-else-if="game.game_status > 5 && game.game_status < 7">
								{{game.game_status - 2 }} Quarter
							</strong>
							<strong v-else-if="game.game_status > 6">
								{{game.game_status - 6 }} Overtime
							</strong>
						</span>
						<span v-else>
							<strong>{{game.game_time.time}}</strong>
						</span>
						<!-- <strong>{{ game.game_time.time }}</strong> -->
					</div>
				</div>
				<div class="card-body">
					<div class="mb-3 d-flex justify-content-between align-items-center">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" 
								   :src="'/images/team-logos/' + game.away_team.logo" 
								   alt="game.away_team.school_name">
							   {{game.away_team.school_name}}
						</span>
						<span v-if="game.game_status > 1">
							{{game.away_score_sum}}
						</span>
						<span v-else-if="game.game_status === 1">
							{{game.away_team_final_score}}
						</span>
						<span v-else>
							-
						</span>
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" 
								   :src="'/images/team-logos/' + game.home_team.logo" 
								   alt="game.home_team.school_name">
							  {{game.home_team.school_name}}
						</span>
						<span v-if="game.game_status > 1">
							{{game.home_score_sum}}
						</span>
						<span v-else-if="game.game_status === 1">
							{{game.home_team_final_score}}
						</span>
						<span v-else>
							-
						</span>
					</div>
				</div>

			</div>
		</a>
	</div>
</template>

<script>
	import axios from 'axios'

	export default {
		props: ['id'],
		data() {
			return {
				game: [],
				id: this.id,
				isLoading: true
			}
		},
		mounted() {
            this.fetchEvent();
            this.interval = setInterval(function () {
                this.fetchEvent();
            }.bind(this), 10000);
        },
		methods: {
			fetchEvent() {
				axios.get('/api/basketball-boys/' + this.id)
				.then(res =>  {
	                    this.game = res.data,
	                    this.isLoading = false
	                    console.log(res.data)
	                })
	                .catch(err => console.log(err));
            }
		},
		computed:{
        	awayTeamTotal: function() {
  			    let total = 0;
  			    for(let i = 0; i < this.game.scores.length; i++){
  			      total += parseInt(this.game.scores[i].away_team_score);
  			    }
  			    return total;
			    },
  			  homeTeamTotal: function() {
  			    let total = 0;
  			    for(let i = 0; i < this.game.scores.length; i++){
  			      total += parseInt(this.game.scores[i].home_team_score);
  			    }
  			    return total;
  			  }
    	  }
	}
</script>

<style>
	
</style>