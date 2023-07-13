var StudentService = {
  init: function() {
    $("#addForm").validate({
      submitHandler: function(form) {
        var formData = new FormData(form);
        StudentService.add(formData);
      }
    });
    StudentService.list();
  },

  list: function() {
    $.get("http://localhost/Webb-Programming/rest/students", function(data) {
      $("#students-list").html("");

      var html = "";
      for (let i = 0; i < data.length; i++) {
        var student = data[i];
        if (student.hasOwnProperty("FirstName")) {
          html += `
            <div class="col-lg-3">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">First Name : ${student.FirstName}</h5>
                  <p class="card-text"> Grade : ${student.Grade}</p>
                  <p class="card-text">Description : ${student.Description}</p>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary mybutton" onclick="StudentService.get('${student.ID}')">Edit</button>
                    <button type="button" class="btn btn-danger mybutton" onclick="StudentService.delete('${student.ID}')">Delete</button>
                  </div>
                </div>
              </div>
            </div>`;
        }
      }
      $("#students-list").html(html);
    });
  },

  get: function(id) {
    $.get('http://localhost/Webb-Programming/rest/students/' + id, function(data) {
      if (data.hasOwnProperty("FirstName")) {
        $("#FirstName").val(data.FirstName).attr('data-id', id);
        $("#LastName").val(data.LastName);
        $("#Grade").val(data.Grade);
        $("#Description").val(data.Description);
        $("#exampleModal").modal("show");
      }
    });
  },

  add: function(formData) {
    var payload = {
      FirstName: formData.get('FirstName'),
      LastName: formData.get('LastName'),
      Grade: formData.get('Grade'),
      Description: formData.get('Description')
    };
  
    $.ajax({
      url: 'http://localhost/Webb-Programming/rest/students',
      type: 'POST',
      data: JSON.stringify(payload),
      processData: false,
      contentType: 'application/json',
      success: function(result) {
        $("#addStudentModal").modal("hide");
        StudentService.list();
      }
    });
  },

  update: function() {
    var student = {};
    student.ID = $('#FirstName').attr('data-id');
    student.FirstName = $('#FirstName').val();
    student.LastName = $('#LastName').val();
    student.Description = $('#Description').val();
    student.Grade = $('#Grade').val();
    $.ajax({
      url: 'http://localhost/Webb-Programming/rest/edit_students/' + student.ID,
      type: 'PUT',
      data: JSON.stringify(student),
      contentType: 'application/json',
      success: function(result) {
        StudentService.list();
      }
    });
  },

  delete: function(id) {
    $.ajax({
      url: 'http://localhost/Webb-Programming/rest/students/' + id,
      type: 'DELETE',
      success: function(result) {
        StudentService.list();
      }
    });
  }
}

$(document).ready(function() {
  StudentService.init();
});
