$('#tableBody').on("click",".btn-update",function(){
    let id=$(this).data('id');
    let row=$(this).closest('tr');
    let status=row.find('.status-select').val();
    let updateButton=row.find('.btn-update');
    updateButton.text("Updating...");
    updateButton.css("pointer-events","none");
    
    $.ajax({
        url:requestUrl,
        data:{
            id:id,
            status:status
        },
        method:"post",
        dataType:"json",
        success:function(response){
            if(response.status=='success'){
                alert(response.message);
                updateButton.text("Update");
                updateButton.css("pointer-events","auto");
            }
            else{
                alert(response.message);
                updateButton.text("Update");
                updateButton.css("pointer-events","auto");
            }
        },
        error:function(error,xhr){
            console.debug(error);
            console.debug(xhr);
            console.log("Error in updating vendors");
            updateButton.text("Update");
            updateButton.css("pointer-events","auto");
        }
    });
});