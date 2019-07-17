<template>
	<div>
			<div v-if="isLoading" class="card">

				<div class="card-body">

					loading...

				</div>

			</div>
			
			<div v-else class="card">
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<span><strong>Girls Soccer</strong></span>
						<span v-if="game.game_status === 1">
							<strong>Final</strong>
						</span>
						<span v-else-if="game.game_status > 1">
							<strong v-if="game.game_status === 2">
								1st Half
							</strong>
							<strong v-if="game.game_status === 3">
								Halftime
							</strong>
							<strong v-if="game.game_status === 4">
								2nd Half
							</strong>
							<strong v-else-if="game.game_status > 4">
								{{game.game_status - 3 }} Overtime
							</strong>
						</span>
						<span v-else>
							<strong>{{game.game_time.time}}</strong>
						</span>
					</div>
				</div>
				<div class="card-body">
					<div class="mb-3 d-flex justify-content-between align-items-center">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" 
								   :src="'/images/team-logos/' + game.away_team.logo" 
								   alt="game.away_team.school_name">
							   <a :href="'/girls-soccer/' + game.the_year.year + '/' + game.away_team.school_name">{{game.away_team.school_name}}</a>
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
							  <a :href="'/girls-soccer/' + game.the_year.year + '/' + game.home_team.school_name">{{game.home_team.school_name}}</a>
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
	</div>
</template>

<script>
	import axios from 'axios'

	export default {
		props: ['id'],
		data() {
			return {
				game: [],
				matchId: this.id,
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
				axios.get('/api/soccer-girls/' + this.matchId)
				.then(res =>  {
	                    this.game = res.data,
	                    this.isLoading = false
	                    console.log(res.data)
	                })
	                .catch(err => console.log(err));
            }
		}
	}
</script>

<style>
	
</style>