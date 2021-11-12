{{-- AJAX Message --}}
<script>        
    function confirmDelete(delId, deleteUrl, dataTable){ 
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        id:delId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if(res && res.success) {
                            notification('success', res.message);                       
                        } else {
                            notification('error', res.message); 
                        }
                        dataTable.ajax.reload();                        
                    },
                    error: function(xhr) {
                        notification('error', res.message);
                    }
                }); 
            }
        });
    }
    
    function confirmStatus(statusId, statusURL, dataTable){ 
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change status of this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: statusURL,
                    type: 'POST',
                    data: {
                        id:statusId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if(res && res.success) {
                            notification('success', res.message);                       
                        } else {
                            notification('error', res.message); 
                        }
                        dataTable.ajax.reload();                        
                    },
                    error: function(xhr) {
                        notification('error', res.message);
                    }
                }); 
            }
        });
    }
    
    
  
</script>