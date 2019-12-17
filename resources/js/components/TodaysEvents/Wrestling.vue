<template>
	<div>
		<a :href="'/wrestling/' + match.id" class="link-no-decoration text-dark">
			<div v-if="isLoading" class="card">

				<div class="card-body">

					loading...

				</div>

			</div>
			
			<div v-else class="card">
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<span><strong>Wrestling</strong></span>
						<strong>{{match.game_time.time}}</strong>
					</div>
				</div>
				<div class="card-body">
					<div class="mb-3 d-flex justify-content-between align-items-center">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" 
								   :src="'/images/team-logos/' + match.host_team.logo" 
								   alt="match.away_team.school_name">
							   {{match.host_team.school_name}}
						</span>
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<span><img style="height: 40px; width: auto; margin-right: 10px;" 
								   :src="'/images/team-logos/' + match.the_team.logo" 
								   alt="match.the_team.school_name">
							  {{match.the_team.school_name}}
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
				axios.get('/api/wrestling/' + this.id)
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