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
						<span><strong>Boys Golf</strong></span>
						<span v-if="match.winning_team == ''">
							<strong>Final</strong>
						</span>
						<span v-else>
							<strong>{{match.game_time.time}}</strong>
						</span>
					</div>
				</div>
				<div class="card-body">
					<div class="mb-3 d-flex justify-content-between align-items-center">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" 
								   :src="'/images/team-logos/' + match.away_team.logo" 
								   alt="match.away_team.school_name">
							   <a :href="'/boys-golf/' + match.the_year.year + '/' + match.away_team.school_name">{{match.away_team.school_name}}</a>
						</span>
						<span v-if="match.away_team_final_score != ''">
							{{match.away_team_final_score}}
						</span>
						<span v-else>
							-
						</span>
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" 
								   :src="'/images/team-logos/' + match.home_team.logo" 
								   alt="match.home_team.school_name">
							  <a :href="'/boys-golf/' + match.the_year.year + '/' + match.home_team.school_name">{{match.home_team.school_name}}</a>
						</span>
						<span v-if="match.home_team_final_score != ''">
							{{match.home_team_final_score}}
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
				match: [],
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
				axios.get('/api/boys-golf/' + this.matchId)
				.then(res =>  {
	                    this.match = res.data,
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