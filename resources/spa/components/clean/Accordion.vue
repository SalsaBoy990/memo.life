<template>
  <div v-for="item in contents" :key="item.id">
    <button @click="toggleAccordion(item.id)" class="block left-align">{{ item.title }}
    </button>
    <div :id="item.id" class="hide accordion-item" v-html="item.data">
    </div>
  </div>
</template>

<script>
export default {
  name: 'Accordion',
  props: [
    'dropdown'
  ],
  data() {
    return {
      accordionId: '',
      sameClick: false,
      toggleClass: '',
      headerActiveClass: '',
      accordionItemClass: '',
      contents: [
        {
          id: 'accordionOne',
          title: 'Open Section 1',
          data: '<div class="box">' +
              '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut\n' +
              '          labore\n' +
              '          et\n' +
              '          dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi\n' +
              '          ut\n' +
              '          aliquip ex\n' +
              '          ea commodo consequat.</p>' +
              '</div>'
        },
        {
          id: 'accordionTwo',
          title: 'Open Section 2',
          data: '<div class="bar-block">' +
              '<a class="bar-item" href="javascript:void(0)">Link 1</a>\n' +
              '      <a class="bar-item" href="javascript:void(0)">Link 2</a>\n' +
              '      <a class="bar-item" href="javascript:void(0)">Link 3</a>' +
              '</div>'
        },
        {
          id: 'accordionThree',
          title: 'Open Section 3',
          data: '<div class="box black">\n' +
              '        <p>Accordion with Images:</p>\n' +
              '        <img src="/images/img_snowtops.jpg"' +
              '             class="animate-zoom thumbnail-third" alt="French Alps">\n' +
              '        <p>French Alps</p>\n' +
              '      </div>'
        },
      ]
    }
  },

  mounted() {
    this.accordionId = '';
    this.sameClick = false;
    this.toggleClass = "show";
    this.headerActiveClass = "accordion-button";
    this.accordionItemClass = "accordion-item";
  },
  methods: {
    toggleAccordion(accordionId = '') {

      // if we click on the same button twice, hide the accordion content
      if (this.accordionId === accordionId) {
        this.accordionId = accordionId;
        const x = document.getElementById(this.accordionId);

        // Hide it when shown
        if (this.sameClick === false) {
          x.classList.remove(this.toggleClass);
          x.previousElementSibling.classList.remove(this.headerActiveClass);
          this.sameClick = true;
        } else { // Show it when hidden
          x.classList.add(this.toggleClass);
          x.previousElementSibling.classList.add(this.headerActiveClass);
          this.sameClick = false;
        }

      } else {
        // This is not a same button click, so set it back to false
        this.sameClick = false;
        this.accordionId = accordionId;
        const x = document.getElementById(this.accordionId);

        // Hide all accordion items
        const y = document.getElementsByClassName(this.accordionItemClass);
        for (let i = 0; i < y.length; i++) {
          const accordionItem = y[i];
          if (accordionItem.classList.contains(this.toggleClass)) {
            accordionItem.classList.remove(this.toggleClass);
          }
          if (accordionItem.previousElementSibling.classList.contains(this.headerActiveClass)) {
            accordionItem.previousElementSibling.classList.remove(this.headerActiveClass);
          }
        }


        if (x.classList) {
          x.classList.toggle(this.toggleClass);
          x.previousElementSibling.classList.toggle(this.headerActiveClass);
        } else {
          // Fallback for IE9 and earlier
          const toggleClassString = " " + this.toggleClass;
          if (x.className.indexOf(this.toggleClass) === -1) {
            x.className += toggleClassString;
          } else {
            x.className = x.className.replace(toggleClassString, "");
          }
        }


      }
    }
  },

}

</script>
