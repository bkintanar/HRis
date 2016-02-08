module.exports = {
  props: [
    'employee', 'page_title', 'job_titles', 'employment_statuses', 'routes', 'has_access', 'permission', 'logged'
  ],

  compiled: function() {

    this.$dispatch(
      'update-page-title', ((this.$route.path.indexOf('pim') > -1) ? 'Employee\'s ' : 'My ') + 'Qualifications'
    );
  },

  data: function() {

    return {
      work_experiences: [{}],
      work_experience_modal: {
        work_experience_id: 0,
        company: '',
        job_title: '',
        from_date: '',
        to_date: '',
        comment: ''
      },
      educations: [{}],
      education_levels: [],
      education_modal: {
        education_id: 0,
        institute: '',
        major_specialization: '',
        from_date: '',
        to_date: '',
        gpa_score: '',
        education_level_id: 0
      },
      employee_skills: [{}],
      skills: [{}],
      skill_modal: {
        skill_id: 0,
        years_of_experience: '',
        comment: ''
      },
      education_level_obj: '',
      education_level_chosen: [{}],
      skill_obj: '',
      skill_chosen: [{}]
    };
  },

  ready: function() {

    this.queryDatabase();
    this.chosenEducationLevels();
    this.chosenSkills();
  },

  methods: {
    queryDatabase: function() {

      if (this.$route.path.indexOf('/pim') > -1) {
        this.employee_id = this.$route.params.employee_id;
      } else {
        this.employee_id = localStorage.getItem('employee_id');
      }

      let params = {
        path: '/employee/get-by-employee-id?include=user,work_experiences,educations,employee_skills',
        entity: { employee_id: this.employee_id },
        headers: { Authorization: localStorage.getItem('jwt-token') }
      };

      client(params).then(
      function(response) {

        this.$dispatch('update-employee', response.entity.data);

        this.employee = response.entity.data;
        this.employee.id = response.entity.data.id;
        this.work_experiences = this.employee.work_experiences.data;
        this.educations = this.employee.educations.data;
        this.employee_skills = this.employee.employee_skills.data;
      }.bind(this),
      function(response) {

        if (response.status.code == 422) {
          this.$route.router.go({
            name: 'error-404'
          });
          console.log(response.entity);
        }
      }.bind(this));

      client({
        path: '/education-levels?table_view=true',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        this.education_levels = response.entity;
      }.bind(this));

      client({
        path: '/skills?table_view=true',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        this.skills = response.entity;
      }.bind(this));
    },

    chosenEducationLevels: function() {

      // retrieve education levels
      client({
        path: '/education-levels',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        this.education_level_chosen = response.entity;
        $('.vue-chosen').trigger('chosen:updated');
      }.bind(this));
    },

    chosenSkills: function() {

      // retrieve skills
      client({
        path: '/skills',
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        this.skill_chosen = response.entity;
        $('.vue-chosen').trigger('chosen:updated');
      }.bind(this));
    },

    toggleModal: function(type) {

      this.editMode = false;

      switch (type) {
        case 'work_experience':
          this.work_experience_modal.company = '';
          this.work_experience_modal.job_title = '';
          this.work_experience_modal.from_date = '';
          this.work_experience_modal.to_date = '';
          this.work_experience_modal.comment = '';
          break;
        case 'education':
          this.education_level_obj = '';
          this.education_modal.institute = '';
          this.education_modal.major_specialization = '';
          this.education_modal.from_date = '';
          this.education_modal.to_date = '';
          this.education_modal.gpa_score = '';
          break;
        case 'skill':
          this.skill_obj = '';
          this.skill_modal.years_of_experience = '';
          this.skill_modal.comment = '';
          break;
      }

      // Date picker
      $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
        forceParse: true,
        calendarWeeks: true,
        autoclose: true,
        clearBtn: true
      });

      $('#' + type + '_modal').modal('toggle');
      $('#' + type + '_modal').on('shown.bs.modal', function() {
        if (type == 'work_experience') {
          $('#company').focus();
        }

        $('.vue-chosen', this).trigger('chosen:updated');
      });
    },

    submitWorkExperienceForm: function() {

      // jasny bug work around
      $('#company').focus();

      this.work_experience_modal.employee_id = this.employee.id;

      client({
        path: '/profile/qualifications/work-experiences',
        method: this.editMode ? 'PATCH' : 'POST',
        entity: this.work_experience_modal,
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        switch (response.status.code) {
          case 200:
            $('#work_experience_modal').modal('toggle');
            if (this.editMode) {
              this.updateRowInWorkExperienceTable();
              swal({ title: response.entity.message, type: 'success', timer: 2000 });
            } else {
              this.work_experiences.push(response.entity.work_experience);
              swal({ title: response.entity.message, type: 'success', timer: 2000 });
            }

            break;
          case 422:
            swal({ title: response.entity.message, type: 'error', timer: 2000 });
            break;
        }
      }.bind(this));
    },

    submitEducationForm: function() {

      // jasny bug work around
      $('#institute').focus();

      this.education_modal.employee_id = this.employee.id;
      this.education_modal.education_level_id = this.education_level_obj.id;

      client({
        path: '/profile/qualifications/educations',
        method: this.editMode ? 'PATCH' : 'POST',
        entity: this.education_modal,
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        switch (response.status.code) {
          case 200:
            $('#education_modal').modal('toggle');
            if (this.editMode) {
              this.updateRowInEducationTable();
              swal({ title: response.entity.message, type: 'success', timer: 2000 });
            } else {
              this.educations.push(response.entity.education);
              swal({ title: response.entity.message, type: 'success', timer: 2000 });
            }

            break;
          case 422:
            swal({ title: response.entity.message, type: 'error', timer: 2000 });
            break;
        }
      }.bind(this));
    },

    submitSkillForm: function() {

      this.skill_modal.employee_id = this.employee.id;
      this.skill_modal.skill_id = this.skill_obj.id;

      client({
        path: '/profile/qualifications/skills',
        method: this.editMode ? 'PATCH' : 'POST',
        entity: this.skill_modal,
        headers: { Authorization: localStorage.getItem('jwt-token') }
      }).then(
      function(response) {

        switch (response.status.code) {
          case 200:
            $('#skill_modal').modal('toggle');
            if (this.editMode) {
              this.updateRowInSkillTable();
              swal({ title: response.entity.message, type: 'success', timer: 2000 });
            } else {
              this.employee_skills.push(response.entity.skill);
              swal({ title: response.entity.message, type: 'success', timer: 2000 });
            }

            break;
          case 422:
            swal({ title: response.entity.message, type: 'error', timer: 2000 });
            break;
        }
      }.bind(this));
    },

    editWorkExperienceRecord: function(work_experience, index) {

      this.editMode = true;
      this.editIndex = index;

      this.assignValuesToWorkExperienceModal(work_experience);

      $('#work_experience_modal').modal('toggle');

      $('#company').focus();
    },

    editEducationRecord: function(education, index) {

      this.editMode = true;
      this.editIndex = index;

      this.assignValuesToEducationModal(education);

      $('#education_modal').modal('toggle');

      $('#education_modal').on('shown.bs.modal', function() {
        $('.vue-chosen', this).trigger('chosen:updated');
      });

      $('#company').focus();
    },

    editSkillRecord: function(skill, index) {

      this.editMode = true;
      this.editIndex = index;

      this.assignValuesToSkillModal(skill);

      $('#skill_modal').modal('toggle');

      $('#skill_modal').on('shown.bs.modal', function() {
        $('.vue-chosen', this).trigger('chosen:update');
      });
    },

    deleteWorkExperienceRecord: function(work_experience, index) {

      var previousWindowKeyDown = window.onkeydown; // https://github.com/t4t5/sweetalert/issues/127

      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        type: 'warning',
        confirmButtonClass: 'confirm-class',
        cancelButtonClass: 'cancel-class',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false,
        closeOnCancel: false
      }, function(isConfirm) {

        swal.disableButtons();
        window.onkeydown = previousWindowKeyDown; // https://github.com/t4t5/sweetalert/issues/127
        if (isConfirm) {
          client({
            path: '/profile/qualifications/work-experiences',
            method: 'DELETE',
            entity: { id: work_experience.id },
            headers: { Authorization: localStorage.getItem('jwt-token') }
          }).then(
          function(response) {

            switch (response.status.code) {
              case 200:
                swal({ title: response.entity.message, type: 'success', timer: 2000 });
                this.work_experiences.splice(index, 1);
                break;
              case 422:
                swal({ title: response.entity.message, type: 'error', timer: 2000 });
                break;
            }
          }.bind(this));
        } else {
          swal('Cancelled', 'No record has been deleted', 'error');
        }
      }.bind(this));
    },

    deleteEducationRecord: function(education, index) {

      var previousWindowKeyDown = window.onkeydown; // https://github.com/t4t5/sweetalert/issues/127

      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        type: 'warning',
        confirmButtonClass: 'confirm-class',
        cancelButtonClass: 'cancel-class',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false,
        closeOnCancel: false
      }, function(isConfirm) {

        swal.disableButtons();
        window.onkeydown = previousWindowKeyDown; // https://github.com/t4t5/sweetalert/issues/127
        if (isConfirm) {
          client({
            path: '/profile/qualifications/educations',
            method: 'DELETE',
            entity: { id: education.id },
            headers: { Authorization: localStorage.getItem('jwt-token') }
          }).then(
          function(response) {

            switch (response.status.code) {
              case 200:
                swal({ title: response.entity.message, type: 'success', timer: 2000 });
                this.educations.splice(index, 1);
                break;
              case 422:
                swal({ title: response.entity.message, type: 'error', timer: 2000 });
                break;
            }
          }.bind(this));
        } else {
          swal('Cancelled', 'No record has been deleted', 'error');
        }
      }.bind(this));
    },

    deleteSkillRecord: function(skill, index) {

      var previousWindowKeyDown = window.onkeydown; // https://github.com/t4t5/sweetalert/issues/127

      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        type: 'warning',
        confirmButtonClass: 'confirm-class',
        cancelButtonClass: 'cancel-class',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false,
        closeOnCancel: false
      }, function(isConfirm) {

        swal.disableButtons();
        window.onkeydown = previousWindowKeyDown; // https://github.com/t4t5/sweetalert/issues/127
        if (isConfirm) {
          client({
            path: '/profile/qualifications/skills',
            method: 'DELETE',
            entity: { id: skill.id },
            headers: { Authorization: localStorage.getItem('jwt-token') }
          }).then(
          function(response) {

            switch (response.status.code) {
              case 200:
                swal({ title: response.entity.message, type: 'success', timer: 2000 });
                this.employee_skills.splice(index, 1);
                break;
              case 422:
                swal({ title: response.entity.message, type: 'error', timer: 2000 });
                break;
            }
          }.bind(this));
        } else {
          swal('Cancelled', 'No record has been deleted', 'error');
        }
      }.bind(this));
    },

    updateRowInWorkExperienceTable: function() {

      this.work_experiences[this.editIndex].company = this.work_experience_modal.company;
      this.work_experiences[this.editIndex].job_title = this.work_experience_modal.job_title;
      this.work_experiences[this.editIndex].from_date = this.work_experience_modal.from_date;
      this.work_experiences[this.editIndex].to_date = this.work_experience_modal.to_date;
      this.work_experiences[this.editIndex].comment = this.work_experience_modal.comment;
    },

    updateRowInEducationTable: function() {

      this.educations[this.editIndex].institute = this.education_modal.institute;
      this.educations[this.editIndex].major_specialization = this.education_modal.major_specialization;
      this.educations[this.editIndex].education_level_id = this.education_modal.education_level_id;
      this.educations[this.editIndex].from_date = this.education_modal.from_date;
      this.educations[this.editIndex].to_date = this.education_modal.to_date;
      this.educations[this.editIndex].gpa_score = this.education_modal.gpa_score;
    },

    updateRowInSkillTable: function() {

      this.employee_skills[this.editIndex].skill_id = this.skill_modal.skill_id;
      this.employee_skills[this.editIndex].skill = this.skill_modal.skill;
      this.employee_skills[this.editIndex].years_of_experience = this.skill_modal.years_of_experience;
      this.employee_skills[this.editIndex].comment = this.skill_modal.comment;
    },

    assignValuesToWorkExperienceModal: function(work_experience) {

      this.work_experience_modal.work_experience_id = work_experience.id;
      this.work_experience_modal.company = work_experience.company;
      this.work_experience_modal.job_title = work_experience.job_title;
      this.work_experience_modal.from_date = work_experience.from_date;
      this.work_experience_modal.to_date = work_experience.to_date;
      this.work_experience_modal.comment = work_experience.comment;

      // Date picker
      $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
        forceParse: true,
        calendarWeeks: true,
        autoclose: true,
        clearBtn: true
      });
    },

    assignValuesToEducationModal: function(education) {

      this.education_modal.education_id = education.id;
      this.education_modal.institute = education.institute;
      this.education_modal.major_specialization = education.major_specialization;
      this.education_level_obj = this.education_level_chosen[education.education_level_id - 1];
      this.education_modal.from_date = education.from_date;
      this.education_modal.to_date = education.to_date;
      this.education_modal.gpa_score = education.gpa_score;

      // Date picker
      $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
        forceParse: true,
        calendarWeeks: true,
        autoclose: true,
        clearBtn: true
      });
    },

    assignValuesToSkillModal: function(employee_skill) {

      this.skill_modal.id = employee_skill.id;
      this.skill_obj = this.skill_chosen[employee_skill.skill_id - 1];
      this.skill_modal.years_of_experience = employee_skill.years_of_experience;
      this.skill_modal.comment = employee_skill.comment;
    }
  }
};
