<template>
    <div v-if="openAlert === true"
         class="panel relative" :class="[color !== '' ? panelClasses : '']">
        <button v-if="showCloseButton === true" @click="hideAlert()" class="close-button fs-18 white-transparent topright">
            <font-awesome-icon :icon="['fas', 'times']"/>
        </button>

        <div class="h5 bold">{{ heading }}</div>
        <p class="margin-0">
            <slot></slot>
        </p>

    </div>
</template>

<script>
export default {
    name: 'Alert',
    props: [
        'showCloseButton',
        'open',
        'color',
        'heading'
    ],
    data() {
        return {
            openAlert: true,
            panelStyles: [],
        }
    },
    mounted() {
        this.panelStyles['danger'] = 'danger text-red-dark border border-red-dark';
        this.panelStyles['warning'] = 'danger text-red-dark border border-red-dark';
        this.panelStyles['success'] = 'danger text-red-dark border border-red-dark';
        this.panelStyles['info'] = 'danger text-red-dark border border-red-dark';
        this.openAlert = true;
    },
    methods: {
        showAlert() {
            this.openAlert = true;
        },

        hideAlert() {
            this.openAlert = false;
        }
    },

    computed: {
        panelClasses() {
            switch (this.$props.color) {
                case 'danger':
                    return 'danger text-red-dark border border-red-dark';
                case 'warning':
                    return 'warning text-orange-dark border border-orange-dark';
                case 'success':
                    return 'success text-green-dark border border-green-dark';
                case 'info':
                    return 'info text-cyan-dark border border-cyan-dark';
                default:
                    return 'info text-cyan-dark border border-cyan-dark';
            }
        }
    }
}

</script>
