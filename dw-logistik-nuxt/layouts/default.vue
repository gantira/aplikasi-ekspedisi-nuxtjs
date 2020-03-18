<template>
	<div id="wrapper">
		<app-sidebar></app-sidebar>
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<app-header></app-header>
				<nuxt/>
			</div>
		</div>
	</div>
</template>

<script>
	import Sidebar from '@/components/layouts/Sidebar.vue'
	import Header from '@/components/layouts/Header.vue'

	export default {
		components: {
			'app-sidebar': Sidebar,
			'app-header': Header
		}
	}
</script>