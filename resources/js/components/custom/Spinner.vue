<template>
	<div>
		<div class="waitContent">
			<div class="text-center">
				<div class="spinner-border spinner-border-lg text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
		        </div>
				<p>{{message}}</p>
			</div>
		</div>
	</div>
</template>
<script>
	export default{
		props:['message'],
	}
</script>