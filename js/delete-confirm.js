// delete-confirm.js
function confirmDelete(id, del) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0A633C',
        cancelButtonColor: 'gray',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'connect/delete-admin.php?delete_id=' + id + '&del=' + del;
        }
    });
}
