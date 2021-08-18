$(document).ready(function() {

    $('#table-tipo').on('click', 'button.btn-edit', function(e) {

        e.preventDefault()

        // Limpar os campos da minha janela modal
        $('.modal-title').empty()
        $('.modal-body').empty()

        // Criar um novo título para nossa janela modals
        $('.modal-title').append('Edição do tipo de usuário')

        let IDTIPO_USUARIO = `IDTIPO_USUARIO=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: IDTIPO_USUARIO,
            url: "src/tipo-usuario/model/view-tipo.php",
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/tipo-usuario/view/form-tipo.html', function() {
                        $('#DESCRICAO').val(dado.dados.DESCRICAO)
                        $('#IDTIPO_USUARIO').val(dado.dados.IDTIPO_USUARIO)
                    })
                    $('.btn-save').show()
                    $('.btn-save').removeAttr('data-operation')
                    $('#modal-tipo').modal('show')
                }
            }
        })
    })

})