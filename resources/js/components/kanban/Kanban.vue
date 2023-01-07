<template>
    <div class="flex justify-center">
      <div class="row">
        <div
          v-for="column in columns"
          :key="column.title"
            :id="column.id"
          class="bg-primary opacity-50 text-center m-2"
        >
          <p class="text-white mt-3">
            {{ column.title }}
          </p>
          <draggable
            :list="column.cards"
            :data-id="column.id"
            item-key="name"
            class="list-group"
            ghost-class="ghost"
            :move="checkMove"
            group="people"
            @start="dragging = true"
            @end="dragging = false"
          >
            <!-- <template #item="{ element }"> -->
              <!-- <div  class="list-group-item">
                {{ element.title }}
              </div> -->
              <div
                class="list-group-item"
                :data-id="element.id"
                v-for="(element) in column.cards"
                :key="element.id"
              >
          {{ element.title }}
          </div>
            <!-- </template> -->
          </draggable>
        </div>
      </div>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import CardLayout from "../layouts/CardLayout.vue";
export default {
  name: "App",
  components: {
    CardLayout,
    draggable,
  },
  data() {
    return {
      cards: {},
      columns: [],
    };
  },
  methods: {
    getColumns() {
      axios.get("/columns").then((response) => {
        this.columns = response.data.columns;
      });
    },
    update(id, columnId){
      var data = {
        columnId: columnId
      }
        axios.put(`/cards/${id}`, data).then(response=>{
          console.log(response)
        }).catch(error=>{
            console.log(error)
        })
    },
    // add: function() {
    //   this.list.push({ name: "Juan " + id, id: id++ });
    //   console.log(this.list)
    // },
    // replace: function() {
    //   this.list = [{ name: "Edgard", id: id++ }];
    //   console.log(this.list)
    // },
    checkMove: function(e) {
      console.log(e)
      var cardId = e.dragged.attributes["data-id"].value;
      var columnId = e.to.attributes["data-id"].value;
      this.update(cardId, columnId)
      window.console.log("Future index: " + e.draggedContext.futureIndex);
    }
  },
  created() {
    this.getColumns();
  },
};
</script>

<style lang="scss">

.column-width {
  min-width: 320px;
  width: 320px;
}
/* Unfortunately @apply cannot be setup in codesandbox, 
but you'd use "@apply border opacity-50 border-blue-500 bg-gray-200" here */
.ghost-card {
  opacity: 0.5;
  background: #f7fafc;
  border: 1px solid #4299e1;
}
</style>
