<template>
  <div class="container mt-5">
    <h4 class="text-center">Students List</h4>

    <!-- Button trigger modal -->

    <button
      type="button"
      class="btn btn-primary mt-2"
      data-toggle="modal"
      data-target="#exampleModal"
    >
      Add Student
    </button>

    <table class="table mt-5">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">District</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="student in fetched_students_data" :key="student.id">
          <th scope="row">{{ student.id }}</th>
          <td>{{ student.name }}</td>
          <td>{{ student.district }}</td>
          <td>
            <button
              class="btn btn-sm btn-success"
              data-toggle="modal"
              data-target="#editStudent"
              @click="editStudent(student)"
            >
              Edit
            </button>
            <button
              class="btn btn-sm btn-danger"
              @click="deleteStudent(student)"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <add-student></add-student>
        </div>
      </div>
    </div>

    <!--EditModal-->
    <!-- Modal -->
    <div
      class="modal fade"
      id="editStudent"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <add-student :edit="true"></add-student>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      fetched_students_data: {},
    };
  },

  methods: {

    //Add
    getStudents() {
      axios.get("get-students").then((response) => {
        this.fetched_students_data = response.data;
      });
    },

    //Edit
    editStudent(student){
         bus.$emit("edit-student", student);
    },

    //Delete
    deleteStudent(student){

    axios.post("delete-student", {id:student.id}).then((response) => {
        if (response.data == "success") {
          alert("Successfully Deleted");

        this.getStudents();
        }
      });
    }
  },

  created() {
    var _this = this;
    bus.$on("student-added", function () {
      _this.getStudents();
    });

    _this.getStudents();
  },

  mounted() {},
};
</script>


<style scoped>
</style>
