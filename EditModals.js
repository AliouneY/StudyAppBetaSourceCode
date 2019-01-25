
var modalContainer = document.getElementById("modalContainer");
var profileModal = document.getElementById("profileModal");
var emailModal = document.getElementById("emailModal");
var usernameModal = document.getElementById("usernameModal");
var passwordModal = document.getElementById("passwordModal");



function openProfileModal()
{
	modalContainer.style.visibility = 'visible';
	profileModal.style.visibility = 'visible';
	profileModal.style.zIndex = 1;
}

function openEmailModal()
{
	modalContainer.style.visibility = 'visible';
	emailModal.style.visibility = 'visible';
	emailModal.style.zIndex = 1;
}

function openUsernameModal()
{
	modalContainer.style.visibility = 'visible';
	usernameModal.style.visibility = 'visible';
	usernameModal.style.zIndex = 1;
}

function openPasswordModal()
{
	modalContainer.style.visibility = 'visible';
	passwordModal.style.visibility = 'visible';
	passwordModal.style.zIndex = 1;
}

function closeModal()
{
	modalContainer.style.visibility = 'hidden';
	profileModal.style.visibility = 'hidden';
	profileModal.style.zIndex = 0;
	emailModal.style.visibility = 'hidden';
	emailModal.style.zIndex = 0;
	usernameModal.style.visibility = 'hidden';
	usernameModal.style.zIndex = 0;
	passwordModal.style.visibility = 'hidden';
	passwordModal.style.zIndex = 0;
}