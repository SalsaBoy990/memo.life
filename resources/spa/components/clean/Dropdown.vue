<template>
  <div v-if="dropdown === 'mouseover'" class="dropdown" @mouseleave.self="hideDropdown" >
    <button @mouseover="toggleDropdown" class="black-button">
      Hover Me! <font-awesome-icon :icon="openDropdown ? 'fa-solid fa-caret-right' : 'fa-solid fa-caret-down'" />
    </button>
    <div v-show="openDropdown === true" @mouseleave.self="hideDropdown" class="dropdown-content bar-block border">
      <slot name="links"></slot>
    </div>
  </div>
  <div v-else class="dropdown" v-click-outside="hideDropdown">
    <button @click="toggleDropdown" class="black-button">
      Click Me! <font-awesome-icon :icon="openDropdown ? 'fa-solid fa-caret-right' : 'fa-solid fa-caret-down'" />
    </button>
    <div v-show="openDropdown === true" class="dropdown-content bar-block border">
      <slot name="links"></slot>
    </div>
  </div>
</template>

<script>
import clickOutside from "./../../directives/clickOutside";

export default {
  name: 'Dropdown',
  props: [
      'dropdown'
  ],
  directives: {
    clickOutside,
  },
  data() {
    return {
      openDropdown: false,
    }
  },
  mounted() {

  },
  methods: {
    toggleDropdown() {
      this.openDropdown = !this.openDropdown;
    },

    hideDropdown() {
      this.openDropdown = false;
    }
  },

}

</script>
