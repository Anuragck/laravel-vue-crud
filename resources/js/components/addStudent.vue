<template>
  <div class="div">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
      <button
        type="button"
        class="close"
        data-dismiss="modal"
        aria-label="Close"
        @click="clearFormData()"
        ref="close_add_button"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Enter Name</label>
          <input type="text" class="form-control" v-model="students.name" />

          <small class="text-danger" v-if="errors.name">
            {{ errors.name[0] }}</small
          >
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label"
            >Enter District</label
          >
          <input type="text" class="form-control" v-model="students.district" />

          <small class="text-danger" v-if="errors.district">
            {{ errors.district[0] }}</small
          >
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button
        type="button"
        class="btn btn-secondary"
        data-dismiss="modal"
        @click="clearFormData()"
      >
        Close
      </button>
      <button
        type="button"
        class="btn btn-primary"
        @click.prevent="submitForm()"
      >
        Save changes
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["edit"],
  data() {
    return {
      title: "Add Student",

      errors: {},

      students: {
        id: "",

        name: "",
        district: "",
      },
    };
  },

  methods: {
    submitForm() {
      axios
        .post("add-student", this.students)
        .then((response) => {
          if (response.data == "success") {
            alert("Successfully Added");

            bus.$emit("student-added");

            this.clearFormData();
            this.$refs.close_add_button.click();
          }
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },

    clearFormData() {
      this.students.name = "";
      this.students.district = "";

      this.errors = {};
    },
  },

  created() {
    if (this.edit) {
      var _this = this;

      _this.title = "Edit Student";

      bus.$on("edit-student", function (student) {
        _this.students.id = student.id;

        _this.students.name = student.name;
        _this.students.district = student.district;
      });
    }
  },
};
</script>

