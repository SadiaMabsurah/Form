function showForm(formId) {
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');

  if (formId === 'login-form') {
    loginForm.classList.add('active');
    registerForm.classList.remove('active');
  } else if (formId === 'register-form') {
    registerForm.classList.add('active');
    loginForm.classList.remove('active');
  }
}
function openEditModal(id,name,email,role){
  document.getElementById('edit-id').value=id;
  document.getElementById('edit-name').value=name;
  document.getElementById('edit-email').value=email;
  document.getElementById('edit-role').value=role;
  document.getElementById('editModal').classList.add('active');
}

function openDeleteModal(id){
  document.getElementById('delete-id').value=id;
  document.getElementById('deleteModal').classList.add('active');
}

function closeModal(modalId){
  document.getElementById(modalId).classList.remove('active');
}