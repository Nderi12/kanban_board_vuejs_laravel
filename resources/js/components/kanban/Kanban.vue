<template>
    <div class="container-fluid p-3">
      <div class="row">
        <div class="buttonIn ml-5 items-center">
          <form @submit.prevent="createNewColumn">
            <input type="text" id="card" v-model="title" placeholder="Create new a column">
            <button class="btn btn-sm btn-success left" type="submit">Create</button>
          </form>
        </div>
      </div>
      <div class="row">
        <div
          v-for="column in columns"
          :key="column.title"
            :id="column.id"
          class="bg-primary opacity-50 text-center m-2"
        >
        <a type="button" @click="deleteColumn(column.id)" class="button">Delete Card</a>
          <p class="text-white mt-3">{{ column.title }}</p>
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
              <div class="list-group-item" :data-id="element.id" v-for="(element) in column.cards"
                :key="element.id"
              >

                <div class="card">
                  
                  <small class="mt-3"><b>{{ element.title }}</b></small>

                  <hr />
                  <p>{{ element.description }}</p>
                  <a type="button" @click="deleteCard(element.id)" class="btn btn-sm btn-danger">Delete</a>
                </div>
          
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
      title: '',
      card: {
        'title': '',
        'decription': '',
        'columnId': ''
      },
      columnId: '',
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
    createNewColumn(){
      axios.post("/columns/", {
        card: this.card,
        _method: "POST",
      });
      this.getColumns();
    },
    createNewCard(){
      axios.post("/cards/", {
        title: this.card,
        _method: "POST",
      });
      this.getColumns();
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
    checkMove: function(e) {
      console.log(e)
      var cardId = e.dragged.attributes["data-id"].value;
      var columnId = e.to.attributes["data-id"].value;
      this.update(cardId, columnId)
      window.console.log("Future index: " + e.draggedContext.futureIndex);
    },
    deleteColumn(id) {
      if (confirm("Are you sure to delete this column ?")) {
        axios.delete("/columns/" + id)
          .then((response) => {
            this.getColumns();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    deleteCard(id) {
      if (confirm("Are you sure to delete this card ?")) {
        axios.delete("/cards/" + id)
          .then((response) => {
            this.getColumns();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
  created() {
    this.getColumns();
  },
};
</script>

<style lang="scss">
.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 100%;
}

.buttonIn {
      width: 300px;
      position: relative;
  }

.button {
  background-color: #c33633;
  border: none;
  color: black;
  padding: 5px 12px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 13px;
  margin: 4px 2px;
  cursor: pointer;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container {
  padding: 2px 16px;
}

.column-width {
  min-width: 320px;
  width: 320px;
}

.ghost-card {
  opacity: 0.5;
  background: #f7fafc;
  border: 1px solid #4299e1;
}
</style>
