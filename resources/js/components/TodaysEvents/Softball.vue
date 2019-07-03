<template>
	<div>
		<a :href="'/softball/' + game.id" class="link-no-decoration text-dark">
			<div v-if="isLoading" class="card">

				<div class="card-body">

					loading...

				</div>

			</div>
			
			<div v-else class="card">
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<span><strong>Softball</strong></span>
						<span v-if="game.inning = 99">
							<strong>Final</strong>
						</span>
						<span v-else>
							<strong>{{game.game_time.time}}</strong>
						</span>
					</div>
				</div>
				<div class="card-body">
					<div class="mb-3 d-flex justify-content-between">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" :src="'/images/team-logos/' + game.away_team.logo" alt="game.away_team.school_name">{{game.away_team.school_name}}</span>
						<span v-if="game.inning > 0 && game.inning < 99">
							{{awayTeamTotal}}
						</span>
						<span v-else-if="game.inning = 99">
							{{game.away_team_final_score}}
						</span>
						<span v-else>
							-
						</span>
					</div>
					<div class="d-flex justify-content-between">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" :src="'/images/team-logos/' + game.home_team.logo" alt="game.home_team.school_name">{{game.home_team.school_name}}</span>
						<span v-if="game.inning > 0 && game.inning < 99">
							{{homeTeamTotal}}
						</span>
						<span v-else-if="game.inning = 99">
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
				axios.get('/api/softball/' + this.id)
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