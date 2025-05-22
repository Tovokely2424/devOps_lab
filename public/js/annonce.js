$("#add-image").click(function(){
    const next = +$("#widgets_counter").val();
    const tmlp = $("#annonce_images").data('prototype').replace(/__name__/g, next);
    $("#annonce_images").append(tmlp);
    $('#widgets_counter').val(next + 1);
    //Gestion de la suppression
    handleDeleteButton();
});
function handleDeleteButton(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    })
}

function updateCounter(){
    const index = +$('#annonce_images div.form-group').length;
    $('#widgets_counter').val(index);
}
updateCounter();
handleDeleteButton();